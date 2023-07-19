<?php

namespace App\Http\Controllers\Admin;

use URL;
use Auth;
use File;
use Cache;
use App\Models\User;
use App\Models\Email;
use App\Models\Option;

use Illuminate\Support\Str;
use App\Models\MessageRoute;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\BusinessRouteSettingUpdateMail;
use App\Http\Controllers\CommonMailController;


class SiteController extends Controller
{
    public function site_settings()
    {
        $site_url = Option::where('key', 'site_url')->first();
        $services_url = Option::where('key', 'services_url')->first();
        $site_info = Option::where('key', 'company_info')->first();
        $info = json_decode($site_info->value);
        $currency_name = Option::where('key', 'currency_name')->first();
        $currency_icon = Option::where('key', 'currency_icon')->first();
        $order_prefix = Option::where('key', 'order_prefix')->first();
        $currency_info = Option::where('key', 'currency_info')->first();
        $auto_order = Option::where('key', 'auto_order')->first();

        $tax = Option::where('key', 'tax')->first();
        $hsn_code = Option::where('key', 'hsn_code')->first();
        $gst_code = Option::where('key', 'gst_code')->first();
        $igst_code = Option::where('key', 'igst_code')->first();
        $cgst_code = Option::where('key', 'cgst_code')->first();
        $sgst_code = Option::where('key', 'sgst_code')->first();
        // dd($tax);

        $currency_info = json_decode($currency_info->value ?? '');

        return view('admin.settings.site_settings', compact('site_url', 'services_url', 'info', 'currency_name', 'currency_icon', 'order_prefix', 'currency_info', 'auto_order', 'tax', 'hsn_code', 'gst_code', 'igst_code', 'cgst_code', 'sgst_code'));
    }

    public function site_settings_update(Request $request)
    {
        $site_url = Option::where('key', 'site_url')->first();
        if (empty($site_url)) {
            $site_url = new Option();
            $site_url->key = 'site_url';
        }
        $site_url->value = URL::to('/');
        $site_url->save();

        $services_url = Option::where('key', 'services_url')->first();
        if (empty($services_url)) {
            $services_url = new Option();
            $services_url->key = 'services_url';
        }
        $services_url->value = $request->services_url;
        $services_url->save();

        $option = Option::where('key', 'company_info')->first();
        // dd($option);

        if (empty($option)) {
            $option = new Option();
            $option->key = 'company_info';
        }
        $data['name'] = $request->site_name;
        $data['site_description'] = $request->site_description;
        $data['email1'] = $request->email1;
        $data['email2'] = $request->email2;
        $data['phone1'] = $request->phone1;
        $data['phone2'] = $request->phone2;
        $data['country'] = $request->country;
        $data['zip_code'] = $request->zip_code;
        $data['state'] = $request->state;
        $data['city'] = $request->city;
        $data['address'] = $request->address;
        $data['google'] = $request->google ?? '';
        $data['facebook'] = $request->facebook ?? '';
        $data['twitter'] = $request->twitter ?? '';
        $data['linkedin'] = $request->linkedin ?? '';
        $data['instagram'] = $request->instagram ?? '';
        $data['youtube'] = $request->youtube ?? '';
        $data['pinterest'] = $request->pinterest ?? '';
        $data['tumblr'] = $request->tumblr ?? '';
        $data['yahoo'] = $request->yahoo ?? '';
        $data['site_color'] = $request->site_color;
        $option->value = json_encode($data);
        $option->save();

        $currency_data['currency_name'] = $request->currency_name;
        $currency_data['currency_icon'] = $request->currency_icon;
        $currency_data['currency_possition'] = $request->currency_possition;
        $currency_name = Option::where('key', 'currency_info')->first();
        if (empty($currency_name)) {
            $currency_name = new Option();
            $currency_name->key = 'currency_info';
        }
        $currency_name->value = json_encode($currency_data);
        $currency_name->save();

        ///

        $tax = Option::where('key', 'tax')->first();
        if (empty($tax)) {
            $tax = new Option();
            $tax->key = 'tax';
        }
        $tax->value = $request->tax;
        // $tax->value=json_encode($request->tax);
        $tax->save();

        // dd($tax);

        ///

        $hsn_code = Option::where('key', 'hsn_code')->first();
        if (empty($hsn_code)) {
            $hsn_code = new Option();
            $hsn_code->key = 'hsn_code';
        }
        $hsn_code->value = $request->hsn_code;
        $hsn_code->save();

        //

        $gst_code = Option::where('key', 'gst_code')->first();
        if (empty($gst_code)) {
            $gst_code = new Option();
            $gst_code->key = 'gst_code';
        }
        $gst_code->value = $request->gst_code;
        $gst_code->save();

        //

        $igst_code = Option::where('key', 'igst_code')->first();
        if (empty($igst_code)) {
            $igst_code = new Option();
            $igst_code->key = 'igst_code';
        }
        $igst_code->value = $request->igst_code;
        $igst_code->save();

        //

        $sgst_code = Option::where('key', 'sgst_code')->first();
        if (empty($sgst_code)) {
            $sgst_code = new Option();
            $sgst_code->key = 'sgst_code';
        }
        $sgst_code->value = $request->sgst_code;
        $sgst_code->save();

        //

        $cgst_code = Option::where('key', 'cgst_code')->first();
        if (empty($cgst_code)) {
            $cgst_code = new Option();
            $cgst_code->key = 'cgst_code';
        }
        $cgst_code->value = $request->cgst_code;
        $cgst_code->save();

        //

        $order_prefix = Option::where('key', 'order_prefix')->first();
        if (empty($order_prefix)) {
            $order_prefix = new Option();
            $order_prefix->key = 'order_prefix';
        }
        $order_prefix->value = $request->order_prefix;
        $order_prefix->save();

        // $auto_order=Option::where('key','auto_order')->first();
        // if (empty($auto_order)) {
        //     $auto_order=new Option;
        //     $auto_order->key="auto_order";
        // }
        // $auto_order->value=$request->auto_order;
        // $auto_order->save();

        if ($request->logo) {
            $validatedData = $request->validate([
                'logo' => 'mimes:png',
            ]);
            $path = 'uploads/';
            $fileName = 'logo.png';
            $request->logo->move($path, $fileName);
        }

        if ($request->favicon) {
            $validatedData = $request->validate([
                'favicon' => 'mimes:ico',
            ]);
            $path = 'uploads/';
            $fileName = 'favicon.ico';
            $request->favicon->move($path, $fileName);
        }

        Cache::forget('site_info');
        return response()->json(['Site Settings Updated']);
    }

    public function business_settings()
    {
        $guide_page = Option::where('key', 'guide_link')->first();
        $ask_for_invoice = Option::where('key', 'ask_for_invoice')->first();
        $invoice_required = Option::where('key', 'invoice_required')->first();
        $ask_for_name = Option::where('key', 'ask_for_name')->first();
        $ask_for_dob = Option::where('key', 'ask_for_dob')->first();
        $ask_for_anniversary_date = Option::where('key', 'ask_for_anniversary_date')->first();
        $name_required = Option::where('key', 'name_required')->first();
        $dob_required = Option::where('key', 'dob_required')->first();
        $anniversary_date_required = Option::where('key', 'anniversary_date_required')->first();
        $route_setting = Option::where('key', 'route_setting')->first();

        // dd($guide_page);

        $currency_info = json_decode($currency_info->value ?? '');

        return view('admin.settings.business_settings', compact('guide_page', 'ask_for_invoice', 'invoice_required', 'ask_for_name', 'ask_for_dob', 'ask_for_anniversary_date', 'name_required', 'dob_required', 'anniversary_date_required', 'route_setting'));
    }

    public function business_settings_update(Request $request)
    {
        //guide page
        $guide_link = Option::where('key', 'guide_link')->first();
        if (empty($guide_link)) {
            $guide_link = new Option();
            $guide_link->key = 'guide_link';
        }
        $guide_link->value = $request->guide_link;
        $guide_link->save();

        //invoice
        if (isset($request->ask_for_invoice)) {
            $ask_for_invoice_val = 1;
        } else {
            $ask_for_invoice_val = 0;
        }

        $ask_for_invoice = Option::where('key', 'ask_for_invoice')->first();
        if (empty($ask_for_invoice)) {
            $ask_for_invoice = new Option();
            $ask_for_invoice->key = 'ask_for_invoice';
        }
        $ask_for_invoice->value = $ask_for_invoice_val;
        $ask_for_invoice->save();

        //is required
        if (isset($request->invoice_required)) {
            $invoice_required_val = 1;
        } else {
            $invoice_required_val = 0;
        }

        $invoice_required = Option::where('key', 'invoice_required')->first();
        if (empty($invoice_required)) {
            $invoice_required = new Option();
            $invoice_required->key = 'invoice_required';
        }
        $invoice_required->value = $invoice_required_val;
        $invoice_required->save();

        //ask_for_name
        if (isset($request->ask_for_name)) {
            $ask_for_name_val = 1;
        } else {
            $ask_for_name_val = 0;
        }

        $ask_for_name = Option::where('key', 'ask_for_name')->first();
        if (empty($ask_for_name)) {
            $ask_for_name = new Option();
            $ask_for_name->key = 'ask_for_name';
        }
        $ask_for_name->value = $ask_for_name_val;
        $ask_for_name->save();

        //ask_for_dob
        if (isset($request->ask_for_dob)) {
            $ask_for_dob_val = 1;
        } else {
            $ask_for_dob_val = 0;
        }

        $ask_for_dob = Option::where('key', 'ask_for_dob')->first();
        if (empty($ask_for_dob)) {
            $ask_for_dob = new Option();
            $ask_for_dob->key = 'ask_for_dob';
        }
        $ask_for_dob->value = $ask_for_dob_val;
        $ask_for_dob->save();

        //ask_for_anniversary_date
        if (isset($request->ask_for_anniversary_date)) {
            $ask_for_anniversary_date_val = 1;
        } else {
            $ask_for_anniversary_date_val = 0;
        }

        $ask_for_anniversary_date = Option::where('key', 'ask_for_anniversary_date')->first();
        if (empty($ask_for_anniversary_date)) {
            $ask_for_anniversary_date = new Option();
            $ask_for_anniversary_date->key = 'ask_for_anniversary_date';
        }
        $ask_for_anniversary_date->value = $ask_for_anniversary_date_val;
        $ask_for_anniversary_date->save();

        //ask_for_anniversary_date
        if (isset($request->name_required)) {
            $name_required_val = 1;
        } else {
            $name_required_val = 0;
        }

        $name_required = Option::where('key', 'name_required')->first();
        if (empty($name_required)) {
            $name_required = new Option();
            $name_required->key = 'name_required';
        }
        $name_required->value = $name_required_val;
        $name_required->save();

        //ask_for_anniversary_date
        if (isset($request->dob_required)) {
            $dob_required_val = 1;
        } else {
            $dob_required_val = 0;
        }

        $dob_required = Option::where('key', 'dob_required')->first();
        if (empty($dob_required)) {
            $dob_required = new Option();
            $dob_required->key = 'dob_required';
        }
        $dob_required->value = $dob_required_val;
        $dob_required->save();

        //ask_for_anniversary_date
        if (isset($request->anniversary_date_required)) {
            $anniversary_date_required_val = 1;
        } else {
            $anniversary_date_required_val = 0;
        }

        $anniversary_date_required = Option::where('key', 'anniversary_date_required')->first();
        if (empty($anniversary_date_required)) {
            $anniversary_date_required = new Option();
            $anniversary_date_required->key = 'anniversary_date_required';
        }
        $anniversary_date_required->value = $anniversary_date_required_val;
        $anniversary_date_required->save();
        //dd($request->all());

        /* ask_for route setting start */
        $route_setting = Option::where('key', 'route_setting')->first();
        $oldRouteSetting = $route_setting->value;
        // dd($oldRouteSetting);

        if (empty($route_setting)) {
            $route_setting = new Option();
            $route_setting->key = 'route_setting';
        }
        $route_setting->value = $request->route_setting;
        $route_setting->save();

        

        $msgRouteData = MessageRoute::pluck('id')->toArray();
        // dd($msgRouteData);
        foreach ($msgRouteData as $key => $messageId) {
            $messageRouteInfo = MessageRoute::find($messageId);
            // dd($messageRouteInfo);
            if ($request->route_setting == 'sms') {
                if ($oldRouteSetting == 'business_routes') {
                    // b=>sms

                    $messageRouteInfo->old_wa = $messageRouteInfo->wa;
                    $messageRouteInfo->old_sms = $messageRouteInfo->sms;
                    $messageRouteInfo->wa = 0;
                    $messageRouteInfo->sms = 1;
                } else {
                    // wha=>sms
                    $messageRouteInfo->wa = 0;
                    $messageRouteInfo->sms = 1;
                }
            } elseif ($request->route_setting == 'whatsapp') {
                if ($oldRouteSetting == 'business_routes') {
                    // b=>sms

                    $messageRouteInfo->old_sms = $messageRouteInfo->sms;
                    $messageRouteInfo->old_wa = $messageRouteInfo->wa;
                    $messageRouteInfo->wa = 1;
                    $messageRouteInfo->sms = 0;
                } else {
                    // wha=>sms
                    $messageRouteInfo->wa = 1;
                    $messageRouteInfo->sms = 0;
                }
            } elseif ($request->route_setting == 'business_routes') {
                $messageRouteInfo->sms = $messageRouteInfo->old_sms;
                $messageRouteInfo->wa = $messageRouteInfo->old_wa;
            }

            $messageRouteInfo->save();
        }

        $routeInfo = MessageRoute::where('status', 1)
            ->select('user_id')
            ->groupBy('user_id')
            ->get();
        // dd($RouteInfo);
        foreach ($routeInfo as $key => $info) {
            $userDetail = User::where('id', $info->user_id)->first();
            // dd($userDetail->mobile);
            $emaildata = [
                'name' => $userDetail->name,
                'mobile' => $userDetail->mobile,
                'email' => $userDetail->email,
                'user_id' => $info->user_id,
            ];

            if ($route_setting->value == 'sms' || $route_setting->value == 'whatsapp') {
                if ($oldRouteSetting == 'business_routes') {
                    $email_info = Email::where('id', 20)->first();
                    $emaildata['id'] = $email_info->id;
                    $emaildata['subject'] = $email_info->subject;
                    $emaildata['content'] = $email_info->content;

                    CommonMailController::BusinessRouteSettingUpdateMail($emaildata);
                }
            } elseif ($route_setting->value == 'business_routes') {
                $email_info = Email::where('id', 21)->first();
                $emaildata['id'] = $email_info->id;
                $emaildata['subject'] = $email_info->subject;
                $emaildata['content'] = $email_info->content;

                CommonMailController::BusinessRouteSettingUpdateMail($emaildata);
            }
        }

        /* ask_for route setting end */
        Cache::forget('business_info');
        return response()->json(['Business Settings Updated']);
    }

    public function system_environment_view()
    {
        $countries = base_path('resources/lang/langlist.json');
        $countries = json_decode(file_get_contents($countries), true);

        $timezones = base_path('resources/lang/timezone.json');
        $timezones = json_decode(file_get_contents($timezones), true);
        return view('admin.settings.env', compact('countries', 'timezones'));
    }

    public function env_update(Request $request)
    {
        $APP_URL_WITHOUT_WWW = str_replace('www.', '', url('/'));
        $APP_NAME = Str::slug($request->APP_NAME);
        $txt =
            'APP_NAME=' .
            $APP_NAME .
            "
                APP_ENV=" .
            $request->APP_ENV .
            "
                APP_KEY=" .
            $request->APP_KEY .
            "
                APP_DEBUG=" .
            $request->APP_DEBUG .
            "
                APP_URL=" .
            $request->APP_URL .
            "
                APP_URL_WITHOUT_WWW=" .
            $APP_URL_WITHOUT_WWW .
            "
                APP_PROTOCOLESS_URL=" .
            $request->APP_PROTOCOLESS_URL .
            "
                APP_PROTOCOL=" .
            $request->APP_PROTOCOL .
            "
                MULTILEVEL_CUSTOMER_REGISTER=" .
            $request->MULTILEVEL_CUSTOMER_REGISTER .
            "

                LOG_CHANNEL=" .
            $request->LOG_CHANNEL .
            "
                LOG_LEVEL=" .
            $request->LOG_LEVEL .
            "\n
                DB_CONNECTION=" .
            env('DB_CONNECTION') .
            "
                DB_HOST=" .
            env('DB_HOST') .
            "
                DB_PORT=" .
            env('DB_PORT') .
            "
                DB_DATABASE=" .
            env('DB_DATABASE') .
            "
                DB_USERNAME=" .
            env('DB_USERNAME') .
            "
                DB_PASSWORD=" .
            env('DB_PASSWORD') .
            "\n
                BROADCAST_DRIVER=" .
            $request->BROADCAST_DRIVER .
            "
                CACHE_DRIVER=" .
            $request->CACHE_DRIVER .
            "
                QUEUE_CONNECTION=" .
            $request->QUEUE_CONNECTION .
            "
                SESSION_DRIVER=" .
            $request->SESSION_DRIVER .
            "
                SESSION_LIFETIME=" .
            $request->SESSION_LIFETIME .
            "\n
                REDIS_HOST=" .
            $request->REDIS_HOST .
            "
                REDIS_PASSWORD=" .
            $request->REDIS_PASSWORD .
            "
                REDIS_PORT=" .
            $request->REDIS_PORT .
            "\n
                QUEUE_MAIL=" .
            $request->QUEUE_MAIL .
            "
                MAIL_MAILER=" .
            $request->MAIL_MAILER .
            "
                MAIL_HOST=" .
            $request->MAIL_HOST .
            "
                MAIL_PORT=" .
            $request->MAIL_PORT .
            "
                MAIL_USERNAME=" .
            $request->MAIL_USERNAME .
            "
                MAIL_PASSWORD=" .
            $request->MAIL_PASSWORD .
            "
                MAIL_ENCRYPTION=" .
            $request->MAIL_ENCRYPTION .
            "
                MAIL_FROM_ADDRESS=" .
            $request->MAIL_FROM_ADDRESS .
            "
                MAIL_TO=" .
            $request->MAIL_TO .
            "
                MAIL_NOREPLY=" .
            $request->MAIL_NOREPLY .
            "
                MAIL_FROM_NAME=" .
            Str::slug($request->MAIL_FROM_NAME) .
            "\n
                DO_SPACES_KEY=" .
            $request->DO_SPACES_KEY .
            "
                DO_SPACES_SECRET=" .
            $request->DO_SPACES_SECRET .
            "
                DO_SPACES_ENDPOINT=" .
            $request->DO_SPACES_ENDPOINT .
            "
                DO_SPACES_REGION=" .
            $request->DO_SPACES_REGION .
            "
                DO_SPACES_BUCKET=" .
            $request->DO_SPACES_BUCKET .
            "\n
                NOCAPTCHA_SECRET=" .
            $request->NOCAPTCHA_SECRET .
            "
                NOCAPTCHA_SITEKEY=" .
            $request->NOCAPTCHA_SITEKEY .
            "

                TIMEZONE=" .
            $request->TIMEZONE .
            '' .
            "
                DEFAULT_LANG=" .
            $request->DEFAULT_LANG .
            "\n
                ";

        File::put(base_path('.env'), $txt);
        return response()->json(['System Updated']);
    }
}
