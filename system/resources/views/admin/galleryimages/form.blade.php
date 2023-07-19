
<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Title Name') }}</label>
    <div class="col-sm-12 col-md-7">
        

        @empty($gallery_imgs->template_id)
        {!!  Form::hidden('template_id',$template_id) !!}
        @else
        {!!  Form::hidden('template_id',$template_id) !!}
        @endempty

        {!! Form::text('title', null, array('class' => 'form-control')) !!}
    </div>
</div>

<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Select Image') }} <span class="is_required">*</span></label>
    <div class="col-sm-12 col-md-7">
        {!! Form::file('image_path', null, array('class' => 'form-control', 'required')) !!}
        <br>
        @empty($gallery_imgs->image_path)
        @else
        <img src="{{asset('assets/templates/'.$gallery_imgs->template_id.'/' .$gallery_imgs->image_path) }}" style="max-height: 100px" class="img-fluid border" id="main_img_preview" alt="">
        @endempty    
    </div>
</div>

<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Title Color') }}</label>
    <div class="col-sm-12 col-md-7">
        {!! Form::text('title_color', null, array('class' => 'form-control')) !!}
    </div>
</div>

<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Tag 1') }}</label>
    <div class="col-sm-12 col-md-4">
        {!! Form::text('tag_1', null, array('class' => 'form-control')) !!}
    </div>
    <div class="col-sm-12 col-md-5 align-self-center">
       {!! Form::label('Show Tag', 'Show Tag 1 :') !!}
       {!! Form::checkbox('show_tag_1', '1') !!}
    </div>
</div>

<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Tag 2') }}</label>
    <div class="col-sm-12 col-md-4">
        {!! Form::text('tag_2', null, array('class' => 'form-control')) !!}
    </div>
    <div class="col-sm-12 col-md-5 align-self-center">
        {!! Form::label('Show Tag', 'Show Tag 2 :') !!}
       {!! Form::checkbox('show_tag_2', '1') !!}
        
     </div>
</div>

<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Tag Background Color') }}</label>
    <div class="col-sm-12 col-md-7">
        {!! Form::text('tag_bg_color', null, array('class' => 'form-control')) !!}
    </div>
</div>


<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Sale Price') }}</label>
    <div class="col-sm-12 col-md-4">
        {!! Form::text('sale_price', null, array('class' => 'form-control')) !!}
    </div>
    <div class="col-sm-12 col-md-5 align-self-center">
        {!! Form::label('Show Sale Price', 'Show Sale Price :') !!}
       {!! Form::checkbox('show_sale_price', '1') !!}
        
     </div>
</div>

<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Price') }}</label>
    <div class="col-sm-12 col-md-4">
        {!! Form::text('price', null, array('class' => 'form-control')) !!}
    </div>
    <div class="col-sm-12 col-md-5 align-self-center">
        {!! Form::label('Show Price', 'Show Price :') !!}
       {!! Form::checkbox('show_price', '1') !!}
        
     </div>
</div>

<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
    <div class="col-sm-12 col-md-7">
        @empty($gallery_imgs)
        <button class="btn btn-primary basicbtn" type="submit">{{ __('Save Gallery') }}</button>
        @else
        <button class="btn btn-primary basicbtn" type="submit">{{ __('Update Gallery') }}</button>
        @endempty
    </div>
</div>