@extends('layouts.admin')
@section('title', 'Admin: Frontend Search List')
@section('head')
    @include('layouts.partials.headersection', ['title' => 'Frontend Search List'])

    <style>
        .custom-switch-input:checked~.custom-switch-indicator {
            background: #31ce55;
        }
    </style>
@endsection
@section('content')

    <div class="card">
        <div class="card-body">
            <div class="card-action-filter">

				<div class="row">
					<div class="col-sm-5 col-12">
						<form>
							<div class="input-group mb-2">
								<select class="form-control selectric" name="no_of_users" id="no_of_users">
									<option value="10" @if ($request->no_of_users == '10') selected @endif>
										{{ __('10') }}</option>
									<option value="25" @if ($request->no_of_users == '25') selected @endif>
										{{ __('25') }}</option>
									<option value="50" @if ($request->no_of_users == '50') selected @endif>
										{{ __('50') }}</option>
									<option value="100" @if ($request->no_of_users == '100') selected @endif>
										{{ __('100') }}</option>
								</select>
								<div class="input-group-append">
									<button class="btn btn-primary" type="submit"><i
											class="fas fa-search"></i></button>
								</div>
							</div>
						</form>

					</div>

					<div class="col-lg-7">
						<div class="add-new-btn">
							<form>
								<div class="input-group mb-2">
									<input type="text" id="src" class="form-control" placeholder="Search..."
										name="src" autocomplete="off" value="{{ $request->src ?? '' }}">
									<select class="form-control selectric" name="term" id="term">
										<option value="name">{{ __('Search By Name') }}</option>
									</select>
									<div class="input-group-append">
										<button class="btn btn-primary" type="submit"><i class="fas fa-search"></i>
										</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>


                <form method="post" class="basicform_with_reload" action="{{ route('admin.frontendSearch.destroys') }}">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="d-flex">
                                <div class="single-filter">
                                    <div class="form-group">
                                        <select class="form-control selectric" name="status">
                                            <option disabled="" selected="">Select Action</option>
                                            <option value="delete">{{ __('Delete Permanently') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="single-filter">
                                    <button type="submit" class="btn btn-primary btn-lg ml-2">{{ __('Apply') }}</button>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="add-new-btn">
                                <a href="{{ route('admin.frontendsearch.create') }}"
                                    class="btn btn-primary float-right">{{ __('Add New Keyword') }}</a>
                            </div>
                        </div>
                    </div>

            </div>
            <div class="table-responsive custom-table">
                @if (count($frontendSearch) >= 1)
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="am-select">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input checkAll" id="selectAll">
                                        <label class="custom-control-label checkAll" for="selectAll"></label>
                                    </div>
                                </th>
                                <th class="am-title">{{ __('Name') }}</th>
                                <th class="am-title">{{ __('Keyword') }}</th>
                                <th class="am-title">{{ __('Path') }}</th>
                                <th class="am-date">{{ __('Status') }}</th>
                                <th class="am-date">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($frontendSearch as $search)
                                <tr id="front_end_search_id_{{ $search->id }}">
                                    <th>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="ids[]" class="custom-control-input"
                                                id="customCheck{{ $search->id }}" value="{{ $search->id }}">
                                            <label class="custom-control-label"
                                                for="customCheck{{ $search->id }}"></label>
                                        </div>
                                    </th>
                                    <td>
                                        {{ $search->name }}
                                    </td>

                                    <td>
                                        {{ $search->keyword }}
                                    </td>

                                    <td>
                                        <a href="{{ $search->path }}" target="_blank">{{ $search->path }}</a>
                                    </td>
                                    <td>

										<label class="custom-switch pl-0 btn btn-sm">
                                            <input type="checkbox" id="{{ $search->id }}"
                                                class="custom-switch-input change-item-status"
                                                @if ($search->status == 1) checked @endif>
                                            <span class="custom-switch-indicator" style="margin-left: 10px;"></span>
                                        </label>

                                        {{--  <span class="badge badge-success" id="active-badge"
                                            @if ($search->status == 0) style="display: none;" @endif>{{ __('Active') }}</span>

                                        <span class="badge badge-danger" id="deactive-badge"
                                            @if ($search->status == 1) style="display: none;" @endif>{{ __('Deactive') }}</span>  --}}

                                    </td>
                                    <td>
                                        <a class="btn btn-sm btn-icon icon-left btn-primary"
                                            href="{{ route('admin.frontendsearch.edit', $search->id) }}"><i
                                                class="fa fa-edit"></i></a>
                                        <a class="btn btn-sm btn-icon icon-left btn-success"
                                            href="{{ route('admin.frontendsearch.show', $search->id) }}"><i
                                                class="fas fa-eye"></i></a>

                                        <a class="btn btn-sm btn-icon icon-left btn-danger delete-item"
                                            id="{{ $search->id }}" href="#"><i class="fa fa-trash"></i></a>
                                        
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        </form>
                    </table>
                @else
                    <div class="card-body">
                        <h3>{{ Config::get('constants.no_record_found') }}</h3>
                    </div>
                @endif

                <div class="card-footer text-center">
                    {{ $frontendSearch->appends(array_except(Request::query(), $request->no_of_users))->links() }}
                </div>


            </div>
        </div>
    </div>
@endsection
@section('end_body')
    <script>
        $(".basicform_with_reload").on('submit', function(e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var basicbtnhtml = $('.basicbtn').html();
            $.ajax({
                type: 'POST',
                url: this.action,
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {

                    $('.basicbtn').html("Please Wait....");
                    $('.basicbtn').attr('disabled', '')

                },

                success: function(response) {
                    $('.basicbtn').removeAttr('disabled')
                    Sweet('success', response);
                    $('.basicbtn').html(basicbtnhtml);
                    location.reload();
                },
                error: function(xhr, status, error) {
                    $('.basicbtn').html(basicbtnhtml);
                    $('.basicbtn').removeAttr('disabled')
                    $('.errorarea').show();
                    $.each(xhr.responseJSON.errors, function(key, item) {
                        Sweet('error', item)
                        $("#errors").html("<li class='text-danger'>" + item + "</li>")
                    });
                    errosresponse(xhr, status, error);
                }
            })
        });

        $(document).on('click', '.delete-item', function(e) {
            e.preventDefault();
            var front_end_search_id = $(this).attr('id');

			Swal.fire({
				title: 'Are you sure?',
				text: "Do you really want to remove this keyword?",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes, delete !'
			  }).then((result) => {
				if (result.value == true) {
					$.ajaxSetup({
						headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						}
					});
	
					$.ajax({
						type: 'POST',
						url: '{{ url('admin/frontend-search/destroy-page') }}' + '/' + front_end_search_id,
						data: {
							front_end_search_id: front_end_search_id
						},
						dataType: 'json',
						success: function(response) {
							Sweet('success', response.message);
							$('#front_end_search_id_' + front_end_search_id).css('display', 'none');
						},
						error: function(xhr, status, error) {
							Sweet('error', 'Keyword not removed');
						}
	
					})
				}
			  })
            
        });

        $(document).on('change', '.change-item-status', function(e) {
            e.preventDefault();

            var front_end_search_id = $(this).attr('id');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: '{{ url('admin/frontend-search/change-page-status') }}' + '/' + front_end_search_id,
                data: {
                    front_end_search_id: front_end_search_id
                },
                dataType: 'json',
                success: function(response) {
                    Sweet('success', response.message);
                    $('#' + response.hide).hide();
                    $('#' + response.show).show();
                },
                error: function(xhr, status, error) {
                    Sweet('error', 'Keyword status not changed');
                }

            })
        });
    </script>
@endsection
