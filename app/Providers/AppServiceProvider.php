<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

use Core\Observers\BaseObserver;

use App\Model\Slider;
use App\Observers\SliderObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Schema::defaultStringLength(191);
        
        $baseobserver = new BaseObserver();
        $baseobserver->init();
        
        Slider::observe(SliderObserver::class);
    }
}
