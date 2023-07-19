@isset($fonts)
{!!$fonts!!}
@endisset
<style>
    .qr-paper-one,
    .qr-paper-one .inner{
        position: relative;
        border: 1px dashed rgba(0, 0, 0, 0.5);
        padding: 10px;
        text-align: center;
        max-width: 320px;
    }
    .qr-paper-one .inner{
        padding: 20px 40px;
        border: 1px solid rgba(0, 0, 0, 0.5);
    }
    .qr-paper-one .inner > .business-logo > img{
        max-width: 100px;
        margin-bottom: 10px;
    }
    .qr-paper-one .inner > .oc-logo{
        /*margin-bottom: 20px;*/
    }
    .qr-paper-one .inner > .oc-logo > img{
        max-width: 110px;
    }
    .qr-paper-one .inner > .owner-name{
        margin-bottom: 15px;
        padding: 5px 15px;
        /* background: linear-gradient(135deg, rgb(0,255,175, 1) -50%, rgba(0,36,156, 1)); */
    }
    .mb-0{
        margin-bottom: 5px;
    }
</style>

<div class="qr-paper-one">
    <div class="inner">
        <div class="business-logo">
            @if($planData['business_detail'] != null && $planData['business_detail']['logo'] != '')
                <img src="{{ asset('assets/business/logos/'.$planData['business_detail']['logo']) }}">
            @endif
        </div>
        <div class="owner-name">
            <h3 class="mb-0" style="font-size:19px;">{{$planData['business_detail']->business_name}}</h3>
        </div>
        <div class="qr-place">
            <div class="qr_main mb-3">
                <div class="qr_inner" style="max-width: 220px;margin:auto;">
                    {!! $qrcode !!}
                </div>
            </div>
            <p class="mb-0">Scan above QR code to get an<br><b>Exciting Offers</b></p>
        </div>

        <hr style="margin: 20px 0px 10px 0px;">

        <div class="oc-logo">
            <div>
                <small>Powered By</small>
            </div>
            <img src="data:image/png;base64, {{ base64_encode(file_get_contents(asset('assets/emails/images/logo-dark.png'))) }}">
        </div>
    </div>
</div>