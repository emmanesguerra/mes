<?php

namespace App\Observers;

use App\Model\News;

class NewsObserver
{
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
