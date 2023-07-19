<?php

namespace App\Mail;

use App\Models\Email;
use App\Models\EmailJob;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OtpVerificationMail extends Mailable
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
        
        $email_info = Email::where('id', 33)->first();
        $email_info['content'] = str_replace('{otp}', "<b>". "Dear Sir/Madam, <br>"  . $this->data['otp']."</b>", $email_info['content']);
        // dd($email_info['content']);

        $subject = $email_info->subject;

        if($this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            ->subject($subject)
            ->view('emails.otp_verification_mail', ['data' => $this->data, 'content' => $email_info['content']])){
            
            // $save_emailjob = new EmailJob();
            // $save_emailjob->user_id = $this->data['id'];
            // $save_emailjob->email_id = $email_info['id'];
            // $save_emailjob->email = $this->data['email'];
            // $save_emailjob->subject = $email_info->subject;
            // $save_emailjob->message = $email_info['content'];
            // $save_emailjob->save();
        }
        return true;
    }
}
