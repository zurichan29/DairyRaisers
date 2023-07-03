<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('images/company-logo.png') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        laravel: "#ef3b2d",
                    }
                },
            },
        };
    </script>
    <title>Dairy Raisers</title>
    
</head>

<body class="mb-48 h-screen bg-yellow-50">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <main>
        {{-- VIEW OUTPUT --}}
        {{ $slot }}
    </main>

</body>
<script>
    var isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};
</script>
<script src="{{ asset('js/index.js') }}"></script>
{{-- <script src="{{ asset('js/filter_shop.js') }}"></script> --}}

</html>
