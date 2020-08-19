<?php

namespace App\Observers;

use App\Model\NewsCategory;
use Illuminate\Support\Facades\Auth;

class NewsCategoryObserver
{
    /**
     * Handle the slider "creating" event.
     *
     * @param  \App\Model\Slider  $categ
     * @return void
     */
    public function creating(NewsCategory $categ)
    {
        $categ->created_by = Auth::id();
    }

    /**
     * Handle the slider "updating" event.
     *
     * @param  \App\Model\Slider  $categ
     * @return void
     */
    public function updating(NewsCategory $categ)
    {
        $categ->updated_by = Auth::id();
    }
}
