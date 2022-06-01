<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Pilih PAK</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link rel="shortcut icon" sizes="196x196" href="{{ url('assets/images/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ url('assets/images/logo.png') }}">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ url('assets/pak/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ url('assets/pak/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ url('assets/pak/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ url('assets/pak/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ url('assets/pak/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ url('assets/pak/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ url('assets/pak/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ url('assets/pak/css/style.css') }}" rel="stylesheet">
</head>

<body>
    <!-- ======= Hero Section ======= -->

    <section id="hero" class="d-flex align-items-center justify-content-center">
        <div class="container" data-aos="fade-up">

            <div class="row justify-content-center" data-aos="fade-up" data-aos-delay="150">
                <div class="col-xl-6 col-lg-8">
                    <h1 class="h1">SILAHKAN PILIH TAHUN PAK</h1>
                </div>
            </div>

            <div class="row gy-4 mt-5 justify-content-center" data-aos="zoom-in" data-aos-delay="250">
                @if ($data != null)
                    @foreach ($data as $item)
                        {{-- @dump($item) --}}
                        <div class="col-xl-2 col-md-4">
                            <div class="icon-box">
                                <i class="ri-database-2-line"></i>
                                <h3>
                                    <a>
                                        <h4>{{ App\models\LockPak::getdate($item->pak->id) }}</h4>
                                        {{ $item->kondisi == 1 ? 'SESUDAH' : 'SEBELUM' }}
                                    </a>
                                    <form action="{{ route('p-to-d') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="pak_id" value="{{ $item->pak_id }}">
                                        <input type="hidden" name="kondisi" value="{{ $item->kondisi }}">
                                        <button type="submit" class="btn btn-sm btn-primary">BUKA</button>
                                    </form>
                                </h3>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" role="button" class="btn btn-danger mt-3">Logout</button>
            </form>
        </div>
    </section><!-- End Hero -->

    <div id="preloader"></div>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="{{ url('assets/pak/vendor/purecounter/purecounter.js') }}"></script>
    <script src="{{ url('assets/pak/vendor/aos/aos.js') }}"></script>
    <script src="{{ url('assets/pak/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ url('assets/pak/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ url('assets/pak/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
    <script src="{{ url('assets/pak/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ url('assets/pak/vendor/php-email-form/validate.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ url('assets/pak/js/main.js') }}"></script>

</body>

</html>
