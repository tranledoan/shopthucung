<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý cửa hàng thú cưng</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('frontend/img/logo.jpg')}}" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="{{ asset('frontend/css/bsgrid.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/css/style.min.css') }}" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" />
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .main-content {
            flex: 1;
        }
    </style>
</head>

<body>

    <!-- HEADER -->
    <div class="header">
        <div class="navbar">
            <div class="navbar__left">
                <a href="{{ URL::to('/') }}" class="navbar__logo">
                    <img src="{{ asset('frontend/img/logo.jpg') }}" alt="">
                </a>

                <div class="navbar__menu">
                    <i id="bars" class="fa fa-bars" aria-hidden="true"></i>
                    <ul>
                        <li><a href="{{ URL::to('/') }}">Trang chủ</a></li>
                        <li><a href="{{ URL::to('/congiong') }}">Con giống</a></li>
                        <li><a href="{{ URL::to('/services') }}">Dịch vụ</a></li>
                        <li><a href="{{ URL::to('/donhang') }}">Đơn hàng</a></li>
                        @if (Auth::check() && Auth::user()->id_phanquyen == 1)
                            <li><a href="{{ URL::to('/dashboard') }}">Dashboard</a></li>
                        @endif
                    </ul>
                </div>
            </div>

            <div class="navbar__center">
                <form action="{{ route('search') }}" method="GET" class="navbar__search">
                    <input type="text" name="tukhoa" placeholder="Nhập để tìm kiếm..." class="search" required>
                    <i class="fa fa-search" id="searchBtn"></i>
                </form>
            </div>

            <div class="navbar__right">
                @if (Auth::check())
                    <span class="mr-2">{{ Auth::user()->hoten }}</span>
                    <div class="logout">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button style="border: none;" type="submit">
                                <i class="fas fa-sign-out-alt text-primary"></i>
                            </button>
                        </form>
                    </div>
                @else
                    <div class="login">
                        <a href="{{ URL::to('login') }}"><i class="fa fa-user"></i></a>
                    </div>
                @endif

                <a href="{{ route('cart') }}" class="navbar__shoppingCart">
                    <img src="{{ asset('frontend/img/shopping-cart.svg') }}" style="width: 24px;" alt="">
                    <span>{{ session('cart') ? count((array) session('cart')) : 0 }}</span>
                </a>
            </div>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main-content">
        @yield('content')
    </div>

    <!-- GO TO TOP -->
    <div class="go-to-top"><i class="fas fa-chevron-up"></i></div>

    <!-- FOOTER -->
    <footer>
        <div class="footer">
            <div class="footer__title">
                <span>Liên hệ</span>
                <div class="footer__social">
                    <a href="https://facebook.com/trieuetam" target="_blank"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-github"></i></a>
                    <a href="#"><i class="fab fa-google"></i></a>
                </div>
            </div>
        </div>

        <div class="footer__info">
            <div class="footer__info-content">
                <h3>Giới thiệu</h3>
                <p>Website quản lý, mua bán thú cưng</p>
            </div>

            <div class="footer__info-content">
                <h3>Liên hệ</h3>
                <p>Địa chỉ: 53 Võ Văn Ngân, Thủ Đức, Hồ Chí Minh</p>
                <p>Email: hieuchung428@gmail.com</p>
                <p>Sđt: 0372334658</p>
            </div>

            <div class="footer__info-content">
                <h3>Fanpage</h3>
                <p>
                    <iframe
                        src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2FC%25E1%25BB%25ADa-h%25C3%25A0ng-S%25E1%25BA%25A3n-ph%25E1%25BA%25A9m-D%25C3%25A0nh-cho-Th%25C3%25BA-C%25C6%25B0ng-100178969197228%2F%3Fref%3Dpages_you_manage&tabs=timeline&width=300px&height=150px&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId"
                        width="100%" height="150px" style="border:none;overflow:hidden" scrolling="no" frameborder="0"
                        allowfullscreen="true"
                        allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share">
                    </iframe>
                </p>
            </div>
            <div class="col-lg-3 col-md-4">
                <div class="footer-newsletter">
                    <h2 class="footer-wid-title text-white" style="text-align: center;">Map</h2>
                </div>
                <div class="footer-map">
                    <iframe id="mapFrame" width="100%" height="260" frameborder="0" style="border:0;" allowfullscreen=""
                        loading="lazy">
                    </iframe>
                </div>
            </div>
        </div>

        <div class="footer__copyright">
            <center>Đồ Án Lập Trình BackEnd-Web2 2025</center>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.post-wrapper').slick({
                slidesToScroll: 1,
                autoplay: true,
                arrow: true,
                dots: true,
                autoplaySpeed: 5000,
                prevArrow: $('.prev'),
                nextArrow: $('.next'),
                appendDots: $(".dot"),
            });

            $('.post-wrapper2').slick({
                slidesToShow: 5,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 2000,
                prevArrow: $('.prev2'),
                nextArrow: $('.next2'),
                responsive: [
                    { breakpoint: 1024, settings: { slidesToShow: 4, slidesToScroll: 3 } },
                    { breakpoint: 600, settings: { slidesToShow: 3, slidesToScroll: 2 } },
                    { breakpoint: 480, settings: { slidesToShow: 2, slidesToScroll: 1 } }
                ]
            });
        });
    </script>

    <script src="{{ asset('frontend/script/script.js') }}"></script>
    <script>
   
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var lat = position.coords.latitude;
            var lon = position.coords.longitude;

      
            var mapURL = `https://www.google.com/maps?q=${lat},${lon}&hl=vi&z=15&output=embed`;

           
            document.getElementById("mapFrame").src = mapURL;
        }, function(error) {
            console.error("Lỗi định vị:", error);
            
        });
    } else {
        alert("Trình duyệt của bạn không hỗ trợ định vị.");
    }
</script>
</body>

</html>