<?php

namespace Core\Http\Controllers\Setting;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Core\Library\Modules\SystemConfigLibrary;
use Core\Library\DropdownOptions;
use Core\Http\Requests\StoreSettingsRequest;

class SettingController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:settings-list|settings-edit', ['only' => ['index','store']]);
         $this->middleware('permission:settings-edit', ['only' => ['store']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array();
        
        $data['model'] = [
            'domain_name' => SystemConfigLibrary::retrieve('domain_name'),
            'website_name' => SystemConfigLibrary::retrieve('website_name'),
            'owner' => SystemConfigLibrary::retrieve('owner'),
            'email_title' => SystemConfigLibrary::retrieve('email_title'),
            'email_reciever' => SystemConfigLibrary::retrieve('email_reciever'),
            'email_cc' => SystemConfigLibrary::retrieve('email_cc'),
            'email_bcc' => SystemConfigLibrary::retrieve('email_bcc'),
            'office_css' => SystemConfigLibrary::retrieve('office_css'),
            'office_block_class' => SystemConfigLibrary::retrieve('office_block_class')
        ];
        
        return view('admin.layouts.modules.setting.form')->with(compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSettingsRequest $request)
    {
        try {
            DB::beginTransaction();
            foreach ($request->all() as $key => $value) {
                SystemConfigLibrary::save($key, $value);
            }
            
            DB::commit();
            return redirect()->back()->with('status-success', 'System settings updated!');
        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()
                    ->with('status-failed', $ex->getMessage())
                    ->withInput($request->input());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
