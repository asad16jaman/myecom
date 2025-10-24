<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>@yield('title')</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="{{ asset('assets/admin/img/kaiadmin/favicon.ico') }}" type="image/x-icon" />
    <meta name="csrf_token" content="{{ csrf_token() }}">
    <!-- Fonts and icons -->
    <script src="{{ asset('assets/admin/js/plugin/webfont/webfont.min.js') }}"></script>
    <script>
        WebFont.load({
            google: { families: ["Public Sans:300,400,500,600,700"] },
            custom: {
                families: [
                    "Font Awesome 5 Solid",
                    "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands",
                    "simple-line-icons",
                ],
                urls: ["{{ asset('assets/admin/css/fonts.min.css') }}"],
            },
            active: function () {
                sessionStorage.fonts = true;
            },
        });
    </script>

    <!-- link vue js -->
     <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
     
    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/admin/css/plugins.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/admin/css/kaiadmin.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/admin/css/custom.css') }}" />

    <style>
        p{
            margin-bottom: 0px!important;
        }
    </style>
    @stack('style')
   
</head>

<body>

    <div class="wrapper">
        <!-- Sidebar -->
        @include('admin.partial.sidebar')
        <!-- End Sidebar -->
        <div class="main-panel">
            <div class="main-header">
                <div class="main-header-logo"></div>
                <!-- Navbar Header -->
                @include('admin.partial.navbar')
                <!-- End Navbar -->
            </div>
            <div class="container">
                
                    @yield('content')
                
            </div>
            @include('admin.partial.footer')
        </div>

      
    </div>
    <!--   Core JS Files   -->
    <script src="{{ asset('assets/admin/js/core/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/core/bootstrap.min.js') }}"></script>

    <!-- jQuery Scrollbar -->
    <script src="{{ asset('assets/admin/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>

    <!-- Bootstrap Notify -->
    <script src="{{ asset('assets/admin/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

    <!-- Sweet Alert -->
    <script src="{{ asset('assets/admin/js/plugin/sweetalert/sweetalert.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <!-- Kaiadmin JS -->
    <script src="{{ asset('assets/admin/js/kaiadmin.min.js') }}"></script>

    <!-- Kaiadmin DEMO methods, don't include it in your project! -->

    <script src="{{ asset('assets/admin/js/demo.js') }}"></script>

    @stack('script')

</body>

</html>