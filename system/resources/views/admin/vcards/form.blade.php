<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Thumbnail Image') }} <span class="is_required">*</span></label>
    <div class="col-sm-12 col-md-7">
        {!! Form::file('thumbnail', null, array('class' => 'form-control', 'required')) !!}
        <br>
        @empty($vcards->thumbnail)
        @else
        <img src="{{asset('assets/business/vcards/' .$vcards->thumbnail) }}" style="max-height: 200px" class="img-fluid border" id="main_img_preview" alt="">
        @endempty    
    </div>
</div>

<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Default Card') }} <span class="is_required">*</span></label>
    <div class="col-sm-12 col-md-7">
        {!! Form::select('default_card',array( '1' => 'Yes', '0' => 'No'), null, ['class' =>
        'form-control']) !!}
    </div>
</div>

<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Status') }} <span class="is_required">*</span></label>
    <div class="col-sm-12 col-md-7">
        {!! Form::select('status',array( '1' => 'Yes', '0' => 'No'), null, ['class' =>
        'form-control']) !!}
    </div>
</div>



<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
    <div class="col-sm-12 col-md-7">
        @empty($vcards)
        <button class="btn btn-primary basicbtn" type="submit">{{ __('Save Vcard') }}</button>
        @else
        <button class="btn btn-primary basicbtn" type="submit">{{ __('Update Vcard') }}</button>
        @endempty
    </div>
</div>