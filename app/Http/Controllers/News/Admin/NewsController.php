<?php

namespace App\Http\Controllers\News\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Core\Library\DataTables;
use Core\Library\FileManager;
use Core\Model\Page;
use App\Model\News;
use App\Model\NewsCategory;
use App\Http\Requests\PostNewsRequest;
use App\Http\Requests\PatchNewsRequest;

class NewsController extends Controller
{
    public $displayAdmin = true;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.modules.news.index');
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
            0 => ['news.id'],
            1 => ['news_categories.name'],
            2 => ['news.title'],
            3 => ['news.short_description'],
            4 => ['news.updated_at'],
        ];
        
        $filteredmodel = DB::table('news')
                ->leftjoin('news_categories', 'news_categories.id', '=', 'news.category_id');
        if($request->isTrashed == 'true') {
            $filteredmodel->whereNotNull('news.deleted_at');
        } else {
            $filteredmodel->whereNull('news.deleted_at');
        }
        $filteredmodel->select(DB::raw("news.id, 
                    news_categories.name, 
                    news.title, 
                    news.short_description,
                    news.updated_at")
            );
        
        $modelcnt = $filteredmodel->count();
        
        $data = DataTables::DataTableFilters($filteredmodel, $request, $tablecols, $hasValue, $totalFiltered);
        
        return response(['data'=> $data,
            'draw' => $request->draw,
            'recordsTotal' => ($hasValue)? $data->count(): $modelcnt,
            'recordsFiltered' => ($hasValue)? $totalFiltered: $modelcnt], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $disk = 'adminuploads';
        $allFiles = Storage::disk($disk)->files();
        $images = FileManager::getImageRelativePath($allFiles, $disk);
        
        $page = Page::where('name', 'News')->first();
        $styles = FileManager::GetCSSRelativePath($page->css);
        
        $categories = NewsCategory::get(['id', 'name as label']);
        
        return view('admin.modules.news.create')->with(compact('styles', 'images', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostNewsRequest $request)
    {
        try
        {
            News::create($request->only('category_id', 'title', 'short_description', 'description'));
            
            return redirect()->route('admin.news.index')->with('status-success', 'News created successfully');
            
        } catch (\Exception $ex) {
            return redirect()->back()->with('status-failed', $ex->getMessage())
                        ->withInput($request->input());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\News  $news
     * @return \Illuminate\Http\Response
     */
    public function show(News $news)
    {
        return view('admin.modules.news.show')->with(compact('news'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\News  $news
     * @return \Illuminate\Http\Response
     */
    public function edit(News $news)
    {
        $disk = 'adminuploads';
        $allFiles = Storage::disk($disk)->files();
        $images = FileManager::getImageRelativePath($allFiles, $disk);
        
        $page = Page::where('name', 'News')->first();
        $styles = FileManager::GetCSSRelativePath($page->css);
        
        $categories = NewsCategory::get(['id', 'name as label']);
        
        return view('admin.modules.news.edit')->with(compact('news', 'styles', 'images', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\News  $news
     * @return \Illuminate\Http\Response
     */
    public function update(PatchNewsRequest $request, News $news)
    {
        try
        {
            $news->update($request->only('title', 'description', 'link', 'image_alt'));
            
            return redirect()->route('admin.news.index')->with('status-success','News ID#'.$news->id.' updated successfully');
            
        } catch (\Exception $ex) {
            return redirect()->back()->with('status-failed', $ex->getMessage())
                        ->withInput($request->input());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\News  $news
     * @return \Illuminate\Http\Response
     */
    public function destroy(News $news)
    {
        try
        {
            $news->delete();
            return redirect()->route('admin.news.index')
                            ->with('status-success','News ID#'.$news->id.' deleted successfully');
        } catch (Exception $ex) {
            return redirect()->route('admin.news.index')
                            ->with('status-failed', $ex->getMessage());
        }
    }
    
    /**
     * Display a listing of the trashed resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trashed()
    {
        return view('admin.modules.news.trashed');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $news = News::onlyTrashed()->find($id);
        
        return view('admin.modules.news.show')->with(compact('news'));
    }
    
    public function processrestore(Request $request, $id)
    {
        try
        {
            News::onlyTrashed()->find($id)->restore();
            
            return redirect()->route('admin.news.index')->with('status-success', 'News ID#'.$id.' restored successfully');
            
        } catch (\Exception $ex) {
            return redirect()->back()->with('status-failed', $ex->getMessage());
        }
    }
    
    public function forcedelete($id)
    {
        try
        {
            $news = News::onlyTrashed()->find($id)->forceDelete();
                    
            return redirect()->route('admin.news.index')
                            ->with('status-success','News ID#'.$id.' is permanently deleted in the system');
        } catch (Exception $ex) {
            return redirect()->route('admin.news.index')
                            ->with('status-failed', $ex->getMessage());
        }
    }
}
