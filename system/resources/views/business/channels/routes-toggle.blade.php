<div>
    <div class="form-group mb-0">

        <div class="custom-switches-stacked flex-row justify-content-end">
            {{-- WhatsApp --}}
            @if($routes->channel_id != 5)
            <label class="message-route-toggle custom-switch mb-0 pl-0" id="wa_{{ $routes->channel_id }}" data-toggle="tooltip" title="WhatsApp Message">
                <input type="checkbox" data-toggle="toggle" name="message_route" value="{{$routes->wa}}" class="custom-switch-input" @if ($routes->wa) checked @endif>
                <span class="custom-switch-description ml-0 mr-1"><i class="fab fa-whatsapp"></i></span>
                <span class="custom-switch-indicator"></span>
            </label>
            @endif
            {{-- SMS --}}
            <label class="message-route-toggle custom-switch mb-0 pl-4" id="sms_{{ $routes->channel_id }}" data-toggle="tooltip" title="SMS Message">
                <input type="checkbox" data-toggle="toggle" name="message_route" value="{{$routes->sms}}" class="custom-switch-input" @if ($routes->sms) checked @endif>
                <span class="custom-switch-description ml-0 mr-1"><i class="far fa-comment-dots"></i></i></span>
                <span class="custom-switch-indicator"></span>
            </label>
        </div>
    </div> 
</div>