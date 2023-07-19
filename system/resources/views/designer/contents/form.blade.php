<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Content Text') }} <span class="is_required">*</span></label>
    <div class="col-sm-12 col-md-7">
        @empty($contents->template_id)
            {!! Form::hidden('template_id', $template_id) !!}
        @else
            {!! Form::hidden('template_id', $template_id) !!}
        @endempty
        
        {!! Form::text('content', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Content Length') }} <span class="is_required">*</span></label>
    <div class="col-sm-12 col-md-7">
        {!! Form::tel('content_length', null, ['class' => 'form-control number-validation', 'maxlength' => '5']) !!}
    </div>
</div>

<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Content Color') }} <span class="is_required">*</span></label>
    <div class="col-sm-12 col-md-7">
        {!! Form::text('content_color', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
    <div class="col-sm-12 col-md-7">
        @empty($contents)
            <button class="btn btn-primary basicbtn" type="submit">{{ __('Save Content') }}</button>
        @else
            <button class="btn btn-primary basicbtn" type="submit">{{ __('Update Content') }}</button>
        @endempty
    </div>
</div>
