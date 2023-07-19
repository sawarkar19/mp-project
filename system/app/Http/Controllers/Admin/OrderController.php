<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

use App\Models\Userplan;
use App\Models\User;
use App\Models\Plan;
use App\Models\Transaction;
use App\Models\Useroption;


use App\Mail\SubscriptionMail;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{

    protected $user_email;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $type=$request->status ?? 'all';
        if ($request->status=='cancelled') {
           $type=0;
        }

        if (!empty($request->src)) {
            $this->user_src=$request->src;
            $this->search_term=$request->term;

            if ($type==='all') {
                $posts=Userplan::whereHas('user',function($q){
                    return $q->where($this->search_term, 'like', '%'.$this->user_src.'%');
                })->with('user','plan_info','payment_method')->where('amount', '<>', 0)->latest()->paginate(40);
            }
            else{
                $posts=Userplan::whereHas('user',function($q){
                    return $q->where($this->search_term, 'like', '%'.$this->user_src.'%');
                })->with('user','plan_info','payment_method')->where('amount', '<>', 0)->where('status',$type)->latest()->paginate(40);
            }
        }
        else{
            if ($type==='all') {
                $posts=Userplan::with('user','plan_info','payment_method')->where('amount', '<>', 0)->latest()->paginate(40);
            }
            else{
                $posts=Userplan::with('user','plan_info','payment_method')->where('amount', '<>', 0)->where('status',$type)->latest()->paginate(40);
            }  
        }

        return view('admin.order.index',compact('type','posts','request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $payment_gateway=\App\Models\Category::where('type','payment_gateway')->get();
        $posts=Plan::where('status',1)->get();
        //dd($posts);
        $email=$request->email ?? '';
        return view('admin.order.create',compact('posts','email','payment_gateway'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email|max:255',
            'payment_method' => 'required',
            'transition_id' => 'required',
            'plan' => 'required',
            'notification_status' => 'required',
            'order_status' => 'required',
        ]);

        if ($request->notification_status == 'yes' && $request->content==null) {
             $msg['errors']['email_comment']='Email Comment Is Required';
             return response()->json($msg,401);
        }
        $user=User::where('email',$request->email)->where('role_id',3)->first();
        if (empty($user)) {
            $msg['errors']['user']='User Not Found';
            return response()->json($msg,401);
        }


        $order_prefix=\App\Option::where('key','order_prefix')->first();

        $trasection=new Trasection;
        $trasection->user_id=$user->id;
        $trasection->category_id = $request->payment_method;  
        $trasection->status=$request->payment_status;  
        $trasection->trasection_id=$request->transition_id;  
        $trasection->save();

        $price=Plan::find($request->plan);
        $exp_days =  $price->days;
        $expiry_date = \Carbon\Carbon::now()->addDays(($exp_days - 1))->format('Y-m-d');


        $max_id=Userplan::max('id');
        $max_id= $max_id + 1;

        $plan=new Userplan;
        $plan->order_no=$order_prefix->value.$max_id;
        $plan->amount=$price->price;
        $plan->user_id=$user->id;
        $plan->plan_id =$request->plan;
        $plan->trasection_id=$trasection->id;
        $plan->will_expire_on=$expiry_date;
        $plan->status=$request->order_status;
        $plan->payment_status=$request->payment_status;
        $plan->save();

        if ($request->notification_status == 'yes'){
            $data['info']=Userplan::with('plan_info','payment_method','user')->find($plan->id);
            $data['comment']=$request->content;
            $data['to_vendor']='vendor';
            if(env('QUEUE_MAIL') == 'on'){
             dispatch(new \App\Jobs\SendInvoiceEmail($data));
            }
            else{
             Mail::to($user->email)->send(new SubscriptionMail($data));
            }
        }

        return response()->json(['Order Created Successfully']);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $info=Userplan::with('plan_info','payment_method','user')->findorFail($id);
        return view('admin.order.show',compact('info'));
    }

    /**
     * print invoice the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function invoice($id)
    {
        $info=Userplan::with('plan_info','payment_method','user')->findorFail($id);
        $plan=Plan::where('id',$info->plan_id)->first();		

        $gst_code_cust=Useroption::where('key','gst_code')->where('user_id',$info->user->id)->first();
        $hsn_code_cust=Useroption::where('key','hsn_code')->where('user_id',$info->user->id)->first();

        $company_info=\App\Models\Option::where('key','company_info')->first();
        $company_info=json_decode($company_info->value);

        $gst_code=\App\Models\Option::where('key','gst_code')->first();
        $hsn_code=\App\Models\Option::where('key','hsn_code')->first();

        $state=Useroption::where('key','state')->where('user_id',$info->user->id)->first();	

        $pdf = \PDF::loadView('emails.subscription_invoicepdf',compact('company_info','info','gst_code','hsn_code','gst_code_cust','hsn_code_cust','state','plan'));
        
        return $pdf->download('invoice.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $info= Userplan::with('plan_info','payment_method')->find($id);
        $payment_gateway=\App\Models\Category::where('type','payment_gateway')->get();
        $posts=Plan::get();

        return view('admin.order.edit',compact('posts','info','payment_gateway'));
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
        if ($request->notification_status == 'yes' && $request->content==null) {
            $msg['errors']['email_comment']='Email Comment Is Required';
            return response()->json($msg,401);
        }

        $plan=Userplan::findorFail($id);
        $plan->plan_id =$request->plan;
        $plan->status=$request->order_status;
        $plan->save();

        if (!empty($plan->transaction_id)) {
            $trasection= Transaction::findorFail($plan->transaction_id);
            $trasection->transaction_id=$request->transaction_id;
            $trasection->category_id =$request->trasection_method;
            $trasection->status=$request->payment_status;
            $trasection->save(); 
        }
        $user=User::find($plan->user_id);
        if($request->order_status == 1){
          $price=Plan::find($plan->plan_id);
        }


        if ($request->notification_status == 'yes'){
            $data['info']=Userplan::with('plan_info','payment_method','user')->find($plan->id);
            $data['comment']=$request->content;
            $data['to_vendor']='vendor';
            if(env('QUEUE_MAIL') == 'on'){
             dispatch(new \App\Jobs\SendInvoiceEmail($data));
            }
            else{
             Mail::to($user->email)->send(new SubscriptionMail($data));
            }
        }

        return response()->json(['Order Updated']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if ($request->ids && !empty($request->method)) {
            if ($request->method=='delete') {
                foreach ($request->ids as $key => $id) {
                    $order=Userplan::find($id);
                    if (!empty($order->trasection_id)) {
                        Trasection::destroy($order->trasection_id);
                    }
                    $order->delete();
                }
            }
            else{
                if ($request->method=='cancelled') {
                    $status=0;
                }
                else{
                     $status=$request->method;
                }
                foreach ($request->ids as $key => $id) {
                    $order=Userplan::find($id);
                    $order->status=$status;
                    $order->save();
                }
            }
        }

        return response()->json(['Success']);
    }
}
