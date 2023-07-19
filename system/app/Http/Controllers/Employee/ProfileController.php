<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\State;
use App\Models\EmployeeDetail;

use Auth;
use Hash;

class ProfileController extends Controller
{
	public function __construct()
    {
        $this->middleware('employee');
    }
    
    public function settings(){
    	$info = User::with('employee_details')->find(Auth::user()->id);
    	if($info->employee_details == null){
    		$info->employee_details = new EmployeeDetail;
    	}
    	$states = State::select('name')->get();
    	
        return view('employee.profile.settings', compact(['info','states']));
    }

	public function profile_update(Request $request){

		$user=User::find(Auth::id());

		$request->validate([
			'name' => 'required|min:2|max:255',
		]);
		$user->name=$request->name; 
		$user->save();

		return response()->json(['status' => true, 'message' => 'Profile Updated Successfully.']);
	}

	public function profile_address(Request $request){

		$user=EmployeeDetail::where('user_id',Auth::id())->orderBy('id', 'desc')->first();

		$request->validate([
			'address' => 'nullable|min:3|max:255',
			'pincode' => 'nullable|numeric',
			'city' => 'nullable|min:3|max:255',
			'state' => 'nullable|min:3|max:255',
		]);

		if($user == null){
			$user = new EmployeeDetail;
			$user->user_id = Auth::id();
			$user->address = $request->address;
			$user->pincode = $request->pincode;
			$user->city = $request->city;
			$user->state = $request->state;
			$user->country = "India";
			$user->save();
		}else{
			$user->address = $request->address;
			$user->pincode = $request->pincode;
			$user->city = $request->city;
			$user->state = $request->state;
			$user->country = "India";
			$user->save();
		}

		return response()->json(['status' => true, 'message' => 'Address Updated Successfully.']); 
	}

}
