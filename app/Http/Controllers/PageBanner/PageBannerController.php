<?php

namespace App\Http\Controllers\PageBanner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\PageBanner;
use App\Model\Page;

class PageBannerController extends Controller
{
    public function panel() 
    {
        $url = \Request::getRequestUri();
        
        $page = Page::where('url', $url)->first();
        
        $banner = $page->banner;
        
        return view('modules.banner.index')->with(compact('banner'));
    }
}
