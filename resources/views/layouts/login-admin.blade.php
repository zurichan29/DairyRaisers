<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('images/company-logo.png') }}" />
    <script src="https://kit.fontawesome.com/95c5b29ec4.js" crossorigin="anonymous"></script>
    <link href="{{ asset('css/sb-admin-2/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sb-admin-2/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sb-admin-2/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css" />

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
    <title>Login at Dairy Raisers</title>
</head>

<body>

    @yield('content')


    <script src="{{ asset('js/sb-admin-2/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2/sb-admin-2.min.js') }}"></script>

    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/index.js') }}"></script>

    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</body>

</html>
