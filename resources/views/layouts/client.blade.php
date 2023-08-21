<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('images/company-logo.png') }}" />

    <title>Dairy Raisers</title>
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <script src="https://kit.fontawesome.com/95c5b29ec4.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="{{ asset('css/sb-admin-2/all.min.css') }}" rel="stylesheet" type="text/css">

    <link href="{{ asset('css/sb-admin-2/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sb-admin-2/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css">
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <link href="{{ asset('css/toastr.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('js/toastr.min.js') }}"></script>
    <script>
        function NotifyUser(status, title, message, noTimePeriod = false) {
            console.log(noTimePeriod);
            toastr.options.closeButton = true;
            if (noTimePeriod === 1) { // Use === for strict comparison
                console.log(noTimePeriod);
                toastr.options.timeOut = 0;
                toastr.options.extendedTimeOut = 0;
            } else if (noTimePeriod === false) {
                console.log(noTimePeriod);
                toastr.options.timeOut = 10000;
                toastr.options.extendedTimeOut = 5000;
            }
            toastr.options.progressBar = true;

            switch (status) {
                case 'success':
                    toastr.success(message, title)
                    break;
                case 'info':
                    toastr.info(message, title)
                    break;
                case 'warning':
                    toastr.warning(message, title)
                    break;
                case 'error':
                    toastr.error(message, title)
                    break;

                default:
                    break;
            }
        }
    </script>
    @if (session()->has('message'))
        <script>
            $(document).ready(function() {
                NotifyUser("{{ session('message')['type'] }}", "{{ session('message')['title'] }}",
                    "{{ session('message')['body'] }}", {{ session('message')['period'] }});
            });
        </script>
    @endif

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

    #spinner-border {
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

    /* Show this content on screens larger than or equal to the lg breakpoint */
    /* @media only screen and (min-width: 768px) {
        .img-carousel {
            width: 50px;
        }

       

      
    } */
</style>

<body class="">
    <div id="loading-animation-id" class="loading-overlay">
        <div id="spinner-border" class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>



    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom shadow">

        <div class="container d-flex flex-column align-items-center justify-content-between">

            <!-- First Line: Brand Name and Navigation Links -->
            <div class="d-flex align-items-center justify-content-between w-100">
                <a class="navbar-brand fw-bold" href="#">
                    <img src="{{ asset('images/company-logo.png') }}" class="brand-img img-fluid logo"
                        alt="Company Logo">
                    DAIRY RAISERS
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="d-none d-lg-block">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link " href="{{ route('index') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="{{ route('shop') }}">Products</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="{{ route('order_history') }}">Orders</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="{{ route('about') }}">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="{{ route('contact') }}">Contact</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="{{ route('faqs') }}">FAQ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="{{ route('terms') }}">Terms</a>
                        </li>
                        <!-- Add other navigation items here -->
                    </ul>
                </div>
            </div>

            <!-- Collapsible Navigation Links (Initially Hidden for Large Screens) -->
            <div class="d-lg-none">
                <div class="collapse navbar-collapse " id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link " href="{{ route('index') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="{{ route('shop') }}">Products</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="{{ route('order_history') }}">Orders</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="{{ route('about') }}">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="{{ route('contact') }}">Contact</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="{{ route('faqs') }}">FAQ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="{{ route('terms') }}">Terms</a>
                        </li>
                        <!-- Add other navigation items here -->
                    </ul>
                </div>
            </div>

            <!-- Second Line: Cart and Login/Register Buttons -->
            <div class="d-flex justify-content-between w-100">
                <div class="btn-group btn-group-sm me-2">
                    <button type="button" class="btn btn-sm btn-dark font-weight-bolder">₱<span
                            id="cartTotal">{{ $cartTotal }}</span>.00</button>
                    <a href="{{ route('cart') }}" class="btn btn-sm btn-outline-primary">
                        <i class="fa-solid fa-cart-shopping me-2"></i> Cart
                        <span class="badge bg-danger" id="cartCount">{{ $cartCount }}</span>
                    </a>
                </div>
                <div class="btn-group">
                    @auth
                        <!-- User is Authenticated -->
                        <a href="{{ route('profile') }}" class="btn btn-sm btn-dark">
                            {{ $displayedName }} <i class="fa-solid fa-user-gear"></i>
                        </a>
                    @else
                        <!-- User is Not Authenticated -->
                        <a href="{{ route('register') }}" class="btn btn-sm btn-outline-dark me-3">Register</a>
                        <a href="{{ route('login') }}" class="btn btn-sm btn-primary">Login</a>
                    @endauth
                </div>
            </div>

        </div>
    </nav>



    <!-- Navigation -->

    <main id="" class="py-3 px-5">
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
                            <a href="{{ route('shop') }}" class="text-dark">Products</a>
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
    <script src="{{ asset('js/sb-admin-2/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2/sb-admin-2.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script>
        window.addEventListener('DOMContentLoaded', function() {
            $('#loading-animation-id').hide();
            var navbarHeight = document.querySelector('.navbar').offsetHeight;
            // var mainContent = document.getElementById('main-content');
            // mainContent.style.marginTop = navbarHeight + 'px';
        });
    </script>
    @if (auth()->check())
        <script>
            $(document).ready(function() {
                let logoutTimer;

                function resetLogoutTimer() {
                    clearTimeout(logoutTimer);

                    // Set the timeout to 30 minutes (1800000 milliseconds)
                    logoutTimer = setTimeout(function() {
                        // Call the logout function or redirect to logout URL
                        // For example, assuming you have a logout route in Laravel:
                        window.location.href = '{{ route('logout') }}';
                    }, 1800000); // 30 minutes
                };

                function initLogoutTimer() {
                    // Add event listeners to detect user activity
                    $(document).on('mousemove keydown', resetLogoutTimer);

                    // Start the timer immediately on page load
                    resetLogoutTimer();
                };

                // Call the initLogoutTimer function when the page is loaded
                $(document).ready(initLogoutTimer);

            });
        </script>
    @endif

</body>

</html>
