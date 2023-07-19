@extends('layouts.business')
@section('title', 'Business: User Management')
@section('head')
@include('layouts.partials.headersection',['title'=>'User Management'])
@endsection
@section('end_head')
   
  <style>
    .search-user select{
      background-position: calc(100% - 20px) calc(100% - 11px);
    }
    @media(max-width:405px){
      .search-user select{
        font-size: 12px !important;
        background-position: calc(100% - 6px) calc(100% - 11px);
        padding: 4px !important;
      }
      .user-search-bar{
        padding: 4px !important;
      }
    }  
  </style>
@endsection

@section('content')

@if(count($planData['users']) > 0)
  {{-- <div class="col-12 mb-2">
    <div class="row">
        <p>
          {{ __('Note*') }} : <b class="text-danger">
            {{ __('You can create up to '.count($planData['users']).' User(s).') }}
          </b>  
        </p>
    </div>
  </div> --}}

@else

  {{-- <div class="col-12 mb-2">
    <div class="row">
        <p>
          {{ __('Note*') }} : <b class="text-danger">
            {{ __('You do not have any User purchased. Please Upgrade!') }}
          </b>  
        </p>
    </div>
  </div> --}}

@endif


<div class="mb-4">
    <div class="row justify-content-between">
      <div class="col-sm-8 col-lg-6 col-12">
        <form>
          <input type="hidden" name="type" value="@if($type === 0) trash @else {{ $type }} @endif">
          <div class="input-group search-user mb-2">

            <input type="text" id="src" class="form-control user-search-bar" placeholder="Search..." name="src" autocomplete="off" value="{{ $request->src ?? '' }}">
            <select class="form-control selectric" name="term" id="term">
              <option value="name"  class="selectList" @if($term == 'name') selected @endif>{{ __('Search By Name') }}</option>
              <option value="mobile" class="selectList" @if($term == 'mobile') selected @endif>{{ __('Search By Mobile') }}</option>
              <!-- <option value="email" @if($term == 'email') selected @endif>{{ __('Search By Mail') }}</option> -->

            </select>
            <div class="input-group-append">                                            
              <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
            </div>
          </div>
        </form>
      </div>

      {{-- <div class="col-sm-4 col-lg-4 col-12 text-sm-right">
        <a href="{{ route('business.employee.create') }}" class="btn btn-primary" id="employeeCreate" onclick="return checkValidations();">{{ __('Create User') }}</a>
      </div> --}}

      <div class="col-sm-4 col-lg-4 col-12 text-sm-right">
        <a href="{{ route('business.employee.create') }}" class="btn btn-primary" id="employeeCreate">{{ __('Create User') }}</a>
      </div>

    </div>
</div>
    
<div class="row">
  <div class="col-12 mt-2">
    <div class="card">
      <div class="card-header">
        <h4>List of Users</h4>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
            @if(count($employees) >= 1)
            
            <table class="table table-striped table-hover table-borderless">
              <thead>
                <tr>
                  <th style="width: 100px">{{ __('Sr. No.') }}</th>

                  <th>{{ __('Name') }}</th>
                  <!-- <th>{{ __('Email') }}</th> -->
                  <th>{{ __('Mobile') }}</th>
                  <th>{{ __('Status') }}</th>
                  <th>{{ __('Join at') }}</th>
                  <th>{{ __('Action') }}</th>
                </tr>
              </thead>
              
              <tbody>
                
                @foreach($employees as $row)
                <tr id="row{{ $row->id }}">
                  <td style="width: 100px;"><b>{{ $loop->iteration }}</b></td>
                  <td><a href="{{ route('business.employee.show', $row->id) }}">{{ $row->name }}</a></td>
                  <!-- <td><a href="mailto:{{ $row->email }}">{{ $row->email }}</a></td> -->
                  <td>{{ $row->mobile }}</td>
                  <td>
                     @if($row->status==1)
                     <span class="badge badge-success">{{ __('Active') }}</span>
                     @elseif($row->status==0) 
                    <span class="badge badge-danger">{{ __('Deactivated') }}</span>
                    @endif
                  </td>
                  <td>{{ \Carbon\Carbon::parse($row->created_at)->format('j M, Y') }}</td>
                  <td>
                    <div class="dropdown d-inline">
                      <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ __('Action') }}
                      </button>
                      <div class="dropdown-menu">
                       
                        <a class="dropdown-item has-icon" href="{{ route('business.employee.show',$row->id) }}"><i class="fas fa-eye"></i> {{ __('View') }}</a>

                        <a class="dropdown-item has-icon" href="{{ route('business.employee.edit',$row->id) }}"><i class="fas fa-user-edit"></i> {{ __('Edit') }}</a>

                        {{-- <a class="dropdown-item has-icon" href="#"><i class="fa fa-trash"></i> {{ __('Delete') }}</a> --}}
                         
                      </div>
                    </div>
                  
                  </td>
                </tr>
                @endforeach
                
                
              </tbody>
                
                
            </table>
           
            @else
                <div class="col-md-12">
                   <div class="no_recored text-center">
                         
                        <h3> {{ Config::get('constants.no_record_found') }}</h3>
                   </div>
                 </div>
                <!-- <h2 style="padding:50px;text-align:center;clear: both;">Sorry No Record Found!</h2> -->
            @endif
         </div>
        <!-- {{ $employees->appends($request->all())->links('vendor.pagination.bootstrap-4') }} -->
     </div>

     <div class="card-footer text-center">
        {{ $employees->appends($request->all())->links('vendor.pagination.bootstrap-4') }}
      </div>

   </div>
 </div>
</div>
@endsection
@section('end_body')
<script src="{{ asset('assets/js/form.js') }}"></script>
<script>
var employeesLimit = '{{ count($planData["users"]) }}';
var usedEmployees = '{{ count($planData["usedUsers"]) }}';

if(employeesLimit == 0 && usedEmployees == 0){
	var employeeValidationMsg = 'Please Purchase Users';
}else if(employeesLimit != 0 && usedEmployees != 0 && usedEmployees == employeesLimit){
	var employeeValidationMsg = 'Your Allowed Limit Has Exceeded';
}

function showValidationPop(validation,message){
	  
	  Swal.fire({
		  title: '<strong>'+message+'</strong>',
		  icon: 'info',
		  html:
			'Please Upgrade your plans.',
		  showCloseButton: true,
		  showCancelButton: false,
		  focusConfirm: false,
		  confirmButtonText: 'Upgrade',
	 }).then(function(data) { console.log(data);
			if(data.dismiss=='close' || data.dismiss=='backdrop'){
			}else{
				window.location = '{{ route('business.plan') }}';
			}
	 });
}

function checkValidations(){ 
  console.log(usedEmployees);
  console.log(employeesLimit);

	if((usedEmployees >= employeesLimit)){
		showValidationPop('employees',employeeValidationMsg);
		return false;
	}
	return true;
}
</script>
@endsection

