<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('State Name') }}</label>
    <div class="col-sm-12 col-md-7">
        @empty($cities->state_id)
            {{ Form::select('state_id',$states,null,['class' => 'form-control', 'id' => 'stateForCity']) }}
        @else
            {{ Form::select('state_id',$states,$cities->state_id,['class' => 'form-control']) }}
        @endempty
    </div>
</div>
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
@empty($cities)
    {!! Form::hidden('status', '0') !!}
@else
    @if($cities->status == 1)
        {!! Form::hidden('status', '1') !!}
    @else
        {!! Form::hidden('status', '0') !!}
    @endif
@endempty
<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
    <div class="col-sm-12 col-md-7">
        @empty($cities)
            <button class="btn btn-primary basicbtn" type="submit">{{ __('Save') }}</button>
        @else
            <button class="btn btn-primary basicbtn" type="submit">{{ __('Update') }}</button>
        @endempty
    </div>
</div>