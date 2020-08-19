<?php

namespace App\Http\Controllers\Quotation\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Core\Library\DataTables;
use App\Model\Quotation;
use App\Http\Requests\PatchQuotationRequest;
use App\Http\Requests\PostQuotationRequest;

class QuotationController extends Controller
{
    public $displayAdmin = true;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.modules.quotes.index');
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
            1 => ['title'],
            2 => ['description'],
            3 => ['updated_at'],
        ];
        
        $filteredmodel = DB::table('quotations');
        if($request->isTrashed == 'true') {
            $filteredmodel->whereNotNull('deleted_at');
        } else {
            $filteredmodel->whereNull('deleted_at');
        }
        $filteredmodel->select(DB::raw("id, 
                    title, 
                    description,
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
        return view('admin.modules.quotes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostQuotationRequest $request)
    {
        try
        {
            Quotation::create($request->only('title', 'description'));
            
            return redirect()->route('admin.quotes.index')->with('status-success', 'Quote created successfully');
        } catch (\Exception $ex) {
            return redirect()->back()
                    ->with('status-failed', $ex->getMessage())
                    ->withInput($request->input());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $quotation = Quotation::find($id);
        
        return view('admin.modules.quotes.show')->with(compact('quotation'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $quotation = Quotation::find($id);
        
        return view('admin.modules.quotes.edit')->with(compact('quotation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function update(PatchQuotationRequest $request, $id)
    {
        try
        {
            $quotation = Quotation::find($id);
            $quotation->update($request->only('title', 'description'));
            
            return redirect()->route('admin.quotes.index')->with('status-success', 'Quote updated successfully');
        } catch (\Exception $ex) {
            return redirect()->back()
                    ->with('status-failed', $ex->getMessage())
                    ->withInput($request->input());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try
        {
            $quotation = Quotation::find($id);
            $quotation->delete();
            return redirect()->route('admin.quotes.index')
                            ->with('status-success','Quote deleted successfully');
        } catch (Exception $ex) {
            return redirect()->route('admin.quotes.index')
                            ->with('status-failed', $ex->getMessage());
        }
    }
    
    /**
     * Display a listing of the trashed resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trashed()
    {
        return view('admin.modules.quotes.trashed');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $quotation = Quotation::onlyTrashed()->find($id);
        
        return view('admin.modules.quotes.show')->with(compact('quotation'));
    }
    
    public function processrestore(Request $request, $id)
    {
        try
        {
            Quotation::onlyTrashed()->find($id)->restore();
            
            return redirect()->route('admin.quotes.index')->with('status-success', 'Quote ID#'.$id.' restored successfully');
            
        } catch (\Exception $ex) {
            return redirect()->back()->with('status-failed', $ex->getMessage());
        }
    }
    
    public function forcedelete($id)
    {
        try
        {
            Quotation::onlyTrashed()->find($id)->forceDelete();
                    
            return redirect()->route('admin.quotes.index')
                            ->with('status-success','Quote ID#'.$id.' is permanently deleted in the system');
        } catch (Exception $ex) {
            return redirect()->route('admin.quotes.index')
                            ->with('status-failed', $ex->getMessage());
        }
    }
}
