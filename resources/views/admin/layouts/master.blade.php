<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Elequip ADMIN | Dashboard</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon"
        href="{{ asset(asset_path('assets/admin/img/logo.png')) }}">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset(asset_path('assets/admin/plugins/fontawesome-free/css/all.min.css')) }}">
    <!-- DataTables -->
    <link rel="stylesheet"
        href="{{ asset(asset_path('assets/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')) }}">
    <link rel="stylesheet"
        href="{{ asset(asset_path('assets/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')) }}">
    <link rel="stylesheet"
        href="{{ asset(asset_path('assets/admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')) }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.3.3/css/rowReorder.dataTables.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="{{ asset(asset_path('assets/admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')) }}">
    <!-- iCheck -->
    <link rel="stylesheet"
        href="{{ asset(asset_path('assets/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css')) }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset(asset_path('assets/admin/plugins/jqvmap/jqvmap.min.css')) }}">

    <!-- overlayScrollbars -->
    <link rel="stylesheet"
        href="{{ asset(asset_path('assets/admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')) }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset(asset_path('assets/admin/plugins/daterangepicker/daterangepicker.css')) }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset(asset_path('assets/admin/plugins/summernote/summernote-bs4.min.css')) }}">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset(asset_path('assets/admin/plugins/toastr/toastr.min.css')) }}">
    <!-- Ekko Lightbox -->
    <link rel="stylesheet" href="{{ asset(asset_path('assets/admin/plugins/ekko-lightbox/ekko-lightbox.css')) }}">
    <!-- Bootstrap Tag Input -->
    {{-- <link rel="stylesheet" href="{{asset(asset_path('assets/admin/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css'))}}"> --}}
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet"
        href="{{ asset(asset_path('assets/admin/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css')) }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset(asset_path('assets/admin/plugins/select2/css/select2.min.css')) }}">
    <!-- <link rel="stylesheet" href="{{ asset(asset_path('assets/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')) }}"> -->
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset(asset_path('assets/admin/css/adminlte.min.css')) }}">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset(asset_path('assets/admin/plugins/treeview/treeview.css')) }}">

    <link rel="stylesheet" href="{{ asset(asset_path('assets/admin/plugins/dropify/dropify.css')) }}">

    <link rel="stylesheet" href="{{ asset(asset_path('assets/admin/css/custom.css')) }}">

    {{-- Js FILES --}}

    <!-- jQuery -->
    <script src="{{ asset(asset_path('assets/admin/plugins/jquery/jquery.min.js')) }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset(asset_path('assets/admin/plugins/jquery-ui/jquery-ui.min.js')) }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->

    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script> --}}
    <!-- Bootstrap 4 -->
    <script src="{{ asset(asset_path('assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js')) }}"></script>
    <!-- DataTables  & Plugins -->
    <script src="{{ asset(asset_path('assets/admin/plugins/datatables/jquery.dataTables.min.js')) }}"></script>
    <script src="{{ asset(asset_path('assets/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')) }}"></script>
    <script src="{{ asset(asset_path('assets/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js')) }}">
    </script>
    <script src="{{ asset(asset_path('assets/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')) }}">
    </script>
    <script src="{{ asset(asset_path('assets/admin/plugins/datatables-buttons/js/dataTables.buttons.min.js')) }}"></script>
    <script src="{{ asset(asset_path('assets/admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')) }}"></script>
    <script src="{{ asset(asset_path('assets/admin/plugins/jszip/jszip.min.js')) }}"></script>
    <script src="{{ asset(asset_path('assets/admin/plugins/pdfmake/pdfmake.min.js')) }}"></script>
    <script src="{{ asset(asset_path('assets/admin/plugins/pdfmake/vfs_fonts.js')) }}"></script>
    <script src="{{ asset(asset_path('assets/admin/plugins/datatables-buttons/js/buttons.html5.min.js')) }}"></script>
    <script src="{{ asset(asset_path('assets/admin/plugins/datatables-buttons/js/buttons.print.min.js')) }}"></script>
    <script src="{{ asset(asset_path('assets/admin/plugins/datatables-buttons/js/buttons.colVis.min.js')) }}"></script>
    <script src="https://cdn.datatables.net/rowreorder/1.3.3/js/dataTables.rowReorder.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jeditable.js/1.7.3/jeditable.min.js"></script>
    <!-- ChartJS -->
    <script src="{{ asset(asset_path('assets/admin/plugins/chart.js/Chart.min.js')) }}"></script>
    <!-- Sparkline -->
    <script src="{{ asset(asset_path('assets/admin/plugins/sparklines/sparkline.js')) }}"></script>
    <!-- JQVMap -->
    <script src="{{ asset(asset_path('assets/admin/plugins/jqvmap/jquery.vmap.min.js')) }}"></script>
    <script src="{{ asset(asset_path('assets/admin/plugins/jqvmap/maps/jquery.vmap.usa.js')) }}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ asset(asset_path('assets/admin/plugins/jquery-knob/jquery.knob.min.js')) }}"></script>
    <!-- daterangepicker -->
    <script src="{{ asset(asset_path('assets/admin/plugins/moment/moment.min.js')) }}"></script>
    <script src="{{ asset(asset_path('assets/admin/plugins/daterangepicker/daterangepicker.js')) }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script
        src="{{ asset(asset_path('assets/admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')) }}">
    </script>
    <!-- Summernote -->
    <script src="{{ asset(asset_path('assets/admin/plugins/summernote/summernote-bs4.min.js')) }}"></script>
    <!-- Toastr -->
    <script src="{{ asset(asset_path('assets/admin/plugins/toastr/toastr.min.js')) }}"></script>
    <!-- Ekko Lightbox -->
    <script src="{{ asset(asset_path('assets/admin/plugins/ekko-lightbox/ekko-lightbox.min.js')) }}"></script>
    <!-- Bootstrap Tag Input -->
    {{-- <script src="{{asset(asset_path('assets/admin/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js'))}}"></script> --}}
    <!-- bootstrap color picker -->
    <script src="{{ asset(asset_path('assets/admin/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js')) }}">
    </script>
    <!-- overlayScrollbars -->
    <script src="{{ asset(asset_path('assets/admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')) }}">
    </script>
    <!-- Select2 -->
    <script src="{{ asset(asset_path('assets/admin/plugins/select2/js/select2.full.min.js')) }}"></script>
    <!-- bs-custom-file-input -->
    <script src="{{ asset(asset_path('assets/admin/plugins/bs-custom-file-input/bs-custom-file-input.min.js')) }}">
    </script>
    <!-- Bootstrap Switch -->
    <script src="{{ asset(asset_path('assets/admin/plugins/bootstrap-switch/js/bootstrap-switch.min.js')) }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset(asset_path('assets/admin/js/adminlte.js')) }}"></script>
    <!-- Custom JS -->
    <script src="{{ asset(asset_path('assets/admin/js/custom.js')) }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset(asset_path('assets/admin/js/demo.js')) }}"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{ asset(asset_path('assets/admin/js/pages/dashboard.js')) }}"></script>

    <script src="{{ asset(asset_path('assets/admin/plugins/treeview/treeview.js')) }}"></script>

    <script src="{{ asset(asset_path('assets/admin/plugins/dropify/dropify.js')) }}"></script>

    <script src="{{ asset(asset_path('assets/admin/plugins/cloneData/cloneData.js')) }}"></script>


    <script>
        $(document).ready(function() {
            $(document).on('submit', ".deleteConfirm", function(e) {
                var del = confirm("Are you sure you want to delete this record?");
                if (del == true) {
                    // alert("record deleting");
                    toastr.error('Record Deleted');
                } else {
                    toastr.warning('Record not delete');
                }

                return del;
            });

            $('.dropify').dropify();
        })
    </script>
    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
            //Initialize Select2 Elements
            $('.select2').select2({
                placeholder: 'Select an option'
            });

            bsCustomFileInput.init();

            // $('.dc-colorpicker').colorpicker();

            // $('.dc-colorpicker').on('colorpickerChange', function(event) {
            //     $('.dc-colorpicker .fa-square').css('color', event.color.toString());
            // });

            $("input[data-bootstrap-switch]").each(function() {
                $(this).bootstrapSwitch();
            });

            toastr.options = {
                "closeButton": true,
                "newestOnTop": false,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }

            $(document).on('click', '[data-toggle="lightbox"]', function(event) {
                event.preventDefault();
                $(this).ekkoLightbox({
                    alwaysShowClose: true
                });
            });

            $("#tree1").treed();

        });
    </script>
    <style>
        .main-header .nav-link {
            height: 1.6rem !important;
        }

        .product_tech_spec {
            box-shadow: 3px 3px 3px burlywood;
            border: 1px solid #f3f5f6;
            font-size: 14px;
            line-height: 1.2;
        }

        .product_tech_spec p, .note-editable p {
            margin-bottom: 1px;
        }

        .note-editor {
            margin-bottom: 0;
        }

        .prod_head {
            font-weight: 800 !important;
            color: #082173 !important;
            /* margin-bottom: 0; */
            text-decoration: underline;
        }
        .amount_p {
            border: 2px solid #e0bd90;
            padding: 10px 5px;
            color: #e86338;
            height: 40px;
            /* margin-top: 15px; */
            line-height: 18px;
            border-radius: .25rem;
        }
        .input-orange-elequip{
            border: 2px solid #e0bd90;
            color: #e86338;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{ asset(asset_path('assets/admin/img/AdminLTELogo.png')) }}"
                alt="AdminLTELogo" height="60" width="60">
        </div>

        <!-- Navbar -->
        @include('admin.layouts.header')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @include('admin.layouts.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('main_content')
        </div>
        <!-- /.content-wrapper -->

        <!-- Footer -->
        @include('admin.layouts.footer')

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    @stack('scripts')
</body>

</html>
