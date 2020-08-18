<?php

namespace Core\Observers;

use Core\Model\Office;
use Illuminate\Support\Facades\Auth;

class OfficeObserver
{
    /**
     * Listen to the Office creating event.
     *
     * @param  \Core\Model\Office  $args
     * @return void
     */
    public function creating(Office $args)
    {
        $args->created_by = Auth::id();
        
        if($args->marker) {
            preg_match('/src="([^"]*)"/', $args->marker, $match);
            if(isset($match[1])) {
                $args->marker = $match[1];
            }
        }
    }
    
    /**
     * Listen to the Office updating event.
     *
     * @param  \Core\Model\Office  $args
     * @return void
     */
    public function updating(Office $args)
    {
        $args->updated_by = Auth::id();
        
        if($args->marker) {
            preg_match('/src="([^"]*)"/', $args->marker, $match);
            if(isset($match[1])) {
                $args->marker = $match[1];
            }
        }
    }
}
