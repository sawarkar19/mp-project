
{!! Form::hidden('ordering') !!}
<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Name') }} <span class="is_required">*</span></label>
    <div class="col-sm-12 col-md-7">
        {!! Form::text('name', null, array('class' => 'form-control char-spcs-validation', 'required')) !!}
    </div>
</div>

<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Slug') }} <span class="is_required">*</span></label>
    <div class="col-sm-12 col-md-7">
        {!! Form::text('slug', null, array('class' => 'form-control char-spcs-validation', 'required')) !!}
    </div>
</div>

<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Short Description') }}</label>
    <div class="col-sm-12 col-md-7">
        {!! Form::textarea('short_description', null, array('class' => 'form-control char-spcs-validation')) !!}
    </div>
</div>

<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Description') }} <span class="is_required">*</span></label>
    <div class="col-sm-12 col-md-7">
        {!! Form::textarea('description', null, array('class' => 'form-control char-spcs-validation', 'required')) !!}
    </div>
</div>

<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Price') }} <span class="is_required">*</span></label>
    <div class="col-sm-12 col-md-7">
        {!! Form::tel('price', null, array('class' => 'form-control number-validation', 'maxlength'=>'8', 'required')) !!}
    </div>
</div>

<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Icon') }}</label>
    <div class="col-sm-12 col-md-7">
        {!! Form::text('icon', null, array('class' => 'form-control char-spcs-validation')) !!}
    </div>
</div>

<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Font Icon') }}</label>
    <div class="col-sm-12 col-md-7">
        {!! Form::text('font_icon', null, array('class' => 'form-control char-spcs-validation')) !!}
    </div>
</div>

<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Route') }} <span class="is_required">*</span></label>
    <div class="col-sm-12 col-md-7">
        {!! Form::text('route', null, array('class' => 'form-control char-spcs-validation','required')) !!}
    </div>
</div>

<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Free Employee') }} <span class="is_required">*</span></label>
    <div class="col-sm-12 col-md-7">
        {!! Form::tel('free_employee', null, array('class' => 'form-control number-validation', 'maxlength'=>'8','required')) !!}
    </div>
</div>

<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Disabled') }} <span class="is_required">*</span></label>
    <div class="col-sm-12 col-md-7">
        {!! Form::select('disabled',array( '1' => 'Enable', '0' => 'Disable'), null, ['class' =>'form-control', 'required']) !!}
    </div>
</div>

<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Use Message') }} <span class="is_required">*</span></label>
    <div class="col-sm-12 col-md-7">
        {!! Form::select('is_use_msg',array( '1' => 'Yes', '0' => 'No'), null, ['class' =>'form-control']) !!}
    </div>
</div>

@empty($channels)
{!! Form::hidden('status', '0') !!}
@else
@if($channels->status == 1)
{!! Form::hidden('status', '1') !!}
@else
{!! Form::hidden('status', '0') !!}
@endif
@endempty
<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
    <div class="col-sm-12 col-md-7">
        @empty($channels)
        <button class="btn btn-primary basicbtn" type="submit">{{ __('Save Channel') }}</button>
        @else
        <button class="btn btn-primary basicbtn" type="submit">{{ __('Update Channel') }}</button>
        @endempty
    </div>
</div>