<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Deduction;
use DB;
use Illuminate\Support\Str;

class DeductionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $deduction_list = Deduction::latest()->paginate(10);
        
        $deduction_url = Session(['deduction_url' => '#']);
        return view('admin.deductions.index', compact('deduction_list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validations = [
            'name' => 'required|min:5|max:100',
            'slug' => 'required|min:5|max:100',
            'amount' => 'required',
        ];

        $messages = [
            'name.required' => 'Name can not be empty !',
            'slug.required' => 'Slug can not be empty !',
            'amount.required' => 'Amount can not be empty !',
        ];
        $this->validate($request, $validations, $messages);

        $options = new Deduction;
        $options->name = $request->name;
        $options->slug = $request->slug;
        $options->amount = $request->amount;
        $options->status = $request->status;
        $options->save();

        return response()->json([
            'status' => true,
            'message' => 'Added Successfully !',
        ]);

    }
    public function getDeduction(Request $request)
    {
        $deduction = Deduction::find($request->id);
        $json=[
            'status'=>true,
            'deduction'=>$deduction
        ];
        // dd($json);
        return response()->json($json);
    }


    public function update(Request $request)
    {
        $validations = [
            'name' => 'required|min:5|max:100',
            'slug' => 'required|min:5|max:100',
            'amount' => 'required',
        ];

        $messages = [
            'name.required' => 'Name can not be empty !',
            'slug.required' => 'Slug can not be empty !',
            'amount.required' => 'Amount can not be empty !',
        ];

        $this->validate($request, $validations, $messages);

        $option = Deduction::find($request->id);
        // dd($option);
        // $option_url = Session::get('option_url');
        $option->name = $request->name;
        $option->slug = $request->slug;
        $option->amount = $request->amount;
        $option->status = $request->status;
        $option->save();

        return response()->json([
            'status' => true,
            'message' => 'Update Successfully !'
        ]);
    }


 
}
