@extends('layouts.client')
@section('content')
    <style>
        tr {
            display: table-row;
        }

        td {
            display: table-cell;
            vertical-align: middle;
            text-align: center;
        }
    </style>
        <div class="coontainer text-center mb-3">
            <p class="fs-2">Your Cart</p>
            @if ($cart)
                <div class="table-responsive">
                    <table class="table table-bordered align-middle" cellspacing="0">
                        <thead class="">
                            <tr>
                                <th></th>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody class="text-center table-group-divider">
                            @foreach ($cart as $item)
                                <tr>
                                    <td class="align-middle">
                                        <button class="btn btn-sm btn-danger btn-remove"><i class="fa-solid fa-xmark"></i>
                                            Remove</button>
                                    </td>
                                    <td>
                                        <div class="">
                                            <div>
                                                <img src="{{ asset($item['img']) }}" alt=""
                                                    class="logo img-fluid" />
                                            </div>
                                            <div>
                                                <h6 class="font-weight-normal">
                                                    {{ $item['name'] }}
                                                    <span class="text-secondary">
                                                        {{ ' | ' . $item['variant'] }}
                                                    </span>
                                                </h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle">₱{{ $item['price'] }}.00</td>
                                    <td class="align-middle">
                                        <input type="number"
                                            class="form-control cart-item quantity-input text-center mx-auto"
                                            value="{{ $item['quantity'] }}" data-cart-id={{ $item['product_id'] }}
                                            style="width: 100px">
                                    </td>
                                    <td class="align-middle">₱<span class="cart-total">{{ $item['total'] }}</span>.00</td>

                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-end"><strong>Grand Total:</strong> </td>
                                <td class="align-middle fw-bold" colspan="1">
                                    ₱<span id="grandTotal">{{ $grand_total }}</span>.00
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <a href="{{ route('checkout') }}" class="btn btn-primary">Checkout</a>
            @else
                <div class=" justify-center text-center items-center">
                    <img src="{{ asset('images/empty_cart.png') }}" alt="" style="width: 400px">
                    <div class="text-center">
                        <p>No items on your cart. Please select on product page.</p>
                    </div>
                </div>
            @endif
        </div>

    <script>
        $(document).ready(function() {
            $('.quantity-input').on('input', function() {
                var cartId = $(this).data('cart-id');
                var newQuantity = $(this).val();
                var cartTotalElement = $(this).closest('tr').find('.cart-total');
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: "{{ route('cart.update') }}",
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                        quantity: newQuantity,
                        cartId: cartId,
                    },
                    success: function(response) {
                        $('#cartTotal').text(response.grandTotal);
                        cartTotalElement.text(response.total);
                        $('#grandTotal').text(response.grandTotal);
                    },
                    error: function(response) {
                        console.log('Error:', response.errors);
                    }
                });
            });

            $(document).on('click', '.btn-remove', function() {
                var cartId = $(this).closest('tr').find('.cart-item').data('cart-id');
                var cartTotalElement = $(this).closest('tr').find('.cart-total');
                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url: "{{ route('cart.remove') }}",
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                        cartId: cartId,
                    },
                    success: function(response) {
                        $('#cartCount').text(response.count);
                        $('#cartTotal').text(response.grandTotal);
                        $(this).closest('tr').remove(); 
                        $('#grandTotal').text(response.grandTotal);
                    }.bind(this),
                    error: function(response) {
                        console.log('Error:', response.errors);
                    }
                });
            });

        });
    </script>
@endsection
