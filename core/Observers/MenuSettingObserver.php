<?php

namespace Core\Observers;

use Illuminate\Support\Facades\Auth;
use Core\Model\MenuSetting;

class MenuSettingObserver
{
    /**
     * Listen to the Content creating event.
     *
     * @param  \Core\Model\Content  $args
     * @return void
     */
    public function creating(MenuSetting $args)
    {
        $args->created_by = Auth::id();
    }
    
    /**
     * Listen to the Content updating event.
     *
     * @param  \Core\Model\Content  $args
     * @return void
     */
    public function updating(MenuSetting $args)
    {
        $args->updated_by = Auth::id();
    }
}
