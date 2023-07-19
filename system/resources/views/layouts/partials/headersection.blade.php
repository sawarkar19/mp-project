<div class="section-header mb-3">
    <h1>{{ $title }}</h1>
    <div class="section-header-breadcrumb d-block">
        <p class="text-capitalize mb-0">
        	@php $i = 0; @endphp
        	@foreach(request()->segments() as $key => $segment)
                @if($key <= 1)
                    @if($i) <i class="fas fa-angle-right"></i> @endif @if($segment == 'customer'){{ 'subscriber' }}@else{{ $segment }}@endif

                    @php $i++; @endphp
                @endif
	        @endforeach
        </p>
    </div>
</div>


@php
    $role_id = Auth::user()->role_id;
@endphp

@if ($role_id == 2 && Request::segment(2) != 'partner')
    @include('business.components.settings-statusbar')
@endif
