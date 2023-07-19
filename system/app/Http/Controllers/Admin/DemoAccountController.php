<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Userplan;
use App\Models\Role;
use App\Models\Option;

use Spatie\Analytics;
use Spatie\Analytics\Period;

use Carbon\Carbon;

class DemoAccountController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('is_sales_person', 1)->orWhere('is_demo', 1)->latest()->paginate(10);
        return view('admin.demo-account.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.demo-account.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validation Data
        $request->validate([
            'name' => 'required|min:2|max:50',
            'email' => 'required|max:100|email|unique:users',
            'mobile' => 'required|unique:users|regex:/[0-9]/|not_regex:/[a-z]/|min:10|max:10',
            'password' => 'required|min:6|confirmed'
        ]);

        $data = $request->all();

        // $access_token = $this->createSocialAccount($data);
        $access_token=NULL;
        $data['access_token'] = $access_token;

        $user = dispatch(new \App\Jobs\CreateDemoAccount($data));

        return response()->json(['status' => true, 'message' => 'Demo account created successfully !']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::with('role')->find($id);
        return view('admin.demo-account.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Create New User
        $user = User::find($id);

        // Validation Data
        $request->validate([
            'name' => 'required|min:2|max:50',
            'email' => 'required|max:100|email|unique:users,email,' . $id,
            'mobile' => 'required|regex:/[0-9]/|not_regex:/[a-z]/|min:10|max:10|unique:users,mobile,' . $id,
            'password' => 'nullable|min:6|confirmed',
        ]);


        $user->name = $request->name;
        $user->email = $request->email;
        $user->status = $request->status;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return response()->json(['status' => true, 'message' => 'Demo account has been updated !']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
            
        if ($request->status == 'delete') {
            if ($request->ids) {
                foreach ($request->ids as $id) {
                    User::destroy($id);
                }
            }
        }
            
        return response()->json(['Success']);
    }

    public function status(Request $request)
    {
        
        if ($request->ids) {
            foreach ($request->ids as $id) {
                $post = User::find($id);
                $post->status = $request->status;
                $post->save();
            }
        }
            
        return response()->json(['Success']);
    }

    public function resendEmail(Request $request)
    {

        $date = \Carbon\Carbon::now()->format('Ymd');
        $m=180;                
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomCode = '';      
        for ($i = 0; $i < $m; $i++) { 
            $index = rand(0, strlen($characters) - 1); 
            $randomCode .= $characters[$index]; 
        }

        $user = User::where('id', $request->user_id)->first();
        $user->pass_token = $randomCode.$date;
        $user->save();

        $data = [
            'name' => $user->name,
            'mobile' => $user->mobile,
            'email' => $user->email,
            'password' => $user->password,
            'token' => $user->pass_token
        ];

        \App\Http\Controllers\CommonMailController::SalesPersonByAdminMail($data);
            
        return response()->json(['Credentials Email Sent!']);
    }

    public function createSocialAccount($data = array()){

        //API call to get whatsapp access token                       
        $postData = array(
            'fullname' => $data['name'],
            'email' => 'ol_'.rand(100000, 999999).$data['email'],
            'password' => $data['password'],
            'confirm_password' => $data['password'],
        );

        //API URL
        $wa_url = Option::where('key','oddek_url')->first();
        $url = $wa_url->value."/api/signup.php";

        //init the resource
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $postData
            //,CURLOPT_FOLLOWLOCATION => true
        ));

        //Ignore SSL certificate verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        //Get response
        $response = curl_exec($ch);
        $output = json_decode($response);
        curl_close($ch);

        if($output != null){
            if ($output->status == 'error') {
                $access_token = '';
            } else {
                $access_token = $output->token;
            }
        }else{
            $access_token = '';
        }

        return $access_token;
    }
}
