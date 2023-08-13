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

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css"/>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <title>Dairy Raisers</title>
</head>
<body>
    <div class="p-4">
        <div class="card shadow mb-3">
            <div class="card-header py-3">
                <div class="row">
                    <div class="col-md-8 d-flex justify-content-start align-items-center">
                        <h5 class="m-0 font-weight-bold text-primary">DAILY SALES (₱)</h5>
                        <div class="d-flex ml-3">
                            <input type="text" class="form-control form-control-sm ml-3" id="dateRange"
                                placeholder="Select date range" autocomplete="off">
                        </div>
                        <div class="d-flex ml-3">
                            <select lect id="categoryFilter" name="categoryFilter" class="form-select form-select-sm mr-2">
                                <option value="">All</option>
                                <option value="Products">Products</option>
                                <option value="Milk">Milk</option>
                                <option value="Buffalo">Buffalo</option>
                            </select>
                            <button type="button" id="applyCategoryFilterBtn" class="btn btn-sm btn-primary">Apply</button>
                        </div>
                    </div> <!-- COPY, PRINT, CSV AND EXCEL BUTTON -->
                    <div class="col-md-4 d-flex justify-content-end align-items-center">
                        <a href="{{ route('admin.sales_report.print') }}" id="print" class="btn btn-outline-primary">
                            <i class="fa-solid fa-print"></i> Print
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body" style="padding-left:70px; padding-right:70px;">
                <div class="pb-4 text-center">
                    <img src="{{ asset('images/company-logo.png') }}" style="width: 60px;">
                    <h3 style="font-size: 18px;">General Trias Dairy Raisers Multi-Purpose Cooperative</h3>
                </div>
                <div class="pb-4 text-center"><h2>Daily Sales</h2></div>

                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" style="font-size: 14px"
                        cellspacing="0">
                        <thead>
                            <tr>
                                <th>DATE</th>
                                <th>NAME</th>
                                <th>CATEGORY</th>
                                <th>PRICE</th>
                                <th>QTY</th>
                                <th>TOTAL SALES</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="5" style="text-align:right">Total:</th>
                                <th id="totalSalesValue"></th>
                            </tr>
                        </tfoot>
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