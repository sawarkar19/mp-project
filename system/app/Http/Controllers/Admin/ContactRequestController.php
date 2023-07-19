<?php

namespace App\Http\Controllers\Admin;
use Auth;
use Carbon\Carbon;
use App\Models\ContactMessage;
use App\Exports\ExportContact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;


class ContactRequestController extends Controller
{
    
     public function contactList(Request $request)
    {
        /* all contact show data, search and pagination start */
        $conditions = [];
        if (!empty($request->src) && !empty($request->term)) {
            $allContacts = ContactMessage::where($request->term, 'like', '%'. $request->src . '%' )->latest()->paginate(10);
        $conditions[] = [$request->term, 'like', '%' . $request->src . '%'];
        } else{
            $allContacts = ContactMessage::orderBy('id', 'DESC')->latest()->paginate(10);
            
        }
        /* all contact show data, search and pagination end */

        return view('admin.contacts-request.contactList', compact('allContacts', 'conditions', 'request'));
    }

    public function exportContacts(Request $request)
    {
        
        $contacts = ContactMessage::get();

        if (count($contacts) > 0) {
        
            try {
                $data = [];
                $i = 1;
                foreach($contacts as $k => $contact){
                
                    $data[] =
                    [
                        'sr_no' => $i,
                        'name' => $contact->name,
                        'mobile' => $contact->mobile,
                        'email' => $contact->email,
                        'message' => $contact->message,
                        'date' => Carbon::parse($contact->created_at)->format("j M, Y"),
                    ];

                    $i++;
                }

                return Excel::download(new ExportContact($data), 'Contacts' . '_' . date('Y_m_d_H_i_s') . '.xlsx');
            } catch(Exception $e) {
                exit($e->getMessage());
            }
        }else{
            return Redirect::back()->with('error_msg', 'Contacts not found.');
        }
    }
}
