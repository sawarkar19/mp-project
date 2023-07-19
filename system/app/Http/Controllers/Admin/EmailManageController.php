<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Email;
use DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Session;
use URL;


class EmailManageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $emails = Email::latest()->paginate(10);
        $email_url = Session(['email_url' => '#']);
        return view('admin.emailmanage.index', compact('emails'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
          $emails = array();
          return view('admin.emailmanage.create', compact('emails'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'subject' => 'required|min:10|max:100',
            'content' => 'required',
        ];

        $messages = [
            'subject.required' => 'Subject can not be empty !',
            'content.required' => 'Content can not be empty !',
        ];

        $this->validate($request, $rules, $messages);

        $email = new Email;
        $email->subject = $request->subject;
        $email->content = $request->content;
        $email->status = $request->status;
        $email->save();
        $url = route('admin.emailmanages.index', $request->id);
        return response()->json([
            'status' => true,
            'message' => 'Email Added Successfully',
            "url" => $url
        ]);
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
        $email_url = Session(['email_url' => URL::previous()]);
        $emails = Email::find($id);
        return view('admin.emailmanage.edit', compact('emails'));
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
        $rules = [
            'subject' => 'required|min:10|max:100',
            'content' => 'required',
        ];

        $messages = [
            'subject.required' => 'Subject can not be empty !',
            'content.required' => 'Content can not be empty !',
        ];

        $this->validate($request, $rules, $messages);

        $email = Email::find($id);
        $email_url = Session::get('email_url');
        $email->subject = $request->subject;
        $email->content = $request->content;
        $email->status = $request->status;
        $email->save();
        return response()->json([
            'status' => true,
            'message' => 'Email Updated Successfully',
            'url' => $email_url
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if ($request->ids) {
            foreach ($request->ids as $id) {
                Email::destroy($id);
            }
            return response()->json(['status' =>true, 'message' => 'Successfully deleted !']);
        }else{
            return response()->json(['status' =>false, 'message' => 'Please select email !']);
        }
    }
}
