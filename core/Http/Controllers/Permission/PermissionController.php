<?php

namespace Core\Http\Controllers\Permission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Core\Library\DataTables;
use Core\Model\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.layouts.modules.permissions.index');
    }
    
    public function data(Request $request)
    {
        $tablecols = [
            0 => ['id'],
            1 => ['name'],
            2 => ['module'],
            3 => ['guard_name'],
        ];
        
        $filteredmodel = DB::table('permissions')
            ->select(DB::raw("id, name, module, guard_name")
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
        $guards = collect(config('auth.guards'))->keys();
        
        return view('admin.layouts.modules.permissions.create',compact('guards'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try 
        {
            DB::beginTransaction();
            $this->validate($request, [
                'name' => 'required',
                'module' => 'required',
                'guard_name' => 'required',
            ]);
            
            $permissions = explode(",", $request->name);
            
            foreach($permissions as $permission) {
                Permission::create([
                    'name' => trim($permission),
                    'module' => $request->module,
                    'guard_name' => $request->guard_name,
                ]);
            }
            
            DB::commit();
            return redirect()->route('admin.permissions.index')
                            ->with('status-success','Permission(s) created successfully');
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()
                    ->with('status-failed', $ex->getMessage())
                    ->withInput($request->input());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $guards = collect(config('auth.guards'))->keys();
        $permission = Permission::find($id);
        
        return view('admin.layouts.modules.permissions.edit',compact('permission', 'guards'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try
        {
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:permissions,name,'.$id,
                'module' => 'required',
                'guard_name' => 'required',
            ]);
            

            if ($validator->fails()) {
                return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
            }

            $permission = Permission::find($id);
            $permission->name = $request->input('name');
            $permission->module = $request->input('module');
            $permission->guard_name = $request->input('guard_name');
            $permission->save();

            return redirect()->route('admin.permissions.index')
                            ->with('status-success','Permission updated successfully');
        } catch (\Exception $ex) {
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
        try
        {
            DB::table("permissions")->where('id',$id)->delete();
            return redirect()->route('admin.permissions.index')
                            ->with('status-success','Permission deleted successfully');
        } catch (\Exception $ex) {
            return redirect()->back()->with('status-failed', $ex->getMessage());
        }
    }
}
