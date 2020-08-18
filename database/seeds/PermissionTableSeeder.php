<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $settings = [
           'settings' => [
               'settings-list',
               'settings-edit',
           ],
           'users' => [
               'users-list',
               'users-create',
               'users-edit',
               'users-delete',
                'users-trash',
                'users-restore',
                'users-fdelete',
           ],
           'roles' => [
               'roles-list',
               'roles-create',
               'roles-edit',
               'roles-delete',
           ],
           'permissions' => [
               'permissions-list',
               'permissions-create',
               'permissions-edit',
               'permissions-delete',
           ],
           'modules' => [
               'modules-list',
               'modules-create',
               'modules-edit'
           ],
           'pages' => [
               'pages-list',
               'pages-create',
               'pages-edit',
               'pages-delete',
                'pages-trash',
                'pages-restore',
                'pages-fdelete',
           ],
           'menus' => [
               'menus-list',
               'menus-create',
               'menus-edit',
               'menus-delete',
           ],
            'contents' => [
                'contents-list',
                'contents-edit',
            ],
            'files' => [
                'files-list',
                'files-create',
                'files-edit',
                'files-delete',
            ],
            'offices' => [
                'offices-list',
                'offices-create',
                'offices-edit',
                'offices-delete',
                'offices-trash',
                'offices-restore',
                'offices-fdelete',
            ],
        ];


        foreach ($settings as $modules => $permissions) {
            foreach ($permissions as $permission) {
                Permission::create(['name' => $permission, 'module' => $modules]);
            }
        }
    }
}
