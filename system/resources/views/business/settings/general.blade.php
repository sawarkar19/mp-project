@extends('layouts.app')
@push('style')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap-colorpicker.min.css') }}">
<link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" />
@endpush
@section('head')
@include('layouts.partials.headersection',['title'=>'Shop Settings'])
@endsection
@section('content')
<div class="row">
    <div class="col-12 col-sm-12 col-lg-12">
        <div class="card">
          <div class="card-header">
            <h4>{{ __('Settings') }}</h4>
        </div>
        <div class="card-body">
            <div class="row">
              <div class="col-12 col-sm-12 col-md-4">
                <ul class="nav nav-pills flex-column" id="myTab4" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active show" id="home-tab4" data-toggle="tab" href="#home4" role="tab" aria-controls="home" aria-selected="true">General</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="profile-tab4" data-toggle="tab" href="#profile4" role="tab" aria-controls="profile" aria-selected="false">Location</a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link" id="contact-tab4" data-toggle="tab" href="#contact4" role="tab" aria-controls="contact" aria-selected="false">Other</a>
                </li>
            </ul>
        </div>
        <div class="col-12 col-sm-12 col-md-8">
            <div class="tab-content no-padding" id="myTab2Content">
              <div class="tab-pane fade active show" id="home4" role="tabpanel" aria-labelledby="home-tab4">
                 <form method="post" action="{{ route('seller.settings.store') }}" class="basicform">
                     @csrf
                     <input type="hidden" name="type" value="general">
                     <div class="form-group">
                         <label>Store Name</label>   
                         <input type="text" name="shop_name" class="form-control" required="" value="{{ $shop_name->value ?? '' }}">     
                     </div>
                       
                     <div class="form-group">
                         <label>Store Description</label>   
                         <textarea class="form-control" required="" name="shop_description">{{ $shop_description->value ?? '' }}</textarea>
                     </div>
                     <div class="form-group">
                         <label>Notification & Reply-to Email</label>   
                         <input type="email" name="store_email" class="form-control" required="" placeholder="reply@example.com" value="{{ $store_email->value ?? '' }}">     
                     </div>

                     <div class="form-group">
                         <label>Order ID Format (Prefix)</label>   
                         <input type="text" name="order_prefix" class="form-control" required="" placeholder="#ABC" value="{{ $order_prefix->value ?? ''  }}">     
                     </div>
                     <div class="form-group">
                         <label>Currency Position</label>   
                         <select class="form-control" name="currency_position">
                            @if(!empty($currency))
                             <option value="left" @if($currency->currency_position  == 'left') selected="" @endif>Left</option>
                             <option value="right" @if($currency->currency_position  == 'right') selected="" @endif>Right</option>
                             @else
                             <option value="left" >Left</option>
                             <option value="right" >Right</option>
                             @endif
                         </select>     
                     </div>
                     <div class="form-group">
                         <label>Currency Name</label>   
                         <input type="text" name="currency_name" class="form-control" required="" placeholder="USD" value="{{ $currency->currency_name ?? '' }}">     
                     </div>
                     <div class="form-group">
                         <label>Currency Icon</label>   
                         <input type="text" name="currency_icon" class="form-control" required="" placeholder="$" value="{{ $currency->currency_icon ?? '' }}">     
                     </div>
                     <div class="form-group">
                        <label>GST ( % )</label>   
                       <input type="text" name="tax" class="form-control" required="" placeholder="0.00" value="{{ $tax->value ?? '' }}">     
                     </div>
					 <div class="form-group">
                        <label>GST Registration No. </label>   
                       <input type="text" name="gst_code" class="form-control" placeholder="GST Code" value="{{ $gst_code->value ?? '' }}">     
                     </div>

					 <div class="form-group">
                        <label>HSN Code </label>   
                       <input type="text" name="hsn_code" class="form-control" placeholder="HSN" value="{{ $hsn_code->value ?? '' }}">     
                     </div>

                     <div class="form-group">
                        <label>{{ __('I will sale (shop type)') }}</label> 
                        @php
                        $shop_type=domain_info('shop_type');
                        @endphp  
                       <select class="form-control" name="shop_type">
                           <option value="1" @if($shop_type == 1) selected="selected" @endif>{{ __('I will sale physical products') }}</option>
                           <option value="0" @if($shop_type == 0) selected="selected" @endif>{{ __('I will sale digital products') }}</option>
                       </select>
                     </div>

                      <div class="form-group">
                         <label>Languages</label>   
                         
                         <select class="form-control select2 col-sm-12" name="lanugage[]" multiple="">
                            @foreach($langlist ?? [] as $key => $row)

                             <option value="{{ $row }},{{ $key }}" @if(in_array($row, $my_languages)) selected="" @endif>{{ $key }}</option>
                             @endforeach
                         </select>  
                      </div>
                       <div class="form-group">
                         <label>Default Language</label>   
                         
                         <select class="form-control col-sm-12" name="local">
                            @foreach($langlist ?? [] as $key => $row)

                             <option value="{{ $key }}" @if($row == $local) selected="" @endif>{{ $row }}</option>
                             @endforeach
                         </select>  
                      </div>

                     <div class="form-group">
                         <button class="btn btn-primary  col-3 basicbtn" type="submit">Save</button> 
                     </div>
                 </form>

             </div>
             <div class="tab-pane fade" id="profile4" role="tabpanel" aria-labelledby="profile-tab4">
                <form method="post" action="{{ route('seller.settings.store') }}" class="basicform">
                    @csrf
                    <input type="hidden" name="type" value="location">
                <div class="form-group">
                    <label>Company</label>
                    <input class="form-control" name="company_name" value="{{ $location->company_name ?? '' }}" type="text" value="" required="">
                </div>
                <div class="form-group">
                    <label>Address</label>
                    <input class="form-control" name="address" value="{{ $location->address ?? '' }}" type="text" value="" required="">
                </div>
                
                <div class="form-group">
                    <label>City</label>
                    <input class="form-control" name="city" value="{{ $location->city ?? '' }}" type="text" value="" required="">
                </div>
                <div class="form-row">
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label>State</label>
                            <input class="form-control" name="state" value="{{ $location->state ?? '' }}" type="text" required="">
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group">
                            <label>Postal / Zip Code</label>
                            <input class="form-control" name="zip_code" value="{{ $location->zip_code ?? '' }}" type="text" required="" placeholder="1234">
                        </div>
                    </div>
                </div>
                <hr>
                <div class="form-group">
                    <label>Email</label>
                    <input class="form-control" name="email" type="email" value="{{ $location->email ?? '' }}" value="" required="">
                </div>
                <div class="form-group">
                    <label>Phone</label>
                    <input class="form-control" name="phone" type="number" value="{{ $location->phone ?? '' }}" value="" required="">
                </div>
                <div class="form-group">
                    <label>Invoice Description</label>
                    <textarea class="form-control" name="invoice_description">{{  $location->invoice_description ?? '' }}</textarea>
                </div>
                <div class="form-group">
                         <button class="btn btn-primary float-right col-3 basicbtn" type="submit">Save</button> 
                     </div>
                 </form>    
            </div>

           


            <div class="tab-pane fade" id="contact4" role="tabpanel" aria-labelledby="contact-tab4">
                <form method="post" action="{{ route('seller.settings.store') }}" class="basicform" enctype="multipart/form-data">
                    <input type="hidden" name="type" value="theme_settings">
                   @csrf
                    <div class="form-group">
                         <label>Theme Color</label>    
                         <input type="text" name="theme_color" class="form-control rgcolorpicker" required="" value="{{ $theme_color->value ?? '' }}"> 
                    </div>
                     

                    <div class="form-group">
                         <label>Logo <span style="color: #f00;">( Recommend PNG image of size: 160 X 100 pixels )</span> </label>    
                         <input type="file" name="logo" accept="image/*" class="form-control">  
                    </div> 
                    <div class="form-group">
                         <label>Favicon <span style="color: #f00;">( Recommend ICO image of size: 32 X 32 / 64 X 64 pixels )</span></label>    
                         <input type="file" name="favicon" accept="image/*" class="form-control">  
                    </div> 

                    <label>Social Links</label>
                <table class="table table-bordered table-striped" id="user_table">
                 <thead>
                    <tr>
                        <th width="35%">Url</th>
                        <th width="35%">Icon Class (<a href="https://fontawesome.com/" target="_blank">fontawesome</a>)</th>
                        <th width="30%"><button  type="button" name="add" id="add" class="btn btn-success btn-sm">Add New</button></th>
                    </tr>
                </thead>
                <tbody>

                    @foreach($socials ?? [] as $key => $row)

                    <tr>
                        <td><input type="text" name="url[]" class="form-control" required value="{{ $row->url }}" /></td>
                        <td><input type="text" name="icon[]" class="form-control" placeholder="fa fa-facebook" required value="{{ $row->icon }}" /></td>
                        <td><button type="button" name="remove" id="" class="btn btn-danger remove">Remove</button></td>
                    </tr>
                   
                    @endforeach

                </tbody>

            </table> 
                    <div class="form-group">
                         <button class="btn btn-primary float-right col-3 basicbtn" type="submit">Save</button> 
                     </div>  
               </form>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
</div>

@endsection
@push('js')
<script src="{{ asset('assets/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/form.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap-colorpicker.min.js') }}"></script>
<script src="{{ asset('assets/js/color.js') }}"></script>
@endpush