<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\News;

class NewsController extends Controller
{
    public function panel() 
    {
        $news = News::all();
        
        return view('modules.news.list')->with(compact('news'));
    }
}
