<?php

namespace App\Observers;

use App\Model\Newsletters;
use Illuminate\Support\Facades\Auth;

class NewslettersObserver
{
    /**
     * Handle the slider "creating" event.
     *
     * @param  \App\Model\Slider  $categ
     * @return void
     */
    public function creating(Newsletters $newsletters)
    {
        $newsletters->created_by = Auth::id();
    }

    /**
     * Handle the slider "updating" event.
     *
     * @param  \App\Model\Slider  $categ
     * @return void
     */
    public function updating(Newsletters $newsletters)
    {
        $newsletters->updated_by = Auth::id();
    }
    
    /**
     * Handle the newsletters "created" event.
     *
     * @param  \App\Model\Newsletters  $newsletters
     * @return void
     */
    public function created(Newsletters $newsletters)
    {
        //
    }

    /**
     * Handle the newsletters "updated" event.
     *
     * @param  \App\Model\Newsletters  $newsletters
     * @return void
     */
    public function updated(Newsletters $newsletters)
    {
        //
    }

    /**
     * Handle the newsletters "deleted" event.
     *
     * @param  \App\Model\Newsletters  $newsletters
     * @return void
     */
    public function deleted(Newsletters $newsletters)
    {
        //
    }

    /**
     * Handle the newsletters "restored" event.
     *
     * @param  \App\Model\Newsletters  $newsletters
     * @return void
     */
    public function restored(Newsletters $newsletters)
    {
        //
    }

    /**
     * Handle the newsletters "force deleted" event.
     *
     * @param  \App\Model\Newsletters  $newsletters
     * @return void
     */
    public function forceDeleted(Newsletters $newsletters)
    {
        //
    }
}
