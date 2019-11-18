<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>SocietyBuddy</title>
    <link rel="icon" href="{{ env('APP_URL') }}/front_assets/img/favicon.png">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ env('APP_URL') }}/front_assets/css/bootstrap.min.css">
    <!-- animate CSS -->
    <link rel="stylesheet" href="{{ env('APP_URL') }}/front_assets/css/animate.css">
    <!-- owl carousel CSS -->
    <link rel="stylesheet" href="{{ env('APP_URL') }}/front_assets/css/owl.carousel.min.css">
    <!-- themify CSS -->
    <link rel="stylesheet" href="{{ env('APP_URL') }}/front_assets/css/themify-icons.css">
    <!-- flaticon CSS -->
    <link rel="stylesheet" href="{{ env('APP_URL') }}/front_assets/css/flaticon.css">
    <!-- font awesome CSS -->
    <link rel="stylesheet" href="{{ env('APP_URL') }}/front_assets/css/magnific-popup.css">
    <!-- swiper CSS -->
    <link rel="stylesheet" href="{{ env('APP_URL') }}/front_assets/css/slick.css">
    <!-- style CSS -->
    <link rel="stylesheet" href="{{ env('APP_URL') }}/front_assets/css/style.css">


</head>
<style type="text/css">
    .poster-main{
            position: relative;
        }
        .poster-main .poster-list .poster-item{
            position: absolute;
            left: 0;
            top: 0;
        }
        .poster-main .poster-btn{
            position: absolute;
            top: 0;
            cursor: pointer;
        }
        .poster-main .poster-prev-btn{
            left: -130px;
            top: -50px;
            background: url("{{ env('APP_URL') }}/front_assets/img/btn_l.png") no-repeat center center;
        }
        .poster-main .poster-next-btn{
            right: -130px;
            top: -50px;
            background: url("{{ env('APP_URL') }}/front_assets/img/btn_r.png") no-repeat center center;
        }
</style>
<body>
    <!--::header part start::-->
    <header class="main_menu home_menu">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <nav class="navbar navbar-expand-lg navbar-light">
                        <a class="navbar-brand" href="{{ route('index')}}"> <img src="{{ env('APP_URL') }}/front_assets/img/society-logo.png" alt="logo" style="width: 7em;"> </a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse main-menu-item justify-content-end"
                            id="navbarSupportedContent">
                            <ul class="navbar-nav align-items-center">
                                <li class="nav-item active">
                                    <a class="nav-link" href="{{ route('index')}}">Home</a>
                                </li>

                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="blog.html" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Features
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="#">Visitor Management</a>
                                        <a class="dropdown-item" href="#">Daily Staff Management</a>
                                        <a class="dropdown-item" href="#">Hassle-free Manage Frequent Guest Visits Child Security</a>
                                        <a class="dropdown-item" href="#">Delivery Management</a>
                                        <a class="dropdown-item" href="#">Community Announcements, Circulars, Meetings, Events Information desk</a>
                                        <a class="dropdown-item" href="#">Amenities Booking</a>
                                        <a class="dropdown-item" href="#">Buy Sell Bulletin Board</a>
                                    </div>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('about')}}">About Us</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="#">Products</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login')}}">Login</a>
                                </li>
                                <!-- <li class="nav-item">
                                    <a class="nav-link" href="contact.html">Contact</a>
                                </li>
                                <!-- <li class="d-none d-lg-block">
                                    <a class="btn_1" href="#">Get a Quote</a>
                                </li> -->
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    @yield('content')

     <footer class="footer-area">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-sm-6 col-md-4 col-xl-3">
                    <div class="single-footer-widget footer_1">
                        <a href="index.html"> <img src="{{ env('APP_URL') }}/front_assets/img/logo_new.png" alt=""> </a>
                        <p>But when shot real her. Chamber her one visite removal six
                            sending himself boys scot exquisite existend an </p>
                        <p>But when shot real her hamber her </p>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4 col-xl-4">
                    <div class="single-footer-widget footer_2">
                        <h4>Newsletter</h4>
                        <p>Stay updated with our latest trends Seed heaven so said place winged over given forth fruit.
                        </p>
                        <form action="#">
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder='Enter email address'
                                        onfocus="this.placeholder = ''"
                                        onblur="this.placeholder = 'Enter email address'">
                                    <div class="input-group-append">
                                        <button class="btn btn_1" type="button"><i class="ti-angle-right"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="social_icon">
                            <a href="#"> <i class="ti-facebook"></i> </a>
                            <a href="#"> <i class="ti-twitter-alt"></i> </a>
                            <a href="#"> <i class="ti-instagram"></i> </a>
                            <a href="#"> <i class="ti-skype"></i> </a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-md-4">
                    <div class="single-footer-widget footer_2">
                        <h4>Contact us</h4>
                        <div class="contact_info">
                            <!-- <p><span> Address :</span> Hath of it fly signs bear be one blessed after </p>
                            <p><span> Phone :</span> # </p> -->
                            <p><span> Email : sales@societybuddy.in</span> </p>
                            <div style="padding-top: 0.5em;">
                                <h5>Download Society Buddy</h5>
                                <a href="#" target="_blank">
                                  <img src="https://mygate.in/wp-content/themes/mygate/images/app-store-btn.png" alt="">
                                </a>
                                <a href="#" target="_blank">
                                  <img src="https://mygate.in/wp-content/themes/mygate/images/google-playstore-btn.png" alt="">
                                 </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="copyright_part_text text-center">
                        <div class="row">
                            <div class="col-lg-12">
                                <p class="footer-text m-0"><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright © Society Buddy 2019. All right reserved.
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- footer part end-->

    <!-- jquery plugins here-->
    <!-- jquery -->
    <script src="{{ env('APP_URL') }}/front_assets/js/jquery-1.12.1.min.js"></script>
    <!-- popper js -->
    <script src="{{ env('APP_URL') }}/front_assets/js/popper.min.js"></script>
    <!-- bootstrap js -->
    <script src="{{ env('APP_URL') }}/front_assets/js/bootstrap.min.js"></script>
    <!-- easing js -->
    <script src="{{ env('APP_URL') }}/front_assets/js/jquery.magnific-popup.js"></script>
    <!-- swiper js -->
    <script src="{{ env('APP_URL') }}/front_assets/js/swiper.min.js"></script>
    <!-- swiper js -->
    <script src="{{ env('APP_URL') }}/front_assets/js/masonry.pkgd.js"></script>
    <!-- particles js -->
    <script src="{{ env('APP_URL') }}/front_assets/js/owl.carousel.min.js"></script>
    <script src="{{ env('APP_URL') }}/front_assets/js/jquery.nice-select.min.js"></script>
    <!-- swiper js -->
    <script src="{{ env('APP_URL') }}/front_assets/js/slick.min.js"></script>
    <script src="{{ env('APP_URL') }}/front_assets/js/jquery.counterup.min.js"></script>
    <script src="{{ env('APP_URL') }}/front_assets/js/waypoints.min.js"></script>
    <!-- custom js -->
    <script src="{{ env('APP_URL') }}/front_assets/js/custom.js"></script>

    <script type="text/javascript" src="{{ env('APP_URL') }}/front_assets/js/Carousel.js"></script>
    <script type="text/javascript">
        $(function () {
            Carousel.init($("#carousel"));
            $("#carousel").init();
        });
    </script>
    <script type="text/javascript" src="{{ env('APP_URL') }}/front_assets/js/contact-2.js"></script>
</body>

</html>
