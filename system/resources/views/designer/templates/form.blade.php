<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Name') }} <span class="is_required">*</span></label>
    <div class="col-sm-12 col-md-7">
        {!! Form::text('name', null, array('class' => 'form-control', 'required')) !!}
    </div>
</div>

<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Select Thumbnail Image') }} <span class="is_required">*</span></label>
    <div class="col-sm-12 col-md-7">
        {!! Form::file('thumbnail', null, array('class' => 'form-control', 'required')) !!}
        <br>
        @empty($templates->thumbnail)
        @else
        <img src="{{asset('assets/' .$templates->thumbnail) }}" style="max-height: 200px" class="img-fluid border" id="main_img_preview" alt="">
        @endempty    
    </div>
</div>

<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Background Image') }} <span class="is_required">*</span></label>
    <div class="col-sm-12 col-md-7">
        {!! Form::file('bg_image', null, array('class' => 'form-control')) !!}
        <br>
        @empty($templates->bg_image)
        @else
        <img src="{{ asset('assets/templates/'.$templates->id.'/'.$templates->bg_image) }}" style="max-height: 200px" class="img-fluid border" id="bi_preview" alt="">
        @endempty
    </div>
</div>

<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Background Color') }} <span class="is_required">*</span></label>
    <div class="col-sm-12 col-md-7">
        {!! Form::text('bg_color', null, array('class' => 'form-control')) !!}
    </div>
</div>

<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Default Color') }} <span class="is_required">*</span></label>
    <div class="col-sm-12 col-md-7">
        {!! Form::text('default_color', null, array('class' => 'form-control')) !!}
    </div>
</div>

<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Business Name Color') }} <span class="is_required">*</span></label>
    <div class="col-sm-12 col-md-7">
        {!! Form::text('business_name_color', null, array('class' => 'form-control')) !!}
    </div>
</div>

<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Tag Line Color') }} <span class="is_required">*</span></label>
    <div class="col-sm-12 col-md-7">
        {!! Form::text('tag_line_color', null, array('class' => 'form-control')) !!}
    </div>
</div>

<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Banner Image') }} <span class="is_required">*</span></label>
    <div class="col-sm-12 col-md-7">
        {!! Form::file('hero_image', null, array('class' => 'form-control', 'required')) !!}
        <br>
        @empty($templates->hero_image)
        @else
        <img src="{{ asset('assets/templates/'.$templates->id.'/'.$templates->hero_image) }}" style="max-height: 200px" class="img-fluid border" id="main_img_preview" alt="">
        @endempty
    </div>
</div>
{{-- <div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Hero Title') }} <span class="is_required">*</span></label>
    <div class="col-sm-12 col-md-7">
        {!! Form::text('hero_title', null, array('class' => 'form-control', 'required')) !!}
    </div>
</div> --}}

{{-- <div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Hero Title Color') }} <span class="is_required">*</span></label>
    <div class="col-sm-12 col-md-7">
        {!! Form::text('hero_title_color', null, array('class' => 'form-control')) !!}
    </div>
</div> --}}

{{-- <div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Hero Text Content') }} <span class="is_required">*</span></label>
    <div class="col-sm-12 col-md-7">
        {!! Form::textarea('hero_text', null, array('class' => 'form-control')) !!}
    </div>
</div> --}}

{{-- <div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Hero Text Color') }} <span class="is_required">*</span></label>
    <div class="col-sm-12 col-md-7">
        {!! Form::text('hero_text_color', null, array('class' => 'form-control')) !!}
    </div>
</div> --}}

<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Video Url') }}</label>
    <div class="col-sm-12 col-md-7">
        {!! Form::text('video_url', null, array('class' => 'form-control')) !!}
    </div>
</div>

<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Video Autoplay') }} <span class="is_required">*</span></label>
    <div class="col-sm-12 col-md-7">
        {!! Form::select('video_autoplay',array( '1' => 'Yes', '0' => 'No'), null, ['class' =>
        'form-control']) !!}
    </div>
</div>

{{-- <div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Heading Content') }} <span class="is_required">*</span></label>
    <div class="col-sm-12 col-md-7">
        {!! Form::text('extra_heading_1', null, array('class' => 'form-control')) !!}
    </div>
</div> --}}

{{-- <div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Heading Color') }} <span class="is_required">*</span></label>
    <div class="col-sm-12 col-md-7">
        {!! Form::text('extra_heading_1_color', null, array('class' => 'form-control')) !!}
    </div>
</div> --}}

{{-- <div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Text Content') }}</label>
    <div class="col-sm-12 col-md-7">
        {!! Form::textarea('extra_text_1', null, array('class' => 'form-control')) !!}
    </div>
</div> --}}

{{-- <div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Text Content Color') }}</label>
    <div class="col-sm-12 col-md-7">
        {!! Form::text('extra_text_1_color', null, array('class' => 'form-control')) !!}
    </div>
</div> --}}

<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Contact Icons Color') }} <span class="is_required">*</span></label>
    <div class="col-sm-12 col-md-7">
        {!! Form::text('contact_icon_color', null, array('class' => 'form-control', 'required')) !!}
    </div>
</div>

<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Whatsapp Icon Color') }} <span class="is_required">*</span></label>
    <div class="col-sm-12 col-md-7">
        {!! Form::text('whatsapp_icon_color', null, array('class' => 'form-control', 'required')) !!}
    </div>
</div>

<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Location Icons Color') }} <span class="is_required">*</span></label>
    <div class="col-sm-12 col-md-7">
        {!! Form::text('location_icon_color', null, array('class' => 'form-control', 'required')) !!}
    </div>
</div>

<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Website Icons Color') }} <span class="is_required">*</span></label>
    <div class="col-sm-12 col-md-7">
        {!! Form::text('website_icon_color', null, array('class' => 'form-control', 'required')) !!}
    </div>
</div>

<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Upload Css File') }} <span class="is_required">*</span></label>
    <div class="col-sm-12 col-md-7">
        {!! Form::file('template_style', null, array('class' => 'form-control', 'required')) !!}
        <br>
        @empty($templates->template_style)
        @else
        <img src="{{ asset('assets/templates/'.$templates->id.'/'.$templates->template_style) }}" style="max-height: 200px" class="img-fluid border" id="bi_preview" alt="">
        @endempty    
    </div>
</div>

<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Upload Logo') }} <span class="is_required">*</span></label>
    <div class="col-sm-12 col-md-7">
        {!! Form::file('logo', null, array('class' => 'form-control', 'required')) !!}
        <br>
        @empty($templates->logo)
        @else
        <img src="{{ asset('assets/templates/'.$templates->id.'/'.$templates->logo) }}" style="max-height: 200px" class="img-fluid border" id="bi_preview" alt="">
        @endempty
    </div>
</div>

<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Template Type') }} <span class="is_required">*</span></label>
    <div class="col-sm-12 col-md-7">
        {!! Form::select('template_type',array( 'banner' => 'banner', 'video' => 'video'), null, ['class' =>
        'form-control', 'required']) !!}
    </div>
</div>

<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Is Free') }} <span class="is_required">*</span></label>
    <div class="col-sm-12 col-md-7">
        {!! Form::select('is_free',array( '1' => 'Yes', '0' => 'No'), null, ['class' =>
        'form-control', 'required']) !!}
    </div>
</div>

<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Business Type') }} <span class="is_required">*</span></label>
    <div class="col-sm-12 col-md-7">
        @empty($templates->business_type)
        {{ Form::select('business_type',$types, null,['class' => 'form-control', 'id' => 'business_type']) }}
        @else
        {{ Form::select('business_type',$types,$templates->business_type,['class' => 'form-control']) }}
        @endempty
    </div>
</div>

@empty($templates)
{!! Form::hidden('status', '0') !!}
@else
@if($templates->status == 1)
{!! Form::hidden('status', '1') !!}
@else
{!! Form::hidden('status', '0') !!}
@endif
@endempty
<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
    <div class="col-sm-12 col-md-7">
        @empty($templates)
        <button class="btn btn-primary basicbtn" type="submit">{{ __('Save Templates') }}</button>
        @else
        <button class="btn btn-primary basicbtn" type="submit">{{ __('Update Templates') }}</button>
        @endempty
    </div>
</div>