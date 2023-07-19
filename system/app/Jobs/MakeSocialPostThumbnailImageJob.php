<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use File, Image;

class MakeSocialPostThumbnailImageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public $offerType;
    public $imageName;
    public $socialType;
    public $fileOriginalName;

    public function __construct($offerType="", $imageName="", $socialType="", $fileOriginalName="")
    {
        $this->offerType = $offerType;
        $this->imageName = $imageName;
        $this->socialType = $socialType;
        $this->fileOriginalName = $fileOriginalName;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        ini_set('memory_limit', '512M');

        $width = $height = 900;
        if($this->socialType == "fb"){
            $width = $height = 900;
        }
        // ...


        $fullPath = $resize_name ="";
        if($this->offerType=="custom"){
            $fullPath = 'assets/templates/custom/'.$this->imageName;
        }
        else{
            $fullPath = 'assets/offer-thumbnails/'.$this->imageName;
        }

        if (file_exists($fullPath)) {
            $folderPath = base_path('../assets/templates/resize-file/');
            if(!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);
            }

            $copy_image = 'copy-'.$this->imageName;            
            File::copy($fullPath, $folderPath.$copy_image);
            $resize_name = $this->socialType.'-resize'.'-'.$this->imageName;
            $resize_path = $folderPath . $resize_name;
            $small_img = Image::make($folderPath.$copy_image)->resize($width, $height, function($constraint) {
                $constraint->aspectRatio();
            });
            $small_img->save($resize_path);

            $img    = Image::make($resize_path);
            $width  = $img->width();
            $height = $img->height();

            $resizeWidth = $small_img->width();
            $resizeHeight = $small_img->height();

            /*
            *  canvas
            */
            
            $dimension = 900;
            if($this->socialType=="fb"){
                $dimension = 900;
            }
            // ...

            $vertical   = (($width < $height) ? true : false);
            $horizontal = (($width > $height) ? true : false);
            // $vertical   = $horizontal = true;
            $square     = (($width = $height) ? true : false);

            // Standard Image
            // if($this->offerType!="custom"){
                if ($square) {
                    $newSize = ($dimension - $resizeWidth) / 2;
                    $right = $left = $newSize;
                    $newWidth = ($dimension) - ($left + $right);

                    $top = $bottom = 200;
                    $newHeight = ($dimension) - ($bottom + $top);

                    $img->resize($newWidth, $newHeight, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                }
                else if ($vertical) {
                    $right = $left = 50;
                    $newWidth = ($dimension) - ($left + $right);

                    $top = $bottom = 200;
                    $newHeight = ($dimension) - ($bottom + $top);

                    $img->resize($newWidth, $newHeight, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                } else if ($horizontal) {
                    $newSize = ($dimension - $resizeWidth) / 2;
                    $right = $left = $newSize;
                    $newWidth = ($dimension) - ($right + $left);

                    $top = $bottom = 200;
                    $newHeight = ($dimension) - ($bottom + $top);

                    $img->resize($newWidth, $newHeight, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                }

                $img->resizeCanvas($dimension, $dimension, 'center', false, '#ffffff');
                $img->save($folderPath.$resize_name);
            // }
            // Custom Image
            // else{
                // Stop for Google Review

            // }
            
            @unlink($folderPath.$copy_image);
        }

        $socialPostImage = $this->reduceImage($this->offerType, $this->imageName, $this->socialType, $resize_name, $this->fileOriginalName);
        
        return true;
    }

    public function reduceImage($offerType="", $imageName="", $socialType="", $resizeHqImage="", $fileOriginalName=""){
        $folderPath = base_path('../assets/templates/resize-file/');

        $width = $height = 900;
        if($socialType == "fb"){
            $width = $height = 900;
        }

        $folderPath = base_path('../assets/templates/resize-file/');
        if(!file_exists($folderPath)) {
            mkdir($folderPath, 0777, true);
        }

        $resize_name = $socialType.'-resize-'.$fileOriginalName;
        $resize_path = $folderPath . $resize_name;
        $small_img = Image::make($folderPath.$resizeHqImage)->resize($width, $height, function($constraint) {
            $constraint->aspectRatio();
        });

        $small_img->save($resize_path);
        // @unlink($folderPath.$resizeHqImage);
        return $resize_name;
    }
}
