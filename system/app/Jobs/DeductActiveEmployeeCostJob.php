<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Models\User;
use App\Models\Deduction;
use App\Models\DeductionHistory;

use DeductionHelper;

class DeductActiveEmployeeCostJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $userId;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $deductionDetail = DeductionHelper::getActiveDeductionDetail('slug', 'employee_login_cost');
        if($deductionDetail != NULL){
            $today = Date('Y-m-d');

            // Get Active Employee
            $activeEmployees = User::where('role_id', 3)->where('created_by', $this->userId)->where('status', 1)->orderBy('id', "ASC")->get();
            $activeEmployeesCount = count($activeEmployees);

            // Get today number of employee deduct count
            $deductedEmpCount = DeductionHistory::where('deduction_id', $deductionDetail->id)->where('user_id', $this->userId)->whereDate('created_at', $today)->count();

            $noOfDeduct = $activeEmployeesCount - $deductedEmpCount;
            if($noOfDeduct > 0){

                // Get Non-Deducted Employees
                $deductedEmps = DeductionHistory::where('deduction_id', $deductionDetail->id)->where('user_id', $this->userId)->whereDate('created_at', $today)->pluck('employee_id')->toArray();

                $nonDeductedEmployees = User::where('role_id', 3)->whereNotIn('id', $deductedEmps)->where('created_by', $this->userId)->where('status', 1)->orderBy('id', "ASC")->get();

                foreach ($nonDeductedEmployees as $key => $employee){
                    if($key < $noOfDeduct){
                        $checkWalletBalance = DeductionHelper::checkWalletBalance($this->userId, $deductionDetail->id);

                        if($checkWalletBalance['status']==1){
                            // Insert in Deduction History Table
                            $channel_id = $message_history_id = $customer_id = 0;
                            DeductionHelper::deductWalletBalance($this->userId ?? 0, $deductionDetail->id ?? 0, $channel_id, $message_history_id, $customer_id, $employee->id);
                        }
                        else{
                            // Update Employee to deactive.
                            $employee = User::find($employee->id);
                            $employee->status = 0;
                            $employee->save();
                        }
                    }
                }
            }
        }
    }
}
