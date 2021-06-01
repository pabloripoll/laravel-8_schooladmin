            </div>
            <!-- /#page-wrapper -->

        </div>
        <!-- /#wrapper -->
        
        <!-- SCRIPTS -->
        <script>
            const csrf_token = "{{ csrf_token() }}"
            const routeLogout = "{{ route('logout') }}"
            const AdminPath = "{{ env('ADMIN_PATH_PREFIX') }}"
            const Layout = "{{ $data->layout }}"
        </script>
        <!-- jQuery -->
        <script src="/themes/bsadmin/js/jquery-2.1.3.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="/themes/bsadmin/js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="/themes/bsadmin/js/metisMenu.min.js"></script>

        <!-- Morris Charts JavaScript  -->
        @if(Request::path() == 'admin' || Request::path() == 'admin/dashboard')
        <script src="/themes/bsadmin/js/raphael.min.js"></script>
        <script src="/themes/bsadmin/js/morris.min.js"></script>
        <script src="/themes/bsadmin/js/morris-data.js"></script>
        @endif

        <!-- Custom Theme JavaScript -->
        <script src="/themes/bsadmin/js/startmin.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="/themes/bsadmin/js/custom/common.js"></script>
        <!-- Layout -->
        <script src="/themes/bsadmin/js/custom/pages/{{ $data->layout }}.js"></script>

    </body>
</html>