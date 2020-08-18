<?php

namespace Core\Observers;

use Core\Model\Module;
use Illuminate\Support\Facades\Auth;

class ModuleObserver
{
    /**
     * Listen to the Module creating event.
     *
     * @param  \Core\Model\Module  $args
     * @return void
     */
    public function creating(Module $args)
    {
        $args->created_by = Auth::id();
    }
    
    /**
     * Listen to the Module updating event.
     *
     * @param  \Core\Model\Module  $args
     * @return void
     */
    public function updating(Module $args)
    {
        $args->updated_by = Auth::id();
    }
}
