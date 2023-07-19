@extends('layouts.admin')
@section('title', 'Admin: System Environment Settings')
@section('head')
@include('layouts.partials.headersection',['title'=>'System Environment Settings'])
@endsection
@section('start_body')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap-colorpicker.min.css') }}">
@endsection
@section('content')

<div class="row">
	<div class="col-sm-12">
		<div class="card">
			<div class="card-header">
				<h4>Note : <span class="text-danger">{{ __('Dont Use Any Kind Of Space In The Input Fields') }}</span></h4>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-12 col-sm-12 col-md-4">
						<ul class="nav nav-pills flex-column" id="myTab4" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" id="home-tab4" data-toggle="tab" href="#home4" role="tab" aria-controls="home" aria-selected="true">{{ __('App') }}</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="contact-tab4" data-toggle="tab" href="#mail_configuration" role="tab" aria-controls="driver" aria-selected="false">{{ __('Mail Configuration') }}</a>
							</li>

							<li class="nav-item">
								<a class="nav-link" id="contact-tab4" data-toggle="tab" href="#recaptcha" role="tab" aria-controls="driver" aria-selected="false">{{ __('Google Recaptcha') }}</a>
							</li>

							<li class="nav-item">
								<a class="nav-link" id="profile-tab4" data-toggle="tab" href="#profile4" role="tab" aria-controls="profile" aria-selected="false">{{ __('Channel') }}</a>
							</li>
							
							<li class="nav-item">
								<a class="nav-link" id="contact-tab4" data-toggle="tab" href="#driver" role="tab" aria-controls="driver" aria-selected="false">{{ __('Drivers') }}</a>
							</li>

							<li class="nav-item">
								<a class="nav-link" id="contact-tab4" data-toggle="tab" href="#redis" role="tab" aria-controls="driver" aria-selected="false">{{ __('Redis') }}</a>
							</li>

							<li class="nav-item">
								<a class="nav-link" id="contact-tab4" data-toggle="tab" href="#other" role="tab" aria-controls="driver" aria-selected="false">{{ __('Others') }}</a>
							</li>

							


						</ul>
					</div>

					<div class="col-12 col-sm-12 col-md-8">
							<form method="post" class="basicform" action="{{ route('admin.env.update') }}">
								@csrf
						<div class="tab-content no-padding" id="myTab2Content">
							<div class="tab-pane fade show active" id="home4" role="tabpanel" aria-labelledby="home-tab4">

								<div class="form-group">
									<label>{{ __('APP_NAME') }}</label>
									<input type="text" required="" name="APP_NAME" class="form-control" value="{{ env('APP_NAME') }}">
								</div>
								<div class="form-group">
									<label>{{ __('APP_ENV') }}</label>
									<input type="text" required="" name="APP_ENV" class="form-control" value="{{ env('APP_ENV') }}">
								</div>
								<div class="form-group">
									<label>{{ __('APP_KEY') }}</label>
									<input type="text" required="" name="APP_KEY" class="form-control" value="{{ env('APP_KEY') }}" readonly="">
								</div>
								<div class="form-group">
									<label>{{ __('APP_DEBUG') }}</label>
									<select class="form-control" name="APP_DEBUG">
										<option value="true" @if(env('APP_DEBUG') == true) selected="" @endif>true (Developers Only)</option>
										<option value="false" @if(env('APP_DEBUG') == false) selected="" @endif>false</option>
									</select>
								</div>
								<div class="form-group">
									<label>{{ __('APP_URL') }}</label>
									<input type="text" required="" name="APP_URL" class="form-control" value="{{ env('APP_URL') }}">
								</div>
								<div class="form-group">
									<label>{{ __('APP_PROTOCOLESS_URL') }}</label>
									<input type="text" required="" name="APP_PROTOCOLESS_URL" class="form-control" value="{{ env('APP_PROTOCOLESS_URL') }}">
								</div>
								<div class="form-group">
									<label>{{ __('APP_PROTOCOL') }}</label>
									<select class="form-control" name="APP_PROTOCOL">
										<option value="https://" @if(env('APP_PROTOCOL') == 'https://') selected @endif>https://</option>
										<option value="http://" @if(env('APP_PROTOCOL') == 'http://') selected @endif>http://</option>
									</select>
								</div>
								<div class="form-group">
									<label>{{ __('MULTILEVEL CUSTOMER REGISTER') }}</label>
									<select class="form-control" name="MULTILEVEL_CUSTOMER_REGISTER">
										<option value="true" @if(env('MULTILEVEL_CUSTOMER_REGISTER') == true) selected @endif>true</option>
										<option value="false" @if(env('MULTILEVEL_CUSTOMER_REGISTER') == false) selected @endif>false</option>
									</select>
								</div>
								

							</div>
							<div class="tab-pane fade" id="profile4" role="tabpanel" aria-labelledby="profile-tab4">
								<div class="form-group">
								<label>{{ __('LOG_CHANNEL') }}</label>
								<input type="text" required="" name="LOG_CHANNEL" class="form-control" value="{{ env('LOG_CHANNEL') }}">
							    </div>
							    <div class="form-group">
								<label>{{ __('LOG_LEVEL') }}</label>
								<input type="text" required="" name="LOG_LEVEL" class="form-control" value="{{ env('LOG_LEVEL') }}">
							    </div>
							</div>

							<div class="tab-pane fade" id="contact4" role="tabpanel" aria-labelledby="contact-tab4">

								<div class="form-group">
									<label>{{ __('DB_CONNECTION') }}</label>
									<input type="text" required="" name="DB_CONNECTION" class="form-control" value="{{ env('DB_CONNECTION') }}" readonly="">
								</div>
								<div class="form-group">
									<label>{{ __('DB_HOST') }}</label>
									<input type="text" required="" name="DB_HOST" class="form-control" value="{{ env('DB_HOST') }}" readonly="">
								</div>
								<div class="form-group">
									<label>{{ __('DB_PORT') }}</label>
									<input type="text" required="" name="DB_PORT" class="form-control" value="{{ env('DB_PORT') }}" readonly="">
								</div>
								<div class="form-group">
									<label>{{ __('DB_DATABASE') }}</label>
									<input type="text" required="" name="DB_DATABASE" class="form-control" value="{{ env('DB_DATABASE') }}" readonly="">
								</div>
								<div class="form-group">
									<label>{{ __('DB_USERNAME') }}</label>
									<input type="text" required="" name="DB_USERNAME" class="form-control" value="{{ env('DB_USERNAME') }}" readonly="">
								</div>
								<div class="form-group">
									<label>{{ __('DB_PASSWORD') }}</label>
									<input type="text"  name="DB_PASSWORD" class="form-control" value="{{ env('DB_PASSWORD') }}" readonly="">
								</div>
								
							</div>

							<div class="tab-pane fade" id="driver" role="tabpanel" aria-labelledby="profile-tab4">

								<div class="form-group">	
									<label>{{ __('BROADCAST_DRIVER') }}</label>
									<input type="text" required="" name="BROADCAST_DRIVER" class="form-control" value="{{ env('BROADCAST_DRIVER') }}">
								</div>
								<div class="form-group">
									<label>{{ __('CACHE_DRIVER') }}</label>
									<input type="text" required="" name="CACHE_DRIVER" class="form-control" value="{{ env('CACHE_DRIVER') }}">
								</div>
								<div class="form-group">
									<label>{{ __('QUEUE_CONNECTION') }}</label>
									<input type="text" required="" name="QUEUE_CONNECTION" class="form-control" value="{{ env('QUEUE_CONNECTION') }}">
								</div>
								<div class="form-group">
									<label>{{ __('SESSION_DRIVER') }}</label>
									<input type="text" required="" name="SESSION_DRIVER" class="form-control" value="{{ env('SESSION_DRIVER') }}">
								</div>
								<div class="form-group">
									<label>{{ __('SESSION_LIFETIME') }}</label>
									<input type="text" required="" name="SESSION_LIFETIME" class="form-control" value="{{ env('SESSION_LIFETIME') }}">
								</div>
								
							</div>

							<div class="tab-pane fade" id="redis" role="tabpanel" aria-labelledby="profile-tab4">
								<div class="form-group">
									<label>{{ __('REDIS_HOST') }}</label>
									<input type="text" required=""  name="REDIS_HOST" class="form-control" value="{{ env('REDIS_HOST') }}">
								</div>
								<div class="form-group">
									<label>{{ __('REDIS_PASSWORD') }}</label>
									<input type="text"  name="REDIS_PASSWORD" class="form-control" value="{{ env('REDIS_PASSWORD') }}">
								</div>
								<div class="form-group">
									<label>{{ __('REDIS_PORT') }}</label>
									<input type="text"  name="REDIS_PORT" class="form-control" value="{{ env('REDIS_PORT') }}">
								</div>
							</div>


							<div class="tab-pane fade" id="recaptcha" role="tabpanel" aria-labelledby="profile-tab4">
								<h6>Google Recaptcha V2</h6>
								<div class="form-group">
									<label>{{ __('NOCAPTCHA_SECRET') }}</label>
									<input type="text"  name="NOCAPTCHA_SECRET" class="form-control" value="{{ env('NOCAPTCHA_SECRET') }}">
								</div>
								<div class="form-group">
									<label>{{ __('NOCAPTCHA_SITEKEY') }}</label>
									<input type="text"  name="NOCAPTCHA_SITEKEY" class="form-control" value="{{ env('NOCAPTCHA_SITEKEY') }}">
								</div>
								
							</div>

							<div class="tab-pane fade" id="mail_configuration" role="tabpanel" aria-labelledby="profile-tab4">
								<div class="form-group">
									<label>{{ __('QUEUE_MAIL') }}</label>
									<select name="QUEUE_MAIL" class="form-control">
										<option value="on" @if(env('QUEUE_MAIL')==='on') selected="" @endif>{{ __('On') }}</option>
										<option value="off" @if(env('QUEUE_MAIL')==='off') selected="" @endif>{{ __('Off') }}</option>
									</select>
								</div>

								<div class="form-group">
									<label>{{ __('MAIL_DRIVER') }}</label>
									<input type="text" required=""  name="MAIL_MAILER" class="form-control" value="{{ env('MAIL_MAILER') }}">
								</div>
								<div class="form-group">
									<label>{{ __('MAIL_HOST') }}</label>
									<input type="text" required=""  name="MAIL_HOST" class="form-control" value="{{ env('MAIL_HOST') }}">
								</div>

								<div class="form-group">
									<label>{{ __('MAIL_PORT') }}</label>
									<input type="text" required=""  name="MAIL_PORT" class="form-control" value="{{ env('MAIL_PORT') }}">
								</div>
								<div class="form-group">
									<label>{{ __('MAIL_USERNAME') }}</label>
									<input type="text" required=""  name="MAIL_USERNAME" class="form-control" value="{{ env('MAIL_USERNAME') }}">
								</div>
								<div class="form-group">
									<label>{{ __('MAIL_PASSWORD') }}</label>
									<input type="text" required=""  name="MAIL_PASSWORD" class="form-control" value="{{ env('MAIL_PASSWORD') }}">
								</div>
								<div class="form-group">
									<label>{{ __('MAIL_ENCRYPTION') }}</label>
									<input type="text" required=""  name="MAIL_ENCRYPTION" class="form-control" value="{{ env('MAIL_ENCRYPTION') }}">
								</div>
								<div class="form-group">
									<label>{{ __('MAIL_FROM_ADDRESS') }}</label>
									<input type="text" required=""  name="MAIL_FROM_ADDRESS" class="form-control" value="{{ env('MAIL_FROM_ADDRESS') }}">
								</div>

								<div class="form-group">
									<label>{{ __('INCOMING MAIL ALSO ORDER') }}</label>
									<input type="text" required=""  name="MAIL_TO" class="form-control" value="{{ env('MAIL_TO') }}">
								</div>

								<div class="form-group">
									<label>{{ __('NO REPLY MAIL ADDRESS FOR SELLER') }}</label>
									<input type="email" required=""  name="MAIL_NOREPLY" class="form-control" value="{{ env('MAIL_NOREPLY') }}">
								</div>

								<div class="form-group">
									<label>{{ __('MAIL_FROM_NAME') }}</label>
									<input type="text" required=""  name="MAIL_FROM_NAME" class="form-control" value="{{ env('MAIL_FROM_NAME') }}">
								</div>

								<span>Note : <span class="text-danger">{{ __('If you are using MAIL QUEUE after Changing The Mail Settings You Need To Restart Your Supervisor From Your Server') }}</span></span><br>

								<span>QUEUE COMMAND Path : <span class="text-danger">{{ base_path() }}</span></span><br>
								<span>QUEUE COMMAND : <span class="text-danger">{{ __('php artisan queue:work') }}</span></span>
							</div>


							<div class="tab-pane fade" id="other" role="tabpanel" aria-labelledby="profile-tab4">
								<div class="">
                                    <div class="form-group">
                                        <label for="BROADCAST_DRIVER">BROADCAST_DRIVER</label>
                                        <input type="text" name="BROADCAST_DRIVER" id="BROADCAST_DRIVER" value="{{ env("BROADCAST_DRIVER") }}" class="form-control">
                                    </div>
                
                                    <div class="form-group">
                                        <label for="CACHE_DRIVER">CACHE_DRIVER</label>
                                        <input type="text" name="CACHE_DRIVER" id="CACHE_DRIVER" value="{{ env("CACHE_DRIVER") }}" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="QUEUE_CONNECTION">QUEUE_CONNECTION</label>
                                        <input type="text" name="QUEUE_CONNECTION" id="QUEUE_CONNECTION" value="{{ env("QUEUE_CONNECTION") }}" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="SESSION_DRIVER">SESSION_DRIVER</label>
                                        <input type="text" name="SESSION_DRIVER" id="SESSION_DRIVER" value="{{ env("SESSION_DRIVER") }}" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="SESSION_LIFETIME">SESSION_LIFETIME</label>
                                        <input type="text" name="SESSION_LIFETIME" id="SESSION_LIFETIME" value="{{ env("SESSION_LIFETIME") }}" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="REDIS_HOST">REDIS_HOST</label>
                                        <input type="text" name="REDIS_HOST" id="REDIS_HOST" value="{{ env("REDIS_HOST") }}" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="REDIS_PASSWORD">REDIS_PASSWORD</label>
                                        <input type="text" name="REDIS_PASSWORD" id="REDIS_PASSWORD" value="{{ env("REDIS_PASSWORD") }}" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="REDIS_PORT">REDIS_PORT</label>
                                        <input type="text" name="REDIS_PORT" id="REDIS_PORT" value="{{ env("REDIS_PORT") }}" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="TIMEZONE">TIMEZONE</label>
                                        <select class="custom-select mr-sm-2" name="TIMEZONE" id="TIMEZONE" >
                                            @foreach($timezones as $timezone)
                                            <option value="{{ $timezone['key'] }}" @if(env('DEFAULT_LANG')==$timezone['key']) selected @endif>{{ $timezone['value'] }}</option>
                                            @endforeach
                                 
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="lang">Default Language</label>
                                        <select class="form-control" name="DEFAULT_LANG" id="lang">
                                            @foreach($countries as $country)
                                            <option value="{{ $country['code'] }}" @if(env('DEFAULT_LANG')==$country['code']) selected @endif>{{ $country['name'] }} ({{ $country['nativeName'] }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
							</div>

							<div class="form-group">
								<button class="btn btn-primary basicbtn" type="submit">{{ __('Update') }}</button>
							</div>
						</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('end_body')
<script src="{{ asset('assets/js/form.js') }}"></script>
<script type="text/javascript">
(function ($) {
	"use strict"

	$('#TIMEZONE').val('{{ env('TIMEZONE') }}')

})(jQuery); 
</script>
@endsection

