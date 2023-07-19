<?php

namespace App\Jobs;
use App\Models\Email;
use App\Models\EmailJob;
use App\Models\WhatsappApi;
use Illuminate\Bus\Queueable;
use App\Models\WhatsappSession;
use App\Mail\CreatePasswordMail;
use App\Mail\MessagingApiCredentialsMail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Http\Controllers\ShortLinkController;
use App\Http\Controllers\WACloudApiController;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class ImportFreeUsersJob implements ShouldQueue
{
    use Dispatchable , InteractsWithQueue, Queueable, SerializesModels;

    public $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        /* Send Email */
        $email_info = Email::where('id', 23)->first();

        $data = [
            'name' => $this->data['name'],
            'email' => $this->data['email'],
            'message' => $email_info['content'],
            'token' => $this->data['token'],
        ];

        $email = new CreatePasswordMail($data);
        Mail::to($data['email'])->send($email);

            $job = new EmailJob;
            $job->user_id = $this->data['user_id'];
            $job->email_id = $email_info->id;
            $job->email = $this->data['email'];
            $job->subject = $email_info->subject;           
            $job->message = $data['message'];
            $job->save();


            /* Send Email */
        $info = Email::where('id', 34)->first();
        $wa_api = WhatsappApi::where('user_id', $this->data['user_id'])->first();
        if ($wa_api != null) {

            $data = [
                'name' => $this->data['name'],
                'email' => $this->data['email'],
            ];
    
            $data['message'] = str_replace('Dear {customer_name}', "<b>". "Dear &nbsp;"  . $this->data['name']."</b>", $info['content']);
            $data['message'] = str_replace('{username}', $wa_api['username'], $data['message']);
            $data['message'] = str_replace('{password}', $wa_api['password'], $data['message']);
            $data['message'] = str_replace('{sender_name}', $wa_api['sendername'], $data['message']);
            $data['subject'] = $email_info['subject'];
    
            $email = new MessagingApiCredentialsMail($data);
            Mail::to($data['email'])->send($email);
    
            $emailJob = new EmailJob;
            $emailJob->user_id = $this->data['user_id'];
            $emailJob->email_id = $info->id;
            $emailJob->email = $this->data['email'];
            $emailJob->subject = $data['subject'];           
            $emailJob->message = $data['message'];
            $emailJob->save();
        }
    }
}
