<?php

namespace App\Mail;

use App\Models\Email;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreatePasswordMail extends Mailable
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
        $email_info = Email::where('id', 23)->first();
       
       return $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
       ->subject($email_info->subject)
       ->view('emails.user_create_password', ['data' => $this->data, 'content' => $email_info->content]);
    }
}
