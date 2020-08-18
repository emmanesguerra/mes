<?php

namespace Core\Http\Controllers\UploadedFiles;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Core\Library\FileManager;

class FileController extends Controller
{
    const ICON_IMG_WIDTH = 100;
    const MEDIUM_IMG_WIDTH = 300;
    const LARGE_IMG__WIDTH = 600;
    
    protected $disk;
    
    function __construct()
    {
         $this->middleware('permission:files-list|files-create', ['only' => ['index','store']]);
         $this->middleware('permission:files-create', ['only' => ['create','store']]);
         
         $this->disk = 'adminuploads';
    }
    
    public function index()
    {
        return view('admin.layouts.modules.files.index');
    }
    
    public function data()
    {
        $allFiles = Storage::disk($this->disk)->files();
        
        $files = array();
        foreach ($allFiles as $file) {
            $files[] = $this->fileInfo($file);
        }
        return ['data' => $files];
    }

    private function fileInfo($filename)
    {        
        $filedata = pathinfo(storage_path() . '/app/public/adminuploads/' . $filename);
                
        $file = array();
        $file['basename'] = $filedata['basename'];
        $file['extension'] = $filedata['extension'];
        $file['path'] = '/storage/adminuploads/'.$filedata['basename'];
        $file['text'] = '/storage/adminuploads/'.$filedata['basename'];
        if(file_exists(storage_path() . '/app/public/adminuploads/icon/' . $filename)) {
            $file['path'] = '/storage/adminuploads/icon/'.$filedata['basename'];
            $file['text'] .=  '<br />/storage/adminuploads/<b>icon</b>/'.$filedata['basename'];
        }
        if(file_exists(storage_path() . '/app/public/adminuploads/medium/' . $filename)) {
            $file['text'] .=  '<br />/storage/adminuploads/<b>medium</b>/'.$filedata['basename'];
        }
        if(file_exists(storage_path() . '/app/public/adminuploads/large/' . $filename)) {
            $file['text'] .=  '<br />/storage/adminuploads/<b>large</b>/'.$filedata['basename'];
        }
        $file['size'] = number_format(filesize($filedata['dirname'] . '/' . $filedata['basename']) / 1048576, 2) . 'MB';

        return $file;
    }
    
    public function create()
    {
        return view('admin.layouts.modules.files.create');
    }
    
    public function store(Request $request)
    {
        try
        {
            $attachments = $request->file('attachments');
            foreach($attachments as $file){                
                $newname = time() . '_' . strtolower($file->getClientOriginalName());
                Storage::disk($this->disk)->put($newname, file_get_contents($file));
                
                if((extension_loaded('imagick')) && (in_array($file->extension(), ['jpg', 'jpeg', 'png', 'gif']))) {
                    
                    FileManager::ResizeAndSave($file, self::ICON_IMG_WIDTH, $newname, $file->extension(), $file->getSize(), $this->disk, 'icon/');
                    
                    FileManager::ResizeAndSave($file, self::MEDIUM_IMG_WIDTH, $newname, $file->extension(), $file->getSize(), $this->disk, 'medium/');
                    
                    FileManager::ResizeAndSave($file, self::LARGE_IMG__WIDTH, $newname, $file->extension(), $file->getSize(), $this->disk, 'large/');
                }
            }

            return response(['success'=> true], 200);
        } catch (\Exception $ex) {
            return response(["success"=> false, "error" => $ex->getMessage(), "errorcode" => 400], 200);
        }
    }
    
    public function destroy ($args)
    {
        try
        {
            $folders = [
                '',
                'icon/',
                'medium/',
                'large/'
            ];

            foreach($folders as $folder) {
                $exists = Storage::disk($this->disk)->exists($folder . $args);
                if($exists) {                
                    Storage::disk($this->disk)->delete($folder . $args);
                }
            }
        
            return redirect()->route('admin.files.index')->with('status-success','File named '.$args.' has been deleted successfully');
        } catch (\Exception $ex) {
            return redirect()->route('admin.files.index')->with('status-failed',$ex->getMessage());
        }
    }
}
