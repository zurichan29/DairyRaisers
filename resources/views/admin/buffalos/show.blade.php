@extends('layouts.admin')

@section('content')
    @if (session('no_access'))
        <div class="alert alert-danger mt-3">
            {{ session('no_access') }}
        </div>
    @else
        {{-- make and insert here the css for print buffao sales --}}
        {{-- <link rel="stylesheet" href="{{ asset('css/buffalo-print.css') }}" media="print"> --}}
        <div id="printableContent" class="card container shadow">
            <button type="button" id="buffaloPrintButton" onclick="printInvoice({{ $buffalo_sales->id }})"
                class="position-absolute top-0 end-0 mr-4 mt-4 btn btn-outline-primary"><i class="fa-solid fa-print"></i>
                Print</button>
            <a href="{{ route('admin.dairy.index') }}"
                class="position-absolute top-0 start-0 ml-4 mt-4 btn btn-secondary">Back</a>
            <div class="card-header d-flex flex-column align-items-center justify-content-center">
                <img src="{{ asset('images/company-logo.png') }}" class="img-fluid" style="width: 80px" alt="company logo">
                <p class="card-title fw-bold fs-4">General Trias Dairy Raisers Multi-Purpose Cooperative</p>
                <p class="mb-0">Santiago, General Trias, 4107 Philippines</p>
                <p> gentridairympc@ymail.com | +63 997 251 4142</p>
            </div>
            <div class="card-body">
                <p class="fw-bold fs-4 text-center mb-4">BUFFALO SALES INVOICE</p>
                <div class="row">
                    <div class="col">
                        <p>Name: {{ $buffalo_sales->buyer_name }}</p>
                        <p>Phone No: +63{{ 9262189072 }}</p>
                        <p>Address: {{ $buffalo_sales->buyer_address }}</p>
                    </div>
                    <div class="col">
                        <p>Invoice Date: {{ $buffalo_sales->created_at->format('F d, Y h:i A') }}</p>
                        <p>Signature: ___________________________________</p>
                    </div>
                </div>
                <table class="table table-bordered" style="font-size: 15px">
                    <thead>
                        <tr>
                            <th scope="col">Gender</th>
                            <th scope="col">Age</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Price</th>
                            <th scope="col">Amount</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        @foreach (json_decode($buffalo_sales->details, true) as $sales)
                            <tr>
                                <td>{{ ucwords(strtolower($sales['gender'])) }}</td>
                                <td>{{ ucwords(strtolower($sales['age'])) }}</td>
                                <td>{{ $sales['quantity'] }}</td>
                                <td>₱{{ $sales['price'] }}</td>
                                <td class="fw-bold">₱{{ $sales['total'] }}</td>
                            </tr>
                        @endforeach
                        @for ($i = count(json_decode($buffalo_sales->details, true)); $i < 6; $i++)
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endfor
                        <tr class="fw-bold" style="font-size: 17px">
                            <td colspan="4" class="text-end">GRAND TOTAL:</td>
                            <td>₱{{ $buffalo_sales->grand_total }}</td>
                        </tr>
                    </tbody>
                </table>
                <div class="row mt-4">
                    <div class="col">
                        <p class="">Recieved the above articles in good order condition.</p>
                        <p class="mb-0">Mode Of Payment:</p>
                        <div class="form-check" style="font-size: 14px">
                            <input class="form-check-input" type="checkbox" value="" id="cash" checked>
                            <label class="form-check-label" for="cash">
                                Cash
                            </label>
                        </div>
                        <div class="form-check" style="font-size: 14px">
                            <input class="form-check-input" type="checkbox" value="" id="online_transfer">
                            <label class="form-check-label" for="online_transfer">
                                Online Transfer
                            </label>
                        </div>
                        <div class="form-check" style="font-size: 14px">
                            <input class="form-check-input" type="checkbox" value="" id="others">
                            <label class="form-check-label" for="others">
                                Others: _______________
                            </label>
                        </div>
                        <p class="mt-3">Thank you for purchasing!</p>

                    </div>
                    <div class="col text-end">
                        @if (auth()->guard('admin')->user()->name == 'Administrator')
                            <p class="mb-0">______________________________</p>
                        @else
                            <p class="mb-0"><u>{{ auth()->guard('admin')->user()->name }}</u></p>
                        @endif
                        <p>Cashier/Representative</p>
                    </div>
                </div>
            </div>
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
            $(document).ready(function() {

            });
        </script>
    @endif
@endsection
