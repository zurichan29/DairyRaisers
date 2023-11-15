@extends('layouts.client')
@section('content')
    <style>
        .image-container {
            position: relative;
        }

        .image-hover {
            transition: filter 0.3s;
        }

        .image-container:hover .image-hover {
            filter: blur(4px);
            /* Add blur effect on image hover */
        }

        .text-description {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 10px;
            display: none;
            text-align: center;
            max-width: 100%;
            /* Adjust the maximum width as needed */
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            word-wrap: break-word;
            max-height: 100%;
            /* Add max height for scrolling */
            box-shadow: 0px 20px 20px rgba(0, 0, 0, 0.5);
            /* Add a box shadow */
        }

        .image-container:hover .text-description {
            display: block;
            overflow: auto;
            overflow: ;
            /* Enable scrolling for long text */
            white-space: normal;
            max-height: 70%;
            /* Adjust the maximum height as needed */
        }


        .out-of-stock-card {
            opacity: 0.5;
            /* Reduce opacity */
            position: relative;
            /* Set position to relative for positioning */
        }

        .not-available-overlay {
            position: absolute;
            top: 50%;
            /* Position in the middle vertically */
            left: 50%;
            /* Position in the middle horizontally */
            transform: translate(-50%, -50%);
            /* Center the element */
            background-color: white;
            /* White background */
            padding: 10px;
            /* Add padding for text readability */
            font-weight: bold;
            text-align: center;
            width: 100%;
            z-index: 1;
            opacity: 1;
            /* Place above the blurred card */
        }

        @media only screen and (max-width: 767px) {}
    </style>
    {{-- <link rel="stylesheet" href="{{ asset('js/popper.min.js') }}"> --}}
    <div class="card mb-3 shadow">
        <div class="set-location card-body ">
            @auth
                @if ($complete_address)
                    <span><span class="text-primary fw-bold">LOCATION :
                        </span>{{ $complete_address }}</span>
                    <a href="{{ route('location.update-show') }}" class="ml-2 btn btn-sm btn-primary">Change</a>
                @else
                    <a href="{{ route('location') }}" class="ml-2 btn btn-primary"><i class="fa-solid fa-location-crosshairs"></i>
                        Set
                        your
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
                            class="fa-solid fa-location-crosshairs"></i>
                        Set your
                        location</a>
                    <span class="ml-2">and start ordering!</span>
                @endif
            @endauth
        </div>
    </div>

    <section class="text-center row m-0 p-0">
        <button class="btn btn-primary d-block d-md-none mb-3" type="button" data-bs-toggle="collapse"
            data-bs-target="#filter-collapse">
            Filters
        </button>
        <div class="collapse d-md-block col-md-3 mb-5" id="filter-collapse">
            <!-- Button to Toggle Filters -->

            <div class="mb-3">
                <form id="searchForm" class=" navbar-search">
                    <div class="input-group">
                        <input id="searchInput" type="text" class="form-control bg-light small"
                            placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button id="searchButton" class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card shadow mb-3">
                <div class="card-header text-primary">
                    <i class="fa-solid fa-sort"></i>
                    Sort by Price
                </div>
                <div class="card-body text-left " style="font-size: 14px">
                    <select name="sort_by" class="form-select">
                        <option value="" style="cursor: pointer">None</option>
                        <option value="low_to_high" style="cursor: pointer">Lowest to Highest</option>
                        <option value="high_to_low" style="cursor: pointer">Highest to Lowest</option>
                    </select>
                </div>
            </div>
            <div class="card shadow mb-3">
                <div class="card-header text-primary">
                    <i class="fa-solid fa-filter"></i>
                    Filter by Variant
                </div>
                <div class="card-body text-left " style="font-size: 14px">
                    <div class="row">
                        <div class="col-md-6">
                            @php
                                $totalVariants = count($variants);
                                $halfTotal = ceil($totalVariants / 2);
                            @endphp

                            @foreach ($variants as $index => $variant)
                                @if ($index < $halfTotal)
                                    <div class="pt-2 pb-2">
                                        <label class="">
                                            <input type="checkbox" name="variants[]" value="{{ $variant->id }}"
                                                style="cursor: pointer">
                                            <span class="ml-4">{{ $variant->name }}</span>
                                        </label>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <div class="col-md-6">
                            @foreach ($variants as $index => $variant)
                                @if ($index >= $halfTotal)
                                    <div class="pt-2 pb-2">
                                        <label class="">
                                            <input type="checkbox" name="variants[]" value="{{ $variant->id }}"
                                                style="cursor: pointer">
                                            <span class="ml-4">{{ $variant->name }}</span>
                                        </label>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="col-md-9">
            <div class="row product-list text-center">
                <div class="text-center text-primary" id="filter-products-loading" style="display: none">
                    <span class="spinner-border spinner-border-sm align-middle me-1" aria-hidden="true"></span>
                    <span role="status">Loading...</span>
                </div>
                <div id="filtered-products">
                    @if ($products)
                        <div class="row d-flex flex-pill h-100">
                            @foreach ($products as $product)
                                <div class="col-lg-4 col-md-6 mb-3">
                                    <div
                                        class="card shadow d-flex flex-pill h-100 @if ($product->stocks <= 0 || $product->status == 'NOT AVAILABLE') out-of-stock-card @endif">
                                        <div class="card-header px-2 d-flex justify-content-between align-items-center">
                                            <h6 class="text-primary text-start">{{ $product->name }}</h6>
                                            <h6 class="text-primary">₱{{ $product->price . '.00' }}</h6>
                                        </div>
                                        <div
                                            class="card-body d-flex justify-content-between align-items-center flex-column">
                                            <div class="image-container position-relative w-100 h-100">
                                                <!-- Add this container -->
                                                <img src="{{ asset($product->img) }}" class="img-fluid image-hover"
                                                    style="height: 220px" alt="product picture">
                                                <div class="text-description">
                                                    {{ $product->description }}
                                                </div>
                                                <!-- Add your product description here -->
                                            </div>
                                            @if ($product->stocks <= 0 || $product->status == 'NOT AVAILABLE')
                                                <div class="not-available-overlay fw-bold text-center"><i
                                                        class="fa-solid fa-circle-xmark"></i> NOT AVAILABLE</div>
                                            @else
                                                <div class="d-grid mt-3">
                                                    <button type="submit" class="btn btn-primary add-to-cart-button"
                                                        data-product-id="{{ $product->id }}">
                                                        <span class="loading-spinner" style="display: none;">
                                                            <span
                                                                class="spinner-border spinner-border-sm align-middle me-1"
                                                                aria-hidden="true"></span>
                                                            <span role="status">Loading...</span>
                                                        </span>
                                                        <span class="btn-text">Add to Cart</span>
                                                    </button>
                                                </div>
                                            @endif
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

            $('#searchButton').click(function() {
                var searchValue = $('#searchInput').val();
                searchProducts(searchValue);
            });

            $('#searchInput').keypress(function(e) {
                if (e.which === 13) { // Check if the pressed key is "Enter"
                    e.preventDefault(); // Prevent the default behavior (form submission)
                    $('#searchButton').trigger('click'); // Trigger the search button click
                }
            });

            $('input[name="variants[]"], select[name="sort_by"]').on('change', function() {
                var searchValue = $('#searchInput').val();
                searchProducts(searchValue);
            });

            function searchProducts(query) {
                var selectedVariants = $('input[name="variants[]"]:checked').map(function() {
                    return $(this).val();
                }).get();
                var selectedSortBy = $('select[name="sort_by"]').val();

                $('#filter-products-loading').show();
                $('#filtered-products').html('');
                console.log(selectedSortBy);
                $.ajax({
                    url: "{{ route('shop') }}",
                    type: "GET",
                    data: {
                        variants: selectedVariants,
                        sort_by: selectedSortBy,
                        search_query: query
                    },
                    success: function(response) {
                        $('#filtered-products').html(response);
                    },
                    error: function(xhr) {
                        console.log(xhr);
                    },
                    complete: function() {
                        $('#filter-products-loading').hide();
                        initAddItem();
                    }
                });
            }

        });
    </script>

@endsection
