<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Core\Library;

/**
 * Description of FileSystem
 *
 * @author alvin
 */

use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Image;

class FileManager
{
    public static function MoveFiles($disk, $filename, $key, $year, $month)
    {
        $exists = Storage::disk('temporary')->exists($filename);
        if($exists) {
            $file = Storage::disk('temporary')->get($filename);
            Storage::disk($disk)->put("$year/$month/$key/$filename", $file);
            Storage::disk('temporary')->delete($filename);
        }
        
        return;
    }
    
    public static function ResizeAndSave($file, $width, $newname, $extension, $size, $disk, $folder = '')
    {
        $manager = new ImageManager(array('driver' => 'imagick'));

        $image = $manager->make($file);
        if($image->width() > $width) {
            self::Resize($image, $width, $extension, $size);
                
            Storage::disk($disk)->put($folder.$newname, $image);
            $image->destroy();
        } else {
            Storage::disk($disk)->put($folder.$newname, file_get_contents($file));
        }
        
        return;
    }
    
    public static function Resize(Image $image, $width, $extension, $size)
    {
        if($size > 110000) { //110kb
            $quality = ($extension == 'gif') ? 90: 80;
        } else {
            $quality = ($extension == 'gif') ? 90: 40;
        }
        
        return  $image->orientate()
                        ->resize($width, null, function($constraint){ 
                            $constraint->upsize();
                            $constraint->aspectRatio();
                        })->encode('jpg', $quality);
    }
    
    public static function GetCSSRelativePath($styles) 
    {
        foreach($styles as $key => $css) {
            $styles[$key] = asset('css/templates/' . $css);
        }
        return $styles;
    }
    
    public static function GetJSRelativePath($styles) 
    {
        foreach($styles as $key => $css) {
            $styles[$key] = asset('js/templates/' . $css);
        }
        return $styles;
    }
    
    public static function GetImageRelativePath($images, $disk, $year = null, $month = null, $key = null) 
    {
        $img = [];
        $icon = [];
        $medium = [];
        $large = [];
        $path = "";
        if($year) {
            $path .= $year."/";
        }
        if($month) {
            $path .= $month."/";
        }
        if($key) {
            $path .= $key."/";
        }
        
        foreach($images as $key => $image) {
            $img[] = (object) [
                'title' => $image,
                'value' => asset("storage/$disk/$path" . $image)
            ];
            if(Storage::disk($disk)->exists($path.'icon/'.$image)) {
                $icon[] =  (object) [
                    'title' => 'icon-' . $image,
                    'value' => asset("storage/$disk/$path"."icon/" . $image)
                ];
            }
            if(Storage::disk($disk)->exists($path.'medium/'.$image)) {
                $medium[] = (object) [
                    'title' => 'medium-' . $image,
                    'value' => asset("storage/$disk/$path"."medium/" . $image)
                ];
            }
            if(Storage::disk($disk)->exists($path.'large/'.$image)) {
                $large[] = (object) [
                    'title' => 'large-' . $image,
                    'value' => asset("storage/$disk/$path"."large/" . $image)
                ];
            }
        }
        
        if(!empty($icon)) {
            $img = array_merge($icon, $img);
        }
        if(!empty($medium)) {
            $img = array_merge($medium, $img);
        }
        if(!empty($large)) {
            $img = array_merge($large, $img);
        }
        
        return $img;
    }
}
