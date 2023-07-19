<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ShortLinkController;
use App\Http\Controllers\WhatsAppApiController;
use App\Http\Controllers\WhatsAppMsgController;

use App\Models\Offer;
use App\Models\OfferSubscription;
use App\Models\Template;
use App\Models\BusinessDetail;
use App\Models\Customer;
use App\Models\Redeem;
use App\Models\SocialChannel;
use App\Models\OfferTemplate;
use App\Models\ShortLink;
use App\Models\Target;

use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon;
use Session;
use Auth;
use DB;
use URL;

class SharedLinkController extends Controller
{

    
}
