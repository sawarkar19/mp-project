<script src="{{ asset('assets/website/vendor/jQuery/jQuery.min.js') }}"></script>

{{--Script for Openlink share button & counts--}}
<script src="{{ asset('assets/js/targets-web.js') }}"></script>

{{-- <script src="https://unpkg.com/@popperjs/core@2"></script> --}}
<script src="{{asset('assets/website/js/popper.2.11.6.js')}}"></script>

<script src="{{ asset('assets/website/vendor/bootstrap/js/bootstrap.min.js') }}"></script>

{{-- /* A way to add scripts to the page. */ --}}
@stack('js')

<script src="{{ asset('assets/website/js/custom.js') }}"></script>


{{-- Owl carousel --}}
<script src="{{ asset('assets/website/vendor/owl.carousel/js/owl.carousel.min.js') }}"></script>

<script>
    $(function() {
        var image = $('img');
        image.each(function(index, element) {
            var w = $(this).width();
            var h = $(this).height();
            $(this).attr('width', w).attr('height', h);
        });
    });
</script>