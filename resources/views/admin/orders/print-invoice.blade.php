@extends('layouts.admin')

@section('content')
    @if (session('no_access'))
        <div class="alert alert-danger mt-3">
            {{ session('no_access') }}
        </div>
    @else
        <style>
            @media print {
                .exclude-print {
                    display: none;
                }
            }
        </style>
        <div id="printableContent" class="card container shadow">
            <button type="button" id="buffaloPrintButton" onclick="printInvoice({{ $order->id }})"
                class="position-absolute top-0 end-0 mr-4 mt-4 btn btn-outline-primary exclude-print"><i
                    class="fa-solid fa-print"></i>
                Print</button>
            <a href="{{ route('admin.orders.index') }}"
                class="position-absolute top-0 start-0 ml-4 mt-4 btn btn-secondary exclude-print">Back</a>
            <div class="card-header d-flex flex-column align-items-center justify-content-center">
                <img src="{{ asset('images/company-logo.png') }}" class="img-fluid" style="width: 80px" alt="company logo">
                <p class="card-title fw-bold fs-4">General Trias Dairy Raisers Multi-Purpose Cooperative</p>
                <p class="mb-0">Santiago, General Trias, 4107 Philippines</p>
                <p> gentridairympc@ymail.com | +63 997 251 4142</p>
            </div>
            <div class="card-body mb-2">
                <p class="fw-bold fs-4 text-center mb-4">ORDER INVOICE</p>
                <div class="row">
                    <div class="col">
                        <p>Name: {{ $order->name }}</p>
                        @if ($order->customer_type != 'retailer')
                            <p>Email: {{ $order->email }}</p>
                        @else
                            <p>Store: {{ $order->store_name }}</p>
                        @endif
                        <p>Phone No: +63{{ $order->mobile_number }}</p>
                        <p>Address: {{ $order->address }}</p>
                    </div>
                    <div class="col">
                        <p>Invoice Date: {{ $order->created_at->format('F d, Y h:i A') }}</p>
                        <p>Order No: {{ $order->order_number }}</p>
                        <p>Signature: ___________________________________</p>
                    </div>
                </div>
                <table class="table table-bordered" style="font-size: 15px">
                    <thead>
                        <tr>
                            <th scope="col">Product</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Price</th>
                            <th scope="col">Total</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        @foreach ($order->items as $item)
                            <tr>
                                <td>{{ $item['name'] }}</td>
                                <td>{{ $item['quantity'] }}</td>
                                <td>₱{{ $item['price'] }}.00</td>
                                <td class="fw-bold">₱{{ $item['total'] }}.00</td>
                            </tr>
                        @endforeach
                        <tr class="fw-bold" style="font-size: 17px">
                            <td colspan="3" class="text-end">GRAND TOTAL:</td>
                            <td>₱{{ $order->grand_total }}.00</td>
                        </tr>
                    </tbody>
                </table>
                <div class="row mt-4">
                    <div class="col">
                        <p class="">Recieved the above articles in good order condition.</p>
                        <p class="mb-2">Mode Of Payment: {{ $order->payment_method }}</p>
                        @if ($order->customer_type != 'retailer')
                            <p class="mb-2">Reference No: {{ $order->reference_number }}</p>
                        @endif
                        <p class="mb-2">Shipping Option: {{ $order->shipping_option }}</p>

                        <p class="mt-3">Thank you for purchasing!</p>

                    </div>
                    <div class="col text-end">

                        <p class="mb-0">______________________________</p>

                        <p>Cashier/Representative</p>
                    </div>
                </div>
            </div>

            <!-- Your invoice content goes here -->
            <!-- Use the data from the $order variable to populate the content -->
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/print-js/1.0.63/print.min.js"></script>

        <script>
            function printInvoice(id) {
                const printWindow = window.open(`{{ route('admin.dairy.print-invoice', '') }}/${id}`, '_blank');

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
                document.getElementById('buffaloPrintButton').style.display = 'none';

                // Use window.print() to open the print dialog.
                window.print();

                // Optional: You can show the "Print" button again after printing.
                document.getElementById('buffaloPrintButton').style.display = 'block';
            }
        </script>
    @endif
@endsection
