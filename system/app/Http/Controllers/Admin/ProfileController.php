<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Hash;
use File;
use Image;

class ProfileController extends Controller
{
    public function settings(){
        return view('admin.profile.settings');
    }

	public function profile_update(Request $request){

		$user=User::find(Auth::id());

		if ($request->password) {
			$validatedData = $request->validate([
				'password' => ['required', 'string', 'min:8', 'confirmed'],
			]);  


			$check=Hash::check($request->password_current,auth()->user()->password);

			if ($check==true) {
				$user->password= Hash::make($request->password);
			}else{

				$returnData['errors']['password']=array(0=>"Enter Valid Old Password");
				$returnData['message']="given data was invalid.";

				return response()->json($returnData, 401);
			}        
		}else{
			$validatedData = $request->validate([
				'name' => 'required|max:255',
				'email'  =>  'required|email|unique:users,email,'.Auth::id(),
			]);
			$user->name=$request->name;
			$user->email=$request->email;  

			if(isset($request->designation)){
				$user->designation=$request->designation;
			}
			if(isset($request->bio)){
				$user->bio=$request->bio;
			}
			if(isset($request->linkedin_profile)){
				$user->linkedin_profile=$request->linkedin_profile;
			}
			if(isset($request->instagram_profile)){
				$user->instagram_profile=$request->instagram_profile;
			}
			if(isset($request->facebook_profile)){
				$user->facebook_profile=$request->facebook_profile;
			}

			if($request->hasFile('profile_pic'))
	        {
	        	$image = $this->uploadImage($request);
	        	$user->profile_pic=$image['file'];
	        } 
		}
		$user->save();

		return response()->json(['Profile Updated Successfully']); 
	}

    public function uploadImage($request){

        $image = $request->file('profile_pic');
        $extension = $image->getClientOriginalExtension();
        $size = $image->getSize();
        $extension = $image->getClientOriginalExtension();
        $fileName = 'ol-profile'.date('dmYhis',time()) . '.' . $extension;

        $destinationPath = base_path('../assets/blogs/authors/');
        if(!File::isDirectory($destinationPath)){
            File::makeDirectory($destinationPath, 0777, true, true);
        }
        
        $image_resize = Image::make($image->getRealPath());
        //$image_resize->resize(318,159);
        $image_resize->save($destinationPath. $fileName);

        return ['status'=>true, 'file' => $fileName];
    }

}
