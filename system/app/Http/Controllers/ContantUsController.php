<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\SalesroboController;

class ContantUsController extends Controller
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

        /* $data = [
            'name' => $request->name,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'message' => $request->message
        ];
        CommonMailController::ContactToAdminMail($data);
        CommonMailController::ContactToUserMail($data); */

        /*
        * Sending the data to the SalesRobo form.
        */
        $form_id = 7;
        $data = array(
            'mauticform[f_name]' => $request->name,
            'mauticform[email]' => $request->email,
            'mauticform[contact_no]' => $request->mobile,
            'mauticform[f_message]' => $request->message,
            'mauticform[formId]' => $form_id,
            'mauticform[return]' => '',
            'mauticform[formName]' => 'contactform'
        );
        $send_to_SalesRobo = SalesroboController::send_form_data($form_id, $data);
        /* END SalesRobo code */

        $return = array( "status" => true, "type" => "success", "message" => "Thank you for getting in touch! We have received your message and one of our colleagues will get back in touch with you soon.");
        /* if($send_to_SalesRobo != ''){
            $return['message']= $send_to_SalesRobo;
        } */

        return json_encode($return);
    }

    public function ebook_download(Request $request){

        /*
        * Sending the data to the SalesRobo form.
        */
        $form_id = 8;
        $data = array(
            'mauticform[f_name]' => $request->name,
            'mauticform[email]' => $request->email,
            'mauticform[whatsapp_number]' => $request->mobile,
            'mauticform[formId]' => $form_id,
            'mauticform[return]' => '',
            'mauticform[formName]' => 'ebooksubscription'
        );
        $send_to_SalesRobo = SalesroboController::send_form_data($form_id, $data);
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
}
