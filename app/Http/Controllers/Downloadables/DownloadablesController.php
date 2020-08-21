<?php

namespace App\Http\Controllers\Downloadables;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use Core\Library\FileManager;
use App\Model\Downloadables;
use Illuminate\Support\Facades\File;
use ZipArchive;

class DownloadablesController extends Controller
{
    public function main($content)
    {
        if(Request::has('folder')) {
            return $this->DisplayFiles();
        } else {
            return $this->DisplayMain();
        }
    }
    
    private function DisplayMain()
    {
        $downloadables = Downloadables::all();
        
        return view('modules.downloadables.main')->with(compact('downloadables'));
    }
    
    private function DisplayFiles()
    {
        $downloadables = Downloadables::where('directory_snake', Request::get('folder'))->first();
        if($downloadables) {
            $disk = 'downloadables';
            $allFiles = Storage::disk($disk)->files($downloadables->directory_snake);
            $images = FileManager::getImageRelativePath($allFiles, $disk);

            return view('modules.downloadables.second')->with(compact('downloadables','images'));
        }
        abort(404);
    }
    
    public function download()
    {
        $zip = new ZipArchive;
   
        $fileName = 'mes_documents_' . time() . '.zip';
   
        if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE)
        {
            $downloadables = Downloadables::where('directory_snake', Request::get('folder'))->first();
            $foldrpath = storage_path('app/public/downloadables/' . $downloadables->directory_snake);
            $files = File::files($foldrpath);
   
            foreach ($files as $key => $value) {
                $relativeNameInZipFile = basename($value);
                $zip->addFile($value, $relativeNameInZipFile);
            }
            $zip->close();
        }
    
        return response()->download(public_path($fileName));
    }
}
