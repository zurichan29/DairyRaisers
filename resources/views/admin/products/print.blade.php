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


    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <title>Dairy Raisers</title>
</head>
<body>
    <div class="p-4">
        <div class="card shadow mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <a href="{{ route('admin.products.print') }}" id="print" class="btn btn-outline-primary">
                    <i class="fa-solid fa-print"></i> Print
                </a>
            </div>
            <div class="card-body" style="padding-left:70px; padding-right:70px;">
                <div class="pb-4  text-center">
                    <img src="{{ asset('images/company-logo.png') }}" style="width: 60px;">
                    <h3 style="font-size: 18px;">General Trias Dairy Raisers Multi-Purpose Cooperative</h3>
                </div>
                <div class="pb-4 text-center"><h2>Product Sales</h2></div>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="">NAME</th>
                                <th class="">VARIANT</th>
                                <th class="">PRICE</th>
                                <th class="">STOCKS</th>
                                <th>STATUS</th>
                                <th>UPDATED AT</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th class="">NAME</th>
                                <th class="">VARIANT</th>
                                <th class="">PRICE</th>
                                <th class="">STOCKS</th>
                                <th>STATUS</th>
                                <th>UPDATED AT</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($products as $product)
                                @php
                                    $icon = null;
                                    $badge = null;
                                    switch ($product->status) {
                                        case 'AVAILABLE':
                                            $icon = 'fa-solid fa-circle-check';
                                            $badge = 'badge-success';
                                            break;
                                    
                                        case 'NOT AVAILABLE':
                                            $icon = 'fa-solid fa-circle-xmark';
                                            $badge = 'badge-danger';
                                            break;
                                    
                                        default:
                                            # code...
                                            break;
                                    }
                                @endphp
                                <tr data-product-id="{{ $product->id }}">
                                    <td class="name-column">{{ $product->name }}</td>
                                    <td class="variant-column">{{ $product->variant->name }}</td>
                                    <td class="price-column">{{ $product->price }}</td>
                                    <td class="stock-column"> {{ $product->stocks }}</td>
                                    <td class="status-column"><span
                                            class="badge {{ $badge }}">{{ $product->status }} <i
                                                class="{{ $icon }}"></i></span>
                                    </td>
                                    <td class="update-column">
                                        {{ $product->updated_at }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/sb-admin-2/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2/sb-admin-2.min.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2/dataTables.bootstrap4.min.js') }}"></script>
    

    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/index.js') }}"></script>
    <script src="{{ asset('js/load_address.js') }}"></script>

    <script>
        window.addEventListener('DOMContentLoaded', function() {
            var navbarHeight = document.querySelector('.navbar').offsetHeight;
            var mainContent = document.getElementById('main-content');
            mainContent.style.marginTop = navbarHeight + 'px';
        });
    </script>

    <script>
        document.getElementById("print").addEventListener("click", function () {
            var table = document.getElementById("dataTable");
            if (table) {
                var newWin = window.open();
                newWin.document.open();
                
                // Add custom styles to the table and header
                newWin.document.write('<html><head>');
                newWin.document.write('<style>');
                newWin.document.write('body { font-family: Nunito; }');
                newWin.document.write('table { border-collapse: collapse; width: 100%; }');
                newWin.document.write('table, th, td { border: 1px solid black; padding: 8px; text-align: left; }');
                newWin.document.write('th { background-color: #f2f2f2; }');
                newWin.document.write('.header { text-align: center; font-size: 18px; margin-bottom: 20px; }');
                newWin.document.write('.company-logo { width: 60px; }');
                newWin.document.write('</style>');
                newWin.document.write('</head><body>');
                
                // Add header with image and heading
                var logoUrl = '{{ asset("images/company-logo.png") }}'; // Pass the absolute URL as a parameter
                newWin.document.write('<img src="' + logoUrl + '" class="company-logo" style="text-align: center;">');
                newWin.document.write('<h3 style="font-size: 18px; text-align: center;">General Trias Dairy Raisers Multi-Purpose Cooperative</h3>');
                newWin.document.write('<h2 style="text-align: center; padding-bottom:10px;">Daily Sales</h2>');
                           
                // Write the table content
                newWin.document.write('<table>');
                newWin.document.write(table.innerHTML);
                newWin.document.write('</table>');
                
                newWin.document.write('</body></html>');
                newWin.document.close();
                newWin.print();

                // Set a timer to close the print window and parent window
                var timer = setTimeout(function() {
                    newWin.close(); // Close the print window
                    window.close(); // Close the parent window (may not work in all browsers due to security)
                }, 5000); // Set the timer duration (in milliseconds)
                
                newWin.close();
                
                // Detect when print dialog is closed or completed
                newWin.onafterprint = function() {
                    clearTimeout(timer); // Cancel the timer if the print is completed
                    newWin.close(); // Close the print window
                };

            }
        });
    </script>
    
    
    
</body>
</html>