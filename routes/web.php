<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware(['auth'])->group(function () {        
        Route::prefix('sliders')->group(function () {
            Route::get('/data', '\App\Http\Controllers\Slider\Admin\SliderController@data')->name('sliders.data');
            Route::get('/trashed', '\App\Http\Controllers\Slider\Admin\SliderController@trashed')->name('sliders.trashed');
            Route::get('/restore/{id?}', '\App\Http\Controllers\Slider\Admin\SliderController@restore')->name('sliders.restore');
            Route::post('/restore/{id}', '\App\Http\Controllers\Slider\Admin\SliderController@processrestore')->name('sliders.processrestore');
            Route::delete('/forcedelete/{id?}', '\App\Http\Controllers\Slider\Admin\SliderController@forcedelete')->name('sliders.forcedelete');
        });
        Route::resource('sliders','\App\Http\Controllers\Slider\Admin\SliderController');
    });
});