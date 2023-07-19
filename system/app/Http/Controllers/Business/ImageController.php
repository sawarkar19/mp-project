<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Business\CommonSettingController;
use Illuminate\Http\Request;
use Image;

class ImageController extends Controller
{
    //
    public function __construct()
    {
       $this->middleware('business');
    }

    public function selectImage(Request $request){

        //notification_list
        $notification_list = CommonSettingController::getNotification();
        $planData = CommonSettingController::getBusinessPlanDetails();

        return view('business.test',compact('notification_list','planData'));
    }


    public function resizeImage(Request $request){

        // dd($request);

        // $this->validate($request, [
        //     'file' => 'required|image|mimes:jpg,jpeg,png|max:2097152',
        // ]);

        if($request->hasFile('file'))
        {
            $image = $request->file('file');
            $extension = $image->getClientOriginalExtension();
            $size = $image->getSize();

            if($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png'){

                if($size <= 2097152){

                    $image = $request->file('file');
                    $extension = $image->getClientOriginalExtension();
                    $fileName = 'img-'.date('dmYhis',time()) . '.' . $extension;
                    $destinationPath = base_path('/resized/');
                    $image_resize = Image::make($image->getRealPath());
                    $image_resize->resize(318,159);
                    $image_resize->save($destinationPath. $fileName);

                    return "Image has been resized Successfully!";

                }else{
                    return "Image size must be smaller than 2MB or equal.";
                }

            }else{
                return "File must be an image (jpg, jpeg or png).";
            }

        }else{
            return "Please select an image.";
        }

    }
}
