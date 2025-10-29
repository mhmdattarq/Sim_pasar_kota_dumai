<!-- Plugins -->
<script src="{{ asset('backend/assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('backend/assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
<script src="{{ asset('backend/assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
<script src="{{ asset('backend/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
<script src="{{ asset('backend/assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
<script src="{{ asset('backend/assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
<script src="{{ asset('backend/assets/plugins/apexcharts-bundle/js/apexcharts.min.js') }}"></script>
<script src="{{ asset('backend/assets/plugins/chartjs/js/Chart.min.js') }}"></script>
<script src="{{ asset('backend/assets/plugins/chartjs/js/Chart.extension.js') }}"></script>
<script src="{{ asset('backend/assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('backend/assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ asset('backend/assets/js/index.js') }}"></script>
<script src="{{ asset('backend/assets/js/app.js') }}"></script>
<!-- Stack untuk script tambahan -->
@stack('scripts')
<script>
    $(document).ready(function() {
        console.log('jQuery ready'); // DEBUG
        $('#example').DataTable();
        var table = $('#example2').DataTable({
            lengthChange: false,
            buttons: ['copy', 'excel', 'pdf', 'print']
        });
        table.buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');

        $(".mobile-toggle-menu").on("click", function() {
            $(".wrapper").toggleClass("toggled");
        });
        $(".overlay").on("click", function() {
            $(".wrapper").removeClass("toggled");
        });
        new PerfectScrollbar('.email-navigation');
        new PerfectScrollbar('.email-read-box');
    });
</script>