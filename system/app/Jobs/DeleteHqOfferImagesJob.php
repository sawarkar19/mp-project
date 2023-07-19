<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Models\Offer;

class DeleteHqOfferImagesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public $offerId;
    public function __construct($offerId=0)
    {
        $this->offerId = $offerId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $offerDetail = Offer::with('offer_template')->find($this->offerId);

        $removeImageName = "";
        if($offerDetail->type == "custom"){
            if($offerDetail->image!=""){
                $hqImage = explode("custom-offer-", $offerDetail->image);
                $removeImageName = "custom-offer-hq-".$hqImage[1];
                $removeImage = base_path().'/../assets/templates/custom/'.$removeImageName;
            }
        }
        else{
            $hqImage = explode("-", $offerDetail->offer_template->thumbnail);
            $removeImageName = $hqImage[0]."-hq-".$hqImage[1];
            $removeImage = base_path().'/../assets/offer-thumbnails/'.$removeImageName;
        }

        @unlink($removeImage);
    }
}
