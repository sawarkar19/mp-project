<?php

namespace App\Http\Controllers;

use App\Mail\TestEmail;
use Illuminate\Http\Request;
use App\Mail\AdminByAdminMail;
use App\Mail\ContactToUserMail;
use App\Mail\ContactToAdminMail;
use App\Mail\CreatePasswordMail;
use App\Mail\ForgotPasswordMail;
use App\Mail\BusinessByAdminMail;
use App\Mail\BusinessWelcomeMail;
use App\Mail\OtpVerificationMail;
use App\Mail\EmailSubscriptionMail;
use App\Mail\BusinessPlanUpdateMail;
use App\Mail\SalesPersonByAdminMail;
use Illuminate\Support\Facades\Mail;
use App\Mail\BusinessPlanExpiredMail;
use App\Mail\BusinessPlanExpireInOneDay;
use App\Mail\BusinessPlanExpireInFiveDay;
use App\Mail\BusinessPlanExpireInThreeDay;
use App\Mail\BusinessRouteSettingUpdateMail;

class CommonMailController extends Controller
{
    //

    public static function TestEmail(){
        Mail::to('ratan.dahat@selftech.in')->send(new TestEmail());
    }

    public static function ContactToAdminMail($data){
        Mail::to('ratan.dahat@selftech.in')->send(new ContactToAdminMail($data));
    }

    public static function ContactToUserMail($data){
        Mail::to($data['email'])->send(new ContactToUserMail($data));
    }

    public static function BusinessByAdminMail($data){
        Mail::to($data['email'])->send(new BusinessByAdminMail($data));
    }

    public static function AdminByAdminMail($data){
        Mail::to($data['email'])->send(new AdminByAdminMail($data));
    }

    public static function SalesPersonByAdminMail($data){
        Mail::to($data['email'])->send(new SalesPersonByAdminMail($data));
    }

    public static function BusinessPlanUpdateMail($data){
        Mail::to($data['email'])->send(new BusinessPlanUpdateMail($data));
    }

    public static function BusinessRouteSettingUpdateMail($data){
        Mail::to($data['email'])->send(new BusinessRouteSettingUpdateMail($data));
    }

    public static function BusinessWelcomeMail($data){
        Mail::to($data['email'])->send(new BusinessWelcomeMail($data));
    }

    public static function EmailSubscriptionMail($data){
        Mail::to($data['email'])->send(new EmailSubscriptionMail($data));
    }

    public static function ForgotPasswordMail($data){
        Mail::to($data['email'])->send(new ForgotPasswordMail($data));
    }

    public static function BusinessPlanExpireInFiveDay($data){
        Mail::to($data['email'])->send(new BusinessPlanExpireInFiveDay($data));
    }

    public static function BusinessPlanExpireInThreeDay($data){
        Mail::to($data['email'])->send(new BusinessPlanExpireInThreeDay($data));
    }

    public static function BusinessPlanExpireInOneDay($data){
        Mail::to($data['email'])->send(new BusinessPlanExpireInOneDay($data));
    }

    public static function BusinessPlanExpiredMail($data){
        Mail::to($data['email'])->send(new BusinessPlanExpiredMail($data));
    }

    public static function CreatePasswordMail($data){
        Mail::to($data['email'])->send(new CreatePasswordMail($data));
    }

    public static function OtpVerificationMail($data){
        Mail::to($data['email'])->send(new OtpVerificationMail($data));
    }
}
