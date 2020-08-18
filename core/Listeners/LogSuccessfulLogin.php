<?php

namespace Core\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Core\Model\UserLog;

class LogSuccessfulLogin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        try
        {
            DB::beginTransaction();
            
            $user = $event->user;

            $userlog = UserLog::create(['log_in' => \Carbon\Carbon::now(), 'ip_address' => $this->request->ip(), 'email' => $user->email]);

            if($userlog) {
                $user->disableAuditing();
                $user->current_ul_id = $userlog->id;
                $user->save();
            }
            
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            Log::error($ex->getMessage());
        }
    }
}
