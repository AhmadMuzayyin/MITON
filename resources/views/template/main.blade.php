<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>RAFIKA | DASHBOARD</title>
    <meta name="description" content="Realisasi Anggaran dan Kegiatan" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- for ios 7 style, multi-resolution icon of 152x152 -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-barstyle" content="black-translucent">
    <link rel="apple-touch-icon" href="{{ url('assets/images/logo.png') }}">
    <meta name="apple-mobile-web-app-title" content="Flatkit">
    <!-- for Chrome on Android, multi-resolution icon of 196x196 -->
    <meta name="mobile-web-app-capable" content="yes">
    <link rel="shortcut icon" sizes="196x196" href="{{ url('assets/images/logo.png') }}">

    <!-- style -->
    <link rel="stylesheet" href="{{ url('assets/animate.css/animate.min.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ url('assets/glyphicons/glyphicons.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ url('assets/font-awesome/css/font-awesome.min.css') }}" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" type="text/css">
    <link rel="stylesheet" href="{{ url('assets/material-design-icons/material-design-icons.css') }}" type="text/css" />

    <link rel="stylesheet" href="{{ url('assets/bootstrap/dist/css/bootstrap.min.css') }}" type="text/css" />

    {{-- DataTable --}}
    <link rel="stylesheet" href="{{ url('assets/DataTable/Table/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/libs/jquery/eonasdan-bootstrap-datetimepicker/yearpicker.css') }}">
    <link rel="stylesheet" href="{{ url('assets/libs/jquery/parsleyjs/dist/parsley.css') }}">
    <!-- build:css ../assets/styles/app.min.css -->
    <link rel="stylesheet" href="{{ url('assets/styles/app.css') }}" type="text/css" />
    <!-- endbuild -->
    <link rel="stylesheet" href="{{ url('assets/styles/font.css') }}" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="app" id="app">

        <!-- ############ LAYOUT START-->

        @include('template.aside')

        {{-- Content --}}
        <div id="content" class="app-content box-shadow-z0" role="main">
            @include('template.header')

            @yield('content')
        </div>
        {{-- End of Content --}}

        <!-- ############ LAYOUT END-->

    </div>

    @include('template.footer')

    @stack('script')
</body>

</html>