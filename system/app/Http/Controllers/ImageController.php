<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Image;

class ImageController extends Controller
{
    //

    public function selectImage(Request $request){

        return view('business.test');
    }


    public function resizeImage(Request $request){

        $this->validate($request, [
            'file' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);


        $image = $request->file;
        $filename = $image->getClientOriginalName();
        $image_resize = Image::make($image->getRealPath());
        $image_resize->resize(318,159);
        $image_resize->save(public_path('images/'.$filename));
        return "Iamge has been resized Successfully!";
    }
}
