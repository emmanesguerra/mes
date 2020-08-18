<?php

namespace Core\Observers;

use Core\Model\User;
use Illuminate\Support\Facades\Auth;

class UserObserver
{
    //
    /**
     * Listen to the User creating event.
     *
     * @param  \Core\Model\User  $args
     * @return void
     */
    public function creating(User $args)
    {
        $args->created_by = Auth::id();
    }
    
    /**
     * Listen to the User updating event.
     *
     * @param  \Core\Model\User  $args
     * @return void
     */
    public function updating(User $args)
    {
        $args->updated_by = Auth::id();
    }
}
