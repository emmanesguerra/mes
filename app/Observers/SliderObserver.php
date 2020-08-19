<?php

namespace App\Observers;

use App\Model\Slider;
use Illuminate\Support\Facades\Auth;

class SliderObserver
{
    /**
     * Handle the slider "creating" event.
     *
     * @param  \App\Model\Slider  $slider
     * @return void
     */
    public function creating(Slider $slider)
    {
        $slider->created_by = Auth::id();
    }

    /**
     * Handle the slider "updating" event.
     *
     * @param  \App\Model\Slider  $slider
     * @return void
     */
    public function updating(Slider $slider)
    {
        $slider->updated_by = Auth::id();
    }

    /**
     * Handle the slider "deleted" event.
     *
     * @param  \App\Model\Slider  $slider
     * @return void
     */
    public function deleted(Slider $slider)
    {
        //
    }

    /**
     * Handle the slider "restored" event.
     *
     * @param  \App\Model\Slider  $slider
     * @return void
     */
    public function restored(Slider $slider)
    {
        //
    }

    /**
     * Handle the slider "force deleted" event.
     *
     * @param  \App\Model\Slider  $slider
     * @return void
     */
    public function forceDeleted(Slider $slider)
    {
        //
    }
}
