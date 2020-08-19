<?php

namespace App\Http\Controllers\Slider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Slider;

class SliderController extends Controller
{
    public function panel() 
    {
        $sliders = Slider::all();
        
        return view('modules.slider.list')->with(compact('sliders'));
    }
}
