<style>
    .qr-paper-two,
    .qr-paper-two .inner{
        position: relative;
        border: 1px dashed rgba(0, 0, 0, 0.5);
        padding: 10px;
        text-align: center;
        max-width: 320px;
    }
    .qr-paper-two .inner{
        padding: 20px 40px;
        border: 1px solid rgba(0, 0, 0, 0.5);
    }
    .qr-paper-two .inner > .offer-img > img{
        max-width: 150px;
    }
    .qr-paper-two .inner > .oc-logo > img{
        max-width: 110px;
    }
    .qr-paper-two .inner > .owner-name{
        /*margin-bottom: 10px;*/
        padding: 5px 5px;
    }
    .mb-0{
        margin-bottom: 5px;
    }
    .contact_data{
        padding: 2px 10px;
        /* background-color: rgb(175 179 183); */
        color: #4d4949;
        font-weight: 500;
        border-radius: 3px;
        display: inline-block;
        line-height: 1.4;
        margin-bottom: 5px;
    }
    span.qr_scan{
        background-color: #ff626b;
        color: white;
        position: relative;
        font-size: 16px;
        padding: 0px 8px 5px 8px;
        display: inline-block;
        margin: 0px;
        vertical-align: middle;
        /*min-width: 240px;*/
    }
    span.qr_scan::before{
        content: "";
        position: absolute;
        top: -18px;
        left: 50%;
        margin-left: -8px;
        border-width: 10px;
        border-style: solid;
        border-color: transparent transparent #ff626b transparent;

    }

</style>

<div class="qr-paper-two">
    <div class="inner px-3">
        <div class="qr-place">
            <div class="qr_main mb-2">
                <div class="qr_inner" style="max-width: 220px;margin:auto;">
                    {!! $qrcode !!}
                </div>
            </div>
            <span class="qr_scan">SCAN ME</span>
            <!-- <p class="mb-0">Scan above QR code to get an<br><b>Exciting  Offers</b></p> -->
        </div>

        <hr style="margin: 20px auto 15px auto;width:200px;">

        <div class="owner-name">
            <h3 class="" style="font-size:18px;color: #000;">{{$planData['business_detail']->business_name}}</h3>
            <div>
                <p class="contact_data mb-0">{{Auth::user()->mobile}}</p>
                <p class="contact_data mb-0" style="font-size:12px;">{{Auth::user()->email}}</p>
            </div>
        </div>
        <hr style="margin: 10px auto 5px auto;width:200px;">
        <div class="oc-logo">
            <div>
                <small>Powered By</small>
            </div>
            <img src="data:image/png;base64, {{ base64_encode(file_get_contents(asset('assets/emails/images/logo-dark.png'))) }}">
        </div>

    </div>
</div>