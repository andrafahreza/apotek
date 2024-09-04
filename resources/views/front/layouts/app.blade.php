<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Sistem Informasi Penjualan Obat</title>
    <link href="/front/assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="/front/assets/logo.png">
    <link href="/front/assets/css/all.min.css" rel="stylesheet">
    <link href="/front/assets/css/fontawesome.css" rel="stylesheet">
    <link href="/front/assets/css/animate.css" rel="stylesheet">
    <link href="/front/assets/css/owl.carousel.min.css" rel="stylesheet">
    <link href="/front/assets/css/icofont.min.css" rel="stylesheet">
    <link href="/front/assets/css/style.css" rel="stylesheet">

    @stack('styles')
</head>

@php
    use App\Models\Pengaturan;
    use App\Models\Keranjang;
    $pengaturan = Pengaturan::first();
    $keranjang = null;
    if (Auth::check()) {
        $keranjang = Keranjang::where('user_id', Auth::user()->id)
            ->where('status', 'open')
            ->first();
    }
    $jumlah = $keranjang != null ? count($keranjang->obat) : 0;
@endphp

<body class="home">
    <header class="header1">
        <div class="header-top-bar-area">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6">
                        <div class="header-left">
                            <address>
                                @if (!empty($pengaturan))
                                    {{ $pengaturan->alamat }}
                                @endif
                            </address>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="headr-bar-right">
                            <a href='tel:{{ !empty($pengaturan) ? $pengaturan->telepon : '' }}'>
                                @if (!empty($pengaturan))
                                    {{ $pengaturan->telepon }}
                                @endif
                            </a>
                            <div class="serch-fl">
                                <a class="ccdda" href="#"><i class="fas fa-search"></i></a>
                            </div>
                            <a href="{{ route('lihat-keranjang') }}"><i class="fas fa-shopping-cart"></i>
                                @if ($jumlah > 0)
                                    {{ $jumlah }} Item
                                @endif
                            </a>
                        </div>
                        <div class="searchh ccfdf">
                            <form id="search" method="post" action="{{ route('search') }}">
                                @csrf
                                <input type="text" name="search" placeholder="Search">
                                <button type="submit" class="sbtn">Search Now</button>
                                <a href="javascript:void(0)" class="srch"><i class="far fa-search"></i></a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <nav id="main-navigation-wrapper"
            class="navbar navbar-default header-middle header-area header-middle position-relative">
            <div class="container">
                <div class="col-xl-3 col-lg-12 col-md-12 col-sm-12 navbar-header">
                    <div class="header-logo">
                        <a href="{{ route('index') }}"><img src="/front/assets/logo.png" alt=""
                                width="100"></a>
                    </div>
                    <button type="button" data-toggle="collapse" data-target="#main-navigation" aria-expanded="false"
                        class="navbar-toggle collapsed"><span class="sr-only">Toggle navigation</span><span
                            class="icon-bar"></span><span class="icon-bar"></span><span
                            class="icon-bar"></span></button>
                </div>
                <div id="main-navigation" class="col-xl-9 col-lg-12 col-md-12 collapse navbar-collapse ">
                    <ul class="nav navbar-nav">
                        <li class="dropdown ">
                            <a href="{{ route('index') }}" class="active">Home</a>
                        </li>
                        @if (!Auth::check())
                            <li class="dropdown ">
                                <a href="{{ route('login') }}">Login</a>
                            </li>
                        @else
                            <li class="dropdown ">
                                <a href="{{ route('riwayat-pembelian-customer') }}">Riwayat Pembelian</a>
                            </li>
                            <li class="dropdown ">
                                <a href="{{ route('pemesanan-customer') }}">Riwayat Pemesanan</a>
                            </li>
                            <li class="dropdown">
                                <a><i class="fas fa-user-circle"></i> {{ Auth::user()->name }}</a><i
                                    class="fa fa-chevron-down"></i>
                                <ul class="dropdown-submenu">
                                    <li><a href="{{ route('profile-customer') }}">Profile</a></li>
                                    <li><a href="{{ route('logout') }}">Logout</a></li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!--hero-area-start-->
    <div class="position-relative">
        <div class="container mt-4" style="background-color: #d9d9d9">
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
                </ol>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <center> <img class="d-block" src="{{ asset('front/assets/slide1.jpg') }}" alt="First slide" style="height: 400px !important"></center>
                    </div>
                    <div class="carousel-item">
                        <center><img class="d-block" src="{{ asset('front/assets/slide2.jpg') }}" alt="Second slide" style="height: 400px !important"></center>
                    </div>
                    <div class="carousel-item">
                        <center><img class="d-block" src="{{ asset('front/assets/slide3.jpg') }}" alt="Third slide" style="height: 400px !important"></center>
                    </div>
                    <div class="carousel-item">
                        <center><img class="d-block" src="{{ asset('front/assets/slide4.jpg') }}" alt="Third slide" style="height: 400px !important"></center>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </div>
    <!--hero-area-end-->

    @yield('content')

    <!--info-area-start-->
    <div class="info-area">
        <div class="container">
            <div class="row no-gutters">
                <div class="col-lg-4 col-md-4">
                    <a href="{{ !empty($pengaturan) ? $pengaturan->map : '' }}" target="_blank">
                        <div class="single-info">
                            <i class="icofont-map-pins"></i>
                            <p>
                                @if (!empty($pengaturan))
                                    {{ $pengaturan->alamat }}
                                @endif
                            </p>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="single-info cl2">
                        <i class="icofont-envelope"></i>
                        <p>
                            <a href="mailto:@if (!empty($pengaturan)) {{ $pengaturan->email }} @endif">
                                @if (!empty($pengaturan))
                                    {{ $pengaturan->email }}
                                @endif
                            </a>
                        </p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4">
                    <div class="single-info cl3">
                        <i class="icofont-mobile-phone"></i>
                        <div class="info-details text-white">
                            <p><a href="tel:@if (!empty($pengaturan)) {{ $pengaturan->telepon }} @endif">
                                    @if (!empty($pengaturan))
                                        {{ $pengaturan->telepon }}
                                    @endif
                                </a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--info-area-end-->

    <!-- footer-area-start-->
    <footer>
        <div class="footer-area pt-50">
            <div class="container">
            </div>
        </div>

        <div class="footer-bottom">
            <div class="container">
                <p> © 2024</p>
            </div>
        </div>
        <a href="#" class="go-top"><i class="fas fa-arrow-up"></i></a>
    </footer>
    <!--    footer-bottom-area-end-->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="/front/assets/js/jquery.min.js"></script>
    <script src="/front/assets/js/popper.js"></script>
    <script src="/front/assets/js/jquery.sticky.js"></script>
    <script src="/front/assets/js/owl.carousel.min.js"></script>
    <script src="/front/assets/js/jquery.magnific-popup.min.js"></script>
    <script src="/front/assets/js/bootstrap.min.js"></script>
    <script src="/front/assets/js/main.js"></script>
    @stack('scripts')
</body>


</html>
