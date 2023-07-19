<?php

namespace App\Http\Controllers;

use App\Models\AdminMessage;
use Illuminate\Http\Request;
use App\Models\ContactMessage;

use App\Models\EmailSubscriber;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\SalesroboController;

class ContactUsController extends Controller
{
    //

    public function postContact(Request $request){

        /* Save Contact for data to the DATABASE */
        $message = new ContactMessage;
        $message->name = $request->name;
        $message->mobile = $request->mobile;
        $message->email = $request->email;
        $message->message = $request->message;
        $message->save();

        /* Send Message on whatsapp */
        $payload = \App\Http\Controllers\WACloudApiController::mp_contact_us_alert('91'.$request->mobile, $request->name);
        $res = \App\Http\Controllers\WACloudApiController::sendMsg($payload);

        /* Admin Message History start */
        $addmin_history = new AdminMessage();
        $addmin_history->template_name = 'mp_contact_us_alert';
        $addmin_history->message_sent_to = $message->mobile;
        $addmin_history->save();
        /* Admin Message History end */
        
        $data = [
            'name' => $request->name,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'message' => $request->message
        ];
        CommonMailController::ContactToAdminMail($data);
        CommonMailController::ContactToUserMail($data);

        /*
        * Sending the data to the SalesRobo form.
        */
        // $form_id = 3;
        // $data = array(
        //     'mauticform[f_name]' => $request->name,
        //     'mauticform[email]' => $request->email,
        //     'mauticform[contact_no]' => $request->mobile,
        //     'mauticform[f_message]' => $request->message,
        //     'mauticform[formId]' => $form_id,
        //     'mauticform[return]' => '',
        //     'mauticform[formName]' => 'contactform'
        // );
        // $send_to_SalesRobo = SalesroboController::send_form_data($form_id, $data);
        /* END SalesRobo code */

        
        $return = array( "status" => true, "type" => "success", "message" => "Thank you for getting in touch! We have received your message and one of our executive will get back in touch with you soon.");
        /* if($send_to_SalesRobo != ''){
            $return['message']= $send_to_SalesRobo;
        } */

        return json_encode($return);
    }

    public function ebook_download(Request $request){

        /*
        * Sending the data to the SalesRobo form.
        
        */
        // $form_id = 6;
        // $data = array(
        //     'mauticform[f_name]' => $request->name,
        //     'mauticform[email]' => $request->email,
        //     'mauticform[whatsapp_number]' => $request->mobile,
        //     'mauticform[formId]' => $form_id,
        //     'mauticform[return]' => '',
        //     'mauticform[formName]' => 'ebooksubscription'
        // );
        // $send_to_SalesRobo = SalesroboController::send_form_data($form_id, $data);
        /* END SalesRobo code */

        $return = array( "status" => true, "type" => "success", "message" => "<b>Congrats!</b> We have sent E-Book on your Email ID($request->email), Please check your inbox.</p>");

        return json_encode($return);

    }

    public function cta_form(Request $request){
        /*
        * Sending the data to the SalesRobo form.
        */
        $form_id = $request->form_id;
        $data = array(
            'mauticform[email]' => $request->cta_email,
            'mauticform[formId]' => $form_id,
            'mauticform[return]' => '',
            'mauticform[formName]' => $request->form_name
        );
        $send_to_SalesRobo = SalesroboController::send_form_data($form_id, $data);
        /* END SalesRobo code */

        $return = array( "status" => true, "type" => "success", "message" => "Thank you for getting in touch! We will get back in touch with you soon.");

        return json_encode($return);
    }

    public function subscribe_wa(Request $request)
    {
        $phone = $request->input_data;
        if($phone != ''){

            $check = EmailSubscriber::where('phone', $phone)->first();
            if($check){
                echo json_encode(array("status" => false, "type"=>"success", "message"=>"Your WhatsApp number is already subscribed."));
            }else{

                $subsciber = new EmailSubscriber;
                $subsciber->phone = $phone;
                $subsciber->save();

                /*
                * Sending the data to the SalesRobo form.
                */
                // $form_id = 4;
                // $data = array(
                //     'mauticform[whatsapp_number]' => $phone,
                //     'mauticform[formId]' => $form_id,
                //     'mauticform[return]' => '',
                //     'mauticform[formName]' => 'mpwebsitefooterform'
                // );
                // $send_to_SalesRobo = \App\Http\Controllers\SalesroboController::send_form_data($form_id, $data);
                /* END SalesRobo code */

                /* Sending email */
                // $data = [
                //     'email' => $email
                // ];
                // \App\Http\Controllers\CommonMailController::EmailSubscriptionMail($data);

                // $url = url('/subscriber-footer/thankyou');
                // dd($url);

                return response()->json(["status" => true, "type" =>"success", "message" => "Thank You! Your WhatsApp number has been subscibed."]);
            }
                
        }else{
            return response()->json(["status" => false, "type"=>"error", "message"=>"Please Enter a WhatsApp number."]);
        }
    }
}
