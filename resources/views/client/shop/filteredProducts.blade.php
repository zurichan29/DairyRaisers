@if ($products)
    <div class="row d-flex flex-pill h-100">
        @foreach ($products as $product)
            <div class="col-md-3 mb-3">
                <div class="card shadow d-flex flex-pill h-100">
                    <div class="card-header px-2 d-flex justify-content-between align-items-center">
                        <h6 class="text-primary text-start">{{ $product->name }}</h6>
                        <h6 class="text-primary">₱{{ $product->price . '.00' }}</h6>
                    </div>
                    <div class="card-body d-flex justify-content-between align-items-center flex-column">
                        <img src="{{ asset($product->img) }}" class="img-fluid" style="height: 220px"
                            alt="product picture">
                        <div class="d-grid mt-3">
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
