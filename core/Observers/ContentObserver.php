<?php

namespace Core\Observers;

use Core\Model\Content;
use Illuminate\Support\Facades\Auth;

class ContentObserver
{
    /**
     * Listen to the Content creating event.
     *
     * @param  \Core\Model\Content  $args
     * @return void
     */
    public function creating(Content $args)
    {
        $args->created_by = Auth::id();
    }
    
    /**
     * Listen to the Content updating event.
     *
     * @param  \Core\Model\Content  $args
     * @return void
     */
    public function updating(Content $args)
    {
        $args->updated_by = Auth::id();
    }
}
