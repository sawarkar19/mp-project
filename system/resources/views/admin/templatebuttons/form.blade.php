<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Name') }}<span class="is_required">*</span></label>
    <div class="col-sm-12 col-md-7">
        @empty($templateButtons->template_id)
            {!! Form::hidden('template_id', $template_id) !!}
        @else
            {!! Form::hidden('template_id', $template_id) !!}
        @endempty
        
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Link') }}<span class="is_required">*</span></label>
    <div class="col-sm-12 col-md-7">
        {!! Form::text('link', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Button Text Color') }}<span class="is_required">*</span></label>
    <div class="col-sm-12 col-md-7">
        {!! Form::text('btn_text_color', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Button Style Color') }}</label>
    <div class="col-sm-12 col-md-7">
        {!! Form::text('btn_style_color', null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Button Style Type') }} <span class="is_required">*</span></label>
    <div class="col-sm-12 col-md-7">
        {!! Form::select('btn_style_type',array( 'Background' => 'Background', 'Border' => 'Border'), null, ['class' =>
        'form-control']) !!}
    </div>
</div>

<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Is Hidden') }}</label>
    <div class="col-sm-12 col-md-7">
        {!! Form::select('is_hidden',array( '1' => 'Yes', '0' => 'No'), null, ['class' =>
        'form-control']) !!}
    </div>
</div>

<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Is Removed') }}</label>
    <div class="col-sm-12 col-md-7">
        {!! Form::select('is_removed',array( '1' => 'Yes', '0' => 'No'), null, ['class' =>
        'form-control']) !!}
    </div>
</div>

<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
    <div class="col-sm-12 col-md-7">
        @empty($templateButtons)
            <button class="btn btn-primary basicbtn" type="submit">{{ __('Save Template Button') }}</button>
        @else
            <button class="btn btn-primary basicbtn" type="submit">{{ __('Update Template Button') }}</button>
        @endempty
    </div>
</div>
