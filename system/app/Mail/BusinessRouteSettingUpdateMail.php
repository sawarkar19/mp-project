<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Email;
use App\Models\Option;
use App\Models\EmailJob;

use App\Models\MessageRoute;
use Illuminate\Bus\Queueable;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BusinessRouteSettingUpdateMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        // dd($data);
        $this->data = $data;
        // dd($this->data);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {        
        if ($this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
        ->subject($this->data['subject'])
        ->view('emails.message_route_setting', ['data' => $this->data, 'content' => $this->data['content']])) {
            $save_emailjob = new EmailJob();
            $save_emailjob->user_id = $this->data['user_id'];
            $save_emailjob->email = $this->data['email'];
            $save_emailjob->email_id = $this->data['id'];
            $save_emailjob->subject = $this->data['subject'];
            $save_emailjob->message = $this->data['content'];
            $save_emailjob->save();
        } 
        return true;
    }
        
}
