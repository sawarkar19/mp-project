{!! Form::hidden('ordering') !!}

<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Name') }} <span
            class="is_required">*</span></label>
    <div class="col-sm-12 col-md-7">
        {!! Form::text('name', null, ['class' => 'form-control char-spcs-validation', 'required']) !!}
    </div>
</div>

<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Slug') }} <span
            class="is_required">*</span></label>
    <div class="col-sm-12 col-md-7">
        {!! Form::text('slug', null, ['class' => 'form-control char-spcs-validation', 'required']) !!}
    </div>
</div>

<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __('Tag') }}</label>
    <div class="col-sm-12 col-md-7">
        {!! Form::text('tag', null, ['class' => 'form-control char-spcs-validation']) !!}
    </div>
</div>

<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ __(' Select Channel') }} <span
            class="is_required">*</span></label>
    <div class="col-sm-12 col-md-7">

        @empty($plangroup_id->channel_id)
            {{ Form::select('channel_id[]', $types, null, ['class' => 'form-control js-example-basic-single', 'multiple' => 'multiple', 'id' => 'channel_id']) }}
        @else
            {{ Form::select('channel_id[]', $types, $channel_ids, ['class' => 'form-control js-example-basic-single', 'required' => 'true', 'multiple' => 'true', 'id' => 'channel_id']) }}
            
        @endempty
    </div>
</div>

@empty($plangroups)
    {!! Form::hidden('status', '0') !!}
@else
    @if ($plangroups->status == 1)
        {!! Form::hidden('status', '1') !!}
    @else
        {!! Form::hidden('status', '0') !!}
    @endif
@endempty
<div class="form-group row mb-4">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
    <div class="col-sm-12 col-md-7">
        @empty($plangroups)
            <button class="btn btn-primary basicbtn" type="submit">{{ __('Save Plan Group') }}</button>
        @else
            <button class="btn btn-primary basicbtn" type="submit">{{ __('Update Plan Group') }}</button>
        @endempty
    </div>
</div>
