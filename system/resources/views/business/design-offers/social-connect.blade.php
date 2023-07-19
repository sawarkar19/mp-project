@extends('layouts.business')
@section('title', 'Connect With Social Media')
@section('head')
    @include('layouts.partials.headersection',['title'=>'Connect With Social Media'])
@endsection

@section('end_head')

@section('content')
    @section('end_body')
        <script>
            $(document).ready(function(){
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success m-1',
                        cancelButton: 'btn btn-primary m-1'
                    },
                    buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                    title: "You are not connected to social media",
                    text: "If you are not connected to any social media then need to post manually!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Go to connect page!',
                    cancelButtonText: 'No, Back to offer list!',
                    reverseButtons: true,
                    allowOutsideClick: false,
                    showCloseButton: true,
                }).
                then((result) => {
                    if (result.value == true) {
                        sessionStorage.setItem("setting_section", "social_connection");
                        window.location.href = "{{ route('business.settings') }}";
                    } 
                    else if (result.dismiss === "cancel") {
                        window.location.href = "{{ route('business.designOffer.templates') }}";
                    }
                });
            });
        </script>
    @endsection
@endsection