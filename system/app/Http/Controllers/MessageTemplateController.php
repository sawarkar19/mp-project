<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MessageTemplateController extends Controller
{
    static function shareOfferLinkTemplate($link){

        $payload = "Dear Customer\n".$link." wishes you a Very Happy Birthday and a Great Year ahead!\nOPNLNK";
    
        return $payload;
    }
}