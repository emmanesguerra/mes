<?php

namespace Core\Http\Controllers\Office;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Core\Library\DataTables;
use Core\Library\Modules\SystemConfigLibrary;
use Core\Model\Office;
use Core\Http\Requests\StoreOfficeRequest;
use Core\Http\Requests\UpdateOfficeRequest;

class OfficeController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:offices-list|offices-create|offices-edit|offices-delete', ['only' => ['index','store']]);
         $this->middleware('permission:offices-create', ['only' => ['create','store']]);
         $this->middleware('permission:offices-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:offices-delete', ['only' => ['destroy']]);
         $this->middleware('permission:offices-trash', ['only' => ['trashed']]);
         $this->middleware('permission:offices-restore', ['only' => ['restore', 'processrestore']]);
         $this->middleware('permission:offices-fdelete', ['only' => ['forcedelete']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.layouts.modules.office.index');
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
            1 => ['address'],
            2 => ['telephone'],
            3 => ['mobile'],
            4 => ['email'],
            5 => ['updated_at'],
        ];
        
        $filteredmodel = DB::table('offices');
        if($request->isTrashed == 'true') {
            $filteredmodel->whereNotNull('deleted_at');
        } else {
            $filteredmodel->whereNull('deleted_at');
        }
        $filteredmodel->select(DB::raw("id, 
                    address, 
                    telephone, 
                    mobile, 
                    email,
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
        $bodyClass = SystemConfigLibrary::retrieve('office_block_class');
        $defaultCss = SystemConfigLibrary::retrieve('office_css');
        $styles = [];
        if(\Illuminate\Support\Facades\Storage::disk('css')->exists($defaultCss)) {
            $styles = [asset('css/templates/' . $defaultCss)];
        }
        
        return view('admin.layouts.modules.office.create')->with(compact('styles', 'bodyClass'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOfficeRequest $request)
    {
        try
        {
            Office::create($request->only('address', 'contact_person', 'telephone', 'mobile', 'email', 'marker', 'm_width', 'm_height', 'store_hours'));
            
            return redirect()->route('admin.offices.index')->with('status-success', 'Office Location created successfully');
            
        } catch (\Exception $ex) {
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
        $office = Office::find($id);
        
        return view('admin.layouts.modules.office.show')->with(compact('office'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bodyClass = SystemConfigLibrary::retrieve('office_block_class');
        $defaultCss = SystemConfigLibrary::retrieve('office_css');
        $styles = [];
        if(\Illuminate\Support\Facades\Storage::disk('css')->exists($defaultCss)) {
            $styles = [asset('css/templates/' . $defaultCss)];
        }
        $office = Office::find($id);
        
        return view('admin.layouts.modules.office.edit')->with(compact('office', 'styles', 'bodyClass'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOfficeRequest $request, $id)
    {
        try
        {
            $office = Office::find($id);
            $office->update($request->only('address', 'contact_person', 'telephone', 'mobile', 'email', 'marker', 'm_width', 'm_height', 'store_hours'));

            return redirect()->route('admin.offices.index')->with('status-success','Office Location updated successfully');
            
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
            Office::find($id)->delete();
            return redirect()->route('admin.offices.index')
                            ->with('status-success','Office Location deleted successfully');
        } catch (Exception $ex) {
            return redirect()->route('admin.offices.index')
                            ->with('status-failed', $ex->getMessage());
        }
    }
    
    /**
     * Display a listing of the trashed resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trashed()
    {
        return view('admin.layouts.modules.office.trashed');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $office = Office::onlyTrashed()->find($id);
        
        return view('admin.layouts.modules.office.show')->with(compact('office'));
    }
    
    public function processrestore(Request $request, $id)
    {
        try
        {
            Office::onlyTrashed()->find($id)->restore();
            
            return redirect()->route('admin.offices.index')->with('status-success', 'Office Location ID#'.$id.' restored successfully');
            
        } catch (\Exception $ex) {
            return redirect()->back()->with('status-failed', $ex->getMessage());
        }
    }
    
    public function forcedelete($id)
    {
        try
        {
            Office::onlyTrashed()->find($id)->forceDelete();
            return redirect()->route('admin.offices.index')
                            ->with('status-success','Office Location ID#'.$id.' is permanently deleted in the system');
        } catch (Exception $ex) {
            return redirect()->route('admin.offices.index')
                            ->with('status-failed', $ex->getMessage());
        }
    }
}
