<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

use Core\Model\Page as CorePage;

class Page extends CorePage
{
    //
    public function banner()
    {
        return $this->hasOne(PageBanner::class);
    }
}
