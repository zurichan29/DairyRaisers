<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns@1.1.0"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-luxon@1.2.0"></script> --}}

    <script src="{{ asset('js/chart.js') }}"></script>
    <script src="https://kit.fontawesome.com/95c5b29ec4.js" crossorigin="anonymous"></script>
    <!-- Add this script tag to include moment.js library -->
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script> --}}

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="{{ asset('css/sb-admin-2/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="{{ asset('css/sb-admin-2/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sb-admin-2/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css">
    <script src="{{ asset('js/jquery.min.js') }}"></script>

    <link href="{{ asset('css/toastr.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('js/toastr.min.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('css/fancybox.min.css') }}" />
    <script src="{{ asset('js/fancybox.min.js') }}"></script>

    <link rel="stylesheet" type="text/css" href="{{ asset('css/daterangepicker.css') }}" />

    <script type="text/javascript" src="{{ asset('js/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/daterangerpicker.min.js') }}"></script>

    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        function orderNotification(order) {
            toastr.options.closeButton = true;
            toastr.options.timeOut = 0;
            toastr.options.extendedTimeOut = 0;
            toastr.info('A new order has been successfully placed (' + order.order_number + ').', ' New Order Placed');
        }

        function showNotification(status, title, message) {
            toastr.options.closeButton = true;
            toastr.options.timeOut = 10000;
            toastr.options.extendedTimeOut = 10000;
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
                showNotification("{{ session('message')['type'] }}", "{{ session('message')['title'] }}",
                    "{{ session('message')['body'] }}");
            });
        </script>
    @endif

    <link rel="icon" href="{{ asset('images/company-logo.png') }}" />
    <title>Admin | Dairy Raisers</title>
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
    </style>
</head>

<body id="page-top">
    <audio id="notification-sound">
        <source src="{{ asset('sounds/order_notification_sound.wav') }}" type="audio/wav">
    </audio>
    <div id="loading-animation-id" class="loading-overlay">
        <div id="spinner-border" class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion exclude-print" style="width: 800px"
            id="accordionSidebar">

            <a class="sidebar-brand d-flex align-items-center justify-content-between"
                href="{{ route('admin.dashboard') }}">
                <div class="">
                    <img src="{{ asset('images/company-logo.png') }}" class="img-fluid" alt="Company logo">
                </div>
                <div class="text-right">
                    <span class="d-inline-block text-truncate">Dairy Raisers</span>
                </div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Interface
            </div>
            {{-- ACCOUNT --}}
            <li class="nav-item {{ Request::routeIs('admin.staff.*') ? 'active' : '' }}" data-base-route="admin.staff">
                <a class="nav-link" href="{{ route('admin.staff.index') }}">
                    <i class="fa-solid fa-user-tie"></i>
                    <span>Staff Management</span>
                </a>
            </li>
            {{-- BUFFALOS --}}
            <li class="nav-item {{ Request::routeIs('admin.dairy.*') ? 'active' : '' }}" data-base-route="admin.dairy">
                <a class="nav-link" href="{{ route('admin.dairy.index') }}">
                    <i class="fa-solid fa-cow"></i>
                    <span>Buffalo Management</span>
                </a>
            </li>
            {{-- PRODUCTS --}}
            <li class="nav-item {{ Request::routeIs('admin.products.*') ? 'active' : '' }}"
                data-base-route="admin.products">
                <a class="nav-link" href="{{ route('admin.products.index') }}">
                    <i class="fa-solid fa-bottle-water"></i>
                    <span>Product Management</span>
                </a>
            </li>
            {{-- ORDERS --}}
            <li class="nav-item {{ Request::routeIs('admin.orders.*') ? 'active' : '' }}"
                data-base-route="admin.orders">
                <a class="nav-link" href="{{ route('admin.orders.index') }}">
                    <i class="fa-solid fa-truck-moving"></i>
                    <span>Order Management</span>
                </a>
            </li>
            {{-- PAYMENT METHODS --}}
            <li class="nav-item {{ Request::routeIs('admin.payment_method.*') ? 'active' : '' }}"
                data-base-route="admin.payment_method">
                <a class="nav-link" href="{{ route('admin.payment_method.index') }}">
                    <i class="fa-solid fa-credit-card"></i>
                    <span>Payment Methods</span>
                </a>
            </li>
            {{-- ACTIVITY LOGS --}}
            <li class="nav-item {{ Request::routeIs('admin.activity_logs') ? 'active' : '' }}"
                data-base-route="admin.activity_logs">
                <a class="nav-link" href="{{ route('admin.activity_logs') }}">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                    <span>Activity Logs</span>
                </a>
            </li>


            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Analytics
            </div>

            {{-- SALES REPORT --}}
            <li class="nav-item {{ Request::routeIs('admin.sales_report.index') ? 'active' : '' }}"
                data-base-route="admin.sales_report">
                <a class="nav-link" href="{{ route('admin.sales_report.index') }}">
                    <i class="fa-solid fa-diagram-project"></i>
                    <span>Sales Report</span></a>
            </li>



            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    {{-- <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small"
                                placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form> --}}

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span
                                    class="mr-2 d-none d-lg-inline text-gray-600 small">{{ auth()->guard('admin')->user()->name }}</span>
                                <img class="img-profile rounded-circle" src="{{ asset('images/avatar-woman.png') }}">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="{{ route('admin.profile.index') }}">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ URL::secure(route('logout.admin')) }}"
                                    data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    @yield('content')



                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto exclude-print">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; General Trias Dairy Raisers Multi-Purpose Cooperative 2023</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="{{ route('logout.admin') }}">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/sb-admin-2/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2/sb-admin-2.min.js') }}"></script>

    <script src="{{ asset('js/sb-admin-2/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2/sb-admin-2.min.js') }}"></script>

    <script src="{{ asset('js/sb-admin-2/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2/dataTables.bootstrap4.min.js') }}"></script>

    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- DataTables JS -->

    <script>
        $(document).ready(function() {
            $('#loading-animation-id').hide();
            var notificationSound = new Audio('{{ asset('sounds/order_notification_sound.wav') }}');

            // Enable pusher logging - don't include this in production
            // Pusher.logToConsole = true;

            var pusher = new Pusher('f25da7ad5e99d90d9214', {
                cluster: 'ap1',
            });

            var channel = pusher.subscribe('admin-channel');
            channel.bind('order-notification', function(data) {
                var order = JSON.parse(JSON.stringify(data));
                notificationSound.play();
                orderNotification(order.order);

            });

            $("input[type='number']").on("keydown", function(event) {
                // Allow only digits, backspace, and decimal point
                if (!((event.keyCode >= 48 && event.keyCode <= 57) || // Digits
                        event.keyCode === 8 || // Backspace
                        event.keyCode === 46 || // Delete
                        event.keyCode === 37 || // Left arrow
                        event.keyCode === 39 || // Right arrow
                        event.keyCode === 190 || // Decimal point (.)
                        event.keyCode === 110)) { // Numpad decimal point (.)
                    event.preventDefault();
                }
            });
            // Get the current route name
            var currentRoute = '{{ Route::currentRouteName() }}';

            // Loop through each sidebar menu item
            $('.nav-item').each(function() {
                var baseRoute = $(this).data('base-route');

                // Check if the current route starts with the base route name
                if (currentRoute.startsWith(baseRoute)) {
                    $(this).addClass('active');
                }
            });

            let logoutTimer;

            function resetLogoutTimer() {
                clearTimeout(logoutTimer);

                // Set the timeout to 30 minutes (1800000 milliseconds)
                logoutTimer = setTimeout(function() {
                    // Call the logout function or redirect to logout URL
                    // For example, assuming you have a logout route in Laravel:
                    window.location.href = '{{ route('logout.admin') }}';
                }, 3600000); // 30 minutes
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

</body>

</html>
