<!-- General JS Scripts -->
<script src="{{ asset('assets/js/jquery-3.5.1.min.js')}}"></script>
<script src="{{ asset('assets/js/jquery-ui.js')}}"></script>

<script src="{{ asset('assets/js/popper.min.js')}}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js')}}"></script>
<script src="{{ asset('assets/js/jquery.nicescroll.min.js')}}"></script>
<script src="{{ asset('assets/js/moment.min.js')}}"></script>

{{-- <script src="{{ asset('assets/js/fullcalendar.js')}}"></script> --}}
<script src="{{ asset('assets/plugin/fullcalendar/lib/main.js')}}"></script>

<script src="{{ asset('assets/js/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('assets/js/cropper.js') }}"></script>
<script src="{{ asset('assets/front/vendor/owl.carousel/js/owl.carousel.min.js') }}"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
@stack('js')
  <script src="{{ asset('assets/js/stisla.js') }}"></script>
  <!-- Template JS File -->
  <script src="{{ asset('assets/js/scripts.js') }}"></script>
