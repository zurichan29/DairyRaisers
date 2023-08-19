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
</style>

<body class="h-100">
    <div class="d-flex justify-content-center align-items-center" style="min-height: 100vh">
        @yield('content')
    </div>
    <!-- Footer -->
    <script src="{{ asset('js/sb-admin-2/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2/sb-admin-2.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script>
        window.addEventListener('DOMContentLoaded', function() {
            $('#loading-animation-id').hide();
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
