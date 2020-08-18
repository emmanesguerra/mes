<?php

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function() {
        return redirect()->route('admin.login');
    });
    Route::get('/login', '\Core\Http\Controllers\AELoginController@showLoginForm')->name('login');
    Route::post('/login', '\Core\Http\Controllers\AELoginController@login')->name('login.post');
    
    Route::get('/changepswd', '\Core\Http\Controllers\AEHomeController@showChangePswdForm')->name('changepswd');
    Route::post('/changepswd', '\Core\Http\Controllers\AEHomeController@changepswd')->name('changepswd.post');
    
    Route::middleware(['auth', 'ischanged'])->group(function () {
        Route::get('/dashboard', '\Core\Http\Controllers\AEHomeController@index')->name('dashboard');
        Route::post('/logout', '\Core\Http\Controllers\AELoginController@logout')->name('logout');

        Route::prefix('settings')->group(function () {
            Route::get('/', '\Core\Http\Controllers\Setting\SettingController@index')->name('settings.index');
            Route::post('/', '\Core\Http\Controllers\Setting\SettingController@store')->name('settings.store');
        });

        Route::prefix('users')->group(function () {
            Route::get('/data', '\Core\Http\Controllers\User\UserController@data')->name('users.data');
            Route::get('/trashed', '\Core\Http\Controllers\User\UserController@trashed')->name('users.trashed');
            Route::get('/restore/{id?}', '\Core\Http\Controllers\User\UserController@restore')->name('users.restore');
            Route::post('/restore/{id}', '\Core\Http\Controllers\User\UserController@processrestore')->name('users.processrestore');
            Route::delete('/forcedelete/{id?}', '\Core\Http\Controllers\User\UserController@forcedelete')->name('users.forcedelete');
            Route::get('/logs', '\Core\Http\Controllers\User\UserLogController@data')->name('users.log.data');
            Route::get('/changelogs', '\Core\Http\Controllers\User\ChangeLogController@data')->name('users.changelog.data');
            Route::get('/changelogs/values/{id?}', '\Core\Http\Controllers\User\ChangeLogController@values')->name('users.changelog.value');
        });
        Route::resource('users','\Core\Http\Controllers\User\UserController');
        
        Route::prefix('roles')->group(function () {
            Route::get('/data', '\Core\Http\Controllers\Role\RoleController@data')->name('roles.data');
        });
        Route::resource('roles','\Core\Http\Controllers\Role\RoleController');
        
        Route::prefix('permissions')->group(function () {
            Route::get('/data', '\Core\Http\Controllers\Permission\PermissionController@data')->name('permissions.data');
        });
        Route::resource('permissions','\Core\Http\Controllers\Permission\PermissionController');
        
        Route::prefix('modules')->group(function () {
            Route::get('/data', '\Core\Http\Controllers\Module\ModuleController@data')->name('modules.data');
        });
        Route::resource('modules','\Core\Http\Controllers\Module\ModuleController');
        
        Route::prefix('pages')->group(function () {
            Route::get('/data', '\Core\Http\Controllers\Page\PageController@data')->name('pages.data');
            Route::get('/template', '\Core\Http\Controllers\Page\PageController@template')->name('pages.template');
            Route::get('/trashed', '\Core\Http\Controllers\Page\PageController@trashed')->name('pages.trashed');
            Route::get('/restore/{id?}', '\Core\Http\Controllers\Page\PageController@restore')->name('pages.restore');
            Route::post('/restore/{id}', '\Core\Http\Controllers\Page\PageController@processrestore')->name('pages.processrestore');
            Route::delete('/forcedelete/{id?}', '\Core\Http\Controllers\Page\PageController@forcedelete')->name('pages.forcedelete');
        });
        Route::resource('pages','\Core\Http\Controllers\Page\PageController');
        
        Route::prefix('menus')->group(function () {
            Route::get('/data', '\Core\Http\Controllers\Menu\MenuController@data')->name('menus.data');
            Route::get('/settings/{id?}', '\Core\Http\Controllers\Menu\MenuController@settings')->name('menus.settings');
            Route::post('/settings/{id}', '\Core\Http\Controllers\Menu\MenuController@settingsstore')->name('menus.settings.store');
        });
        Route::resource('menus','\Core\Http\Controllers\Menu\MenuController');
        
        Route::prefix('files')->group(function () {
            Route::get('/data', '\Core\Http\Controllers\UploadedFiles\FileController@data')->name('files.data');
        });
        Route::resource('files','\Core\Http\Controllers\UploadedFiles\FileController');
        
        Route::prefix('contents')->group(function () {
            Route::get('/data', '\Core\Http\Controllers\Content\ContentController@data')->name('contents.data');
        });
        Route::resource('contents','\Core\Http\Controllers\Content\ContentController');
        
        Route::prefix('offices')->group(function () {
            Route::get('/data', '\Core\Http\Controllers\Office\OfficeController@data')->name('offices.data');
            Route::get('/trashed', '\Core\Http\Controllers\Office\OfficeController@trashed')->name('offices.trashed');
            Route::get('/restore/{id?}', '\Core\Http\Controllers\Office\OfficeController@restore')->name('offices.restore');
            Route::post('/restore/{id}', '\Core\Http\Controllers\Office\OfficeController@processrestore')->name('offices.processrestore');
            Route::delete('/forcedelete/{id?}', '\Core\Http\Controllers\Office\OfficeController@forcedelete')->name('offices.forcedelete');
        });
        Route::resource('offices','\Core\Http\Controllers\Office\OfficeController');
    });
    
});

Route::get('/{slug?}', '\Core\Http\Controllers\AEController@index')->where('slug', '^(?!admin$).*$');