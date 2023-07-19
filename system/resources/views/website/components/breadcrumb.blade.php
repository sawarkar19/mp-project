@if (!empty($bcrm))
<div class="d-flex justify-content-end pt-2 pt-md-0">
    <ul class="breadcrumb breadcrumb--classic breadcrumb--classic-chevron mb-0">
        <li><a href="{{url('/')}}"><i class="bi bi-house-door"></i></a> </li>
        @php $count = count($bcrm); @endphp
        @for ($i = 0; $i < $count; $i++)
        <li class="@if ($i == $count - 1)active @endif">
            <a href="@if(!$bcrm[$i]['link']) # @else {{$bcrm[$i]['link']}} @endif">{{$bcrm[$i]['name']}}</a>
        </li>
        @endfor
    </ul>
</div>
@endif