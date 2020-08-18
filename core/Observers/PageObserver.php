<?php

namespace Core\Observers;

use Core\Model\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PageObserver
{
    /**
     * Listen to the Page creating event.
     *
     * @param  \Core\Model\Page  $args
     * @return void
     */
    public function creating(Page $args)
    {
        $file = Storage::disk('templates')->get($args->template);
        $args->template_html = $file;
        $args->created_by = Auth::id();
    }
    
    /**
     * Listen to the Page updating event.
     *
     * @param  \Core\Model\Page  $args
     * @return void
     */
    public function updating(Page $args)
    {
        $args->updated_by = Auth::id();
    }
}
