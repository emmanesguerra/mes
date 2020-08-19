<?php

namespace App\Http\Controllers\Quotation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Quotation;

class QuotationController extends Controller
{
    public function panel() 
    {
        $quotes = Quotation::all();
        
        return view('modules.quotes.list')->with(compact('quotes'));
    }
}
