<?php

namespace Core\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Core\Model\Page;

class AEController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($params = null)
    {
        $url = array_filter(explode('/', \Request::getPathInfo()));
        
        $page = Page::where('url', '/'. reset($url))->first();
        
        if($page) {
            
            $data = [];
            
            foreach($page->contents as $panel) {
                if($panel->html_template) {
                    $data[$panel->pivot->tags] = $panel->html_template;
                } else {
                    $module = new $panel->class_namespace;
                    $fnname = $panel->method_name;
                    $data[$panel->pivot->tags] = $module->$fnname($panel, $url);
                }
            }
        
            $this->GenerateHeader($page);
            
            echo view('templates.' . str_replace('.blade.php', "", $page->template), $data);
        
            $this->GenerateFooter($page);
            
        } else {
            abort(404);
        }
    }
    
    private function GenerateHeader(Page $page)
    {
        echo view('layouts.header')->with(compact('page'));
    }
    
    private function GenerateFooter(Page $page)
    {        
        echo view('layouts.footer')->with(compact('page'));
    }
}
