<?php

namespace App\Http\Controllers\News\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\PostNewsCategoryRequest;
use App\Http\Requests\PatchNewsCategoryRequest;
use Core\Library\DataTables;
use App\Model\NewsCategory;

class NewsCategoryController extends Controller
{
    //put your code here
    
    public function index()
    {
        return view('admin.modules.news.category.index');
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
            3 => ['short_description'],
            5 => ['updated_at'],
        ];
        
        $filteredmodel = DB::table('news_categories');
        if($request->isTrashed == 'true') {
            $filteredmodel->whereNotNull('deleted_at');
        } else {
            $filteredmodel->whereNull('deleted_at');
        }
        $filteredmodel->select(DB::raw("id, 
                    name,
                    short_description,
                    updated_at")
            );
        
        $modelcnt = $filteredmodel->count();
        
        $data = DataTables::DataTableFilters($filteredmodel, $request, $tablecols, $hasValue, $totalFiltered);
        
        return response(['data'=> $data,
            'draw' => $request->draw,
            'recordsTotal' => ($hasValue)? $data->count(): $modelcnt,
            'recordsFiltered' => ($hasValue)? $totalFiltered: $modelcnt], 200);
    }
    
    public function create()
    {
        return view('admin.modules.news.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostNewsCategoryRequest $request)
    {
        try
        {
            NewsCategory::create($request->only('name', 'short_description'));
            
            return redirect()->route('admin.newscategory.index')->with('status-success', 'Category created successfully');
            
        } catch (\Exception $ex) {
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
        $newscategory = NewsCategory::find($id);
        
        return view('admin.modules.news.category.show')->with(compact('newscategory'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $newscategory = NewsCategory::find($id);
        
        return view('admin.modules.news.category.edit')->with(compact('newscategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PatchNewsCategoryRequest $request, $id)
    {
        try
        {
            $newscategory = NewsCategory::find($id);
            $newscategory->update($request->only('name', 'short_description'));
            
            return redirect()->route('admin.newscategory.index')->with('status-success','Category ID#'.$id.' updated successfully');
            
        } catch (\Exception $ex) {
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
            NewsCategory::find($id)->delete();
            return redirect()->route('admin.newscategory.index')
                            ->with('status-success','News category deleted successfully');
        } catch (Exception $ex) {
            return redirect()->route('admin.newscategory.index')
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
        return view('admin.modules.news.category.trashed');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $newscategory = NewsCategory::onlyTrashed()->find($id);
        
        return view('admin.modules.news.category.show')->with(compact('newscategory'));
    }
    
    public function processrestore(Request $request, $id)
    {
        try
        {
            NewsCategory::onlyTrashed()->find($id)->restore();
            
            return redirect()->route('admin.newscategory.index')->with('status-success', 'News Category ID#'.$id.' restored successfully');
            
        } catch (\Exception $ex) {
            return redirect()->back()->with('status-failed', $ex->getMessage());
        }
    }
    
    public function forcedelete($id)
    {
        try
        {
            NewsCategory::onlyTrashed()->find($id)->forceDelete();
                    
            return redirect()->route('admin.newscategory.index')
                            ->with('status-success','News Category ID#'.$id.' is permanently deleted in the system');
        } catch (Exception $ex) {
            return redirect()->route('admin.newscategory.index')
                            ->with('status-failed', $ex->getMessage());
        }
    }
}
