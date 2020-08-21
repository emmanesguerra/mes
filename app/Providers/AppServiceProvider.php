<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

use Core\Observers\BaseObserver;

use App\Model\Slider;
use App\Observers\SliderObserver;

use App\Model\Quotation;
use App\Observers\QuotationObserver;

use App\Model\NewsCategory;
use App\Observers\NewsCategoryObserver;

use App\Model\News;
use App\Observers\NewsObserver;

use App\Model\PageBanner;
use App\Observers\PageBannerObserver;

use App\Model\Newsletters;
use App\Observers\NewslettersObserver;

use App\Model\Subscriber;
use App\Observers\SubscriberObserver;

use App\Model\Downloadables;
use App\Observers\DownloadablesObserver;

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
        Quotation::observe(QuotationObserver::class);
        NewsCategory::observe(NewsCategoryObserver::class);
        News::observe(NewsObserver::class);
        PageBanner::observe(PageBannerObserver::class);
        Newsletters::observe(NewslettersObserver::class);
        Subscriber::observe(SubscriberObserver::class);
        Downloadables::observe(DownloadablesObserver::class);
    }
}
