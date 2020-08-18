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
        $url = '/' . $params;
        
        $page = Page::where('url', $url)->first();
        
        if($page) {
            
            $data = [];
            
            foreach($page->contents as $panel) {
                if($panel->html_template) {
                    $data[$panel->pivot->tags] = $panel->html_template;
                } else {
                    $module = new $panel->class_namespace;
                    $fnname = $panel->method_name;
                    $data[$panel->pivot->tags] = $module->$fnname($panel);
                }
            }
        
            $this->GenerateHeader($page);
            
            echo view('templates.' . str_replace('.blade.php', "", $page->template), $data);
        
            $this->GenerateFooter($page);
            
        } else {
            echo 'Page not found';
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
