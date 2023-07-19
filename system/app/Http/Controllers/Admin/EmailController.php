<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\AdminMessageToBusiness;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required',
            'subject' => 'required',
            'message' => 'required',
        ]);
        $data = array();
        $data = [
            'subject'=>$request->subject,
            'message'=>$request->message,
            'email'=>$request->email
        ];
        // $data['subject']=$request->subject;
        // $data['message']=$request->message;
        // $data['email']=$request->email;
        // if(env('QUEUE_MAIL') == 'on'){
        //   dispatch(new \App\Jobs\SendInvoiceEmail($data));
        // }
        // else{
          Mail::to($request->email)->send(new AdminMessageToBusiness($data));
        // }

       return response()->json(['Mail Sent Successfully']);
    }

    
}
