<?php

namespace App\Http\Controllers\Slider\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Core\Library\DataTables;
use Core\Library\FileManager;
use App\Library\DropdownOption;
use App\Model\Slider;
use App\Http\Requests\PatchSliderRequest;
use App\Http\Requests\PostSliderRequest;

class SliderController extends Controller
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
        return view('admin.modules.slider.index');
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
            2 => ['image'],
            3 => ['link'],
            4 => ['updated_at'],
        ];
        
        $filteredmodel = DB::table('sliders');
        if($request->isTrashed == 'true') {
            $filteredmodel->whereNotNull('deleted_at');
        } else {
            $filteredmodel->whereNull('deleted_at');
        }
        $filteredmodel->select(DB::raw("id, 
                    title, 
                    image,
                    link, 
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
        $positions = DropdownOption::BackgroundPositions();
        $pos1 = collect([['id' => 'top', 'label' => 'top'],['id' => 'bot', 'label' => 'bottom']]);
        $pos2 = collect([['id' => 'lft', 'label' => 'left'],['id' => 'rgt', 'label' => 'right']]);
        
        return view('admin.modules.slider.create')->with(compact('positions', 'pos1', 'pos2'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostSliderRequest $request)
    {
        try
        {
            $disk = 'sliders';
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
            Slider::create([
                'title' => $request->title,
                'description' => $request->description,
                'link' => $request->link,
                'text_pos1' => $request->text_pos1,
                'text_pos2' => $request->text_pos2,
                'image' => $newname,
                'backgound_pos' => ($request->backgound_pos) ? $request->backgound_pos: 'center',
            ]);
            
            return redirect()->route('admin.sliders.index')->with('status-success', 'Slider created successfully');
            
        } catch (\Exception $ex) {
            if($request->hasFile('image')) {
                $this->RemoveImageFile($disk, $newname); 
            }
            return redirect()->back()
                    ->with('status-failed', $ex->getMessage())
                    ->withInput($request->input());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function show(Slider $slider)
    {
        return view('admin.modules.slider.show')->with(compact('slider'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function edit(Slider $slider)
    {
        $positions = DropdownOption::BackgroundPositions();
        $pos1 = collect([['id' => 'top', 'label' => 'top'],['id' => 'bot', 'label' => 'bottom']]);
        $pos2 = collect([['id' => 'lft', 'label' => 'left'],['id' => 'rgt', 'label' => 'right']]);
        
        return view('admin.modules.slider.edit')->with(compact('slider', 'positions', 'pos1', 'pos2'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function update(PatchSliderRequest $request, Slider $slider)
    {
        try
        {
            DB::beginTransaction();
            
            $slider->update($request->only('title', 'description', 'link', 'image_alt', 'text_pos1', 'text_pos2', 'backgound_pos'));
            
            if($request->hasFile('image')) {
                $oldimage = $slider->image;
                
                $disk = 'sliders';
                $file = $request->file('image');
                $newname = time() . '_' . strtolower($file->getClientOriginalName());
                Storage::disk($disk)->put($newname, file_get_contents($file));

                if((extension_loaded('imagick')) && (in_array($file->extension(), ['jpg', 'jpeg', 'png', 'gif']))) {
                    FileManager::ResizeAndSave($file, self::ICON_IMG_WIDTH, $newname, $file->extension(), $file->getSize(), $disk, 'icon/');
                }

                $slider->image = $newname;
                $slider->save();
                
                $this->RemoveImageFile($disk, $oldimage); 
            }

            DB::commit();
            return redirect()->route('admin.sliders.index')->with('status-success','Slider ID#'.$slider->id.' updated successfully');
            
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
     * @param  \App\Model\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slider $slider)
    {
        try
        {
            $slider->delete();
            return redirect()->route('admin.sliders.index')
                            ->with('status-success','Slider deleted successfully');
        } catch (Exception $ex) {
            return redirect()->route('admin.sliders.index')
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
        return view('admin.modules.slider.trashed');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $slider = Slider::onlyTrashed()->find($id);
        
        return view('admin.modules.slider.show')->with(compact('slider'));
    }
    
    public function processrestore(Request $request, $id)
    {
        try
        {
            Slider::onlyTrashed()->find($id)->restore();
            
            return redirect()->route('admin.sliders.index')->with('status-success', 'Slider ID#'.$id.' restored successfully');
            
        } catch (\Exception $ex) {
            return redirect()->back()->with('status-failed', $ex->getMessage());
        }
    }
    
    public function forcedelete($id)
    {
        try
        {
            $sliders = Slider::onlyTrashed()->find($id);
            
            $this->RemoveImageFile('sliders', $sliders->image);   
            
            $sliders->forceDelete();
                    
            return redirect()->route('admin.sliders.index')
                            ->with('status-success','Slider ID#'.$id.' is permanently deleted in the system');
        } catch (Exception $ex) {
            return redirect()->route('admin.sliders.index')
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
