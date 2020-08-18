<?php

namespace Core\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Core\Http\Requests\StorePageRequest;
use Core\Http\Requests\UpdatePageRequest;
use Core\Model\Page;
use Core\Model\Content;
use Core\Library\DataTables;

class PageController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:pages-list|pages-create|pages-edit|pages-delete', ['only' => ['index','store']]);
         $this->middleware('permission:pages-create', ['only' => ['create','store']]);
         $this->middleware('permission:pages-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:pages-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.layouts.modules.page.index');
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
            0 => ['id'],
            1 => ['name'],
            2 => ['url'],
            3 => ['description'],
            4 => ['template'],
            5 => ['updated_at'],
        ];
        
        $filteredmodel = DB::table('pages');
        if($request->isTrashed == 'true') {
            $filteredmodel->whereNotNull('deleted_at');
        } else {
            $filteredmodel->whereNull('deleted_at');
        }
        $filteredmodel->select(DB::raw("id, 
                    name, 
                    url,
                    description, 
                    template,
                    updated_at")
            );
        
        $modelcnt = $filteredmodel->count();
        
        $data = DataTables::DataTableFilters($filteredmodel, $request, $tablecols, $hasValue, $totalFiltered);
        
        return response(['data'=> $data,
            'draw' => $request->draw,
            'recordsTotal' => ($hasValue)? $data->count(): $modelcnt,
            'recordsFiltered' => ($hasValue)? $totalFiltered: $modelcnt], 200);
    }
    
    public function template(Request $request)
    {
        $file = Storage::disk('templates')->get($request->template);
        
        $pattern = '/\{!!(.*?)\!!}/';
        preg_match_all ($pattern, $file, $matches);
        
        $resp = collect($matches[1])->map(function($panels) {
             return [
                     'panel' => trim(str_replace('$', '', $panels)),
                     'name' => null,
                     'html_template' => null,
                     'isnew' => false,
                     'selected' => null
             ];
        });
        
        return response(['data'=> $resp], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $files = Storage::disk('templates')->allFiles();
        $scripts = Storage::disk('javascripts')->allFiles();
        $styles = Storage::disk('css')->allFiles();
        
        $contents = Content::get(['id', 'name']);
        $contents->push(['id' => 'NEW', 'name' => 'Create New'])->toArray();
        
        return view('admin.layouts.modules.page.create')->with(compact('files', 'scripts', 'styles', 'contents'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePageRequest $request)
    {
        try
        {
            DB::beginTransaction();
            
            $page = Page::create($request->only('name', 'title', 'url', 'description', 'javascripts', 'css', 'template'));
            
            if($page) {
                if($request->has('contents')) {
                    foreach($request->contents as $tags => $data) {
                        if(isset($data['selected_panel'])) {
                            $contentId = $data['selected_panel'];
                        } else {
                            $content = Content::create([
                                'name' => $data['name'], 
                                'html_template' => $data['html_template'], 
                                'container_class' => $data['classname'], 
                                'type' => ($tags == 'Main') ? 'M': 'P']);
                            $contentId = $content->id;
                        }
                        
                        $page->contents()->attach($contentId, ['tags' => $tags]);
                    }
                }
            }
            DB::commit();
            return redirect()->route('admin.pages.index')->with('status-success', 'Page created successfully');
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()
                    ->with('status-failed', $ex->getMessage())
                    ->withInput($request->input());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $page = Page::find($id);
        $page->contents;
        
        return view('admin.layouts.modules.page.show')->with(compact('page'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page = Page::find($id);
        
        $panels = $page->contents->map(function ($panel) {
            return [
                     'panel' => $panel->pivot->tags,
                     'name' => $panel->id,
                     'html_template' => $panel->html_template,
                     'isnew' => false,
                     'selected' => $panel->id
             ];
        });
        
        $files = Storage::disk('templates')->allFiles();
        $scripts = Storage::disk('javascripts')->allFiles();
        $styles = Storage::disk('css')->allFiles();
        
        $contents = Content::get(['id', 'name']);
        $contents->push(['id' => 'NEW', 'name' => 'Create New'])->toArray();
        
        return view('admin.layouts.modules.page.edit')->with(compact('page', 'files', 'scripts', 'styles', 'contents', 'panels'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePageRequest $request, $id)
    {
        try
        {
            DB::beginTransaction();
            
            $page = Page::find($id);
            $page->update($request->only('name', 'title', 'description', 'javascripts', 'css', 'template'));
            
            if($page) {
                if($request->has('contents')) {
                    $page->contents()->detach();
                    foreach($request->contents as $tags => $data) {
                        if(isset($data['selected_panel'])) {
                            $contentId = $data['selected_panel'];
                        } else {
                            $content = Content::create([
                                'name' => $data['name'], 
                                'html_template' => $data['html_template'], 
                                'container_class' => $data['classname'], 
                                'type' => ($tags == 'Main') ? 'M': 'P']);
                            $contentId = $content->id;
                        }
                        
                        $page->contents()->attach($contentId, ['tags' => $tags]);
                    }
                }
            }
            DB::commit();
            return redirect()->route('admin.pages.index')->with('status-success', 'Page updated successfully');
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()
                    ->with('status-failed', $ex->getMessage())
                    ->withInput($request->input());
        }
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
            Page::find($id)->delete();
            return redirect()->route('admin.pages.index')
                            ->with('status-success','Page deleted successfully');
        } catch (\Exception $ex) {
            return redirect()->back()->with('status-failed', $ex->getMessage());
        }
    }
    
    /**
     * Display a listing of the trashed resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trashed()
    {
        return view('admin.layouts.modules.page.trashed');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $page = Page::onlyTrashed()->find($id);
        $page->contents;
        
        return view('admin.layouts.modules.page.show')->with(compact('page'));
    }
    
    public function processrestore(Request $request, $id)
    {
        try
        {
            Page::onlyTrashed()->find($id)->restore();
            
            return redirect()->route('admin.pages.index')->with('status-success', 'Page ID#'.$id.' restored successfully');
            
        } catch (\Exception $ex) {
            return redirect()->back()->with('status-failed', $ex->getMessage());
        }
    }
    
    public function forcedelete($id)
    {
        try
        {
            Page::onlyTrashed()->find($id)->forceDelete();
            
            return redirect()->route('admin.pages.index')
                            ->with('status-success','Page ID#'.$id.' is permanently deleted in the system');
        } catch (Exception $ex) {
            return redirect()->route('admin.pages.index')
                            ->with('status-failed', $ex->getMessage());
        }
    }
}
