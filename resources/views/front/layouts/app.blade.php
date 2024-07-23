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
<body class="home">
    <header class="header1">
        <div class="header-top-bar-area">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6">
                        <div class="header-left">
                            <address>Alamat</address>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="headr-bar-right">
                            <a href="tel:123456789">08123123</a>
                            <div class="serch-fl">
                                <a class="ccdda" href="#"><i class="fas fa-search"></i></a>
                            </div>
                            <a href="#"><i class="fas fa-shopping-cart"></i></a>
                        </div>
                        <div class="searchh ccfdf">
                            <form id="search"><input type="text" placeholder="Search"><button type="submit"
                                    class="sbtn">Search Now</button>
                                <a href="javascript:void(0)" class="srch"><i class="far fa-search"></i></a></form>
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
                        <a href="{{ route('index') }}"><img src="/front/assets/logo.png" alt="" width="50"></a>
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
                        <li class="dropdown ">
                            <a href="{{ route('login') }}">Login</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!--hero-area-start-->
    <div class="hero-area position-relative">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="hero-containt">
                        <h3>Sistem Informasi <br> Penjualan Obat </h3>
                        <a href="#" class="theme-btn">Hubungi Kami</a>
                    </div>
                </div>
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
                    <div class="single-info">
                        <i class="icofont-map-pins"></i>
                        <p>11 Georgian Rd,
                            58/A, New York City</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="single-info cl2">
                        <i class="icofont-envelope"></i>
                        <p><a href="mailto:info@info.com">info@info.com</a><br />
                            <a href="info%40medics.html">info@medics.com</a>
                        </p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4">
                    <div class="single-info cl3">
                        <i class="icofont-mobile-phone"></i>
                        <div class="info-details text-white">
                            <p><a href="tel:01234567890">01213-456-7890</a></p>
                            <p><a href="tel:01234567890">01213-456-7890</a></p>
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
