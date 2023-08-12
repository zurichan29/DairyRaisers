@extends('layouts.client')
@section('content')
    @if (session('message'))
        <p>{{ session('message') }}</p>
    @endif
    <div class="row mb-3">
        <div class="col align-items-stretch">
            <div class="card shadow h-100">
                <div class="card-header text-primary">
                    <i class="fa-solid fa-sort"></i>
                    Sort by Price
                </div>
                <div class="card-body text-left" style="font-size: 14px">
                    <select name="sort_by" class="form-select">
                        <option value="" style="cursor: pointer">None</option>
                        <option value="low_to_high" style="cursor: pointer">Lowest to Highest</option>
                        <option value="high_to_low" style="cursor: pointer">Highest to Lowest</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-10 align-items-stretch">
            <div class="mb-3 d-flex justify-content-between">
                <div class="d-flex flex-column justify-content-between">
                    <div>
                        @auth
                            @if ($complete_address)
                                <span><span class="text-primary fw-bold">LOCATION :
                                    </span>{{ $complete_address }}</span>
                                <a href="{{ route('location.update-show') }}" class="ml-2 btn btn-sm btn-primary">Change</a>
                            @else
                                <a href="{{ route('location') }}" class="ml-2 btn btn-primary"><i
                                        class="fa-solid fa-location-crosshairs"></i> Set your
                                    location</a>
                                <span class="ml-2">and start ordering!</span>
                            @endif
                        @else
                            @if (session()->has('guest_address'))
                                <span><span class="text-primary fw-bold">LOCATION :
                                    </span>{{ session('guest_address')['complete_address'] }}</span>
                                <a href="{{ route('location.update-show') }}" class="ml-2 btn btn-sm btn-primary">Change</a>
                            @else
                                <a href="{{ route('location') }}" class="ml-2 btn btn-primary"><i
                                        class="fa-solid fa-location-crosshairs"></i> Set your
                                    location</a>
                                <span class="ml-2">and start ordering!</span>
                            @endif
                        @endauth

                    </div>
                    <div>
                        <!-- Empty space for vertical justification -->
                    </div>
                </div>
                <div>
                    <form class="d-none d-sm-inline-block form-inline mr-auto my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card text-center">
                <div class="card-body text-center">
                    <p class="text-primary fs-2">GENTRI'S BEST</p>
                </div>
            </div>
        </div>
    </div>


    <section class="panel text-center row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header text-primary">
                    <i class="fa-solid fa-filter"></i>
                    Filter by Variant
                </div>
                <div class="card-body text-left " style="font-size: 14px">
                    @foreach ($variants as $variant)
                        <div class="pt-2 pb-2">
                            <label class="" style="">
                                <input type="checkbox" name="variants[]" value="{{ $variant->id }}"
                                    style="cursor: pointer">
                                <span class="ml-4">{{ $variant->name }}</span>
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

        <div class="col-md-10">
            <div class="row product-list text-center">
                <div class="text-center text-primary" id="filter-products-loading" style="display: none">
                    <span class="spinner-border spinner-border-sm align-middle me-1" aria-hidden="true"></span>
                    <span role="status">Loading...</span>
                </div>
                <div id="filtered-products">
                    @if ($products)
                        <div class="row d-flex flex-pill h-100">
                            @foreach ($products as $product)
                                <div class="col-md-3 mb-3">
                                    <div class="card shadow">
                                        <div class="card-header px-2 d-flex justify-content-between align-items-center">
                                            <h6 class="text-primary text-start">{{ $product->name }}</h6>
                                            <h6 class="text-primary">₱{{ $product->price . '.00' }}</h6>
                                        </div>
                                        <div class="card-body">
                                            <img src="{{ asset($product->img) }}" class="img-fluid" alt="product picture">
                                            <div class="d-grid">
                                                <button type="submit" class="btn btn-primary add-to-cart-button"
                                                    data-product-id="{{ $product->id }}">
                                                    <span class="loading-spinner" style="display: none;">
                                                        <span class="spinner-border spinner-border-sm align-middle me-1"
                                                            aria-hidden="true"></span>
                                                        <span role="status">Loading...</span>
                                                    </span>
                                                    <span class="btn-text">Add to Cart</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="font-semibold text-center p-4">
                            <h1>NO PRODUCT FOUND</h1>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <script>
        $(document).ready(function() {

            $(document).on('click', '.add-to-cart-button', function() {
                var productId = $(this).data('product-id');
                var submitBtn = $(this);
                var loadingSpinner = submitBtn.find('.loading-spinner');
                var buttonText = submitBtn.find('.btn-text');
                var productId = submitBtn.data('product-id');

                submitBtn.prop('disabled', true);
                buttonText.hide();
                loadingSpinner.show();

                $.ajax({
                    url: "{{ route('product.update-cart') }}",
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        product_id: productId
                    },
                    success: function(response) {
                        if (response.error) {
                            NotifyUser('error', 'Error',
                                'Something went wrong. Please try again.');
                        } else {
                            $('#cartCount').text(response.count);
                            $('#cartTotal').text(response.total);
                            buttonText.text('Added (' + response.quantity + ')');
                            console.log(buttonText.text());
                            NotifyUser('success', 'TOTAL: ₱' + response.total + '.00', response
                                .product_name +
                                ' has added to cart (' + response.quantity + ').');
                        }

                    },
                    error: function(xhr) {
                        if (xhr.status === 404) {
                            alert('Product not found.'); // Handle 404 error
                        } else if (xhr.responseJSON.errors) {
                            window.location.href = "{{ route('location') }}";
                        } else {
                            console.log(xhr);
                        }

                    },
                    complete: function() {
                        submitBtn.prop('disabled', false);
                        buttonText.show();
                        loadingSpinner.hide();
                    }
                });
            });

            function initAddItem() {
                $.ajax({
                    url: "{{ route('product.fetch-cart') }}",
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        if (response.error) {
                            NotifyUser('error', 'Error',
                                'Something went wrong. Please try again.');
                        } else {
                            console.log(response.orderData);

                            for (var i = 0; i < response.orderData.length; i++) {
                                var product = response.orderData[i];

                                var img = product.img;
                                var name = product.name;
                                var price = product.price;
                                var productId = product.product_id;
                                var quantity = product.quantity;
                                var total = product.total;
                                var variant = product.variant;

                                $('.add-to-cart-button').each(function() {
                                    var id = $(this).data('product-id');
                                    var buttonText = $(this).find('.btn-text');
                                    if (id == productId) {
                                        console.log("Product Name:", name);
                                        buttonText.text('Added (' + quantity + ')');
                                    }
                                });
                            }

                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 404) {
                            alert('Product not found.'); // Handle 404 error
                        } else {
                            console.log(xhr);
                        }

                    }
                })
            }

            initAddItem();

            $('input[name="variants[]"], select[name="sort_by"]').on('change', function() {
                var selectedVariants = $('input[name="variants[]"]:checked').map(function() {
                    return $(this).val();
                }).get();
                var selectedSortBy = $('select[name="sort_by"]').val();

                $('#filter-products-loading').show();
                $('#filtered-products').html('');

                $.ajax({
                    url: "{{ route('shop') }}",
                    type: "GET",
                    data: {
                        variants: selectedVariants,
                        sort_by: selectedSortBy
                    },
                    success: function(response) {
                        $('#filtered-products').html(response);
                    },
                    error: function(xhr) {
                        console.log(xhr);
                    },
                    complete: function(xhr) {
                        $('#filter-products-loading').hide();
                        initAddItem();
                    }
                });
            });
        });
    </script>

@endsection
