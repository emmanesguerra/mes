<?php

namespace App\Observers;

use App\Model\PageBanner;
use Illuminate\Support\Facades\Auth;

class PageBannerObserver
{
    /**
     * Handle the slider "creating" event.
     *
     * @param  \App\Model\Slider  $categ
     * @return void
     */
    public function creating(PageBanner $args)
    {
        $args->created_by = Auth::id();
    }

    /**
     * Handle the slider "updating" event.
     *
     * @param  \App\Model\Slider  $categ
     * @return void
     */
    public function updating(PageBanner $args)
    {
        $args->updated_by = Auth::id();
    }
    
    /**
     * Handle the page banner "created" event.
     *
     * @param  \App\Model\PageBanner  $pageBanner
     * @return void
     */
    public function created(PageBanner $pageBanner)
    {
        //
    }

    /**
     * Handle the page banner "updated" event.
     *
     * @param  \App\Model\PageBanner  $pageBanner
     * @return void
     */
    public function updated(PageBanner $pageBanner)
    {
        //
    }

    /**
     * Handle the page banner "deleted" event.
     *
     * @param  \App\Model\PageBanner  $pageBanner
     * @return void
     */
    public function deleted(PageBanner $pageBanner)
    {
        //
    }

    /**
     * Handle the page banner "restored" event.
     *
     * @param  \App\Model\PageBanner  $pageBanner
     * @return void
     */
    public function restored(PageBanner $pageBanner)
    {
        //
    }

    /**
     * Handle the page banner "force deleted" event.
     *
     * @param  \App\Model\PageBanner  $pageBanner
     * @return void
     */
    public function forceDeleted(PageBanner $pageBanner)
    {
        //
    }
}
