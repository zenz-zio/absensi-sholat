<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | Dashboard</title>

    {{--
        Source Sans Pro REMOVED from global layout — it was loading alongside
        the dashboard's own fonts (Amiri/Plus Jakarta Sans/IBM Plex Mono) and
        was unused there, causing duplicate font requests.
        If another page (e.g. admin pages) still needs Source Sans Pro,
        push it from that specific view instead:

        @push('styles')
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=swap">
        @endpush
    --}}

    <!-- Font Awesome (subset: solid only — this covers every icon used so far:
         fa-mosque, fa-clock, fa-sun, fa-user-graduate, fa-calendar-alt, fa-bell,
         fa-spinner, fa-clipboard-list, fa-chart-line, fa-trophy, fa-map-pin,
         fa-map-marker-alt, fa-sync-alt, fa-cloud-moon, fa-sun-haze, fa-sunset,
         fa-moon-stars, fa-quote-left, fa-check-circle, fa-question-circle,
         fa-exclamation-triangle, fa-calendar-day.
         If any page elsewhere uses regular/brands icons, add that CSS file too
         via @push('styles') on that page rather than reverting this to all.min.css) -->
    <link rel="stylesheet" href="{{ asset('assets') }}/AdminLTE/plugins/fontawesome-free/css/fontawesome.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/AdminLTE/plugins/fontawesome-free/css/solid.min.css">

    <!-- iCheck (used by checkboxes/radios across most pages — keep global) -->
    <link rel="stylesheet" href="{{ asset('assets') }}/AdminLTE/plugins/icheck-bootstrap/icheck-bootstrap.min.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets') }}/AdminLTE/dist/css/adminlte.min.css">

    <!-- overlayScrollbars -->
    <link rel="stylesheet"
        href="{{ asset('assets') }}/AdminLTE/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">

    {{--
        MOVED OUT of the global layout — load these ONLY on pages that need them,
        via @push('styles') in the specific view. See per-page snippets below.

        - tempusdominus-bootstrap-4.min.css   -> only pages with a datepicker
        - jqvmap.min.css                      -> only pages with a map widget
        - daterangepicker.css                 -> only pages with a date-range filter
        - summernote-bs4.min.css              -> only pages with a rich text editor
        - dataTables.bootstrap4.min.css       -> only pages with a DataTable
        - responsive.bootstrap4.min.css       -> only pages with a DataTable
        - buttons.bootstrap4.min.css          -> only pages with DataTable export buttons
    --}}

    @stack('styles')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Navbar -->
        <x-navbar />

        <!-- Main Sidebar Container -->
        <x-sidebaruser />

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>@yield('title')</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Siswa</a></li>
                                <li class="breadcrumb-item active">@yield('title')</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </section>
        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer">
            <strong>Copyright &copy; 2025-2026 <a href="https://adminlte.io">Absensi Sholat</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 3.2.0
            </div>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark"></aside>
    </div>
    <!-- ./wrapper -->

    <!-- jQuery (required by AdminLTE + Bootstrap bundle + most plugins) -->
    <script src="{{ asset('assets') }}/AdminLTE/plugins/jquery/jquery.min.js" defer></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('assets') }}/AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js" defer></script>
    <!-- iCheck init depends on jQuery, kept global since checkboxes are used widely -->
    <!-- AdminLTE App -->
    <script src="{{ asset('assets') }}/AdminLTE/dist/js/adminlte.js" defer></script>

    <script defer>
        document.addEventListener('DOMContentLoaded', function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });
    </script>

    {{--
        MOVED OUT of the global layout — load these ONLY on pages that need them,
        via @push('scripts') in the specific view. See per-page snippets below.

        - jquery-ui.min.js + uibutton bridge          -> only if a page uses jQuery UI widgets
        - Chart.min.js                                -> only pages with charts (dashboard admin, if any)
        - sparkline.js                                -> only pages with sparkline widgets
        - jquery.vmap.min.js + jquery.vmap.usa.js      -> only pages with the JQVMap map
        - jquery.knob.min.js                          -> only pages with knob charts
        - moment.min.js + daterangepicker.js          -> only pages with a date-range filter
        - tempusdominus-bootstrap-4.min.js            -> only pages with a datepicker
        - summernote-bs4.min.js                       -> only pages with a rich text editor
        - dashboard.js (AdminLTE demo script)         -> DELETE — this is demo-only, not needed
        - jquery.overlayScrollbars.min.js             -> only if a page relies on custom scrollbars
        - DataTables core + bs4/responsive/buttons
          + jszip + pdfmake + vfs_fonts               -> only pages with a DataTable (e.g. Data Siswa, Absensi)
    --}}

    @stack('scripts')
</body>

</html>