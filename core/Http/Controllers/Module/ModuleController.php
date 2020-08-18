<?php

namespace Core\Http\Controllers\Module;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Core\Http\Requests\StoreModuleRequest;
use Core\Http\Requests\UpdateModuleRequest;
use Core\Model\Module;
use Core\Model\Content;
use Core\Model\Permission;
use Core\Library\DataTables;

class ModuleController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:modules-list|modules-create|modules-edit', ['only' => ['index','store']]);
         $this->middleware('permission:modules-create', ['only' => ['create','store']]);
         $this->middleware('permission:modules-edit', ['only' => ['edit','update']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.layouts.modules.module.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request)
    {
        $tablecols = [
            0 => ['id'],
            1 => ['module_name'],
            2 => ['description'],
            3 => ['route_root_name'],
            4 => ['updated_at'],
        ];
        
        $filteredmodel = DB::table('modules')
                ->select(DB::raw("id, 
                    module_name, 
                    description, 
                    route_root_name, 
                    updated_at")
            );
        
        $modelcnt = $filteredmodel->count();
        
        $data = DataTables::DataTableFilters($filteredmodel, $request, $tablecols, $hasValue, $totalFiltered);
        
        return response(['data'=> $data,
            'draw' => $request->draw,
            'recordsTotal' => ($hasValue)? $data->count(): $modelcnt,
            'recordsFiltered' => ($hasValue)? $totalFiltered: $modelcnt], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.layouts.modules.module.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreModuleRequest $request)
    {
        try
        {
            DB::beginTransaction();
            //save to db
            $module = Module::create($request->only('module_name', 'description', 'route_root_name', 'icon'));
            
            if($module) {
                //create permissions
                $this->CreatePermissions($module->module_name);

                //create controller, model, observer, request and migration
                $strCleanName = $this->GenerateClassFiles($module->module_name);

                //create contents
                $this->CreateContentData($module->module_name, $request);
                
                $module->disableAuditing();
                $module->admin_classnamespace = "\App\Http\Controllers\\" . $strCleanName . "\Admin\\" . $strCleanName . "Controller";
                $module->save();
            }
            
            DB::commit();
            return redirect()->route('admin.modules.index')->with('status-success', 'Module created successfully');
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()
                    ->with('status-failed', $ex->getMessage())
                    ->withInput($request->input());
        }
    }
    
    private function CreatePermissions($string)
    {
        // strip out all whitespace and convert to lowercase
        $clean = strtolower(preg_replace('/\s*/', '', $string));
        
        $permissions = ['-list', '-create', '-edit', '-delete', '-trash', '-restore', '-fdelete'];
        
        foreach($permissions as $permission) {
            Permission::create([
                'name' => $clean . $permission, 'module' => $clean
            ]);
        }
        
        return;
    }
    
    private function GenerateClassFiles($string)
    {
        // strip out all whitespace and convert to lowercase
        $title = \Illuminate\Support\Str::title($string);
        $clean = preg_replace('/\s*/', '', $title);
        
        Artisan::call("make:model", ['name' => 'Model/'.$clean, '-m' => true]);
        
        Artisan::call("make:controller", ['name' => $clean.'/'.$clean.'Controller']);
        
        Artisan::call("make:controller", ['name' => $clean.'/Admin/'.$clean.'Controller',  '--model' => 'Model/'.$clean]);
        
        Artisan::call("make:observer", ['name' => $clean.'Observer',  '--model' => 'Model/'.$clean]);
        
        Artisan::call("make:request", ['name' => 'Post'.$clean.'Request']);
        
        Artisan::call("make:request", ['name' => 'Patch'.$clean.'Request']);
        
        return $clean;
    }
    
    private function CreateContentData($moduleName, $request)
    {
        $title = \Illuminate\Support\Str::title($moduleName);
        $clean = preg_replace('/\s*/', '', $title);
        
        Content::create([
            "name" => $title . " Main",
            "type" => "M",
            "class_namespace" => "\App\Http\Controllers\\" . $clean . "\\" . $clean . "Controller",
            "method_name" => 'main'
        ]);
        
        if($request->has('haspanel')) {
            Content::create([
                "name" => $title . " Panel",
                "type" => "P",
                "class_namespace" => "\App\Http\Controllers\\" . $clean . "\\" . $clean . "Controller",
                "method_name" => 'panel'
            ]);
        }
        
        return;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $module = Module::find($id);
        
        return view('admin.layouts.modules.module.show')->with(compact('module'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $module = Module::find($id);
        
        return view('admin.layouts.modules.module.edit')->with(compact('module'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateModuleRequest $request, $id)
    {
        try
        {
            DB::beginTransaction();
            $input = $request->all();

            $module = Module::find($id);
            $module->update($input);

            DB::commit();
            return redirect()->route('admin.modules.index')
                            ->with('status-success','Module updated successfully');
            
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()
                    ->with('status-failed', $ex->getMessage())
                    ->withInput($request->input());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
