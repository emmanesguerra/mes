<?php

namespace App\Observers;

use App\Model\News;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class NewsObserver
{
    /**
     * Handle the slider "creating" event.
     *
     * @param  \App\Model\Slider  $categ
     * @return void
     */
    public function creating(News $args)
    {
        $args->created_by = Auth::id();
        $args->slug = Str::slug($args->title);
    }

    /**
     * Handle the slider "updating" event.
     *
     * @param  \App\Model\Slider  $categ
     * @return void
     */
    public function updating(News $args)
    {
        $args->updated_by = Auth::id();
        $args->slug = Str::slug($args->title);
    }
    
    /**
     * Handle the news "created" event.
     *
     * @param  \App\Model\News  $news
     * @return void
     */
    public function created(News $news)
    {
        //
    }

    /**
     * Handle the news "updated" event.
     *
     * @param  \App\Model\News  $news
     * @return void
     */
    public function updated(News $news)
    {
        //
    }

    /**
     * Handle the news "deleted" event.
     *
     * @param  \App\Model\News  $news
     * @return void
     */
    public function deleted(News $news)
    {
        //
    }

    /**
     * Handle the news "restored" event.
     *
     * @param  \App\Model\News  $news
     * @return void
     */
    public function restored(News $news)
    {
        //
    }

    /**
     * Handle the news "force deleted" event.
     *
     * @param  \App\Model\News  $news
     * @return void
     */
    public function forceDeleted(News $news)
    {
        //
    }
}
