<?php

namespace App\Http\Controllers\ContactUs;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use App\Model\ContactUs;
use App\Http\Requests\PostContactUsRequest;
use Core\Library\Modules\SystemConfigLibrary;
use App\Mail\SendInquiry;

class ContactUsController extends Controller
{
    //
    public function main()
    {
        $contacts = ContactUs::all();
        
        return view('modules.contactus.main')->with(compact('contacts'));
    }
    
    public function send(PostContactUsRequest $request)
    {
        $title = SystemConfigLibrary::retrieve('email_title');
        $reciever = SystemConfigLibrary::retrieve('email_reciever');
        $cc = SystemConfigLibrary::retrieve('email_cc');
        $bcc = SystemConfigLibrary::retrieve('email_bcc');
        
        Mail::to($reciever)
            ->cc($cc)
            ->bcc($bcc)
            ->send(new SendInquiry($request, $title));
        
        return Redirect::to(URL::previous() . "#contactusform")->with('status-success', 'Email sent');
    }
}
