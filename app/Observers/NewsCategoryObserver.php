<?php

namespace App\Observers;

use App\Model\NewsCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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
        $categ->slug = Str::slug($categ->name);
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
        $categ->slug = Str::slug($categ->name);
    }
}
