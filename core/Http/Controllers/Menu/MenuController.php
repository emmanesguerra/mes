<?php

namespace Core\Http\Controllers\Menu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Core\Http\Requests\StoreMenuRequest;
use Core\Http\Requests\StoreMenuSettingRequest;
use Core\Model\Content;
use Core\Model\Menu;
use Core\Model\MenuSetting;
use Core\Model\Page;
use Core\Library\HierarchicalDB;
use Core\Library\DataTables;

class MenuController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:menus-list|menus-create|menus-edit|menus-delete', ['only' => ['index','store']]);
         $this->middleware('permission:menus-create', ['only' => ['create','store']]);
         $this->middleware('permission:menus-edit', ['only' => ['settings','settingsstore']]);
         $this->middleware('permission:menus-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = \Core\Model\Page::get(['id', 'name']);
        
        return view('admin.layouts.modules.menu.index')->with(compact('pages'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request)
    {
        $tablecols = [
            1 => ['title']
        ];
        
        $filteredmodel = DB::table('menus')
                ->select(DB::raw("title, 
                    parent_id,
                    page_id,
                    lft,
                    rgt,
                    id,
                    lvl")
            )->orderBy('lft');
        
        $modelcnt = $filteredmodel->count();
        
        $data = DataTables::DataTableFilters($filteredmodel, $request, $tablecols, $hasValue, $totalFiltered);
        
        return response(['data'=> $data,
            'draw' => $request->draw,
            'recordsTotal' => ($hasValue)? $data->count(): $modelcnt,
            'recordsFiltered' => ($hasValue)? $totalFiltered: $modelcnt], 200);
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMenuRequest $request)
    {
        try
        {
            DB::beginTransaction();
            
            $parent = Menu::find($request->parentId);
            
            $hierarchyLib = new HierarchicalDB('menus');
            
            if($parent) {
                $hierarchyLib->updateLftPlus($parent->rgt);
                $hierarchyLib->updateRgtPlus($parent->rgt);
                $left = $parent->rgt;
                $lvl = $parent->lvl + 1;
            } else {
                $left = $hierarchyLib->getLastRgt() + 1;
                $lvl = 1;
            }
            $right = $left + 1;
            $page = Page::find($request->pageId);
            $title = ($page) ? $page->name: $request->nTitle;
            
            $menu = Menu::create([
                'title' => $title,
                'parent_id' => $request->parentId,
                'page_id' => ($request->has('pageId')) ? $request->pageId: null,
                'lft' => $left,
                'rgt' => $right,
                'lvl' => $lvl
            ]);
            
            $this->createContentPanel($menu);
            $this->createMenuSetting($menu);
            
            DB::commit();
            
            Session::flash('status-success', 'New menu added');
            
            return response(['response'=> 'Menu created'], 200);
            
        } catch (\Exception $ex) {
            DB::rollback();
            return response(['response'=> $ex->getMessage()], 400);
        }
    }
    
    private function createContentPanel($menu)
    {
        if($menu) {
            if(is_null($menu->page_id)) {
                Content::create([
                    'name' => $menu->title . ' Nav',
                    'type' => 'N',
                    'class_namespace' => '\Core\Http\Controllers\Menu\MenuController',
                    'method_name' => 'navi'
                ]);
            }
        } 
        
        return;
    }
    
    private function createMenuSetting($menu)
    {
        if($menu) {
            if(is_null($menu->page_id)) {
        
                MenuSetting::create(['menu_id' => $menu->id, 
                    'blck_start' => '', 
                    'blck_end' => '', 
                    'list_dflt' => '', 
                    'list_chld' => '', 
                    'list_end' => '', 
                    'anch_dflt' => '', 
                    'anch_chld' => '']);
                
            }
        }
        
        return;
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try
        {
            DB::beginTransaction();
            
            $menu = Menu::find($id);
            
            if($menu) {
                $hierarchyLib = new HierarchicalDB('menus');
                $hierarchyLib->updateLftMinus($menu->rgt);
                $hierarchyLib->updateRgtMinus($menu->rgt);
                
                $title = $menu->title;
                
                $this->deleteContentPanel($menu);
                
                $menu->delete();
            } 
            
            DB::commit();
            return redirect()->route('admin.menus.index')
                        ->with('status-success', $title . ' has been removed');
            
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->route('admin.menus.index')
                        ->with('status-failed', $ex->getMessage());
        }
    }
    
    private function deleteContentPanel($menu)
    {
        if(is_null($menu->page_id)) {
            $content = Content::where([
                'name' => $menu->title . ' Nav',
                'type' => 'N'
            ])->first();
            
            if($content) {
                $content->delete();
            }
        }
        
        return;
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function settings($id)
    {
        $settings = MenuSetting::find($id);
        
        return view('admin.layouts.modules.menu.settings')->with(compact('settings'));
    }
    
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function settingsstore(StoreMenuSettingRequest $request, $id)
    {
        try
        {
            $settings = MenuSetting::find($id);
            $settings->update($request->only(
                    'blck_start', 
                    'blck_end', 
                    'list_dflt', 
                    'list_chld', 
                    'list_end', 
                    'anch_dflt', 
                    'anch_chld',
                    'subblck_start', 
                    'subblck_end', 
                    'sublist_dflt', 
                    'sublist_chld', 
                    'sublist_end', 
                    'subanch_dflt', 
                    'subanch_chld'));

            return redirect()->route('admin.menus.index')
                            ->with('status-success','Menu settings updated successfully');
            
        } catch (\Exception $ex) {
            return redirect()->back()->with('status-failed', $ex->getMessage());
        }
    }
    
    public function navi(Content $content)
    {
        try
        {
            $title = str_replace(" Nav", "", $content->name);
            $root = Menu::where('title' , $title)->select('lft', 'rgt', 'id')->first();
            $settings = $root->setting;
            
            if($root) {
                $html = $this->generateNaviForChildren($root->submenu, $settings, false);
                return $html;
            }
            return "";
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
        }
    }
    
    private function generateNaviForChildren($submenu, $settings, $isChildren = true) 
    {
        $html = ($isChildren) ? $settings->subblck_start: $settings->blck_start;
                
        foreach($submenu as $menu) {
            if(count($menu->submenu) > 0) {
                $html .= ($isChildren) ? $settings->sublist_chld: $settings->list_chld;
                $anchor = ($isChildren) ? $settings->subanch_chld: $settings->anch_chld;
            } else {
                $html .= ($isChildren) ? $settings->sublist_dflt: $settings->list_dflt;
                $anchor = ($isChildren) ? $settings->subanch_dflt: $settings->anch_dflt;
            }
            
            $page = $menu->page;
            $html .= view('layouts.navigation.anchor')->with(compact('anchor', 'page'));
            
            if(count($menu->submenu) > 0) {
                $html .= $this->generateNaviForChildren($menu->submenu, $settings, true);
            }
            
            $html .= ($isChildren) ? $settings->sublist_end: $settings->list_end;
        }
        
        $html .= ($isChildren) ? $settings->subblck_end: $settings->blck_end;
        
        return $html;
    }
}
