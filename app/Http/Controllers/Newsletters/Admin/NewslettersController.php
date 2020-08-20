<?php

namespace App\Http\Controllers\Newsletters\Admin;

use App\Http\Controllers\Controller;
use App\Model\Newsletters;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Core\Library\FileManager;
use Core\Library\DataTables;
use App\Http\Requests\PostNewslettersRequest;
use App\Http\Requests\PatchNewslettersRequest;

class NewslettersController extends Controller
{
    public $displayAdmin = true;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.modules.newsletters.index');
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
            1 => ['title'],
            2 => ['updated_at'],
        ];
        
        $filteredmodel = DB::table('newsletters');
        if($request->isTrashed == 'true') {
            $filteredmodel->whereNotNull('deleted_at');
        } else {
            $filteredmodel->whereNull('deleted_at');
        }
        $filteredmodel->select(DB::raw("id, 
                    title, 
                    updated_at")
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
        
        return view('admin.modules.newsletters.create')->with(compact('images'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostNewslettersRequest $request)
    {
        try
        {
            Newsletters::create($request->only(['title', 'content']));
            
            return redirect()->route('admin.newsletters.index')->with('status-success', 'Newsletter created successfully');
            
        } catch (\Exception $ex) {
            return redirect()->back()
                    ->with('status-failed', $ex->getMessage())
                    ->withInput($request->input());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Newsletters  $newsletters
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $newsletters = Newsletters::find($id);
        
        return view('admin.modules.newsletters.show')->with(compact('newsletters'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Newsletters  $newsletters
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $disk = 'adminuploads';
        $allFiles = Storage::disk($disk)->files();
        $images = FileManager::getImageRelativePath($allFiles, $disk);
        
        $newsletters = Newsletters::find($id);
        
        return view('admin.modules.newsletters.edit')->with(compact('newsletters', 'images'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Newsletters  $newsletters
     * @return \Illuminate\Http\Response
     */
    public function update(PatchNewslettersRequest $request, $id)
    {
        try
        {
            $newsletters = Newsletters::find($id);
            $newsletters->update($request->only('title', 'content'));
            
            return redirect()->route('admin.newsletters.index')->with('status-success','Newsletter ID#'.$newsletters->id.' updated successfully');
            
        } catch (\Exception $ex) {
            return redirect()->back()->with('status-failed', $ex->getMessage())
                        ->withInput($request->input());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Newsletters  $newsletters
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try
        {
            $newsletters = Newsletters::find($id);
            $newsletters->delete();
            return redirect()->route('admin.newsletters.index')
                            ->with('status-success','Newsletter ID#'.$newsletters->id.' deleted successfully');
        } catch (Exception $ex) {
            return redirect()->route('admin.newsletters.index')
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
        return view('admin.modules.newsletters.trashed');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $newsletters = Newsletters::onlyTrashed()->find($id);
        
        return view('admin.modules.newsletters.show')->with(compact('newsletters'));
    }
    
    public function processrestore(Request $request, $id)
    {
        try
        {
            Newsletters::onlyTrashed()->find($id)->restore();
            
            return redirect()->route('admin.newsletters.index')->with('status-success', 'Newsletter ID#'.$id.' restored successfully');
            
        } catch (\Exception $ex) {
            return redirect()->back()->with('status-failed', $ex->getMessage());
        }
    }
    
    public function forcedelete($id)
    {
        try
        {
            Newsletters::onlyTrashed()->find($id)->forceDelete();
                    
            return redirect()->route('admin.newsletters.index')
                            ->with('status-success','Newsletter ID#'.$id.' is permanently deleted in the system');
        } catch (Exception $ex) {
            return redirect()->route('admin.newsletters.index')
                            ->with('status-failed', $ex->getMessage());
        }
    }
}
