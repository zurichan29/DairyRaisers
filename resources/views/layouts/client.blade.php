<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('images/company-logo.png') }}" />

    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <script src="https://kit.fontawesome.com/95c5b29ec4.js" crossorigin="anonymous"></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="icon" href="{{ asset('images/company-logo.png') }}" />

    <title>Dairy Raisers</title>

</head>
<!-- Custome style -->
<style>
    .logo {
        width: 80px;
        /* Adjust the width as per your needs */
        height: 80px;
        /* Adjust the height as per your needs */
        object-fit: cover;
        /* Maintain aspect ratio and cover the container */
    }

    .nav-link {
        margin-right: 15px;
        margin-left: 15px;
    }

    .nav-item {
        position: relative;
    }

    .nav-link-hover {
        transition: color 0.3s ease-in-out, transform 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        position: relative;
        margin-right: 0;
        margin-left: 0;
    }

    .nav-link-hover:hover {
        color: #007bff;
        transform: scale(1.1);
    }

    .nav-link-hover::before {
        content: "";
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 100%;
        height: 2px;
        background-color: #007bff;
        transform: scaleX(0);
        transition: transform 0.3s ease-in-out;
    }

    .nav-link-hover:hover::before {
        transform: scaleX(1);
    }
</style>

<body class="">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow fixed-top">
        <div class="container d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <img src="{{ asset('images/company-logo.png') }}" class="img-fluid logo" alt="Company Logo">
                <a class="navbar-brand" href="#">Dairy Raisers</a>
            </div>
            <div class="navbar-nav flex-grow-1 justify-content-center">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link nav-link-hover" href="{{ route('index') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-hover" href="{{ route('shop') }}">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-hover" href="{{ route('orders') }}">Orders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-hover" href="{{ route('about') }}">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-hover" href="{{ route('contact') }}">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-hover" href="{{ route('faqs') }}">FAQ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-hover" href="{{ route('terms') }}">Terms</a>
                    </li>
                </ul>
            </div>
            <div>
                @auth
                    <a href="{{ route('cart') }}">Cart</a>
                    <p>Cart Item: {{ $cartCount }}</p>
                    <p>Cart Total: {{ $cartTotal }}</p>
                @else
                    <a href="{{ route('register') }}" class="btn btn-outline-dark">Register</a>
                    <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                @endauth
            </div>
        </div>
    </nav>
     <!-- Navigation -->
     
    <main id="main-content" class="p-3">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="text-center text-lg-start text-dark" style="background-color: #ECEFF1">
        <!-- Section: Social media -->
        <section class="d-flex justify-content-between p-4 text-white bg-primary">
            <!-- Left -->
            <div class="me-5">
                <span>Get connected with us on social networks:</span>
            </div>
            <!-- Left -->

            <!-- Right -->
            <div>
                <a href="#" class="text-white me-4">
                    <i class="fa-brands fa-facebook"></i>
                </a>
                <a href="#" class="text-white me-4">
                    <i class="fa-brands fa-twitter"></i>
                </a>
                <a href="#" class="text-white me-4">
                    <i class="fa-brands fa-google"></i>
                </a>
                <a href="#" class="text-white me-4">
                    <i class="fa-brands fa-instagram"></i>
                </a>
                <a href="#" class="text-white me-4">
                    <i class="fa-brands fa-linkedin"></i>
                </a>
                <a href="#" class="text-white me-4">
                    <i class="fa-brands fa-github"></i>
                </a>
            </div>
            <!-- Right -->
        </section>
        <!-- Section: Social media -->

        <!-- Section: Links  -->
        <section class="">
            <div class="container text-center text-md-start mt-5">
                <!-- Grid row -->
                <div class="row mt-3">
                    <!-- Grid column -->
                    <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
                        <!-- Content -->
                        <h6 class="text-uppercase fw-bold">Dairy Raisers</h6>
                        <hr class="mb-4 mt-0 d-inline-block mx-auto"
                            style="width: 60px; background-color: #7c4dff; height: 2px" />
                        <p>
                            Here you can use rows and columns to organize your footer
                            content. Lorem ipsum dolor sit amet, consectetur adipisicing
                            elit.
                        </p>
                    </div>
                    <!-- Grid column -->

                    <!-- Grid column -->
                    <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
                        <!-- Links -->
                        <h6 class="text-uppercase fw-bold">Links</h6>
                        <hr class="mb-4 mt-0 d-inline-block mx-auto"
                            style="width: 60px; background-color: #7c4dff; height: 2px" />
                        <p>
                            <a href="{{ route('products.index') }}" class="text-dark">Products</a>
                        </p>
                        <p>
                            <a href="{{ route('about') }}" class="text-dark">About</a>
                        </p>
                        <p>
                            <a href="{{ route('terms') }}" class="text-dark">Terms</a>
                        </p>
                        <p>
                            <a href="{{ route('faqs') }}" class="text-dark">FAQ</a>
                        </p>
                    </div>
                    <!-- Grid column -->

                    <!-- Grid column -->
                    <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                        <!-- Links -->
                        <h6 class="text-uppercase fw-bold">Contact</h6>
                        <hr class="mb-4 mt-0 d-inline-block mx-auto"
                            style="width: 60px; background-color: #7c4dff; height: 2px" />
                        <p><i class="fas fa-home mr-3"></i> Santiago, General Trias, Philippines, 4107</p>
                        <p><i class="fas fa-envelope mr-3"></i> gentridairympc@ymail.com</p>
                        <p><i class="fas fa-phone mr-3"></i> +63 997 251 4142</p>
                        <p><i class="fas fa-phone mr-3"></i> +63 932 548 8081</p>
                    </div>
                    <!-- Grid column -->
                </div>
                <!-- Grid row -->
            </div>
        </section>
        <!-- Section: Links  -->

        <!-- Copyright -->
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2)">
            © 2023 Copyright:
            <p class="text-dark">General Trias Dairy Raisers Multi-Purpose Cooperative</p>
        </div>
        <!-- Copyright -->
    </footer>
    <!-- Footer -->

    <script>
        var isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};
    </script>
    <script src="{{ asset('js/index.js') }}"></script>
    <script src="{{ asset('js/load_address.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2/jquery.min.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2/bootstrap.bundle.min.js') }}"></script>
    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('js/sb-admin-2/jquery.min.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2/bootstrap.bundle.min.js') }}"></script>
    <script>
        window.addEventListener('DOMContentLoaded', function() {
            var navbarHeight = document.querySelector('.navbar').offsetHeight;
            var mainContent = document.getElementById('main-content');
            mainContent.style.marginTop = navbarHeight + 'px';
        });
    </script>
</body>

</html>
