@extends('layouts.admin')
@section('title', 'Admin: Plans')
@section('head')
    @include('layouts.partials.headersection', ['title' => 'Plans'])
@endsection
@section('content')

    <div class="row">
        <div class="col-12 mt-2">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="{{ route('admin.plans.destroys') }}" class="basicform_with_reload">
                        @csrf
                        <div class="float-left mb-1">
                            <div class="input-group">
                                <select class="form-control" name="type">
                                    <option selected="" disabled="">{{ __('Select Action') }}</option>
                                    <option value="delete">{{ __('Delete Permanently') }}</option>

                                </select>
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">{{ __('Submit') }}</button>
                                </div>
                            </div>
                        </div>
                        <div class="float-right">
                            <a href="{{ route('admin.plan.create') }}" class="btn btn-primary">{{ __('Create Plan') }}</a>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped table-hover text-center table-borderless">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" class="checkAll"></th>

                                        <th>{{ __('Name') }}</th>
                                        {{--  <th>{{ __('Price') }}</th>  --}}
                                        <th>{{ __('Duration') }}</th>
                                        {{--  <th>{{ __('Users') }}</th>  --}}
                                        {{--  <th>{{ __('Featured') }}</th>  --}}
                                        <th>{{ __('Is Deafult') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($posts as $row)
                                        <tr id="row{{ $row->id }}">
                                            <td><input type="checkbox" name="ids[]" value="{{ $row->id }}"></td>

                                            <td>{{ $row->name }}</td>
                                            {{--  <td>{{ $row->price }}</td>  --}}
                                            <td>
                                                @if ($row->days == 365)
                                                    Yearly
                                                @elseif($row->days == 30)
                                                    Monthly
                                                @else
                                                    {{ $row->days }} Days
                                                @endif
                                            </td>
                                            {{--  <td>{{ $row->active_users_count }}</td>  --}}
                                            {{--  <td>
                                                @if ($row->featured == 1)
                                                    <span class="badge badge-success  badge-sm">Yes</span>
                                                @else
                                                    <span class="badge badge-danger  badge-sm">No</span>
                                                @endif
                                            </td>  --}}
                                            <td>
                                                @if ($row->is_default == 1)
                                                    <span class="badge badge-success  badge-sm">Yes</span>
                                                @else
                                                    <span class="badge badge-danger  badge-sm">No</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($row->status == 1)
                                                    <span class="badge badge-success  badge-sm">Active</span>
                                                @else
                                                    <span class="badge badge-danger  badge-sm">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.plan.edit', $row->id) }}"
                                                    class="btn btn-primary btn-sm text-center"><i
                                                        class="far fa-edit"></i></a>

                                                <a href="{{ route('admin.plan.show', $row->id) }}"
                                                    class="btn btn-success btn-sm text-center"><i
                                                        class="far fa-eye"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $posts->links('vendor.pagination.bootstrap-4') }}
                        </div>
                    </form>
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

                    if (response.status == true) {
                        Sweet('success', response.message);
                    } else {
                        Sweet('error', response.message);
                    }

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
    </script>
@endsection
