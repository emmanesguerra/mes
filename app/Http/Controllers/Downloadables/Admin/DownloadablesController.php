<?php

namespace App\Http\Controllers\Downloadables\Admin;

use App\Http\Controllers\Controller;
use App\Model\Downloadables;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Core\Library\DataTables;
use Core\Library\FileManager;

class DownloadablesController extends Controller
{
    public $displayAdmin = true;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.modules.downloadables.index');
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
            1 => ['directory'],
            2 => ['updated_at'],
        ];
        
        $filteredmodel = DB::table('downloadables');
        $filteredmodel->select(DB::raw("id, 
                    directory, 
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
        return view('admin.modules.downloadables.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try
        {
            Downloadables::create([
                'directory' => $request->directory,
                'directory_snake' => Str::snake($request->directory)
            ]);
            
            return redirect()->route('admin.downloadables.index')->with('status-success', 'Directory created successfully');
            
        } catch (\Exception $ex) {
            return redirect()->back()
                    ->with('status-failed', $ex->getMessage())
                    ->withInput($request->input());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Downloadables  $downloadables
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $downloadables = Downloadables::find($id);
        $disk = 'downloadables';
        $allFiles = Storage::disk($disk)->files($downloadables->directory_snake);
        $images = FileManager::getImageRelativePath($allFiles, $disk);
        
        return view('admin.modules.downloadables.show')->with(compact('downloadables', 'images'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Downloadables  $downloadables
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $downloadables = Downloadables::find($id);
        
        return view('admin.modules.downloadables.edit')->with(compact('downloadables'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Downloadables  $downloadables
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try
        {
            $downloadables = Downloadables::find($id);
            
            $disk = 'downloadables';
            $attachments = $request->file('attachments');
            foreach($attachments as $file){                
                $newname = strtolower($file->getClientOriginalName());
                Storage::disk($disk)->put( $downloadables->directory_snake . '/' . $newname, file_get_contents($file));
            }

            return response(['success'=> true], 200);
        } catch (\Exception $ex) {
            return response(["success"=> false, "error" => $ex->getMessage(), "errorcode" => 400], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Downloadables  $downloadables
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try
        {
            $downloadables = Downloadables::find($id);
            
            $foldrpath = storage_path('app/public/downloadables/' . $downloadables->directory_snake);
            
            File::deleteDirectory($foldrpath);
            
            $downloadables->delete();
            
            return redirect()->route('admin.downloadables.index')
                            ->with('status-success','Downloable ID#'.$downloadables->id.' deleted successfully');
        } catch (Exception $ex) {
            return redirect()->route('admin.downloadables.index')
                            ->with('status-failed', $ex->getMessage());
        }
    }
}
