<?php

namespace Core\Observers;

use Illuminate\Support\Facades\Auth;
use Core\Model\Menu;

class MenuObserver
{
    /**
     * Listen to the Content creating event.
     *
     * @param  \Core\Model\Content  $args
     * @return void
     */
    public function creating(Menu $args)
    {
        $args->created_by = Auth::id();
    }
    
    /**
     * Listen to the Content updating event.
     *
     * @param  \Core\Model\Content  $args
     * @return void
     */
    public function updating(Menu $args)
    {
        $args->updated_by = Auth::id();
    }
}
