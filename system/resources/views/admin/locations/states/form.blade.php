<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Name') }}</label>
    <div class="col-sm-12 col-md-7">
        {!! Form::text('name', null, array('class' => 'form-control', 'required')) !!}
    </div>
</div>
<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Latitude') }}</label>
    <div class="col-sm-12 col-md-7">
        {!! Form::text('lat', null, array('class' => 'form-control', 'required')) !!}
    </div>
</div>
<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Longitude') }}</label>
    <div class="col-sm-12 col-md-7">
        {!! Form::text('lng', null, array('class' => 'form-control', 'required')) !!}
    </div>
</div>
@empty($states)
    {!! Form::hidden('status', '0') !!}
@else
    @if($states->status == 1)
        {!! Form::hidden('status', '1') !!}
    @else
        {!! Form::hidden('status', '0') !!}
    @endif
@endempty
<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
    <div class="col-sm-12 col-md-7">
        @empty($states)
            <button class="btn btn-primary basicbtn" type="submit">{{ __('Save') }}</button>
        @else
            <button class="btn btn-primary basicbtn" type="submit">{{ __('Update') }}</button>
        @endempty
    </div>
</div>

