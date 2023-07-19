<?php

namespace App\Mail;

use PDF;
use App\Models\User;
use App\Models\Email;
use App\Models\State;

use App\Models\Option;
use App\Models\EmailJob;
use App\Models\Transaction;
use App\Models\UserChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use App\Models\BusinessDetail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BusinessPlanUpdateMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user = User::where('mobile', $this->data['mobile'])
                        ->orderBy('id', 'desc')
                        ->first();

        $transaction = Transaction::with('method', 'userplans')
                                    ->where('user_id', $user->id)
                                    ->orderBy('id', 'desc')
                                    ->first();

        $channel_ids = [];
        $count_free_paid_employee_ids = 0;
        $empPlanData = $rechangeInfo = [];
        foreach ($transaction->userplans as $key => $plan) {
            $channel_ids = explode(',', $plan->channel_ids);

            $free_employee_ids = $paid_employee_ids = 0;
            if (!empty($plan->free_employee_ids)) {
                $free_employee_ids = explode(',', $plan->free_employee_ids);
                // if(count($free_employee_ids)>0){
                //     $count_free_paid_employee_ids =+ count($free_employee_ids);
                // }
            }
            if ($plan->paid_employee_ids) {
                $paid_employee_ids = explode(',', $plan->paid_employee_ids);
                if (count($paid_employee_ids) > 0) {
                    $count_free_paid_employee_ids = $count_free_paid_employee_ids + count($paid_employee_ids);
                }

                $empPlanData = $plan->plan_info;
            }
            $rechangeInfo = $plan->recharge_info;
        }

        $transaction->userplans_channel = UserChannel::with('channel', 'freeEmployee')
            ->whereIn('id', $channel_ids)
            ->get();
        $employee_price = Option::where('key', 'employee_price')->first();

        $plan_period = Transaction::where('transactions.id', $transaction->id)
                                    ->leftjoin('userplans', 'transactions.id', '=', 'userplans.transaction_id')
                                    ->leftjoin('plans', 'userplans.plan_id', '=', 'plans.id')
                                    ->select('plans.name', 'plans.months')
                                    ->first();

        $gst_state = $this->data['gst_state'];

        $this->data['state'] = State::with('state')
                                        ->where('id', $gst_state)
                                        ->pluck('name')
                                        ->first();

        if (!empty($transaction)) {
            $business = BusinessDetail::where('user_id', $user->id)
                                        ->orderBy('id', 'desc')
                                        ->first();

            $email_info = Email::where('id', 2)->first();
            $email_info['content'] = str_replace('Dear {customer_name}', "<b>". "Dear &nbsp;"  . $user->name."</b>", $email_info['content']);
            $subject = $email_info->subject;
            // dd($subject);

            $customPaper = [0, 0, 794.0, 1123.0];
            $pdf = \PDF::loadView('business.plan.download-history', compact('count_free_paid_employee_ids', 'transaction', 'plan_period', 'business', 'user', 'count_free_paid_employee_ids', 'employee_price', 'empPlanData', 'rechangeInfo'))
                ->setOptions(['defaultFont' => 'sans-serif', 'enable_remote' => true])
                ->setPaper($customPaper, 'portrait');
               
            if (isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] == 'mouthpublicity.io') {
                if (
                    $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                        ->bcc('accounts@selftech.in', 'MouthPublicity.io')
                        ->subject($subject)
                        ->view('emails.subscription_thankyou', ['data' => $this->data, 'content' => $email_info['content']])
                        ->attachData($pdf->output(), date('Y.m.d.h.i.s') . '_invoice.pdf', ['mime' => 'application/pdf'])
                ) {
                    $save_emailjob = new EmailJob();
                    $save_emailjob->user_id = $user->id;
                    $save_emailjob->email_id = $email_info['id'];
                    $save_emailjob->email = $user->email;
                    $save_emailjob->subject = $email_info->subject;
                    $save_emailjob->message = $email_info->content;
                    $save_emailjob->save();
                }
                return true;
            } else {
                if ($this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                ->subject($subject)
                ->view('emails.subscription_thankyou', ['data' => $this->data, 'content' => $email_info['content']])
                ->attachData($pdf->output(), date('Y.m.d.h.i.s') . '_invoice.pdf', ['mime' => 'application/pdf'])) {
                    $save_emailjob = new EmailJob();
                    $save_emailjob->user_id = $user->id;
                    $save_emailjob->email_id = $email_info['id'];
                    $save_emailjob->email = $user->email;
                    $save_emailjob->subject = $email_info->subject;
                    $save_emailjob->message = $email_info['content'];
                    $save_emailjob->save();
                } 
                return true;
            }
        }
    }
}
