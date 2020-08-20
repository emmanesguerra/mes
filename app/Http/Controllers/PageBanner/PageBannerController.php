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
        $url = array_filter(explode('/', \Request::getPathInfo()));
        
        $page = Page::where('url', '/'. reset($url))->first();
        
        if($page->banner) {
            $banner = $page->banner;
        
            return view('modules.banner.index')->with(compact('banner'));
        } else {
            return "";
        }
    }
}
