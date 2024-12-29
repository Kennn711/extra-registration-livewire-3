<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('backend') }}/assets/img/kaiadmin/favicon.ico" type="image/x-icon" />

    <!-- Fonts and icons -->
    <script src="{{ asset('backend') }}/assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
        WebFont.load({
            google: {
                "families": ["Public Sans:300,400,500,600,700"]
            },
            custom: {
                "families": ["Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"],
                urls: ['assets/css/fonts.min.css']
            },
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('backend') }}/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('backend') }}/assets/css/plugins.min.css">
    <link rel="stylesheet" href="{{ asset('backend') }}/assets/css/kaiadmin.css">
    <link rel="stylesheet" href="{{ asset('assets/bootstrap-icons-1.11.3/font/bootstrap-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/sweetalert/sweetalert.min.css') }}">

    <title>{{ $title ?? 'Page Title' }}</title>
</head>

<body>
    <div class="wrapper">
        @include('layouts-backend.sidebar')
        <div class="main-panel">
            @include('layouts-backend.navbar')

            <div class="container">
                <div class="page-inner">
                    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                        <div>
                            <h3 class="fw-bold mb-3">@yield('page-title')</h3>
                            <h6 class="op-7 mb-2">@yield('page-subtitle')</h6>
                        </div>
                    </div>
                    {{-- Slot / content --}}
                    {{ $slot }}
                </div>
            </div>

            <footer class="footer">
                <div class="container-fluid">
                    <div class="copyright ms-auto">
                        2024, made with <i class="fa fa-heart heart text-danger"></i> by <a href="https://github.com/Kennn711" target="_blank">Kennn</a>
                    </div>
                </div>
            </footer>
        </div>



    </div>

    <!--   Core JS Files   -->
    <script src="{{ asset('backend') }}/assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="{{ asset('backend') }}/assets/js/core/popper.min.js"></script>
    <script src="{{ asset('backend') }}/assets/js/core/bootstrap.min.js"></script>

    <!-- jQuery Scrollbar -->
    <script src="{{ asset('backend') }}/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

    <!-- Chart JS -->
    <script src="{{ asset('backend') }}/assets/js/plugin/chart.js/chart.min.js"></script>

    <!-- jQuery Sparkline -->
    <script src="{{ asset('backend') }}/assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

    <!-- Chart Circle -->
    <script src="{{ asset('backend') }}/assets/js/plugin/chart-circle/circles.min.js"></script>

    <!-- Datatables -->
    <script src="{{ asset('backend') }}/assets/js/plugin/datatables/datatables.min.js"></script>

    <!-- Bootstrap Notify -->
    <script src="{{ asset('backend') }}/assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>

    <!-- jQuery Vector Maps -->
    <script src="{{ asset('backend') }}/assets/js/plugin/jsvectormap/jsvectormap.min.js"></script>
    <script src="{{ asset('backend') }}/assets/js/plugin/jsvectormap/world.js"></script>


    <!-- Kaiadmin JS -->
    <script src="{{ asset('backend') }}/assets/js/kaiadmin.min.js"></script>

    <!-- Sweet Alert -->
    {{-- <script src="{{ asset('backend') }}/assets/js/plugin/sweetalert/sweetalert.min.js"></script> --}}
    <script src="{{ asset('backend/assets/sweetalert/sweetalert.min.js') }}"></script>
    @if (session('message-success'))
        <script>
            Swal.fire({
                position: "top",
                icon: "success",
                title: "{!! session('message-success') !!}",
                showConfirmButton: false,
                toast: true,
                timer: 2500,
                timerProgressBar: true,
            });
        </script>
    @endif
    @if (session('message-error'))
        <script>
            Swal.fire({
                position: "top",
                icon: "error",
                title: "{!! session('message-error') !!}",
                showConfirmButton: false,
                toast: true,
                timer: 2500,
                timerProgressBar: true,
            });
        </script>
    @endif
    <script>
        $('#lineChart').sparkline([102, 109, 120, 99, 110, 105, 115], {
            type: 'line',
            height: '70',
            width: '100%',
            lineWidth: '2',
            lineColor: '#177dff',
            fillColor: 'rgba(23, 125, 255, 0.14)'
        });

        $('#lineChart2').sparkline([99, 125, 122, 105, 110, 124, 115], {
            type: 'line',
            height: '70',
            width: '100%',
            lineWidth: '2',
            lineColor: '#f3545d',
            fillColor: 'rgba(243, 84, 93, .14)'
        });

        $('#lineChart3').sparkline([105, 103, 123, 100, 95, 105, 115], {
            type: 'line',
            height: '70',
            width: '100%',
            lineWidth: '2',
            lineColor: '#ffa534',
            fillColor: 'rgba(255, 165, 52, .14)'
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#basic-datatables').DataTable({});
        });
    </script>
    @stack('scripts')
</body>

</html>
