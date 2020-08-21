<?php

namespace App\Http\Controllers\Newsletters;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\SubscriberRequest;
use App\Model\Subscriber;
use App\Model\SubscriberVCode;
use App\Mail\NewsletterSignup;
use Core\Library\Modules\SystemConfigLibrary;

class NewslettersController extends Controller
{
    //
    public function panel()
    {
        return view('modules.newsletter.signup');
    }
    
    public function subscribe(SubscriberRequest $request)
    {
        try {
            DB::beginTransaction();
            
            $subs = Subscriber::where('email', $request->email)->first();
            if(!$subs) {
                $subs = Subscriber::create(['email']);
            } else {
                if($subs->unsubscribed_date) {
                    $subs->unsubscribed_date = null;
                    $subs->save();
                } else {
                    throw new \Exception('This email is already subscribe in our newsletter');
                }
            }
            
            if($subs) {
                
                $vcode = SubscriberVCode::firstOrCreate([
                    'email' => $subs->email,
                    'token' => sha1(time())
                ]);
                
                if($vcode) {
                    $bcc = SystemConfigLibrary::retrieve('email_bcc');
                    Mail::to($subs->email)
                        ->bcc($bcc)
                        ->send(new NewsletterSignup($vcode));
                }
            }
            
            DB::commit();
            return redirect('new-subscriber');
            
        } catch (\Exception $ex) {
            DB::rollback();
            return Redirect::to(URL::previous() . "#signupnewsletter")
                    ->with('status-failed', $ex->getMessage())
                    ->withInput($request->input());
        }
    }
    
    public function verify(Request $request)
    {
        try
        {
            $token = SubscriberVCode::where('token', $request->token)->first();
            if($token) {
                
                $subs = Subscriber::where('email', $token->email)->first();
                $subs->verified_date = \Carbon\Carbon::now();
                $subs->save();
                
                $token->delete();
                echo '<script>'
                        . 'alert("Thank you for subscribing with us. You will be redirected to the homepage in a few seconds");'
                        . 'window.location="/";'
                        . '</script>';
                exit;
            } else {
                abort(401, 'Invalid Token');
            }
        } catch (\Exception $ex) {
            abort(500, $ex->getMessage());
        }
    }
}
