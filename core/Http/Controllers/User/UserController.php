<?php

namespace Core\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Core\Http\Requests\StoreUserRequest;
use Core\Http\Requests\UpdateUserRequest;

use Core\Model\Role;
use Core\Model\Permission;
use Core\Model\User;
use DB;
use Core\Library\DataTables;

class UserController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:users-list|users-create|users-edit|users-delete', ['only' => ['index','store']]);
         $this->middleware('permission:users-create', ['only' => ['create','store']]);
         $this->middleware('permission:users-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:users-delete', ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        return view('admin.layouts.modules.user.list');
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
            0 => ['users.id'],
            1 => ['users.firstname'],
            2 => ['users.lastname'],
            3 => ['users.email'],
            4 => ['roles.name'],
            5 => ['users.updated_at'],
        ];
        
        $filteredmodel = DB::table('users')
                ->leftjoin('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
                ->leftjoin('roles', 'roles.id', '=', 'model_has_roles.role_id');
        if($request->isTrashed == 'true') {
            $filteredmodel->whereNotNull('users.deleted_at');
        } else {
            $filteredmodel->whereNull('users.deleted_at');
        }
        $filteredmodel->select(DB::raw("users.id, 
                    users.firstname, 
                    users.lastname, 
                    users.email, 
                    roles.name,
                    users.updated_at")
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
        $data = [
            'roles' => Role::get(['id', 'name as label'])
        ];
        return view('admin.layouts.modules.user.add')->with(compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = User::create($request->only('firstname', 'lastname', 'middlename', 'email', 'password'));
            
            $user->assignRole($request->input('roles'));
            
            DB::commit();
            return redirect()->route('admin.users.index')->with('status-success', 'User created successfully');
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
        $user = User::find($id);
        $role = $user->roles->first();
        $rolePermissions = null;
        if($role) {
            $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
                ->where("role_has_permissions.role_id",$role->id)
                ->get();
        }


        return view('admin.layouts.modules.user.show',compact('user','role','rolePermissions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $role = $user->roles->first();
        $data = [
            'roles' => Role::get(['id', 'name as label'])
        ];
        return view('admin.layouts.modules.user.edit')->with(compact('data', 'user', 'role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        try
        {
            DB::beginTransaction();
            $input = $request->all();

            $user = User::find($id);
            $user->update($input);
            DB::table('model_has_roles')->where('model_id',$id)->delete();


            $user->assignRole($request->input('roles'));


            DB::commit();
            return redirect()->route('admin.users.index')
                            ->with('status-success','User updated successfully');
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
            User::find($id)->delete();
            return redirect()->route('admin.users.index')
                            ->with('status-success','User deleted successfully');
        } catch (Exception $ex) {
            return redirect()->route('admin.users.index')
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
        return view('admin.layouts.modules.user.trashed');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $user = User::onlyTrashed()->find($id);
        $user->contents;
        
        return view('admin.layouts.modules.user.show')->with(compact('user'));
    }
    
    public function processrestore(Request $request, $id)
    {
        try
        {
            User::onlyTrashed()->find($id)->restore();
            
            return redirect()->route('admin.users.index')->with('status-success', 'User ID#'.$id.' restored successfully');
            
        } catch (\Exception $ex) {
            return redirect()->back()->with('status-failed', $ex->getMessage());
        }
    }
    
    public function forcedelete($id)
    {
        try
        {
            User::onlyTrashed()->find($id)->forceDelete();
            
            return redirect()->route('admin.users.index')
                            ->with('status-success','User ID#'.$id.' is permanently deleted in the system');
        } catch (Exception $ex) {
            return redirect()->route('admin.users.index')
                            ->with('status-failed', $ex->getMessage());
        }
    }
}
