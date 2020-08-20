<?php

namespace App\Observers;

use App\Model\Subscriber;
use Illuminate\Support\Facades\Auth;

class SubscriberObserver
{
    /**
     * Handle the slider "creating" event.
     *
     * @param  \App\Model\Subscriber  $subs
     * @return void
     */
    public function creating(Subscriber $subs)
    {
        $subs->created_by = Auth::id();
    }

    /**
     * Handle the slider "updating" event.
     *
     * @param  \App\Model\Subscriber  $subs
     * @return void
     */
    public function updating(Subscriber $subs)
    {
        $subs->updated_by = Auth::id();
    }
}
