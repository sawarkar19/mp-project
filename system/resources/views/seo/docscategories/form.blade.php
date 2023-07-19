
{{--  {!! Form::hidden('ordering') !!}  --}}
<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Name') }} <span class="is_required">*</span></label>
    <div class="col-sm-12 col-md-7">
        {!! Form::text('name', null, array('class' => 'form-control char-spcs-validation', 'required')) !!}
    </div>
</div>

{{--  <div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Short Description') }}</label>
    <div class="col-sm-12 col-md-7">
        {!! Form::textarea('short_description', null, array('class' => 'form-control char-spcs-validation')) !!}
    </div>
</div>  --}}


<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Status') }}</label>
    <div class="col-sm-12 col-md-7">
        {!! Form::select('status',array( '1' => 'Active', '0' => 'Inactive'), null, ['class' =>'form-control']) !!}
    </div>
</div>

@empty($docscategories)
@else
<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Ordering') }}</label>
    <div class="col-sm-12 col-md-7">
        {!! Form::text('ordering', null, array('class' => 'form-control number-validation', 'maxlength'=>'8')) !!}
    </div>
</div>
@endempty


<div class="form-group row mb-4">
    <label for="site-title" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Meta Title</label>
    <div class="col-sm-12 col-md-7">
        {{-- <input type="text" name="meta_title" class="form-control" value=""> --}}
        {!! Form::text('meta_title', null, array('class' => 'form-control')) !!}
    </div>
</div>
<div class="form-group row mb-4">
    <label for="description" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Meta Description</label>
    <div class="col-sm-12 col-md-7">
        {{-- <textarea class="form-control" name="meta_description">{{ $settings->meta_description }}</textarea> --}}
        {!! Form::textarea('meta_description', null, array('class' => 'form-control')) !!}
    </div>
</div>
<div class="form-group row mb-4">
    <label for="site-title" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Meta Keywords</label>
    <div class="col-sm-12 col-md-7">
        {{-- <input type="text" name="meta_keywords" class="form-control" value="{{ $settings->meta_keywords }}"> --}}
        {!! Form::text('meta_keywords', null, array('class' => 'form-control')) !!}
    </div>
</div>



<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
    <div class="col-sm-12 col-md-7">
        @empty($docscategories)
        <button class="btn btn-primary basicbtn" type="submit">{{ __('Save Document Category') }}</button>
        @else
        <button class="btn btn-primary basicbtn" type="submit">{{ __('Update Document Category') }}</button>
        @endempty
    </div>
</div>