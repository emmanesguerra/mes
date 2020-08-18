<?php

use Illuminate\Database\Seeder;
use Core\Model\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class CreateDeveloperUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::unsetEventDispatcher();
        $user = User::create([
        	'firstname' => 'Emmanuelle', 
        	'middlename' => 'Magtibay', 
        	'lastname' => 'Esguerra', 
        	'email' => 'admin@gmail.com',
        	'password' => 'namme',
        	'created_by' => '1'
        ]);
  
        $role = Role::create(['name' => 'Ae Developer']);
   
        $permissions = Permission::pluck('id','id')->all();
  
        $role->syncPermissions($permissions);
   
        $user->assignRole([$role->id]);
        
        $role1 = Role::create(['name' => 'Admin']);
   
        $permissions1 = Permission::whereIn('module', ['contents', 'files', 'offices'])
                ->whereNotIn('name', ['offices-trash', 'offices-restore', 'offices-fdelete'])->get()->pluck('id','id');
  
        $role1->syncPermissions($permissions1);
    }
}
