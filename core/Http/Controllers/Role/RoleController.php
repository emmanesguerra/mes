<?php

namespace Core\Http\Controllers\Role;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Core\Library\DataTables;
use Core\Model\Role;
use Core\Model\Permission;


class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:roles-list|roles-create|roles-edit|roles-delete', ['only' => ['index','store']]);
         $this->middleware('permission:roles-create', ['only' => ['create','store']]);
         $this->middleware('permission:roles-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:roles-delete', ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('admin.layouts.modules.roles.index');
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
            1 => ['name'],
        ];
        
        $filteredmodel = DB::table('roles')
            ->select(DB::raw("id, name")
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
        $permission = Permission::get()->groupBy('module');
        return view('admin.layouts.modules.roles.create',compact('permission'));
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
                'name' => 'required|unique:roles,name',
                'permission' => 'required',
            ]);


            $role = Role::create(['name' => $request->input('name')]);
            $role->syncPermissions($request->input('permission'));


            DB::commit();
            return redirect()->route('admin.roles.index')
                            ->with('status-success','Role created successfully');
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
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
            ->where("role_has_permissions.role_id",$id)
            ->get();


        return view('admin.layouts.modules.roles.show',compact('role','rolePermissions'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::find($id);
        $permission = Permission::get()->groupBy('module');
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();
        
        return view('admin.layouts.modules.roles.edit',compact('role','permission','rolePermissions'));
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
            DB::beginTransaction();
            $this->validate($request, [
                'name' => 'required',
                'permission' => 'required',
            ]);

            $role = Role::find($id);
            $role->name = $request->input('name');
            $role->save();

            $role->syncPermissions($request->input('permission'));

            DB::commit();
            return redirect()->route('admin.roles.index')
                            ->with('status-success','Role updated successfully');
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
        try
        {
            DB::table("roles")->where('id',$id)->delete();
            return redirect()->route('admin.roles.index')
                            ->with('status-success','Role deleted successfully');
        } catch (\Exception $ex) {
            return redirect()->back()->with('status-failed', $ex->getMessage());
        }
    }
}
