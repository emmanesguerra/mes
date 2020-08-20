<?php

namespace App\Http\Controllers\Newsletters\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Core\Library\DataTables;
use App\Model\Subscriber;
use App\Http\Requests\PostNSubscribersRequest;
use App\Http\Requests\PatchNSubscribersRequest;

class Subscribers extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.modules.newsletters.subscribers.index');
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
            1 => ['email'],
            2 => ['unsubscribed_date'],
            3 => ['updated_at'],
        ];
        
        $filteredmodel = DB::table('newsletters_subs');
        $filteredmodel->select(DB::raw("id, 
                    email, 
                    unsubscribed_date,
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
        return view('admin.modules.newsletters.subscribers.create')->with(compact('images'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostNSubscribersRequest $request)
    {
        try
        {
            $emails = explode(",", $request->email);
            
            foreach($emails as $email) {
                Subscriber::create([
                    'email' => trim($email)
                ]);
            }
            
            return redirect()->route('admin.newsletterssubs.index')->with('status-success', 'Subscriber(s) created successfully');
            
        } catch (\Exception $ex) {
            return redirect()->back()
                    ->with('status-failed', $ex->getMessage())
                    ->withInput($request->input());
        }
    }
    
    public function edit($id)
    {
        try
        {
            $subs = Subscriber::find($id);
            $subs->unsubscribed_date = \Carbon\Carbon::now();
            $subs->save();
            
            return redirect()->route('admin.newsletterssubs.index')
                            ->with('status-success','Subscriber ID#'.$id.' unsubscribed successfully');
        } catch (Exception $ex) {
            return redirect()->route('admin.newsletterssubs.index')
                            ->with('status-failed', $ex->getMessage());
        }
    }
    
    public function subs($id)
    {
        try
        {
            $subs = Subscriber::find($id);
            $subs->unsubscribed_date = null;
            $subs->save();
            
            return redirect()->route('admin.newsletterssubs.index')
                            ->with('status-success','Subscriber ID#'.$id.' re-subscribed successfully');
        } catch (Exception $ex) {
            return redirect()->route('admin.newsletterssubs.index')
                            ->with('status-failed', $ex->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Newsletters  $newsletters
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try
        {
            Subscriber::find($id)->delete();
            return redirect()->route('admin.newsletterssubs.index')
                            ->with('status-success','Subscriber ID#'.$id.' deleted successfully');
        } catch (Exception $ex) {
            return redirect()->route('admin.newsletterssubs.index')
                            ->with('status-failed', $ex->getMessage());
        }
    }
}
