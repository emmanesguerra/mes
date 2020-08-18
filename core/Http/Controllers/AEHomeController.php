<?php

namespace Core\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AEHomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.layouts.modules.dashboard');
    }
    
    public function showChangePswdForm()
    {
        return view('auth.changepswd');
    }
    
    public function changepswd(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|confirmed|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{6,}$/'
        ]);


        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $user = Auth::user();
        $user->password = $request->password;
        $user->password_chaged_at = \Carbon\Carbon::now();
        $user->save();

        return redirect()->route('admin.dashboard')
                        ->with('status-success','User password is updated successfully');
    }
}
