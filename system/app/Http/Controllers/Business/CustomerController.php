<?php

namespace App\Http\Controllers\Business;

use DB;

use URL;
use Auth;
use Carbon\Carbon;

use App\Models\User;
use App\Models\Offer;
use App\Models\Redeem;
use App\Models\Target;
use App\Models\Customer;
use App\Models\Userplan;
use App\Models\AssignTask;
use App\Models\OfferFuture;
use App\Models\ContactGroup;
use Illuminate\Http\Request;
use App\Models\GroupCustomer;
use App\Models\BusinessCustomer;

use App\Models\OfferSubscription;
use App\Http\Controllers\Controller;

use Rap2hpoutre\FastExcel\FastExcel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Redirect;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Http\Controllers\WhatsAppApiController;
use App\Http\Controllers\Business\CommonSettingController;
use Yajra\DataTables\Facades\DataTables;
use App\Helper\Deductions\DeductionHelper;
use App\Exports\ContactExport;
use Maatwebsite\Excel\Facades\Excel;

class CustomerController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('business');
    }

    public function groups(Request $request)
    {
        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();
        $userBalance = DeductionHelper::getUserWalletBalance(Auth::id());
        return view('business.customer.groups', compact('notification_list', 'planData', 'userBalance'));
    }

    public function getContactGroups(Request $request)
    {
        if ($request->ajax()) {
            $planData = CommonSettingController::getBusinessPlanDetails();
            $groups = ContactGroup::withCount('customers')
                ->where('user_id', Auth::id())
                ->get();

        
            return Datatables::of($groups)
            ->addIndexColumn()
            ->addColumn('name', function ($q) {
                return $q->name;
            })
            ->addColumn('total customers', function ($q) {
                return '<span class="badge badge-success">'.$q->customers_count.'</span>';
            })
            ->addColumn('default group', function ($q) {
                $is_default = '<span class="badge badge-success">YES</span>';
                if($q->is_default != 1){
                    $is_default = '<span class="badge badge-danger">NO</span>';
                }
                return $is_default;
            })
            ->addColumn('action', function ($q) use($planData) {
                $action = '<a class="btn btn-warning" href="'.route('business.viewGroup',$q->id).'">'.__('View').'</a>';
                if($planData['userData']->current_account_status == 'paid'){
                    if($q->is_default != 1){
                        $action .= '&nbsp;<a class="btn btn-info mr-1" href="'.route('business.editGroup',$q->id).'">'. __('Edit').'</a>';
                    }
                }
                return $action;
            })
            ->escapeColumns([])
            ->make(true);
        }
    }

    public function viewGroup(Request $request, $id)
    {
        $group = ContactGroup::findorFail($id);

        //notification_list
        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();
        $userBalance = DeductionHelper::getUserWalletBalance(Auth::id());

        return view('business.customer.index', compact('group', 'notification_list', 'planData','userBalance','id'));
    }

    public function getGroupsList(Request $request)
    {
        if ($request->ajax()) {
            $customer_ids = BusinessCustomer::where('user_id', Auth::id())
                ->pluck('customer_id')
                ->toArray();

            $customers = Customer::with('info')
                ->withCount('subscription')
                ->whereIn('customers.id', $customer_ids)
                ->leftjoin('business_customers', 'customers.id', '=', 'business_customers.customer_id')
                ->where('business_customers.user_id', Auth::id())
                ->leftjoin('group_customers', 'customers.id', '=', 'group_customers.customer_id')
                ->where('group_customers.contact_group_id', $request->id)
                ->orderBy('business_customers.id', 'desc')
                ->groupBy('id')
                ->get();

            return Datatables::of($customers)
            ->addIndexColumn()
            ->addColumn('whatsapp mobile', function ($q) {
                return $q->mobile;
            })
            ->addColumn('name', function ($q) {
                return $q->info->name;
            })
            ->addColumn('date of birth', function ($q) {
                $dob = '-';
                if($q->info->dob != ''){
                    $dob = \Carbon\Carbon::parse($q->info->dob)->format('j M');
                }
                return $dob;
            })
            ->addColumn('anniversary date', function ($q) {
                $anniversary_date = '-';
                if($q->info->anniversary_date != ''){
                    $anniversary_date = \Carbon\Carbon::parse($q->info->anniversary_date)->format('j M');
                }
                return $anniversary_date;
            })
            ->addColumn('total subscription', function ($q) {
                return '<span class="badge badge-success">'.$q->subscription_count.'</span>';
            })
            ->addColumn('action', function ($q) use($request) {
                return '<a class="btn btn-info" href="'.route('business.customer.edit',['id' => $q->id, 'group_id' => $request->id]).'">'. __('Edit').'</a>';
            })
            ->escapeColumns([])
            ->make(true);
        }
    }

    public function editGroup($id)
    {
        $group = ContactGroup::findorFail($id);

        //notification_list
        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();

        return view('business.customer.edit-group', compact('group', 'notification_list', 'planData'));
    }

    public function updateGroup(Request $request, $id)
    {
        // dd('Hi');
        $request->validate([
            'name' => 'required|max:50',
        ]);

        $group = ContactGroup::findorFail($id);
        $group->name = $request->name;
        $group->save();

        $redirect_url = route('business.contactGroups');

        return response()->json(["status" => true, "message" => "Group updated successfully!", 'redirect_url' => $redirect_url]);
    }

    public function create(Request $request)
    {
        //notification_list
        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();

        /*Plan Details*/
        $rest_plan_id = ['0' => 1, '1' => 2, '2' => 3, '3' => 4, '4' => 5, '5' => 6, '6' => 7, '7' => 8];

        return view('business.customer.create', compact('notification_list', 'planData', 'rest_plan_id'));
    }

    public function store(Request $request)
    {
        $data = Auth::user();

        $request->validate([
            'name' => 'nullable|max:20',
            'mobile' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
        ]);

        // check number is valid or not
        /*$wpa_num = '+91'.$request->mobile;
        $res = WhatsAppApiController::CheckValidNumber($wpa_num);
        $jsonRes = json_decode($res);
        if($jsonRes->contacts[0]->status == 'invalid'){
            return response()->json(["success" => false, "message" => "WhatsApp number is invalid."]);
        }*/

        $checkWithBusiness = Customer::with('businesses')
            ->leftjoin('business_customers', 'customers.id', '=', 'business_customers.customer_id')
            ->where('customers.mobile', $request->mobile)
            ->where('business_customers.user_id', Auth::id())
            ->orderBy('customers.id', 'desc')
            ->first();

        if ($checkWithBusiness != null) {
            $error['errors']['error'] = 'Mobile Number already exists';
            return response()->json($error, 401);
        }

        $user = Customer::where('mobile', $request->mobile)
            ->orderBy('id', 'desc')
            ->first();
        if ($user == null) {
            $user = new Customer();
            $user->mobile = $request->mobile;
            $user->user_id = $data->id;
            $user->created_by = $data->id;
            $user->save();

            $user->uuid = $user->id . 'CUST' . date('Ymd');
            $user->save();

            $business_customer = new BusinessCustomer();
            $business_customer->customer_id = $user->id;
            $business_customer->user_id = $data->id;
            $business_customer->name = $request->name;
            $business_customer->dob = $request->dob;
            $business_customer->anniversary_date = $request->anniversary_date;
            $business_customer->save();
        } else {
            $business_customer = new BusinessCustomer();
            $business_customer->customer_id = $user->id;
            $business_customer->user_id = $data->id;
            $business_customer->name = $request->name;
            $business_customer->dob = $request->dob;
            $business_customer->anniversary_date = $request->anniversary_date;
            $business_customer->save();
            
        }

        return response()->json(['success' => true, 'message' => 'Customer Created Successfully']);
    }

    public function show($id)
    {
        $info = Customer::withCount('offers', 'offers_active', 'offers_complete', 'offers_incomplete')->findorFail($id);

        $subscription = OfferSubscription::where('customer_id', $id)
            ->orderBy('id', 'desc')
            ->first();

        $is_redeemed = 0;
        if ($subscription != null) {
            $redeemed = Redeem::where('offer_subscribe_id', $subscription->id)
                ->select(['is_redeemed'])
                ->orderBy('id', 'desc')
                ->first();
            if ($redeemed != null) {
                $is_redeemed = $redeemed->is_redeemed;
            }
        }

        $offers = OfferSubscription::with('offer')
            ->where('user_id', Auth::id())
            ->where('customer_id', $id)
            //->withCount('targets')
            ->latest()
            ->paginate(10);

        foreach ($offers as $k_offer => $v_offer) {
            if ($v_offer->offer->type == 'future') {
                $offers[$k_offer]['completed'] = $this->shareCount($v_offer->id, $v_offer->offer->id);
            } else {
                $offers[$k_offer]['completed'] = $this->shareTaskCount($v_offer->id);
            }
        }
        //dd($offers);

        //notification_list
        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();

        return view('business.customer.show', compact('info', 'subscription', 'offers', 'is_redeemed', 'notification_list', 'planData'));
    }

    public function shareCount($subsc_id, $offer_id)
    {
        $subscription = OfferSubscription::where('id', $subsc_id)
            ->orderBy('id', 'desc')
            ->first();
        if ($subscription->parent_id != '') {
            $count = Target::whereIn('offer_subscribe_id', [$subscription->id, $subscription->parent_id])
                ->where('repeated', 0)
                ->count();
        } else {
            $count = Target::where('offer_subscribe_id', $subsc_id)
                ->where('repeated', 0)
                ->count();
        }

        return $count;
    }

    public function shareTaskCount($subsc_id)
    {
        $count = AssignTask::where('offer_subscribed_id', $subsc_id)
            ->where('is_completed', '1')
            ->count();
        return $count;
    }

    public function edit($id)
    {
        $info = Customer::with('details')->findorFail($id);

        //notification_list
        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();

        return view('business.customer.edit', compact('info', 'notification_list', 'planData'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'nullable|max:20',
            // 'mobile' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
        ]);

        $user = Customer::findorFail($id);

        $business_customer = BusinessCustomer::where('customer_id', $user->id)
            ->where('user_id', Auth::id())
            ->first();

        if ($business_customer != null) {
            $business_customer = BusinessCustomer::findorFail($business_customer->id);
            $business_customer->name = $request->name;
            $business_customer->dob = $request->dob;
            $business_customer->anniversary_date = $request->anniversary;
            $business_customer->save();
        } else {
            $business_customer = new BusinessCustomer();
            $business_customer->customer_id = $user->id;
            $business_customer->user_id = Auth::id();
            $business_customer->name = $request->name;
            $business_customer->dob = $request->dob;
            $business_customer->anniversary_date = $request->anniversary;
            $business_customer->save();
        }

        return response()->json(['success' => true, 'message' => 'Customer Updated Successfully']);
    }

    public function customerDelete($id)
    {
        $delete = Customer::where('id', $id)->delete();
        if ($delete == 1) {
            $success = true;
            $message = 'User deleted successfully';
        } else {
            $success = true;
            $message = 'User not found';
        }
        //  Return response
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }

    public function customerDeleteBulk(Request $request)
    {
        if ($request->action == 'delete') {
            $customer_ids = BusinessCustomer::where('user_id', Auth::id())
                ->pluck('customer_id')
                ->toArray();
            $customers = Customer::with('details')
                ->withCount('subscription')
                ->whereIn('customers.id', $customer_ids)
                ->leftjoin('business_customers', 'customers.id', '=', 'business_customers.customer_id')
                ->where('business_customers.user_id', Auth::id())
                ->get();

            if (count($customers) > 0) {
                $deleteBusinessList = $deleteCustomerList = [];
                foreach ($customers as $cust) {
                    if ($cust->subscription_count == 0 && $cust->is_imported == '1') {
                        $deleteBusinessList[] = $cust->id;
                        $busiCustomers = BusinessCustomer::where('customer_id', $cust->id)
                            ->pluck('user_id')
                            ->toArray();
                        if (count($busiCustomers) == 1 && in_array(Auth::id(), $busiCustomers)) {
                            $deleteCustomerList[] = $cust->id;
                        }
                    }
                }

                if (count($deleteBusinessList) > 0 || count($deleteCustomerList) > 0) {
                    if (count($deleteBusinessList) > 0) {
                        BusinessCustomer::where('user_id', Auth::id())
                            ->whereIn('customer_id', $deleteBusinessList)
                            ->delete();
                    }

                    if (count($deleteCustomerList) > 0) {
                        Customer::whereIn('id', $deleteCustomerList)->delete();
                    }

                    return response()->json([
                        'success' => true,
                        'message' => 'Customers deleted successfully.',
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Customers not available to delete.',
                    ]);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Customers not available to delete.',
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.',
            ]);
        }
    }

    public function customerDestroy(Request $request, $id)
    {
        $auth_id = Auth::id();
        $delete = Customer::where('id', $id)->delete();
        if ($delete == 1) {
            $success = true;
            $message = 'User deleted successfully';
        } else {
            $success = true;
            $message = 'User not found';
        }
        //  Return response
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }

    public function destroy(Request $request, $id)
    {
        // if ($request->type=='delete') {
        //     $auth_id=Auth::id();
        //     // foreach ($request->ids as $key => $id) {
        //         $user=  Customer::findorFail($id);
        //         $user->delete();
        //     // }
        //     return response()->json(['Customer Deleted']);
        // }
    }

    public function destroys(Request $request)
    {
        if ($request->type == 'delete') {
            $auth_id = Auth::id();
            foreach ($request->ids as $key => $id) {
                $user = Customer::findorFail($id);
                $user->delete();
            }
            return response()->json(['Customer Deleted']);
        }
    }

    public function suspend(Request $request)
    {
        $auth_id = Auth::id();
        $user = Customer::findorFail($request->id);
        $user->status = 3;
        $user->save();
        return response()->json(['Customer suspended']);
    }

    public function custSuspended(Request $request)
    {
        // dd('hey');

        if ($request->src) {
            $posts = Customer::where($request->type, 'LIKE', '%' . $request->src . '%')
                ->where('status', '3')
                ->latest()
                ->paginate(20);
        } else {
            $posts = Customer::where('status', '3')
                ->latest()
                ->paginate(20);
        }

        $src = $request->src ?? '';

        //notification_list
        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();

        return view('business.customer.suspend', compact('posts', 'src', 'notification_list', 'planData'));
    }

    public function getSubscriptionData(Request $request)
    {
        $subscription = OfferSubscription::with('offer_details', 'targets', 'targets_parent', 'extra_targets', 'extra_targets_parent', 'completed_task', 'redeem_data')
            ->where('id', $request->sub_id)
            ->orderBy('id', 'desc')
            ->first();

        if ($subscription != null) {
            return response()->json(['success' => true, 'data' => $subscription, 'message' => 'Subscription found!']);
        } else {
            return response()->json(['success' => false, 'message' => 'Subscription not found!']);
        }
    }

    public function getCustomerData(Request $request)
    {
        $customer = Customer::where('mobile', $request->number)
            ->orderBy('id', 'desc')
            ->first();

        if ($customer != '') {
            $customerData = BusinessCustomer::where('user_id', Auth::id())
                ->where('customer_id', $customer->id)
                ->orderBy('id', 'desc')
                ->first();

            if ($customerData != '') {
                return response()->json(['status' => true, 'message' => 'Customer found.', 'data' => $customerData]);
            } else {
                return response()->json(['status' => false, 'message' => 'Customer details not found.']);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Customer not found.']);
        }
    }

    public function export(Request $request)
    {
        $customer_ids = BusinessCustomer::where('user_id', Auth::id())
        ->pluck('customer_id')
        ->toArray();
        $customers_data = Customer::whereIn('customers.id', $customer_ids)
            ->leftjoin('business_customers', 'customers.id', '=', 'business_customers.customer_id')
            ->where('business_customers.user_id', Auth::id())
            ->select('mobile', 'name', 'dob', 'anniversary_date')
            ->get();

        if (count($customers_data) > 0) {
            $filename = 'Customers' . '_' . date('Y_m_d_H_i_s') . '.xlsx';

            $address = 'assets/business/customer-imports/customers.xlsx';
            $spreadsheet = IOFactory::load($address);
        
            try {
                
                $cell_no = 2;
                foreach($customers_data as $k => $data){
                    $dob_day = $dob_month = $anni_day = $anni_month = '';
                    if($data->dob != ''){
                        $dob_arr = explode(' ', $data->dob);
                        $dob_day = $dob_arr[0];
                        $dob_month = $dob_arr[1];
                    }

                    if($data->anniversary_date != ''){
                        $anni_arr = explode(' ', $data->anniversary_date);
                        $anni_day = $anni_arr[0];
                        $anni_month = $anni_arr[1];
                    }
                    

                    $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(1, $cell_no, $data->mobile);
                    $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(2, $cell_no, $data->name);
                    $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(3, $cell_no, $dob_day);
                    $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(4, $cell_no, $dob_month);
                    $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(5, $cell_no, $anni_day);
                    $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(6, $cell_no, $anni_month);

                    $cell_no++;
                }

                $writer = new Xlsx($spreadsheet);
                $writer->save($filename);
                $content = file_get_contents($filename);
            } catch(Exception $e) {
                exit($e->getMessage());
            }

            header("Content-Disposition: attachment; filename=".$filename);

            unlink($filename);
            exit($content);
        }else{
            return Redirect::back()->with('error_msg', 'Contacts not found.');
        }
    }

    public function exportContacts(Request $request)
    {
        $customer_ids = BusinessCustomer::where('user_id', Auth::id())
        ->pluck('customer_id')
        ->toArray();
        $customers_data = Customer::whereIn('customers.id', $customer_ids)
            ->leftjoin('business_customers', 'customers.id', '=', 'business_customers.customer_id')
            ->where('business_customers.user_id', Auth::id())
            ->select('mobile', 'name', 'dob', 'anniversary_date')
            ->get();

        if (count($customers_data) > 0) {
        
            try {
                $data = [];
                $i = 1;
                foreach($customers_data as $k => $customer_data){
                    $dob_day = $dob_month = $anni_day = $anni_month = '';
                    if($customer_data->dob != ''){
                        $dob_arr = explode(' ', $customer_data->dob);
                        $dob_day = $dob_arr[0];
                        $dob_month = $dob_arr[1];
                    }

                    if($customer_data->anniversary_date != ''){
                        $anni_arr = explode(' ', $customer_data->anniversary_date);
                        $anni_day = $anni_arr[0];
                        $anni_month = $anni_arr[1];
                    }

                    $data[] =
                    [
                        'sr_no' => $i,
                        'mobile' => $customer_data->mobile,
                        'name' => $customer_data->name,
                        'dob_day' => $dob_day,
                        'dob_month' => $dob_month,
                        'anni_day' => $anni_day,
                        'anni_month' => $anni_month
                    ];

                    $i++;
                }

                return Excel::download(new ContactExport($data), 'Customers' . '_' . date('Y_m_d_H_i_s') . '.xlsx');
            } catch(Exception $e) {
                exit($e->getMessage());
            }
        }else{
            return Redirect::back()->with('error_msg', 'Contacts not found.');
        }
    }

    public function import(Request $request)
    {
        //old contact groups
        $groups = ContactGroup::where('user_id', Auth::id())
            ->where('is_default', 0)
            ->get();
        // dd($groups);

        //notification_list
        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();

        return view('business.customer.import-customers', compact('notification_list', 'planData', 'groups'));
    }

    public function importCustomer(Request $request)
    {
        $file = $request->file('customer_list');
        if ($file) {
            $original_name = $file->getClientOriginalName();
            $tmp_name = pathinfo($original_name, PATHINFO_FILENAME);

            $extension = $file->getClientOriginalExtension(); //Get extension of uploaded file

            $filename = $tmp_name . '_' . date('Y_m_d_H_i_s') . '.' . $extension;

            $tempPath = $file->getRealPath();
            $fileSize = $file->getSize(); //Get size of uploaded file in bytes

            //Check for file extension and size
            $fileCheck = $this->checkUploadedFile($extension, $fileSize);
            if ($fileCheck['status'] == false) {
                return response()->json(['status' => false, 'message' => $fileCheck['message'], 'data' => []]);
            }

            if (!file_exists(public_path('assets/business/customer-imports'))) {
                mkdir(public_path('assets/business/customer-imports'), 0777, true);
            }
            //Where uploaded file will be stored on the server
            $location = public_path('assets/business/customer-imports'); //Created an "uploads" folder for that

            // Upload file
            $file->move($location, $filename);
            // In case the uploaded file path is to be stored in the database
            $filepath = public_path('assets/business/customer-imports/' . $filename);

            $fileData = [];
            $customers = (new FastExcel())->import($filepath);

            /* Validate file before import */
            $validate = $this->validateFile($customers);
            if ($validate['status'] == false) {
                return response()->json(['status' => $validate['status'], 'message' => $validate['message'], 'data' => $validate['data']]);
            }

            $failed_numbers = $added_to = $not_added = $exist_numbers = [];
            $total_count = $failed_count = $success_count = $repeated_count = 0;

            //total numbers
            $total_count = count($customers);

            //contact group
            if ($request->old_group != '') {
                $group = ContactGroup::find($request->old_group);
            } else {
                $group = new ContactGroup();
                $group->user_id = Auth::id();
                $group->name = trim($request->group_name);
                $group->save();
            }

            foreach ($customers as $single_customer) {
                if (!in_array($single_customer['Whatsapp Number'], $added_to) || empty($added_to)) {
                    $createCustomer = $this->createCustomer($single_customer, $group->id);

                    if ($createCustomer['status'] == false) {
                        if ($createCustomer['flag'] == 'failed') {
                            $failed_numbers[] = $createCustomer['mobile'];
                        } else {
                            $exist_numbers[] = $createCustomer['mobile'];
                        }
                    } else {
                        $added_to[] = $single_customer['Whatsapp Number'];
                    }
                } else {
                    $not_added[] = $single_customer['Whatsapp Number'];
                }
            }

            $success_count = count($added_to);
            $repeated_count = count($exist_numbers) + count($not_added);

            if (!empty($failed_numbers)) {
                $failed_count = count($failed_numbers);
            }

            $stats = [
                'total_count' => $total_count,
                'success_count' => $success_count,
                'failed_count' => $failed_count,
                'repeated_count' => $repeated_count,
            ];

            if ($success_count <= 0) {
                return response()->json([
                    'status' => true,
                    'message' => 'Customer(s) data updated successfully.',
                    'data' => $stats,
                ]);
            } else {
                $contact_count = GroupCustomer::where('contact_group_id', $group->id)->count();
                if ($contact_count == 0) {
                    GroupCustomer::destroy($group->id);
                }

                return response()->json([
                    'status' => true,
                    'message' => 'Customer(s) added successfully.',
                    'data' => $stats,
                ]);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Please select file to upload.', 'data' => []]);
        }
    }

    public function groupCheck(Request $request)
    {
        $group = ContactGroup::where('user_id', Auth::id())
            ->where('name', trim($request->group_name))
            ->first();

        if ($group == null) {
            return response()->json(['status' => true]);
        } else {
            return response()->json(['status' => false, 'message' => 'Group name already exists.']);
        }
    }

    public function validateFile($customers)
    {
        if (empty($customers)) {
            return ['status' => false, 'message' => 'Sheet is blank.', 'data' => []];
        }

        $rows = [];
        $i = 2;
        foreach ($customers as $single_customer) {
            if (!isset($single_customer['Whatsapp Number']) || !isset($single_customer['Customer Name']) || !isset($single_customer['Date of Birth ( Day )']) || !isset($single_customer['Date of Birth ( Month )']) || !isset($single_customer['Anniversary Date ( Day )']) || !isset($single_customer['Anniversary Date ( Month )'])) {
                return ['status' => false, 'message' => 'Please select valid file to upload.', 'data' => []];
            }

            $errors = [];

            if (trim($single_customer['Whatsapp Number']) == '') {
                $errors[] = 'Whatsapp number is blank.';
            }

            if (strlen(trim($single_customer['Whatsapp Number'])) != 10) {
                $errors[] = 'Whatsapp number is not valid.';
            }

            if (strlen(trim($single_customer['Customer Name'])) > 50) {
                $errors[] = 'Customer name is too long.';
            }

            /* Validate date of birth */
            if(strlen(trim($single_customer['Date of Birth ( Month )'])) == 0 && strlen(trim($single_customer['Date of Birth ( Day )'])) > 0){
                $errors[] = 'Date of Birth ( Month ) is empty.';
            }

            if(strlen(trim($single_customer['Date of Birth ( Month )'])) != 0 && strlen(trim($single_customer['Date of Birth ( Day )'])) == 0){
                $errors[] = 'Date of Birth ( Day ) is empty.';
            }

            if(strlen(trim($single_customer['Date of Birth ( Month )'])) != 0 && strlen(trim($single_customer['Date of Birth ( Day )'])) != 0){
                if(trim($single_customer['Date of Birth ( Month )']) == 'February' && trim($single_customer['Date of Birth ( Day )']) > 29){
                    $errors[] = 'Date of Birth ( Day ) is invalid.';
                }

                if(in_array(trim($single_customer['Date of Birth ( Month )']), ['April', 'June', 'September', 'November']) && trim($single_customer['Date of Birth ( Day )']) > 30){
                    $errors[] = 'Date of Birth ( Day ) is invalid.';
                }

                if(in_array(trim($single_customer['Date of Birth ( Month )']), ['January', 'March', 'May', 'July', 'August', 'October', 'December']) && trim($single_customer['Date of Birth ( Day )']) > 31){
                    $errors[] = 'Date of Birth ( Day ) is invalid.';
                }
            }

            
            /* Validate anniversary date */
            if(strlen(trim($single_customer['Anniversary Date ( Month )'])) == 0 && strlen(trim($single_customer['Anniversary Date ( Day )'])) > 0){
                $errors[] = 'Anniversary Date ( Month ) is empty.';
            }

            if(strlen(trim($single_customer['Anniversary Date ( Month )'])) != 0 && strlen(trim($single_customer['Anniversary Date ( Day )'])) == 0){
                $errors[] = 'Anniversary Date ( Day ) is empty.';
            }

            if(strlen(trim($single_customer['Anniversary Date ( Month )'])) != 0 && strlen(trim($single_customer['Anniversary Date ( Day )'])) != 0){
                if(trim($single_customer['Anniversary Date ( Month )']) == 'February' && trim($single_customer['Anniversary Date ( Day )']) > 29){
                    $errors[] = 'Anniversary Date ( Day ) is invalid.';
                }

                if(in_array(trim($single_customer['Anniversary Date ( Month )']), ['April', 'June', 'September', 'November']) && trim($single_customer['Anniversary Date ( Day )']) > 30){
                    $errors[] = 'Anniversary Date ( Day ) is invalid.';
                }

                if(in_array(trim($single_customer['Anniversary Date ( Month )']), ['January', 'March', 'May', 'July', 'August', 'October', 'December']) && trim($single_customer['Anniversary Date ( Day )']) > 31){
                    $errors[] = 'Anniversary Date ( Day ) is invalid.';
                }
            }

            // dd($errors);

            if (!empty($errors)) {
                $rows[$i] = $errors;
            }

            $i++;
        }

        if (!empty($rows)) {
            return ['status' => false, 'message' => 'Errors found while uploading customers.', 'data' => $rows];
        } else {
            return ['status' => true, 'message' => 'Validation successful.', 'data' => []];
        }
        #dd($rows);
    }

    public function createCustomer($single_customer, $group_id)
    {
        $customer = Customer::where('mobile', $single_customer['Whatsapp Number'])
            ->orderBy('id', 'desc')
            ->first();

        $dob_date = $single_customer['Date of Birth ( Day )'];
        $dob_month = $single_customer['Date of Birth ( Month )'];

        $anniversary_day = $single_customer['Anniversary Date ( Day )'];
        $anniversary_month = $single_customer['Anniversary Date ( Month )'];

        $date_of_birth = $anniversary_date = '';
        if ($single_customer['Date of Birth ( Day )'] != '' && $single_customer['Date of Birth ( Month )'] != '') {
            $date_of_birth = $dob_date . ' ' . $dob_month;
        }

        if ($single_customer['Anniversary Date ( Day )'] != '' && $single_customer['Anniversary Date ( Month )'] != '') {
            $anniversary_date = $anniversary_day . ' ' . $anniversary_month;
        }

        // dd($single_customer['Date of Birth ( dd-mm )']);
        if ($customer == null) {
            $customer = new Customer();
            $customer->mobile = $single_customer['Whatsapp Number'];
            $customer->user_id = Auth::id();
            $customer->created_by = Auth::id();
            $customer->is_imported = '1';
            $customer->save();

            $customer->uuid = $customer->id . 'CUST' . date('Ymd');
            $customer->save();

            $business_customer = new BusinessCustomer();
            $business_customer->customer_id = $customer->id;
            $business_customer->user_id = Auth::id();
            $business_customer->name = $single_customer['Customer Name'];
            $business_customer->dob = $date_of_birth;
            $business_customer->anniversary_date = $anniversary_date;
            $business_customer->save();
        } else {
            $businessCustomer = BusinessCustomer::where('user_id', Auth::id())
                ->where('customer_id', $customer->id)
                ->orderBy('id', 'desc')
                ->first();

            if ($businessCustomer != null) {
                $business_customer = BusinessCustomer::find($businessCustomer->id);
            } else {
                $business_customer = new BusinessCustomer();
            }
            $business_customer->customer_id = $customer->id;
            $business_customer->user_id = Auth::id();
            $business_customer->name = $single_customer['Customer Name'];
            $business_customer->dob = $date_of_birth;
            $business_customer->anniversary_date = $anniversary_date;
            $business_customer->save();
        }

        if ($customer != null) {
            $isExist = true;

            $contact = GroupCustomer::where('user_id', Auth::id())
                ->where('contact_group_id', $group_id)
                ->where('customer_id', $customer->id)
                ->first();
            if ($contact == null) {
                $isExist = false;

                $contact = new GroupCustomer();
                $contact->user_id = Auth::id();
                $contact->contact_group_id = $group_id;
                $contact->customer_id = $customer->id;
                $contact->save();
            }

            //check customer for group created or not
            if ($contact == null) {
                return ['status' => false, 'message' => 'Customer not created.', 'mobile' => $single_customer['Whatsapp Number'], 'flag' => 'failed'];
            }

            if ($isExist == false) {
                return ['status' => true, 'message' => 'Customer(s) created successfully.'];
            } else {
                return ['status' => false, 'message' => 'Customer already exists.', 'mobile' => $single_customer['Whatsapp Number'], 'flag' => 'exist'];
            }
        } else {
            return ['status' => false, 'message' => 'Customer not created.', 'mobile' => $single_customer['Whatsapp Number'], 'flag' => 'failed'];
        }
    }

    public function checkUploadedFile($extension, $fileSize)
    {
        $valid_extension = ['xlsx']; //Only xlsx files
        $maxFileSize = 2097152; // Uploaded file size limit is 2mb

        if (in_array(strtolower($extension), $valid_extension)) {
            if ($fileSize <= $maxFileSize) {
                return ['status' => true, 'message' => 'Valid file type.'];
            } else {
                return ['status' => false, 'message' => 'Please select file to upload.'];
            }
        } else {
            return ['status' => false, 'message' => 'Invalid file extension.'];
        }
    }
}
