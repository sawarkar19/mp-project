<?php
// 59VwvFsOSQql39tedzfukfhzqSyRNEqBw47C7QRAJsNrN1e9uZ0Tprd7Bcqr0ffz
namespace App\Http\Controllers\Business;

use Carbon\Carbon;
use Auth, CURLFile;
use Session;

use App\Models\Task;

use App\Models\User;

use GuzzleHttp\Psr7;
use App\Models\Offer;
use App\Models\Option;
use App\Models\SocialPost;
use App\Models\InstantTask;
use Illuminate\Http\Request;
use App\Models\OfferTemplate;
use App\Models\UserSocialPlatform;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;

use App\Models\BusinessDetail;

use App\Http\Controllers\Controller;
use App\Models\UserSocialConnection;

use App\Services\PayUService\Exception;
use App\Jobs\UpdateSocialConnectionSalesPerson;
use App\Http\Controllers\Business\CommonSettingController;

use App\Jobs\OfferPostToSocialMedia;

use DeductionHelper;
use App\Models\UserChannel;

class SocialConnectController extends Controller
{
    public function __construct()
    {
        $this->middleware('business');
    }

    // update social media connections
    public function updateUserConnections()
    {
        // get User connected social media
        $option=Option::where('key','social_post_url')->first();
        $userDetail = User::find(Auth::id());

        if($userDetail->social_post_api_token==NULL){
            $this->createSocialPostAuth($userDetail->id);
            $userDetail = User::find(Auth::id());
        }

        $social_post_api_token = $userDetail->social_post_api_token;
        $url=$option->value."/api/getUser";

        $postfields=[];
        $curlParams=[
            'url' => $url,
            'social_post_api_token' => $social_post_api_token
        ];
        $response = $this->curlGet($curlParams);
        $response = json_decode($response);
        
        $userSocialConnection = UserSocialConnection::where('user_id', Auth::id())->first();
        if($userSocialConnection==NULL){
            $userSocialConnection = new UserSocialConnection;
        }
        $userSocialConnection->user_id = Auth::id();
        if($response!=NULL){
            if(isset($response->user)){
                // Webhook
                $userSocialConnection->webhook_path = $response->user->webhook ?? NULL;

                // Facebook
                $userSocialConnection->is_facebook_auth = $response->user->token != NULL ? 1 : NULL;
                $userSocialConnection->facebook_token = $response->user->token ?? NULL;
                $userSocialConnection->facebook_app_id = $response->user->facebook_app_id ?? NULL;
                $userSocialConnection->facebook_page_id = $response->user->selected_fb_page_id ?? NULL;
                $userSocialConnection->facebook_pages = $response->user->facebook_page_id ?? NULL;
                $userSocialConnection->facebook_page_details = $response->user->facebook_page_id ?? NULL;

                // Twitter
                $userSocialConnection->is_twitter_auth = $response->user->twitter_token != NULL ? 1 : NULL;
                $userSocialConnection->twitter_token = $response->user->twitter_token ?? NULL;
                $userSocialConnection->twitter_id = $response->user->twitter_id ?? NULL;
                $userSocialConnection->twitter_token_secret = $response->user->twitter_token_secret ?? NULL;
                $userSocialConnection->twitter_username = $response->user->twitter_username ?? NULL;
                $userSocialConnection->twitter_bearer_token = $response->user->twitter_bearer_token ?? NULL;

                // LinkedIn
                $userSocialConnection->is_linkedin_auth = $response->user->linkedin_token != NULL ? 1 : NULL;
                $userSocialConnection->linkedin_id = $response->user->linkedin_id ?? NULL;
                $userSocialConnection->linkedin_token = $response->user->linkedin_token ?? NULL;
                $userSocialConnection->linkedin_page_id = $response->user->linkedin_page_id ?? NULL;

                // Instagram 
                $userSocialConnection->is_instagram_auth = $response->user->instagram_token != NULL ? 1 : NULL;
                $userSocialConnection->instagram_token = $response->user->instagram_token ?? NULL;
                $userSocialConnection->instagram_username = $response->user->instagram_username ?? NULL;
                $userSocialConnection->instagram_user_id = $response->user->instagram_user_id ?? NULL;

                $userSocialConnection->is_youtube_auth = $response->user->youtube_access_token != NULL ? 1 : NULL;

                // Check Connection 
                // 1. Facebook
                if($response->user->token==NULL || $response->user->facebook_app_id==NULL || $response->user->facebook_page_id==NULL){
                    $userSocialConnection->is_facebook_auth = NULL;
                    $userSocialConnection->facebook_token = NULL;
                    $userSocialConnection->facebook_app_id = NULL;
                    $userSocialConnection->facebook_page_id = NULL;
                    $userSocialConnection->facebook_pages = NULL;
                    $userSocialConnection->facebook_page_details = NULL;
                }

                // 2. Instagram
                if($response->user->instagram_token==NULL || $response->user->instagram_username==NULL || $response->user->instagram_user_id==NULL){
                    $userSocialConnection->is_instagram_auth = NULL;
                    $userSocialConnection->instagram_token = NULL;
                    $userSocialConnection->instagram_username = NULL;
                    $userSocialConnection->instagram_user_id = NULL;
                }
            }
        }

        $userSocialConnection->save();
        /* Update Social Channels for Sales Person */
        dispatch(new UpdateSocialConnectionSalesPerson());

        return true;
    }

    public function index(Request $request)
    {
        echo '<script type="text/JavaScript">
            sessionStorage.setItem("setting_section", "social_connection"); 
        </script>';
        return redirect('business/settings');
        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();

        $this->updateUserConnections();

        $userSocialConnection = UserSocialConnection::where('user_id', Auth::id())->first();
        if($userSocialConnection==NULL){
            $userSocialConnection = new UserSocialConnection;
        }

        $isFacebookCheck = $isTwitterCheck = $islinkedInCheck = $isInstagramCheck =0;
        $isFacebookConnected = $isInstagramConnected = 0;
        if($request->has('facebook')){
            $isFacebookCheck = 1;
            $isFacebookConnected = $userSocialConnection->is_facebook_auth ?? NULL;
        }
        else if($request->has('twitter')){
            $isTwitterCheck = 1;
        }
        else if($request->has('linkedin')){
            $islinkedInCheck = 1;
        }
        else if($request->has('instagram')){
            $isInstagramCheck = 1;
            $isInstagramConnected = $userSocialConnection->is_instagram_auth ?? NULL;
        }

        $userSocialPlatform = UserSocialPlatform::orderBy('sort_no', 'ASC')->get();
        $googleReviewDeductCost = DeductionHelper::getActiveDeductionDetail('slug', 'google_review_verification');

        $youtubeTasks = InstantTask::where('user_id', Auth::id())->whereIn('task_id', [10,11,12])->whereNull('deleted_at')->count();
        // dd($youtubeTasks);

        return view('business.social-posts.social-connect', compact('notification_list','planData', 'userSocialConnection', 'isFacebookCheck', 'isFacebookConnected', 'isTwitterCheck', 'islinkedInCheck', 'isInstagramCheck', 'isInstagramConnected', 'userSocialPlatform', 'googleReviewDeductCost', 'youtubeTasks'));
    }

    public function createOldUserAuthKey(Request $request)
    {
        $users = User::where('role_id', 2)->whereNull('social_post_api_token')
                        ->orWhere('social_post_api_token', '')
                        ->pluck('id')->toArray();
        // dd($users);
        foreach ($users as $key => $user) {
            //API URL
            $this->createSocialPostAuth($user);
            // echo "<br/>User id <pre>"; print_r($user);
        }

        return "Token added successfully!";
    }

    // // Helper function courtesy of https://github.com/guzzle/guzzle/blob/3a0787217e6c0246b457e637ddd33332efea1d2a/src/Guzzle/Http/Message/PostFile.php#L90
    function getCurlValue($filename, $contentType, $postname)
    {
        // PHP 5.5 introduced a CurlFile object that deprecates the old @filename syntax
        // See: https://wiki.php.net/rfc/curl-file-upload
        if (function_exists('curl_file_create')) {
            return curl_file_create($filename, $contentType, $postname);
        }

        // Use the old style if using an older version of PHP
        $value = "@{$filename};filename=" . $postname;
        if ($contentType) {
            $value .= ';type=' . $contentType;
        }

        return $value;
    }

    public function curlGet($params=[]){
        //init the resource
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $params['url'],
            CURLOPT_RETURNTRANSFER => true,
            // CURLOPT_ENCODING => '',
            // CURLOPT_MAXREDIRS => 10,
            // CURLOPT_TIMEOUT => 0,
            // CURLOPT_FOLLOWLOCATION => true,
            // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HEADER => 0,
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$params['social_post_api_token']
            ),
        ));
        
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    public function curlPost($params=[]){
        $postfields = $params['postfields'];
        
        //init the resource
        $curl = curl_init();

        if(isset($params['postfields']['single_image']) && !empty($params['postfields']['single_image'])){
            $single_image_name = $params['postfields']['single_image'];
            
            $fileName = pathinfo($single_image_name, PATHINFO_FILENAME);
            $fileExt = pathinfo($single_image_name, PATHINFO_EXTENSION);
            // $fileType = mime_content_type($single_image_name);
            // Log::debug($fileType);
            $file_with_path = asset($single_image_name);

            // $cfile = curl_file_create($fileName.".".$fileExt, $fileType, 'image_'.rand(111111, 999999));
            // curl_setopt ($curl, CURLOPT_SAFE_UPLOAD, false);

            // dd($single_image_name, $fileName, $fileExt, $fileType, $file_with_path);
            // $filename = $params['postfields']['single_image'];
            // $cfile = $this->getCurlValue($filename, 'image/jpeg', 'cattle-01.jpeg');

            $postfields['image'] = $file_with_path;
            $postfields['extension'] = $fileExt;
            unset($postfields['single_image']);
        }

        curl_setopt_array($curl, array(
            CURLOPT_URL => $params['url'],
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $postfields,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$params['social_post_api_token']
            ),
        ));

        $response = curl_exec($curl);
        // echo ($response); exit;
        curl_close($curl);
        return $response;
    }

    public function createSocialPostAuth($user_id){
        //API URL
        $option=Option::where('key','social_post_url')->first();
        $url=$option->value."/api/register";
        
        $userDetail = User::find($user_id);

        $params = [
            'name' => $userDetail->name,
            'email'=> $userDetail->email,
            'password' => 12345678,
            'webhook' => route('getSocialPostInfo')
        ];

        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $params
            //,CURLOPT_FOLLOWLOCATION => true
        ));

        //Ignore SSL certificate verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        //Get response
        $response = curl_exec($ch);
        $output = json_decode($response);
        curl_close($ch);
        
        if($output==NULL){
            return 1;
        }
        else if($output->status == true){
            $access_token = $output->data->api_token;

            $userDetail->social_post_api_token = $access_token;
            $userDetail->save();
            return 1;
        }else{
            $access_token = '';
            return 1;
        }
    }

    public function connectSocialMedia(Request $request)
    {
        // dd($request);
        $res['status'] = false;
        try {
            switch ($request->socialAccount) {

                case 'facebook':
                    $res['status'] = true;
                    $res['social_account_type'] = $request->socialAccount;
                    $res['response'] = $this->connectWithFacebook($request);
                    // $res['response'] = $url;
                    break;

                case 'twitter':
                    $res['status'] = true;
                    $res['social_account_type'] = $request->socialAccount;
                    $res['response'] = $this->connectWithTwitter($request);
                    // $res['response'] = $url;
                    break;

                case 'instagram':
                    $res['status'] = true;
                    $res['social_account_type'] = $request->socialAccount;
                    $res['response'] = $this->connectWithInstagram($request);
                    // $res['response'] = $url;
                    break;

                case 'linkedIn':
                    $res['status'] = true;
                    $res['social_account_type'] = $request->socialAccount;
                    $res['response'] = $this->connectWithLinkedIn($request);
                    // $res['response'] = $url;
                    break;

                case 'youtube':
                    $res['status'] = true;
                    $res['social_account_type'] = $request->socialAccount;
                    $res['response'] = $this->connectWithYoutube($request);
                    // $res['response'] = $url;
                    break;

                case 'google':
                    $res['status'] = true;
                    $res['social_account_type'] = $request->socialAccount;
                    $res['response'] = $this->connectWithGoogleReview($request);
                    // $res['response'] = $url;
                    break;
                
                default:
                    $res['status'] = false;
                    $res['social_account_type'] = '';
                    $res['response'] = "Something went wrong!";
                    break;
            }
        } catch (\Exception $e) {
            $res = $e->getMessage();
        }
        return response()->json($res);
    }

    // // create design post in middleware server
    public function createOfferDesignPost($params=[]){
        $option=Option::where('key','social_post_url')->first();

        $user_id = $params['user_id'] ?? Auth::id();
        $userDetail = User::find($user_id);

        if($userDetail->social_post_api_token==NULL){
            $this->createSocialPostAuth($userDetail->id);
            $userDetail = User::find($user_id);
        }

        $social_post_api_token = $userDetail->social_post_api_token;
        $url=$option->value."/api/add-post";

        $postfields=[];
        if(isset($params['name'])){
            $postfields['name'] = $params['name'];
        }
        if(isset($params['message'])){
            $postfields['message'] = $params['message'];
        }
        if(isset($params['single_image'])){
            $postfields['single_image'] = $params['single_image'];
        }
        if(isset($params['url'])){
            $postfields['url'] = $params['url'];
        }

        if(isset($params['facebook_url'])){
            $postfields['facebook_url'] = $params['facebook_url'];
        }

        if(isset($params['twitter_url'])){
            $postfields['twitter_url'] = $params['twitter_url'];
        }

        if(isset($params['linkedin_url'])){
            $postfields['linkedin_url'] = $params['linkedin_url'];
        }

        if(isset($params['start_date'])){
            $postfields['start_date'] = $params['start_date'];
        }
        else{
            $postfields['start_date'] = "";
        }

        if(isset($params['end_date'])){
            $postfields['end_date'] = $params['end_date'];
        }
        else{
            $postfields['end_date'] = "";
        }

        $curlParams=[
            'url' => $url,
            'social_post_api_token' => @$social_post_api_token,
            'postfields' => @$postfields,
        ];
        $response = $this->curlPost($curlParams);
        // echo ($response); exit;

        $response = json_decode($response,true);

        if($response==NULL || $response['status']==400){
            $offer = Offer::find($params['offer_id']);
            $offer->is_social_post_created = 0;
            $offer->save();

            $response['is_social_error'] = true;
            return $response;
        }
        else if($response['status']==200){
            $offer = Offer::find($params['offer_id']);
            $offer->social_post__db_id = $response['data']['id'];
            $offer->is_social_post_created = 1;
            $offer->save();

            $response['is_social_error'] = false;
            return $response;
        }
    }

    // // create design post in middleware server
    public function updateOfferDesignPost($params=[]){
        $option=Option::where('key','social_post_url')->first();
        $url=$option->value."/api/update-post";

        $userDetail = User::find(Auth::id());
        if($userDetail->social_post_api_token==NULL){
            $this->createSocialPostAuth($userDetail->id);
            $userDetail = User::find(Auth::id());
        }
        $social_post_api_token = $userDetail->social_post_api_token;

        $postfields=[];
        if(isset($params['name'])){
            $postfields['name'] = $params['name'];
        }
        if(isset($params['message'])){
            $postfields['message'] = $params['message'];
        }
        if(isset($params['single_image'])){
            $postfields['single_image'] = $params['single_image'];
        }
        if(isset($params['url'])){
            $postfields['url'] = $params['url'];
        }

        if(isset($params['facebook_url'])){
            $postfields['facebook_url'] = $params['facebook_url'];
        }

        if(isset($params['twitter_url'])){
            $postfields['twitter_url'] = $params['twitter_url'];
        }

        if(isset($params['linkedin_url'])){
            $postfields['linkedin_url'] = $params['linkedin_url'];
        }
        if(isset($params['post_id'])){
            $postfields['post_id'] = $params['post_id'];
        }

        if(isset($params['start_date'])){
            $postfields['start_date'] = $params['start_date'];
        }
        else{
            $postfields['start_date'] = "";
        }

        if(isset($params['end_date'])){
            $postfields['end_date'] = $params['end_date'];
        }
        else{
            $postfields['end_date'] = "";
        }

        $curlParams=[
            'url' => $url,
            'social_post_api_token' => @$social_post_api_token,
            'postfields' => @$postfields,
        ];
        // dd($curlParams);
        $response = $this->curlPost($curlParams);
        $response = json_decode($response,true);
        // dd($response);
        if($response==NULL || $response['status']==400){
            $offer = Offer::find($params['offer_id']);
            $offer->is_social_post_created = 0;
            $offer->save();
            
            $response=[];
            $response['is_social_error'] = true;
            return $response;
        }
        else if($response['status']==200){
            $offer = Offer::find($params['offer_id']);
            $offer->is_social_post_created = 1;
            $offer->save();

            $response=[];
            $response['is_social_error'] = false;
            return $response;
        }
    }

    // CRON => create design post in middleware server
    public function curlPostCron($params=[]){

        $postfields = $params['postfields'];
        // dd($postfields);

        //init the resource
        $curl = curl_init();

        if(isset($params['postfields']['single_image']) && !empty($params['postfields']['single_image'])){
            $single_image_name = $params['postfields']['single_image'];
            
            $fileName = pathinfo($single_image_name, PATHINFO_FILENAME);
            $fileExt = pathinfo($single_image_name, PATHINFO_EXTENSION);
            // $fileType = mime_content_type($single_image_name);
            // dd($single_image_name, $fileName, $fileExt);
            $file_with_path = asset($single_image_name);

            // $cfile = curl_file_create($fileName.".".$fileExt, $fileType, 'image_'.rand(111111, 999999));
            // curl_setopt ($curl, CURLOPT_SAFE_UPLOAD, false);

            // dd($single_image_name, $fileName, $fileExt, $fileType, $file_with_path);
            // $filename = $params['postfields']['single_image'];
            // $cfile = $this->getCurlValue($filename, 'image/jpeg', 'cattle-01.jpeg');

            $postfields['image'] = $file_with_path;
            $postfields['extension'] = $fileExt;
            unset($postfields['single_image']);
        }

        curl_setopt_array($curl, array(
            CURLOPT_URL => $params['url'],
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $postfields,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$params['social_post_api_token']
            ),
        ));

        $response = curl_exec($curl);

        // dd($postfields, $params, $response);

        curl_close($curl);
        return $response;
    }

    public function createOfferDesignPostUsingCron($params=[]){
        $option=Option::where('key','social_post_url')->first();
        $userDetail = User::find($params['user_id']);

        if($userDetail->social_post_api_token==NULL){
            $this->createSocialPostAuth($userDetail->id);
            $userDetail = User::find($params['user_id']);
        }

        $social_post_api_token = $userDetail->social_post_api_token;
        $url=$option->value."/api/add-post";

        $postfields=[];
        if(isset($params['name'])){
            $postfields['name'] = $params['name'];
        }
        if(isset($params['message'])){
            $postfields['message'] = $params['message'];
        }
        if(isset($params['single_image'])){
            $postfields['single_image'] = $params['single_image'];
        }
        if(isset($params['url'])){
            $postfields['url'] = $params['url'];
        }

        // $userSocialConnection = UserSocialConnection::where('user_id', $offer->user_id)->first();
        // if(isset($userSocialConnection->linkedin_page_id)){
        //     $postfields['page_id'] = $userSocialConnection->linkedin_page_id ?? NULL;
        // }

        if(isset($params['facebook_url'])){
            $postfields['facebook_url'] = $params['facebook_url'];
        }

        if(isset($params['twitter_url'])){
            $postfields['twitter_url'] = $params['twitter_url'];
        }

        if(isset($params['linkedin_url'])){
            $postfields['linkedin_url'] = $params['linkedin_url'];
        }

        if(isset($params['start_date'])){
            $postfields['start_date'] = $params['start_date'];
        }
        else{
            $postfields['start_date'] = "";
        }

        if(isset($params['end_date'])){
            $postfields['end_date'] = $params['end_date'];
        }
        else{
            $postfields['end_date'] = "";
        }

        $curlParams=[
            'url' => $url,
            'social_post_api_token' => @$social_post_api_token,
            'postfields' => @$postfields,
        ];
        // dd($curlParams);
        $response = $this->curlPostCron($curlParams);
        // echo "create "; dd($response);
        $response = json_decode($response,true);

        if($response==NULL || $response['status']==400){
            $offer = Offer::find($params['offer_id']);
            $offer->is_social_post_created = 0;
            $offer->save();

            $response['is_social_error'] = true;
            return $response;
        }
        else if($response['status']==200){
            $offer = Offer::find($params['offer_id']);
            $offer->social_post__db_id = $response['data']['id'];
            $offer->is_social_post_created = 1;
            $offer->save();

            $response['is_social_error'] = false;
            return $response;
        }
    }

    public function updateOfferDesignPostUsingCron($params=[]){
        $option=Option::where('key','social_post_url')->first();
        $url=$option->value."/api/update-post";

        $userDetail = User::find($params['user_id']);
        if($userDetail->social_post_api_token==NULL){
            $this->createSocialPostAuth($userDetail->id);
            $userDetail = User::find($params['user_id']);
        }
        $social_post_api_token = $userDetail->social_post_api_token;

        $postfields=[];
        if(isset($params['name'])){
            $postfields['name'] = $params['name'];
        }
        if(isset($params['message'])){
            $postfields['message'] = $params['message'];
        }
        if(isset($params['single_image'])){
            $postfields['single_image'] = $params['single_image'];
        }
        if(isset($params['url'])){
            $postfields['url'] = $params['url'];
        }

        $userSocialConnection = UserSocialConnection::where('user_id', $offer->user_id)->first();

        if(isset($params['facebook_url'])){
            $postfields['facebook_url'] = $params['facebook_url'];
        }

        if(isset($params['twitter_url'])){
            $postfields['twitter_url'] = $params['twitter_url'];
        }

        if(isset($params['linkedin_url'])){
            $postfields['linkedin_url'] = $params['linkedin_url'];
        }

        if(isset($params['post_id'])){
            $postfields['post_id'] = $params['post_id'];
        }

        // if(isset($userSocialConnection->linkedin_page_id)){
        //     $postfields['page_id'] = $userSocialConnection->linkedin_page_id ?? NULL;
        // }

        if(isset($params['start_date'])){
            $postfields['start_date'] = $params['start_date'];
        }
        else{
            $postfields['start_date'] = "";
        }

        if(isset($params['end_date'])){
            $postfields['end_date'] = $params['end_date'];
        }
        else{
            $postfields['end_date'] = "";
        }

        $curlParams=[
            'url' => $url,
            'social_post_api_token' => @$social_post_api_token,
            'postfields' => @$postfields,
        ];
        // dd($curlParams);
        $response = $this->curlPostCron($curlParams);
        // dd($response);
        $response = json_decode($response,true);
       
        if($response==NULL || $response['status']==400){
            $offer = Offer::find($params['offer_id']);
            $offer->is_social_post_created = 0;
            $offer->save();
            
            $response=[];
            $response['is_social_error'] = true;
            return $response;
        }
        else if($response['status']==200){
            $offer = Offer::find($params['offer_id']);
            $offer->is_social_post_created = 1;
            $offer->save();

            $response['is_social_error'] = false;
            return $response;
        }
    }

    public function onConnectPostToSocialMedia(Request $request){
        if(isset($request->socialType) && $request->socialType!=""){
            $this->postOngoingOfferToSocialMedia($request->socialType);
        }
    }

    public function postOngoingOfferToSocialMedia($socialType){
        $isChannelActive = UserChannel::whereChannelId(1)->whereUserId(Auth::id())->first('status');
        if($isChannelActive->status == 1){
            $ongoingOffer = Offer::where('user_id', Auth::id())
                        ->where('start_date', '<=', date('Y-m-d'))
                        ->where('end_date', '>=', date('Y-m-d'))
                        ->first();

            $taskIds = [];
            if($socialType == "facebook"){
                $taskIds = [2, 3, 15];
            }
            else if($socialType == "instagram"){
                $taskIds = [5, 16];
            }
            else if($socialType == "twitter"){
                $taskIds = $tasks = [7];
            }
            else if($socialType == "linkedIn"){
                $taskIds = [9];
            }

            if($ongoingOffer!=NULL){
                $instanceTask = InstantTask::whereUserId(Auth::id())->where('offer_id', $ongoingOffer->id)->whereIn('task_id', $taskIds)->whereNull('deleted_at')->orderBy('id', 'DESC')->pluck('id')->toArray();

                if(count($instanceTask)==0){
                    $data['user_id'] = Auth::id();
                    $data['offer_id'] = $ongoingOffer->id;
                    $data['social_post_id'] = $ongoingOffer->social_post__db_id;

                    $jobData=[
                        'user_id' => Auth::id(),
                        'offer_id' => $ongoingOffer->id,
                        'social_post_id' => $ongoingOffer->social_post__db_id,
                    ];
                    dispatch(new OfferPostToSocialMedia($jobData));
                }
            }
        }
    }

    // Post Offer to Social Media
    public function postToSocialLink(Request $request)
    {
        $res=[];
        try {
            $social_type = decrypt($request->social_type);
            $offer_id = decrypt($request->offer_id);

            $offerDetail = Offer::find($offer_id);
            if($offerDetail->social_post__db_id==NULL){
                $this->setOfferAndPost($offerDetail);
                $offerDetail = Offer::find($offer_id);
            }

            switch ($social_type) {
                case 'facebook':
                    $res['status'] = true;
                    $res['code'] = 200;
                    $res['social_type'] = $social_type;
                    $res['social_type_slug'] = encrypt($social_type);
                    $res['response'] = $this->postToFacebook($social_type, $offer_id);
                    break;

                case 'twitter':
                    $res['status'] = true;
                    $res['code'] = 200;
                    $res['social_type'] = $social_type;
                    $res['social_type_slug'] = encrypt($social_type);
                    $res['response'] = $this->postToTweet($social_type, $offer_id);
                    break;

                case 'linkedin':
                    $res['status'] = true;
                    $res['code'] = 200;
                    $res['social_type'] = $social_type;
                    $res['social_type_slug'] = encrypt($social_type);
                    $res['response'] = $this->postToLinkedin($social_type, $offer_id);
                    break;

                case 'instagram':
                    $res['status'] = true;
                    $res['code'] = 200;
                    $res['social_type'] = $social_type;
                    $res['social_type_slug'] = encrypt($social_type);
                    $res['response'] = $this->postToInstagram($social_type, $offer_id);
                    break;
                
                default:
                    $res['status'] = false;
                    $res['code'] = 500;
                    $res['social_account_type'] = '';
                    $res['response'] = "Something went wrong!";
                    break;
            }
        } catch (\Exception $e) {
            $res = $e->getMessage();
        }
        // dd($res);
        return response()->json($res);
    }

    // Facebook
    public function connectWithFacebook($request)
    {
        $option=Option::where('key','social_post_url')->first();
        $url=$option->value."/api/facebook/connect?callback_url=".URL::to('business/settings?facebook="true"');

        $userDetail = User::find(Auth::id());
        if($userDetail->social_post_api_token==NULL){
            $this->createSocialPostAuth($userDetail->id);
            $userDetail = User::find(Auth::id());
            $social_post_api_token = $userDetail->social_post_api_token;
        }
        $social_post_api_token = $userDetail->social_post_api_token;
        
        $curlParams=[
            'url' => $url,
            'social_post_api_token' => $social_post_api_token
        ];
        $response = $this->curlGet($curlParams);
        // dd($response);
        return $response;
    }

    public function getFacebookPages(Request $request)
    {
        $option=Option::where('key','social_post_url')->first();
        $url=$option->value."/api/facebook/getPageIds";

        $userDetail = User::find(Auth::id());
        if($userDetail->social_post_api_token==NULL){
            $this->createSocialPostAuth($userDetail->id);
            $userDetail = User::find(Auth::id());
            $social_post_api_token = $userDetail->social_post_api_token;
        }
        $social_post_api_token = $userDetail->social_post_api_token;
        
        $postfields=[];
        $curlParams=[
            'url' => $url,
            'social_post_api_token' => $social_post_api_token,
            'postfields' => @$postfields,
        ];
        $response = $this->curlPost($curlParams);
        $response = json_decode($response, true);

        if($response!=NULL){
            if($response['status']==200){
                $userSocialConnection = UserSocialConnection::where('user_id', Auth::id())->first();
                $userSocialConnection->facebook_pages = json_encode($response['page_ids']);
                $userSocialConnection->save();
    
                /* Update Social Channels for Sales Person */
                dispatch(new UpdateSocialConnectionSalesPerson());
    
                $response['facebook_page_id'] = $userSocialConnection->facebook_page_id;
            }
            else{
                $response['error'] = "Facebook pages not found!";
                $response['status'] = 500;
                $response['page_ids'] = [];
            }
        }
        else{
            $response['error'] = "Facebook pages not found!";
            $response['status'] = 500;
            $response['page_ids'] = [];
        }
        return response()->json($response);
    }

    public function saveFacebookPage(Request $request)
    {
        $res['status']=500;
        if($request->facebook_page){
            // update in managemedia server
            $option=Option::where('key','social_post_url')->first();        
            
            $userDetail = User::find(Auth::id());
            if($userDetail->social_post_api_token==NULL){
                $this->createSocialPostAuth($userDetail->id);
                $userDetail = User::find(Auth::id());
            }

            $social_post_api_token = $userDetail->social_post_api_token;
            $url=$option->value."/api/facebook/updatePageId";

            $postfields=[];
            $postfields['fb_page_id'] = $request['facebook_page'];

            $curlParams=[
                'url' => $url,
                'social_post_api_token' => @$social_post_api_token,
                'postfields' => @$postfields,
            ];
            // dd($curlParams);
            $response = $this->curlPost($curlParams);
            $response = json_decode($response, true);

            if($response!=NULL){
                if($response['status']==200){
                    $userSocialConnection = UserSocialConnection::where('user_id', Auth::id())->first();
                    $userSocialConnection->facebook_page_id = $request['facebook_page'];
                    $userSocialConnection->save();

                    /* Update Social Channels for Sales Person */
                    dispatch(new UpdateSocialConnectionSalesPerson());

                    $instant_task = InstantTask::whereUserId(Auth::id())->whereNull('deleted_at')->whereTaskId(1)->where('task_value', $request['facebook_page'])->first();
                    // $instant_task = InstantTask::where('user_id', Auth::id())->where('task_id', 1)->first();
                    if($instant_task!=NULL){
                        // Update
                        $instant_task->task_value = $request['facebook_page'];
                        $instant_task->save();
                    }
                    else{
                        $instanceTasks = InstantTask::whereUserId(Auth::id())->whereNull('deleted_at')->whereTaskId(1)->orderBy('id', 'DESC')->pluck('id')->toArray();

                        foreach ($instanceTasks as $ITaskKey => $Itask) {
                            $iTask = InstantTask::find($Itask);
                            $iTask->deleted_at = Carbon::now();
                            $iTask->save();
                        }

                        // New Create
                        $instant_task = new InstantTask;
                        $instant_task->user_id = Auth::id();
                        $instant_task->task_id = 1;
                        $instant_task->task_value = $request['facebook_page'];
                        $instant_task->save();
                    }

                    $res['status']=200;
                    $res['message']="Page updated successfully";
                }
            }
            else{
                $res['message']="Unable to update page";
            }
        }
        else{
            $res['message']="Unable to update page";
        }
        return $res;
    }

    public function postToFacebook($social_type, $offer_id)
    {
        // dd("postToFacebook", $social_type, $offer_id);
        $option=Option::where('key','social_post_url')->first();        
        $offer = Offer::find($offer_id);

        $userDetail = User::find($offer->user_id);
        
        if($userDetail->social_post_api_token==NULL){
            $this->createSocialPostAuth($userDetail->id);
            $userDetail = User::find(Auth::id());
        }

        $social_post_api_token = $userDetail->social_post_api_token;
        $url=$option->value."/api/facebook/publish";

        // Get Page ID
        $userSocialConnection = UserSocialConnection::where('user_id', Auth::id())->first();
        $post_id = (int) $offer->social_post__db_id;
        $page_id = (int) $userSocialConnection->facebook_page_id;

        $postfields=[];
        $postfields['post_id'] = $post_id;
        $postfields['page_id'] = $page_id;

        $curlParams=[
            'url' => $url,
            'social_post_api_token' => @$social_post_api_token,
            'postfields' => @$postfields,
        ];
        // dd($curlParams);
        $response = $this->curlPost($curlParams);
        // echo ($response); exit;
        $response = json_decode($response, true);

        $res=[];
        $res['social_type'] = $social_type;
        $res['offer_id'] = encrypt($offer_id);
        if($response==NULL){
            $res['error'] = "Something went wring!, Unable to Post offer to your social account";
            $res['status'] = 500;
        }
        else if($response['status']==200){
            $res['post_short_url'] = $response['post_url'];
            $res['msg'] = $response['msg'];
            $res['status'] = $response['status'];
        }
        else{
            $res['error'] = $response['msg'];
            $res['msg'] = $response['msg'];
            $res['status'] = $response['status'];
        }
        // dd($res);
        return $res;
    }

    // Twitter
    public function connectWithTwitter($request){
        $option=Option::where('key','social_post_url')->first();
        $url=$option->value."/api/twitter/connect?callback_url=".URL::to('business/settings?twitter="true"');

        $userDetail = User::find(Auth::id());
        if($userDetail->social_post_api_token==NULL){
            $this->createSocialPostAuth($userDetail->id);
            $userDetail = User::find(Auth::id());
            $social_post_api_token = $userDetail->social_post_api_token;
        }
        $social_post_api_token = $userDetail->social_post_api_token;
        
        $curlParams=[
            'url' => $url,
            'social_post_api_token' => $social_post_api_token
        ];
        $response = $this->curlGet($curlParams);
        return $response;
    }

    public function saveTwitterUsername(Request $request)
    {
        $option=Option::where('key','social_post_url')->first();
        $url=$option->value."/api/twitter/getUserName";

        $userDetail = User::find(Auth::id());
        if($userDetail->social_post_api_token==NULL){
            $this->createSocialPostAuth($userDetail->id);
            $userDetail = User::find(Auth::id());
            $social_post_api_token = $userDetail->social_post_api_token;
        }
        $social_post_api_token = $userDetail->social_post_api_token;
        
        $curlParams=[
            'url' => $url,
            'social_post_api_token' => $social_post_api_token
        ];
        $response = $this->curlGet($curlParams);
        $response = json_decode($response);
        if($response->status==200){
            $checkTask = [
                $response->twitter_username,
                '@'.$response->twitter_username
            ];

            $instantTask = InstantTask::where('user_id', Auth::id())->where('task_id', 6)->whereNotIn('task_value', $checkTask)->whereNull('deleted_at')->pluck('id')->toArray();
            InstantTask::whereIn("id", $instantTask)->update(['deleted_at' => Carbon::now()]);

            $instantTaskInfo = InstantTask::where('user_id', Auth::id())->where('task_id', 6)->whereIn('task_value', $checkTask)->whereNull('deleted_at')->first();
            if($instantTaskInfo==NULL){
                $newInstantTasks = new InstantTask;
                $newInstantTasks->user_id = Auth::id();
                $newInstantTasks->task_id = 6;
                $newInstantTasks->task_value = "@".$response->twitter_username;
                $newInstantTasks->save();
            }
        }
        return true;
    }

    public function postToTweet($social_type, $offer_id)
    {
        $option=Option::where('key','social_post_url')->first();        
        $offer = Offer::find($offer_id);

        $userDetail = User::find($offer->user_id);
        
        if($userDetail->social_post_api_token==NULL){
            $this->createSocialPostAuth($userDetail->id);
            $userDetail = User::find(Auth::id());
        }
        
        $social_post_api_token = $userDetail->social_post_api_token;
        $url=$option->value."/api/twitter/tweet";

        $postfields=[];
        $postfields['post_id'] = $offer->social_post__db_id;

        $curlParams=[
            'url' => $url,
            'social_post_api_token' => @$social_post_api_token,
            'postfields' => @$postfields,
        ];
        $response = $this->curlPost($curlParams);
        $response = json_decode($response,true);

        // $response=[
        //     'status'=>32,
        //     'msg'=>'Could not authenticate you.'
        // ];
        $res=[];
        $res['social_type'] = $social_type;
        $res['offer_id'] = encrypt($offer_id);
        if($response==NULL){
            $res['error'] = "Something went wring!, Unable to Post offer to your social account";
            $res['status'] = 500;
        }
        else if($response['status']==32){
            $expiredParams=[
                'user_id' => Auth::id(),
                'platform' => "twitter",
            ];
            app('App\Http\Controllers\SocialPagesController')->expireSocialMedia($expiredParams);
            
            $res['status'] = 500;
            $res['is_expired'] = true;
            $res['error'] = "Token expired please reconnect";
        }
        else if($response['status']==200){
            $res['post_short_url'] = $response['tweet_url'];
            $res['status'] = $response['status'];
        }
        else{
            $res['error'] = $response['msg'];
            $res['status'] = $response['status'];
        }
        // dd($res);
        return $res;
    }

    // Instagram
    public function connectWithInstagram($request)
    {
        $option=Option::where('key','social_post_url')->first();
        $url=$option->value."/api/instagram/authenticate?callback_url=".URL::to('business/settings?instagram="true"');

        $userDetail = User::find(Auth::id());
        if($userDetail->social_post_api_token==NULL){
            $this->createSocialPostAuth($userDetail->id);
            $userDetail = User::find(Auth::id());
            $social_post_api_token = $userDetail->social_post_api_token;
        }
        $social_post_api_token = $userDetail->social_post_api_token;
        
        $curlParams=[
            'url' => $url,
            'social_post_api_token' => $social_post_api_token
        ];
        $response = $this->curlGet($curlParams);
        // dd($response, $curlParams);
        // print_r($response); die;
        return $response;
    }

    public function saveInstagramUsername(Request $request)
    {
        $option=Option::where('key','social_post_url')->first();
        $url=$option->value."/api/getUser";

        $userDetail = User::find(Auth::id());
        if($userDetail->social_post_api_token==NULL){
            $this->createSocialPostAuth($userDetail->id);
            $userDetail = User::find(Auth::id());
            $social_post_api_token = $userDetail->social_post_api_token;
        }
        $social_post_api_token = $userDetail->social_post_api_token;
        
        $curlParams=[
            'url' => $url,
            'social_post_api_token' => $social_post_api_token
        ];
        $response = $this->curlGet($curlParams);
        $response = json_decode($response);

        if($response!=NULL){
            if($response->status==200 && $response->user->instagram_username){
                $task_value = "https://www.instagram.com/".$response->user->instagram_username;
                $instagram_user_id = $response->user->instagram_user_id ?? NULL;

                $userSocialConnection = UserSocialConnection::where('user_id', Auth::id())->first();
                if($userSocialConnection==NULL){
                    $userSocialConnection = new UserSocialConnection;
                }
                $userSocialConnection->instagram_user_id = $instagram_user_id;
                $userSocialConnection->save();

                $instantTask = InstantTask::where('user_id', Auth::id())->where('task_id', 4)->where('task_value', "!=", $task_value)->whereNull('deleted_at')->pluck('id')->toArray();
                InstantTask::whereIn("id", $instantTask)->update(['deleted_at' => Carbon::now()]);

                $instantTaskInfo = InstantTask::where('user_id', Auth::id())->where('task_id', 4)->where('task_value', $task_value)->whereNull('deleted_at')->first();
                
                if($instantTaskInfo==NULL){
                    $newInstantTasks = new InstantTask;
                    $newInstantTasks->user_id = Auth::id();
                    $newInstantTasks->task_id = 4;
                    $newInstantTasks->task_value = $task_value;
                    $newInstantTasks->save();
                }
            }
        }
        return true;
    }

    public function postToInstagram($social_type, $offer_id)
    {
        $option=Option::where('key','social_post_url')->first();        
        $offer = Offer::find($offer_id);

        $res = [];
        $res['social_type'] = $social_type;
        $res['offer_id'] = encrypt($offer_id);

        if($offer->type=="custom" && $offer->website_url != ''){
            $res['error'] = "Url will not post on Instagram";
            $res['status'] = 500;
        }
        else{

            $userDetail = User::find($offer->user_id);
            if($userDetail->social_post_api_token==NULL){
                $this->createSocialPostAuth($userDetail->id);
                $userDetail = User::find(Auth::id());
            }
            
            $social_post_api_token = $userDetail->social_post_api_token;
            $url=$option->value."/api/instagram/postToInstagram";

            $postfields=[];
            $postfields['post_id'] = $offer->social_post__db_id;
            $curlParams=[
                'url' => $url,
                'social_post_api_token' => @$social_post_api_token,
                'postfields' => @$postfields,
            ];
            $response = $this->curlPost($curlParams);
            $response = json_decode($response,true);
            
            if($response==NULL){
                $res['error'] = "Something went wring!, Unable to Post offer to your social account";
                $res['status'] = 500;
            }
            else if($response['status']==200){
                $urlPostDetail = $option->value."/api/instagram/getInstaPostDetails";
                $curlParams=[
                    'url' => $urlPostDetail,
                    'social_post_api_token' => @$social_post_api_token,
                    'postfields' => @$postfields,
                ];

                $responsePostDetail = $this->curlPost($curlParams);
                $responsePostDetail = json_decode($responsePostDetail,true);
                if($responsePostDetail!=NULL){
                    if($responsePostDetail['status']==200){
                        $permalink = $responsePostDetail['data']['permalink'];
                        $res['msg'] = $response['msg'];
                        $res['status'] = $response['status'];
                        $res['post_short_url'] = $permalink;
                    }
                }
                else{
                    $res['error'] = "Something went wring!, Unable to Post offer to your social account";
                    $res['status'] = 500;
                }       
            }
            else{
                $res['error'] = $response['msg'];
                $res['status'] = $response['status'];
            }
        }
        return $res;
    }

    // LinkedIn
    public function connectWithLinkedIn($request)
    {
        $option=Option::where('key','social_post_url')->first();
        $url=$option->value."/api/linkedin/connect?callback_url=".URL::to('business/settings?linkedin="true"');

        $userDetail = User::find(Auth::id());
        
        if($userDetail->social_post_api_token==NULL){
            $this->createSocialPostAuth($userDetail->id);
            $userDetail = User::find(Auth::id());
        }
        $social_post_api_token = $userDetail->social_post_api_token;

        $curlParams=[
            'url' => $url,
            'social_post_api_token' => $social_post_api_token
        ];

        $response = $this->curlGet($curlParams);
        return $response;
    }

    public function saveLinkedinPage(Request $request)
    {
        $userSocialConnection = UserSocialConnection::where('user_id', Auth::id())->first();
        if($userSocialConnection==NULL){
            $userSocialConnection = new UserSocialConnection;
        }
        $userSocialConnection->linkedin_page_id = $request->linkedin_page_id ?? null;
        
        if($userSocialConnection->save()){
            // update in managemedia server
            $option=Option::where('key','social_post_url')->first();        
            
            $userDetail = User::find(Auth::id());
            if($userDetail->social_post_api_token==NULL){
                $this->createSocialPostAuth($userDetail->id);
                $userDetail = User::find(Auth::id());
            }
            
            $social_post_api_token = $userDetail->social_post_api_token;
            $url=$option->value."/api/linkedin/updatePageId";

            $postfields=[];
            $postfields['page_id'] = $request['linkedin_page_id'];

            $curlParams=[
                'url' => $url,
                'social_post_api_token' => @$social_post_api_token,
                'postfields' => @$postfields,
            ];
            
            $response = $this->curlPost($curlParams);
            $response = json_decode($response, true);

            $res['status']=200;
            $res['message']="Page updated successfully";

            /* Update Social Channels for Sales Person */
            dispatch(new UpdateSocialConnectionSalesPerson());
        }
        else{
            $res['message'] = "Something went wring!, unable to find LinkedIn page";
            $res['status'] = 500;
        }
        return $res;
    }

    public function postToLinkedin($social_type, $offer_id)
    {
        $option=Option::where('key','social_post_url')->first();        
        $offer = Offer::find($offer_id);

        $res=[];
        $res['social_type'] = $social_type;
        $res['offer_id'] = encrypt($offer_id);

        $userDetail = User::find($offer->user_id);
        $userSocialConnection = UserSocialConnection::where('user_id', $offer->user_id)->first();

        if($userDetail->social_post_api_token==NULL){
            $this->createSocialPostAuth($userDetail->id);
            $userDetail = User::find(Auth::id());
        }

        $social_post_api_token = $userDetail->social_post_api_token;
        $url=$option->value."/api/linkedin/post";

        $postfields=[];
        $postfields['post_id'] = $offer->social_post__db_id;
        $postfields['page_id'] = $userSocialConnection->linkedin_page_id ?? NULL;

        $curlParams=[
            'url' => $url,
            'social_post_api_token' => @$social_post_api_token,
            'postfields' => @$postfields,
        ];
        // dd($curlParams);
        $response = $this->curlPost($curlParams);
        // dd($response);
        $response = json_decode($response,true);
        
        if($response==NULL){
            $res['error'] = "Something went wrong!, Unable to Post offer to your social account";
            $res['status'] = 500;
        }
        else if($response['status']==200){
            $res['post_short_url'] = $response['post_url'];
            $res['status'] = $response['status'];
        }
        else{
            $res['is_duplicate'] = $response['is_duplicate'] ?? 0;
            $res['error'] = $response['msg'];
            $res['status'] = $response['status'];
        }
        // dd($res);
        return $res;
    }

    // Youtube
    public function connectWithYoutube($request)
    {
        $option=Option::where('key','social_post_url')->first();
        $url=$option->value."/api/youtube/auth?callback_url=".URL::to('business/settings?youtube="true"');

        $userDetail = User::find(Auth::id());
        
        if($userDetail->social_post_api_token==NULL){
            $this->createSocialPostAuth($userDetail->id);
            $userDetail = User::find(Auth::id());
        }
        $social_post_api_token = $userDetail->social_post_api_token;

        $curlParams=[
            'url' => $url,
            'social_post_api_token' => $social_post_api_token
        ];

        $response = $this->curlGet($curlParams);
        // dd($response);
        return $response;
    }

    public function connectWithGoogleReview($request)
    {
        if($request->socialAccount=='google'){

            $findGoogleMap = 'https://www.google.com/maps/';
            $find_google_map = strpos($request->review_maplink, $findGoogleMap);
            if ($find_google_map != 0 || $find_google_map === false) {
                $findGoogleMap = 'https://www.google.co.in/maps/';
                $find_google_map = strpos($request->review_maplink, $findGoogleMap);
            }
            if (($request->review_maplink != '') && ($find_google_map != 0 || $find_google_map === false)) {
                return response()->json(['status' => false, 'message' => 'Please enter valid google map link']);
            }

            $userSocialConnection = UserSocialConnection::where('user_id', Auth::id())->first();
            if($userSocialConnection==NULL){
                $userSocialConnection = new UserSocialConnection;
            }
            $userSocialConnection->user_id = Auth::id();
            $userSocialConnection->is_google_auth = 1;
            if($userSocialConnection->save()){
                $task_id = 13;
                $task_value = $request->review_placeid;

                $instanceTask = InstantTask::whereUserId(Auth::id())->whereNull('deleted_at')->whereTaskId($task_id)->where('task_value', $task_value)->orderBy('id', 'DESC')->pluck('id')->toArray();
                if($instanceTask == null){
                    $deleteInstanceTask = InstantTask::whereUserId(Auth::id())->whereNull('deleted_at')->whereTaskId($task_id)->where('task_value', '!=', $task_value)->orderBy('id', 'DESC')->pluck('id')->toArray();

                    foreach ($deleteInstanceTask as $ITaskKey => $Itask) {
                        $iTask = InstantTask::find($Itask);
                        $iTask->deleted_at = Carbon::now();
                        $iTask->save();
                    }

                    $new_instanceTask = new InstantTask;
                    $new_instanceTask->user_id = Auth::id();
                    $new_instanceTask->task_id = $task_id;
                    $new_instanceTask->task_value = $task_value;
                    $new_instanceTask->one_extra_field_value = $request->review_maplink;
                    $new_instanceTask->user_id = Auth::id();
                    $new_instanceTask->save();
                }
                // Google Review Place Id update in business details social links
                if($task_id==13){
                    $businessDetail = BusinessDetail::where('user_id', Auth::id())->first();
                    if($businessDetail!=NULL){
                        $businessDetail->google_review_placeid = $task_value;
                        $businessDetail->save();
                    }
                }

                $json = [
                    'status' => true,
                    'message' => "Successfully connect with Google review"
                ];
            }
            else{
                $json = [
                    'status' => false,
                    'message' => "Unable to get response from Google"
                ];
            }
        }
        else{
            $json = [
                'status' => false,
                'message' => "Unable to get response from Google"
            ];
        }
        return $json;
    }
    




    // POST Offer if Not Created
    public function setOfferAndPost($offer)
    {
        $url = $img_url = "";

        if($offer->type=='standard'){
            $offerTemplate = OfferTemplate::where('offer_id', $offer->id)->first();
            // $img_url = 'assets/offer-thumbnails/'.$offerTemplate->thumbnail;
            $img_url = app('App\Http\Controllers\Business\OfferController')->reduceImage1080("standard", $offerTemplate->thumbnail);
            $img_url = "assets/templates/resize-file/".$img_url;
        }
        else{
            if($offer->website_url != ''){
                $img_url = "";
                $url = $offer->website_url;
            }else{
                // $img_url = 'assets/templates/custom/'.$offer->image;
                $img_url = app('App\Http\Controllers\Business\OfferController')->reduceImage1080("custom", $offer->image);
                $img_url = "assets/templates/resize-file/".$img_url;
            }
        }

        // GET Social Platforms
        $socialPlatform = SocialPost::with('social_platforms')->where('offer_id', $offer->id)->first();

        $facebook_url = "";
        $twitter_url = "";
        $linkedin_url = "";

        foreach ($socialPlatform->social_platforms as $platformKey => $platform) {
            if($offer->website_url == ''){
                if($platform->platform_key == "facebook"){
                    $facebook_url = URL::to('/f').'/'.$offer->uuid.'?media='.$platform->value;
                }
                else if($platform->platform_key == "twitter"){
                    $twitter_url = URL::to('/f').'/'.$offer->uuid.'?media='.$platform->value;
                }
                else if($platform->platform_key == "linkedin"){
                    $linkedin_url = URL::to('/f').'/'.$offer->uuid.'?media='.$platform->value;
                }
            }
            else{
                if($platform->platform_key == "facebook"){
                    $facebook_url = $offer->website_url.'?media='.$platform->value;
                }
                else if($platform->platform_key == "twitter"){
                    $twitter_url = $offer->website_url.'?media='.$platform->value;
                }
                else if($platform->platform_key == "linkedin"){
                    $linkedin_url = $offer->website_url.'?media='.$platform->value;
                }
            }
        }


        if($offer->social_post__db_id==NULL){
            // New Create Post
            $postParams = [
                'offer_id' => $offer->id,
                'name' => $offer->title,
                'message' => $offer->description,
                'url' => $url,
                'single_image' => $img_url,
                'user_id' => $offer->user_id,
                'start_date' => $offer->start_date,
                'end_date' => $offer->end_date,
                'facebook_url' => $facebook_url,
                'twitter_url' => $twitter_url,
                'linkedin_url' => $linkedin_url,
            ];
            $this->createOfferDesignPostUsingCron($postParams);
            // echo "\n create <pre>"; print_r($postParams);
        }
        else{
            // Update Post
            $postParams = [
                'offer_id' => $offer->id,
                'name' => $offer->title,
                'message' => $offer->description,
                'single_image' => $img_url,
                'url' => $url,
                'post_id' => $offer->social_post__db_id,
                'user_id' => $offer->user_id,
                'start_date' => $offer->start_date,
                'end_date' => $offer->end_date,
                'facebook_url' => $facebook_url,
                'twitter_url' => $twitter_url,
                'linkedin_url' => $linkedin_url,
            ];
            $this->updateOfferDesignPostUsingCron($postParams);
            // echo "\n update <pre>"; print_r($postParams);
        }
    }

    // Post To Instant Task
    public function addSocialPostTask(Request $request)
    {
        $task_value = $request->task_value;
        $task_key = decrypt($request->task_key);
        $offer_id = decrypt($request->offer_id);

        $instant_tasks = new InstantTask;

        $tasks = [];
        if($task_key == "facebook"){
            // $instant_tasks->task_key = "fb_post_url";
            $tasks = [2, 3, 15];
        }
        else if($task_key == "twitter"){
            // $instant_tasks->task_key = "tw_tweet_like";
            $tasks = [7];
        }
        else if($task_key == "linkedin"){
            // $instant_tasks->task_key = "li_post_url";
            $tasks = [9];
        }
        else if($task_key == "instagram"){
            // $instant_tasks->task_key = "li_post_url";
            $tasks = [5, 16];
        }
        
        $inTasks=[];
        foreach ($tasks as $key => $task){
            $taskInfo = Task::find($task);
            // if($taskInfo->coming_soon==0){
                $instanceTask = InstantTask::whereUserId(Auth::id())->whereNull('deleted_at')->whereTaskId($task)->orderBy('id', 'DESC')->pluck('id')->toArray();
                if($instanceTask != null){
                    foreach ($instanceTask as $ITaskKey => $Itask) {
                        $iTask = InstantTask::find($Itask);
                        $iTask->deleted_at = Carbon::now();
                        $iTask->save();
                    }
                }

                $newInstantTasks['user_id'] = Auth::id();
                $newInstantTasks['offer_id'] = $offer_id;
                $newInstantTasks['task_value'] = $request->task_value;
                $newInstantTasks['task_id'] = $task;
                $inTasks[]=$newInstantTasks;
            // }
        }

        // echo "<pre>"; print_r($inTasks);
        // echo "<pre>"; print_r($offer_id);
        // return response()->json([
        //     "status" => true,
        //     "message" => "Task updated successfully" 
        // ]);

        if(InstantTask::insert($inTasks)){
            return response()->json([
                "status" => true,
                "message" => "Offer Posted Successfully" 
            ]);
        }
        else{
            return response()->json([
                "status" => false,
                "message" => "Unable to post offer" 
            ]);
        }
    }
    
}
