<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\News;
use App\Model\NewsCategory;

class NewsController extends Controller
{
    CONST PAGINATE_CTR = 5;
    
    public function panel() 
    {
        $news = News::orderBy('created_at', 'desc')->get();
        
        return view('modules.news.list')->with(compact('news'));
    }
    
    public function main($content, $args = null)
    {
        $level = 3;
        $news = News::where('slug', last($args))->first();
        if(!$news) {
            $news = NewsCategory::where('slug', last($args))->first();
            $level = 2;
        }
        if(!$news) {
            $news = News::paginate(self::PAGINATE_CTR);
            $level = 1;
        }
        
        $html = "";
        if($level === 3) {
            $html = $this->DisplayNewsContent($news);
        } else if ($level === 2) {
            $html = $this->DisplayCategoryContent($news);
        } else {
            $html = $this->DisplayAllNews($news);
        }
        
        return $html;
    }
    
    private function DisplayNewsContent(News $news) 
    {
        return view('modules.news.main')->with(compact('news'));
    }
    
    private function DisplayCategoryContent(NewsCategory $category) 
    {
        $news = $category->news()->paginate(self::PAGINATE_CTR);
        
        return view('modules.news.category')->with(compact('category', 'news'));
    }
    
    private function DisplayAllNews($news) 
    {
        return view('modules.news.paginate')->with(compact('news'));
    }
}
