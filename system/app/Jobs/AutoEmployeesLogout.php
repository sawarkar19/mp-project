<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Carbon\Carbon;
use App\Models\User;
use App\Models\UserLogin;
use Auth;

class AutoEmployeesLogout implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $yesterdayDate = Carbon::now()->subDays(1)->format('Y-m-d');

        // $employeeIds = User::where('role_id', 3)->pluck('id')->toArray();
        $employeeIds = User::where('role_id', 3)->where('status', 1)->pluck('id')->toArray();
        $loginEmployees = UserLogin::whereIn('user_id', $employeeIds)->where('is_login', '1')->whereDate('updated_at', $yesterdayDate)->pluck('user_id')->toArray();

        // SESSION Expire and set is_login = 0 in UserLogin
        foreach ($employeeIds as $key => $user_id) {
            $userToLogout = User::where('id',$user_id)->where('status', 1)->first();
            $userToLogout->expire_login = '1';
            $userToLogout->save();
        }
    }
}
