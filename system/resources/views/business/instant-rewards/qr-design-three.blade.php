<style>
    .qr-paper-three,
    .qr-paper-three .inner{
        position: relative;
        border: 1px dashed rgba(0, 0, 0, 0.5);
        
        text-align: center;
        max-width: 320px;
    }
    .qr-paper-three{
        padding: 10px;
    }
    .qr-paper-three .inner{
        border: 1px solid rgba(0, 0, 0, 0.5);
    }
    .qr-paper-three .inner > .inner-next{
        padding: 20px 30px;
    }
    .qr-paper-three .inner > .offer-section{
        margin-bottom: 20px;
        /*background-color: #ff626b;*/
        background:rgba(0,36,156, 1);
    }
    .qr-paper-three .inner-next > .oc-logo > img{
        max-width: 110px;
    }
    .qr-paper-three .inner-next > .owner-name{
        margin-bottom: 15px;
        padding: 5px 5px;
    }
    .mb-0{
        margin-bottom: 5px;
    }
</style>

<div class="qr-paper-three">
    <div class="inner">
        <div class="bg-light p-2">
            <table>
                <tr>
                    @if($planData['business_detail'] != null && $planData['business_detail']['logo'] != '')
                    <td>
                        <div style="width: 70px;" class="mr-2">
                            <img src="{{ asset('assets/business/logos/'.$planData['business_detail']['logo']) }}" class="w-100">
                        </div>
                    </td>
                    @endif
                    <td class="text-left">
                        <div class="w-100">
                            <h5 style="line-height: 1;margin:0px;"><b>{{$planData['business_detail']->business_name}}</b></h5>
                            <p style="margin:0px;">{{Auth::user()->mobile}}</p>
                            <p style="margin:0px;font-size:12px;word-break: break-all;line-height:1;">{{Auth::user()->email}}</p>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <div class="inner-next">
            <div class="qr-place">
                <div class="qr_main my-4">
                    <div class="qr_inner" style="max-width: 200px;margin:auto;">
                        {!! $qrcode !!}
                    </div>
                </div>
            </div>
            <div class="offer-section">
                <p class="text-capitalize">Scan this QR Code to checkout our exciting offers</p>
            </div>
            <hr style="margin: 10px 0px 5px;">
            <div class="oc-logo">
                <div>
                    <small>Powered By</small>
                </div>
                <img src="data:image/png;base64, {{ base64_encode(file_get_contents(asset('assets/emails/images/logo-dark.png'))) }}">
            </div>
        </div>
    </div>
</div>