<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('images/company-logo.png') }}" />

    {{-- <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <script src="https://kit.fontawesome.com/95c5b29ec4.js" crossorigin="anonymous"></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}" defer></script> --}}

    <script src="https://kit.fontawesome.com/95c5b29ec4.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="{{ asset('css/sb-admin-2/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="{{ asset('css/sb-admin-2/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sb-admin-2/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css">
    <script src="{{ asset('js/jquery.min.js') }}"></script>

    <title>Dairy Raisers</title>

</head>
<!-- Custome style -->
<style>
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
    }

    .spinner-border {
        width: 4rem;
        /* Adjust the size as needed */
        height: 4rem;
        /* Adjust the size as needed */
    }

    /* Custom CSS for hover dropdown */
    .dropdowns:hover .dropdown-menu {
        display: block;
    }

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
    <div id="loading-animation-id" class="loading-overlay">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
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
                        <a class="nav-link nav-link-hover" href="{{ route('order_history') }}">Orders</a>
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
            @auth
                <div class="navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto"></ul>
                    <div class="d-flex gap-5 align-items-center">
                        <div class="btn-group btn-group-sm me-2" role="group"
                            aria-label="Button group with nested dropdown">
                            <button type="button"
                                class="btn btn-sm btn-dark font-weight-bolder">₱{{ $cartTotal . '.00' }}</button>
                            <div class="dropdown dropdowns position-static btn-group" role="group">
                                <a href="{{ route('cart') }}"
                                    class="btn btn-sm btn-outline-primary position-relative dropdown-toggle"
                                    id="hoverDropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa-solid fa-cart-shopping me-2"></i> Cart
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ $cartCount }}
                                        <span class="visually-hidden">your shopping cart</span>
                                    </span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" style="width: 300px"
                                    aria-labelledby="cartDropdown">
                                    @if ($carts->count() != 0)
                                        <div class="row p-2">
                                            <div class="col-md-12">
                                                @foreach ($carts as $item)
                                                    <div class="row align-items-center mb-3">
                                                        <div class="col-3">
                                                            <img src="{{ asset($item->product->img) }}" class="img-fluid"
                                                                alt="Item picture">
                                                        </div>
                                                        <div class="col">
                                                            <p class="font-weight-normal mb-0">
                                                                {{ $item->product->name }}
                                                                <span class="text-secondary">
                                                                    {{ ' | ' . $item->product->variant }}
                                                                </span>
                                                            </p>
                                                            <div class="row">
                                                                <div class="col">
                                                                    <p class="text-secondary fw-light mb-0">
                                                                        ₱{{ $item->price . '.00' }}
                                                                    </p>
                                                                </div>
                                                                <div class="col">
                                                                    <p class="text-secondary fw-light mb-0">
                                                                        Quantity: {{ $item->quantity }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="border-top mt-0 mb-1"></div>
                                                            <p class="font-weight-bold">
                                                                Total: ₱{{ $item->price * $item->quantity . '.00' }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                @endforeach
                                                <div class="d-grid ">
                                                    <a href="{{ route('checkout') }}"
                                                        class="btn btn-sm btn-primary">Checkout</a>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <img src="{{ asset('images/empty_cart.png') }}" class="img-fluid"
                                            alt="empty cart">
                                        <h5 class="text-center">Empty Cart</h5>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('profile') }}" class=" btn  btn-dark">
                            <i class="fa-solid fa-user-gear"></i>
                        </a>
                    </div>
                </div>
            @else
                <div class="btn-group">
                    <a href="{{ route('register') }}" class="me-2 btn btn-outline-dark">Register</a>
                    <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                </div>

            @endauth
        </div>
    </nav>
    <!-- Navigation -->

    <main id="main-content" class="py-3 px-5">
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
                <a href="https://twitter.com/gentrisbest" class="text-white me-4">
                    <i class="fa-brands fa-twitter"></i>
                </a>
                <a href="https://mail.google.com/mail/u/0/?tab=rm&ogbl#search/gentridairympc%40ymail.com%E2%80%8B​"
                    class="text-white me-4">
                    <i class="fa-brands fa-google"></i>
                </a>
                <a href="https://www.instagram.com/gentrisbest/" class="text-white me-4">
                    <i class="fa-brands fa-instagram"></i>
                </a>
                <a href="https://www.linkedin.com/company/general-trias-dairy-raisers-multi-purpose-cooperative"
                    class="text-white me-4">
                    <i class="fa-brands fa-linkedin"></i>
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
                            Dependable is what we are. Quality milk since 2005.
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
    <script src="{{ asset('js/sb-admin-2/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2/sb-admin-2.min.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/index.js') }}"></script>
    <script src="{{ asset('js/load_address.js') }}"></script>
    {{-- <script src="{{ asset('js/sb-admin-2/jquery.min.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2/jquery.min.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2/bootstrap.bundle.min.js') }}"></script> --}}
    <script>
        window.addEventListener('DOMContentLoaded', function() {
            $('#loading-animation-id').hide();
            var navbarHeight = document.querySelector('.navbar').offsetHeight;
            var mainContent = document.getElementById('main-content');
            mainContent.style.marginTop = navbarHeight + 'px';
        });
    </script>
</body>

</html>
