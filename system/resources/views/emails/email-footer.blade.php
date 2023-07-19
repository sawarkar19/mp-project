@php
    $option= DB::table('options')->where('key', 'company_info')->first();
    $info=json_decode($option->value);
@endphp

<tr style="background-color: #000;" align="center">
    <td style="padding: 30px;">
        <div>
            <a href="{{url('/')}}"><img src="{{ asset('assets/emails/images/logo-plain-light.png') }}" style="width: 100%;max-width: 90px;" alt="MouthPublicity.io"></a>
        </div>
        <div>
            <ul style="list-style: none;color: #FFF;padding-left: 0px;margin-bottom: 0px;">
                @if($info->facebook != '')
                    @if($info->facebook != '#')
                    <li style="display: inline;margin: 3px;">
                        <a href="{{ $info->facebook }}" target="_blank" style="display: inline-block;">
                            <img src="{{ asset('assets/emails/images/facebook.png') }}" style="width: 26px;" alt="facebook">
                        </a>
                    </li>
                    @endif
                @endif
                @if($info->instagram != '')
                    @if($info->instagram != '#')
                    <li style="display: inline;margin: 3px;">
                        <a href="{{ $info->instagram }}" target="_blank" style="display: inline-block;">
                            <img src="{{ asset('assets/emails/images/instagram.png') }}" style="width: 26px;" alt="facebook">
                        </a>
                    </li>
                    @endif
                @endif
                @if($info->linkedin != '')
                    @if($info->linkedin != '#')
                    <li style="display: inline;margin: 3px;">
                        <a href="{{ $info->linkedin }}" target="_blank" style="display: inline-block;">
                            <img src="{{ asset('assets/emails/images/linkedin.png') }}" style="width: 26px;" alt="facebook">
                        </a>
                    </li>
                    @endif
                @endif
                @if($info->twitter != '')
                    @if($info->twitter != '#')
                    <li style="display: inline;margin: 3px;">
                        <a href="{{ $info->twitter }}" target="_blank" style="display: inline-block;">
                            <img src="{{ asset('assets/emails/images/twitter.png') }}" style="width: 26px;" alt="facebook">
                        </a>
                    </li>
                    @endif
                @endif
                @if($info->youtube != '')
                    @if($info->youtube != '#')
                    <li style="display: inline;margin: 3px;">
                        <a href="{{ $info->youtube }}" target="_blank" style="display: inline-block;">
                            <img src="{{ asset('assets/emails/images/youtube.png') }}" style="width: 26px;" alt="facebook">
                        </a>
                    </li>
                    @endif
                @endif
            </ul>
        </div>
    </td>
</tr>
