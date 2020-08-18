<?php

namespace Core\Listeners;

use Illuminate\Auth\Events\Logout;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Core\Model\UserLog;

class LogSuccessfulLogout
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Logout  $event
     * @return void
     */
    public function handle(Logout $event)
    {
        $user = $event->user;

        $userlog = UserLog::find($user->current_ul_id);
        $userlog->log_out = \Carbon\Carbon::now();
        $userlog->save();
    }
}
