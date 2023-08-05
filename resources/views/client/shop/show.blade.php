@extends('layouts.client')
@section('content')


    <div class="text-center mb-5">
        <h1 style="color:#007bff; margin-bottom:3rem; margin-top:1rem; text-transform:uppercase;">
            <strong>Taste the Gentri's Best</strong>
        </h1>
    </div>

    <section class="panel text-center" style="border: none; box-shadow: none; display:flex;">

        <form action="{{ URL::secure(route('shop')) }}" method="GET" class="items-left text-left"
            style="margin-right:30px; width:300px; height: 470px; padding:30px; border-radius: 15px; box-shadow: 13px 13px 20px #cbced1, -13px -13px 20px #fff;">
            <div>
                <label class="panel-heading" style="color:#007bff;">
                    <i class="fa-solid fa-filter"></i>
                    <strong> Filter by Variant</strong></label>
            </div>
            <div class="panel-body">
                <div class="pt-2 pb-2">
                    <label class="" style="">
                        <input type="checkbox" name="variants[]" value="Milk" style="cursor: pointer">
                        <span class="ml-4">Milk</span>
                    </label>
                </div>

                <div class="pb-2">
                    <label class="">
                        <input type="checkbox" name="variants[]" value="Yoghurt" style="cursor-pointer">
                        <span class="ml-4">Yoghurt</span>
                    </label>
                </div>
                <div class="pb-2">
                    <label class="">
                        <input type="checkbox" name="variants[]" value="Pastillas" style="cursor-pointer">
                        <span class="ml-4">Pastillas</span>
                    </label>
                </div>
                <div class="pb-2">
                    <label class="">
                        <input type="checkbox" name="variants[]" value="Jelly" style="cursor-pointer">
                        <span class="ml-4">Jelly</span>
                    </label>
                </div>
                <div class="pb-2">
                    <label class="">
                        <input type="checkbox" name="variants[]" value="Frozen Dessert" style="cursor-pointer">
                        <span class="ml-4">Frozen Dessert</span>
                    </label>
                </div>
                <div class="pb-2">
                    <label class="">
                        <input type="checkbox" name="variants[]" value="Cheese" style="cursor-pointer">
                        <span class="ml-4">Cheese</span>
                    </label>
                </div>
            </div>
            <hr>
            <div style="margin-top: 40px">
                <div>
                    <label class="panel-heading" style="color:#007bff;"><i class="fa-solid fa-sort"></i>
                        <strong> Sort by Price</strong></label>
                </div>
                <div class="panel-body">
                    <select name="sort_by" class=""
                        style="cursor: pointer; outline: none; color: #666; border-radius: 5px; box-shadow: inset 5px 5px 5px #cbced1, inset -5px -5px 5px #fff;">
                        <option value="" style="cursor: pointer">None</option>
                        <option value="low_to_high" style="cursor: pointer">Lowest to Highest</option>
                        <option value="high_to_low" style="cursor: pointer">Highest to Lowest</option>
                    </select>
                </div>
            </div>
        </form>

        <!-- Display filtered products / or all products -->
        <div id="filtered-products" class="row product-list text-center">
            @if ($products)
                <div class="row d-flex flex-pill h-100">


                    @foreach ($products as $product)
                        <div class="col-md-3 mb-3">
                            <form method="GET" action="{{ URL::secure(route('product.view', ['id' => $product->id])) }}">
                                <div class="card shadow">
                                    <div class="card-header px-2 d-flex justify-content-between align-items-center">
                                        <h6 class="text-primary text-start">{{ $product->name }}</h6>
                                        <h6 class="text-primary">₱{{ $product->price . '.00' }}</h6>
                                    </div>
                                    <div class="card-body">
                                        <img src="{{ asset($product->img) }}" class="img-fluid" alt="product picture">
                                        <div class="d-grid">
                                            <button class="btn btn-primary" type="submit">
                                                Add to Cart
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        
                    @endforeach
                </div>
            @else
                <div class="font-semibold text-center p-4">
                    <h1>NO PRODUCT FOUND</h1>
                </div>
            @endif
        </div>

    </section>
    <script>
        $(document).ready(function() {
            $('input[name="variants[]"], select[name="sort_by"]').on('change', function() {

                var selectedVariants = $('input[name="variants[]"]:checked').map(function() {
                    return $(this).val();
                }).get();
                var selectedSortBy = $('select[name="sort_by"]').val();

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
                        // Handle error if necessary
                    }
                });
            });
        });
    </script>

@endsection
