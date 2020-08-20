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
        $news = News::orderBy('created_at', 'desc')->limit(5)->get();
        
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
        
        $menu = new \Core\Http\Controllers\Menu\MenuController();
        $quicklink = \Core\Model\Content::where('name', 'Quicklinks Nav')->first();
        $quicklinks = $menu->navi($quicklink);
        
        $html = "";
        if($level === 3) {
            $html = $this->DisplayNewsContent($news, $quicklinks);
        } else if ($level === 2) {
            $html = $this->DisplayCategoryContent($news, $quicklinks);
        } else {
            $html = $this->DisplayAllNews($news, $quicklinks);
        }
        
        return $html;
    }
    
    private function DisplayNewsContent(News $news, $quicklinks) 
    {
        $categoryLists = $this->DisplayCategoryLists();
        
        return view('modules.news.main')->with(compact('news', 'categoryLists', 'quicklinks'));
    }
    
    private function DisplayCategoryContent(NewsCategory $category, $quicklinks) 
    {
        $categoryLists = $this->DisplayCategoryLists();
        $news = $category->news()->paginate(self::PAGINATE_CTR);
        
        return view('modules.news.category')->with(compact('category', 'news', 'categoryLists', 'quicklinks'));
    }
    
    private function DisplayAllNews($news, $quicklinks) 
    {
        $categoryLists = $this->DisplayCategoryLists();
        
        return view('modules.news.paginate')->with(compact('news', 'categoryLists', 'quicklinks'));
    }
    
    private function DisplayCategoryLists()
    {
        $categories = NewsCategory::orderBy('name', 'asc')->get();
        
        return  view('modules.news.panels.category')->with(compact('categories'));
    }
}
