<?php

namespace App\Http\Controllers\PageBanner\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Core\Library\DataTables;
use Core\Library\FileManager;
use App\Library\DropdownOption;
use App\Model\PageBanner;
use App\Model\Page;


class PageBannerController extends Controller
{
    CONST ICON_IMG_WIDTH = 150;
    
    public $displayAdmin = true;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.modules.pagebanner.index');
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
            0 => ['page_banners.page_id'],
            1 => ['pages.name'],
            2 => ['page_banners.title'],
            3 => ['page_banners.description'],
            4 => ['page_banners.image'],
            5 => ['page_banners.updated_at'],
        ];
        
        $filteredmodel = DB::table('page_banners')
                ->leftjoin('pages', 'pages.id', '=', 'page_banners.page_id');
        if($request->isTrashed == 'true') {
            $filteredmodel->whereNotNull('page_banners.deleted_at');
        } else {
            $filteredmodel->whereNull('page_banners.deleted_at');
        }
        $filteredmodel->select(DB::raw("page_banners.page_id, 
                    pages.name, 
                    page_banners.title, 
                    page_banners.description,
                    page_banners.image,
                    page_banners.updated_at")
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
        $pages = Page::doesntHave('banner')->get(['id', 'name as label']);
        $positions = DropdownOption::BackgroundPositions();
        return view('admin.modules.pagebanner.create')->with(compact('positions', 'pages'));
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
            $disk = 'pagebanner';
            $newname = "";
            if($request->hasFile('image')) {
                $file = $request->file('image');
                $newname = time() . '_' . strtolower($file->getClientOriginalName());
                Storage::disk($disk)->put($newname, file_get_contents($file));

                if((extension_loaded('imagick')) && (in_array($file->extension(), ['jpg', 'jpeg', 'png', 'gif']))) {
                    FileManager::ResizeAndSave($file, self::ICON_IMG_WIDTH, $newname, $file->extension(), $file->getSize(), $disk, 'icon/');
                }
            } else {
                throw new \Exception ('Image is required');
            }
            
            PageBanner::create([
                'page_id' => $request->page_id,
                'title' => $request->title,
                'description' => $request->description,
                'image' => $newname,
                'backgound_pos' => ($request->backgound_pos) ? $request->backgound_pos: 'center',
            ]);
            
            return redirect()->route('admin.pagebanner.index')->with('status-success', 'Page Banner created successfully');
            
        } catch (\Exception $ex) {
            if($request->hasFile('image')) {
                $this->RemoveImageFile($disk, $newname); 
            }
            return redirect()->route('admin.pagebanner.create')
                    ->with('status-failed', $ex->getMessage())
                    ->withInput($request->input());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\PageBanner  $pageBanner
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pageBanner = PageBanner::find($id);
        
        return view('admin.modules.pagebanner.show')->with(compact('pageBanner'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\PageBanner  $pageBanner
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $positions = DropdownOption::BackgroundPositions();
        $pageBanner = PageBanner::find($id);
        
        return view('admin.modules.pagebanner.edit')->with(compact('pageBanner', 'positions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try
        {
            DB::beginTransaction();
            
            $pageBanner = PageBanner::find($id);
            $pageBanner->update($request->only('title', 'description', 'link', 'backgound_pos'));
            
            if($request->hasFile('image')) {
                $oldimage = $pageBanner->image;
                
                $disk = 'pagebanner';
                $file = $request->file('image');
                $newname = time() . '_' . strtolower($file->getClientOriginalName());
                Storage::disk($disk)->put($newname, file_get_contents($file));

                if((extension_loaded('imagick')) && (in_array($file->extension(), ['jpg', 'jpeg', 'png', 'gif']))) {
                    FileManager::ResizeAndSave($file, self::ICON_IMG_WIDTH, $newname, $file->extension(), $file->getSize(), $disk, 'icon/');
                }

                $pageBanner->image = $newname;
                $pageBanner->save();
                
                $this->RemoveImageFile($disk, $oldimage); 
            }

            DB::commit();
            return redirect()->route('admin.pagebanner.index')->with('status-success','Page Banner ID#'.$pageBanner->id.' updated successfully');
            
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
     * @param  \App\Model\PageBanner  $pageBanner
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try
        {
            $pageBanner = PageBanner::find($id);
            $pageBanner->delete();
            return redirect()->route('admin.pagebanner.index')
                            ->with('status-success','Page Banner deleted successfully');
        } catch (Exception $ex) {
            return redirect()->route('admin.pagebanner.index')
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
        return view('admin.modules.pagebanner.trashed');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $pageBanner = PageBanner::onlyTrashed()->find($id);
        
        return view('admin.modules.pagebanner.show')->with(compact('pageBanner'));
    }
    
    public function processrestore(Request $request, $id)
    {
        try
        {
            PageBanner::onlyTrashed()->find($id)->restore();
            
            return redirect()->route('admin.pagebanner.index')->with('status-success', 'Page Banner ID#'.$id.' restored successfully');
            
        } catch (\Exception $ex) {
            return redirect()->back()->with('status-failed', $ex->getMessage());
        }
    }
    
    public function forcedelete($id)
    {
        try
        {
            $pageBanner = PageBanner::onlyTrashed()->find($id);
            
            $this->RemoveImageFile('pagebanner', $pageBanner->image);   
            
            $pageBanner->forceDelete();
                    
            return redirect()->route('admin.pagebanner.index')
                            ->with('status-success','Page Banner ID#'.$id.' is permanently deleted in the system');
        } catch (Exception $ex) {
            return redirect()->route('admin.pagebanner.index')
                            ->with('status-failed', $ex->getMessage());
        }
    }
    
    private function RemoveImageFile($disk, $image) {
        if(Storage::disk($disk)->exists($image)) {
            Storage::disk($disk)->delete($image);
            if(Storage::disk($disk)->exists('icon/'.$image)) {
                Storage::disk($disk)->delete('icon/'.$image);
            }
        }   
        return;
    }
}
