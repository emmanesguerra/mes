<?php

namespace App\Observers;

use App\Model\Downloadables;
use Illuminate\Support\Facades\Auth;

class DownloadablesObserver
{
    /**
     * Handle the slider "creating" event.
     *
     * @param  \App\Model\Downloadables  $categ
     * @return void
     */
    public function creating(Downloadables $dd)
    {
        $dd->created_by = Auth::id();
    }

    /**
     * Handle the slider "updating" event.
     *
     * @param  \App\Model\Downloadables  $categ
     * @return void
     */
    public function updating(Downloadables $categ)
    {
        $dd->updated_by = Auth::id();
    }
    
    /**
     * Handle the downloadables "created" event.
     *
     * @param  \App\Model\Downloadables  $downloadables
     * @return void
     */
    public function created(Downloadables $downloadables)
    {
        //
    }

    /**
     * Handle the downloadables "updated" event.
     *
     * @param  \App\Model\Downloadables  $downloadables
     * @return void
     */
    public function updated(Downloadables $downloadables)
    {
        //
    }

    /**
     * Handle the downloadables "deleted" event.
     *
     * @param  \App\Model\Downloadables  $downloadables
     * @return void
     */
    public function deleted(Downloadables $downloadables)
    {
        //
    }

    /**
     * Handle the downloadables "restored" event.
     *
     * @param  \App\Model\Downloadables  $downloadables
     * @return void
     */
    public function restored(Downloadables $downloadables)
    {
        //
    }

    /**
     * Handle the downloadables "force deleted" event.
     *
     * @param  \App\Model\Downloadables  $downloadables
     * @return void
     */
    public function forceDeleted(Downloadables $downloadables)
    {
        //
    }
}
