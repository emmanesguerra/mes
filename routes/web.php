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
        
        Route::prefix('quotes')->group(function () {
            Route::get('/data', '\App\Http\Controllers\Quotation\Admin\QuotationController@data')->name('quotes.data');
            Route::get('/trashed', '\App\Http\Controllers\Quotation\Admin\QuotationController@trashed')->name('quotes.trashed');
            Route::get('/restore/{id?}', '\App\Http\Controllers\Quotation\Admin\QuotationController@restore')->name('quotes.restore');
            Route::post('/restore/{id}', '\App\Http\Controllers\Quotation\Admin\QuotationController@processrestore')->name('quotes.processrestore');
            Route::delete('/forcedelete/{id?}', '\App\Http\Controllers\Quotation\Admin\QuotationController@forcedelete')->name('quotes.forcedelete');
        });
        Route::resource('quotes','\App\Http\Controllers\Quotation\Admin\QuotationController');
        
        Route::prefix('news')->group(function () {
            Route::get('/data', '\App\Http\Controllers\News\Admin\NewsController@data')->name('news.data');
            Route::get('/trashed', '\App\Http\Controllers\News\Admin\NewsController@trashed')->name('news.trashed');
            Route::get('/restore/{id?}', '\App\Http\Controllers\News\Admin\NewsController@restore')->name('news.restore');
            Route::post('/restore/{id}', '\App\Http\Controllers\News\Admin\NewsController@processrestore')->name('news.processrestore');
            Route::delete('/forcedelete/{id?}', '\App\Http\Controllers\News\Admin\NewsController@forcedelete')->name('news.forcedelete');
        });
        Route::resource('news','\App\Http\Controllers\News\Admin\NewsController');
        
        Route::prefix('newscategory')->group(function () {
            Route::get('/data', '\App\Http\Controllers\News\Admin\NewsCategoryController@data')->name('newscategory.data');
            Route::get('/trashed', '\App\Http\Controllers\News\Admin\NewsCategoryController@trashed')->name('newscategory.trashed');
            Route::get('/restore/{id?}', '\App\Http\Controllers\News\Admin\NewsCategoryController@restore')->name('newscategory.restore');
            Route::post('/restore/{id}', '\App\Http\Controllers\News\Admin\NewsCategoryController@processrestore')->name('newscategory.processrestore');
            Route::delete('/forcedelete/{id?}', '\App\Http\Controllers\News\Admin\NewsCategoryController@forcedelete')->name('newscategory.forcedelete');
        });
        Route::resource('newscategory','\App\Http\Controllers\News\Admin\NewsCategoryController');
        
        Route::prefix('pagebanner')->group(function () {
            Route::get('/data', '\App\Http\Controllers\PageBanner\Admin\PageBannerController@data')->name('pagebanner.data');
            Route::get('/trashed', '\App\Http\Controllers\PageBanner\Admin\PageBannerController@trashed')->name('pagebanner.trashed');
            Route::get('/restore/{id?}', '\App\Http\Controllers\PageBanner\Admin\PageBannerController@restore')->name('pagebanner.restore');
            Route::post('/restore/{id}', '\App\Http\Controllers\PageBanner\Admin\PageBannerController@processrestore')->name('pagebanner.processrestore');
            Route::delete('/forcedelete/{id?}', '\App\Http\Controllers\PageBanner\Admin\PageBannerController@forcedelete')->name('pagebanner.forcedelete');
        });
        Route::resource('pagebanner','\App\Http\Controllers\PageBanner\Admin\PageBannerController');
        
        Route::prefix('newsletters')->group(function () {
            Route::get('/data', '\App\Http\Controllers\Newsletters\Admin\NewslettersController@data')->name('newsletters.data');
            Route::get('/trashed', '\App\Http\Controllers\Newsletters\Admin\NewslettersController@trashed')->name('newsletters.trashed');
            Route::get('/restore/{id?}', '\App\Http\Controllers\Newsletters\Admin\NewslettersController@restore')->name('newsletters.restore');
            Route::post('/restore/{id}', '\App\Http\Controllers\Newsletters\Admin\NewslettersController@processrestore')->name('newsletters.processrestore');
            Route::delete('/forcedelete/{id?}', '\App\Http\Controllers\Newsletters\Admin\NewslettersController@forcedelete')->name('newsletters.forcedelete');
        });
        Route::resource('newsletters','\App\Http\Controllers\Newsletters\Admin\NewslettersController');
        
        Route::prefix('newsletterssubs')->group(function () {
            Route::get('/data', '\App\Http\Controllers\Newsletters\Admin\Subscribers@data')->name('newsletterssubs.data');
            Route::get('/subs/{id}', '\App\Http\Controllers\Newsletters\Admin\Subscribers@subs')->name('newsletterssubs.subs');
        });
        Route::resource('newsletterssubs','\App\Http\Controllers\Newsletters\Admin\Subscribers');
        
        Route::prefix('downloadables')->group(function () {
            Route::get('/data', '\App\Http\Controllers\Downloadables\Admin\DownloadablesController@data')->name('downloadables.data');
        });
        Route::get('/downloadables', '\App\Http\Controllers\Downloadables\Admin\DownloadablesController@index')->name('downloadables.index');
        Route::get('/downloadables/create', '\App\Http\Controllers\Downloadables\Admin\DownloadablesController@create')->name('downloadables.create');
        Route::get('/downloadables/{id}', '\App\Http\Controllers\Downloadables\Admin\DownloadablesController@show')->name('downloadables.show');
        Route::post('/downloadables', '\App\Http\Controllers\Downloadables\Admin\DownloadablesController@store')->name('downloadables.store');
        Route::get('/downloadables/{id}/edit', '\App\Http\Controllers\Downloadables\Admin\DownloadablesController@edit')->name('downloadables.edit');
        Route::post('/downloadables/{id}', '\App\Http\Controllers\Downloadables\Admin\DownloadablesController@update')->name('downloadables.update');
        Route::delete('/downloadables/{id}', '\App\Http\Controllers\Downloadables\Admin\DownloadablesController@destroy')->name('downloadables.delete');
    });
});

Route::post('/send-inquiry', '\App\Http\Controllers\ContactUs\ContactUsController@send')->name('contactus.store');
Route::post('/subscribe', '\App\Http\Controllers\Newsletters\NewslettersController@subscribe')->name('subscriber.store');
Route::get('/subscriber/welcome', '\App\Http\Controllers\Newsletters\NewslettersController@welcome')->name('subscriber.welcome');
Route::get('/subscriber/verify', '\App\Http\Controllers\Newsletters\NewslettersController@verify')->name('subscriber.verify');