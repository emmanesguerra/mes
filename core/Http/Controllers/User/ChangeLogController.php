<?php

namespace Core\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Core\Library\DataTables;
use OwenIt\Auditing\Models\Audit;

class ChangeLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request)
    {
        $tablecols = [
            0 => ['users.email'],
            1 => ['audits.event'],
            2 => ['audits.auditable_type'],
            3 => ['audits.auditable_id'],
            4 => ['audits.created_at']
        ];
        
        $filteredmodel = DB::table('audits')
                ->leftjoin('users', 'audits.user_id', '=', 'users.id')
                ->where('audits.tags', 'displayToDashboard')
                ->select(DB::raw("users.email, 
                        audits.event, 
                        audits.auditable_type, 
                        audits.auditable_id,
                        audits.created_at,
                        audits.id")
                );
        
        $modelcnt = $filteredmodel->count();
        
        $data = DataTables::DataTableFilters($filteredmodel, $request, $tablecols, $hasValue, $totalFiltered);
        
        return response(['data'=> $data,
            'draw' => $request->draw,
            'recordsTotal' => ($hasValue)? $data->count(): $modelcnt,
            'recordsFiltered' => ($hasValue)? $totalFiltered: $modelcnt], 200);
    }
    
    public function values($id)
    {
        try
        {
            $data = Audit::find($id);
            
            return response([
                    'data'=> [
                        'old' => $data->old_values,
                        'new' => $data->new_values,
                        'event' => $data->event,
                    ]
                ], 200);
        } catch (Exception $ex) {
            return response(['message'=> $ex->getMessage()], 400);
        }
    }
}
