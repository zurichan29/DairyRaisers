@extends('layouts.admin')

@section('content')

    {{-- make and insert here the css for print buffao sales --}}
    <style>
        @media print {
            .exclude-print {
                display: none;
            }
        }
    </style>
    <div id="printableContent" class="card container shadow">
        <button type="button" id="printButton" onclick="printInvoice()"
            class="position-absolute top-0 end-0 mr-4 mt-4 btn btn-outline-primary exclude-print"><i class="fa-solid fa-print"></i>
            Print</button>
        <a href="{{ route('admin.products.index') }}"
            class="position-absolute top-0 start-0 ml-4 mt-4 btn btn-secondary exclude-print">Back</a>
        <div class="card-header d-flex flex-column align-items-center justify-content-center">
            <img src="{{ asset('images/company-logo.png') }}" class="img-fluid" style="width: 80px" alt="company logo">
            <p class="card-title fw-bold fs-4">General Trias Dairy Raisers Multi-Purpose Cooperative</p>
            <p class="mb-0">Santiago, General Trias, 4107 Philippines</p>
            <p> gentridairympc@ymail.com | +63 997 251 4142</p>
        </div>
        <div class="card-body">
            <p class="fw-bold fs-4 text-center mb-4">PRODUCT INVENTORY</p>
            <table class="table table-bordered" id="dataTable" style="font-size: 15px">
                <thead>
                    <tr>
                        <th class="">NAME</th>
                        <th class="">VARIANT</th>
                        <th class="">PRICE</th>
                        <th class="">STOCKS</th>
                        <th class="">STATUS</th>
                        <th class="">UPDATED AT</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th class="">NAME</th>
                        <th class="">VARIANT</th>
                        <th class="">PRICE</th>
                        <th class="">STOCKS</th>
                        <th class="">STATUS</th>
                        <th class="">UPDATED AT</th>
                    </tr>
                </tfoot>
                <tbody class="table-group-divider">
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/print-js/1.0.63/print.min.js"></script>

    <script>
        function printInvoice(id) {
            const printWindow = window.open(`{{ route('admin.products.print', '') }}`, '_blank');

            const closePrintTab = function() {
                printWindow.close();
            };

            printWindow.onload = function() {
                printWindow.print();
            };

            // Listen for the beforeprint event
            window.addEventListener('beforeprint', closePrintTab);

            // Remove the event listener if the user cancels the print
            window.addEventListener('afterprint', function() {
                window.removeEventListener('beforeprint', closePrintTab);
            });
        }
        
        //Print
        function printInvoice(id) {
            // Optional: You can hide the "Print" button before printing.
            document.getElementById('printButton').style.display = 'none';
                
            // Use window.print() to open the print dialog.
            window.print();

            // Optional: You can show the "Print" button again after printing.
            document.getElementById('printButton').style.display = 'block';
        }
    </script>
    
    
@endsection