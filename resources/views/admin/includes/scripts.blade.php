

<!-- ./wrapper -->
<!-- REQUIRED SCRIPTS -->
<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="{{ URL::asset('public/admin/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap -->
<script src="{{ URL::asset('public/admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- DataTables -->
<script src="{{ URL::asset('public/admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('public/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ URL::asset('public/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ URL::asset('public/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ URL::asset('public/admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ URL::asset('public/admin/dist/js/adminlte.js') }}"></script>
<!-- OPTIONAL SCRIPTS -->
<script src="{{ URL::asset('public/admin/dist/js/demo.js') }}"></script>
<!-- PAGE PLUGINS -->
<!-- Toastr -->
<script src="{{ URL::asset('public/admin/plugins/toastr/toastr.min.js') }}"></script>

<script src="{{ URL::asset('public/admin/Pnotify/pnotify.custom.min.js') }}"></script>
<script src="{{ URL::asset('public/js/moment.min.js') }}"></script>
<script type="text/javascript">
	$(window).on('load', function(){ 
		$('#cover').fadeOut(1000);
	});
</script>
@stack('script')