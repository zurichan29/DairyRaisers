@extends('layouts.client')
@section('content')


        <div class="text-center mb-5">
            <h1 style="color:#007bff; margin-bottom:3rem; margin-top:1rem; text-transform:uppercase;">
                <strong>Taste the Gentri's Best</strong>
            </h1>
        </div>

        <section class="panel text-center" style="border: none; box-shadow: none; display:flex;">

            <form action="{{ URL::secure(route('shop')) }}" method="GET" class="items-left text-left" style="margin-right:30px; width:300px; height: 470px; padding:30px; border-radius: 15px; box-shadow: 13px 13px 20px #cbced1, -13px -13px 20px #fff;">
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
                        <select name="sort_by" class="" style="cursor: pointer; outline: none; color: #666; border-radius: 5px; box-shadow: inset 5px 5px 5px #cbced1, inset -5px -5px 5px #fff;">
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
                    @foreach ($products as $product)
                        <div class="box-container col-md-4 text-center" style="display:flex; max-width: 300px; min-height: 400px; margin:auto; margin-bottom:30px; padding:30px;
                        background-color: #ecf0f3; border-radius: 15px; box-shadow: 13px 13px 20px #cbced1, -13px -13px 20px #fff;">
                            <form method="GET" action="{{ URL::secure(route('product.view', ['id' => $product->id])) }}"
                                class="item panel" method="POST">
                                <div class="pro-img-box">
                                    <img src="{{ asset($product->img) }}" alt="" style="width: 60%;
                                    border-radius: 4px 4px 0 0;
                                    -webkit-border-radius: 4px 4px 0 0;">
                                </div>
                                <div class="panel-body text-center" style="margin-bottom: 50px">
                                    <h4>
                                        <a class="name pro-title"><strong>{{ $product->name }}</strong></a>
                                    </h4>
                                    <p class="price" style="width: 100%; border: none; outline: none; background: none;
                                    font-size:1rem; color: #666; padding: 10px 15px 10px 10px; margin-bottom: 20px; border-radius: 10px;
                                    box-shadow: inset 5px 5px 5px #cbced1, inset -5px -5px 5px #fff;">₱ {{ $product->price }} </p>
                                </div>

                                <button class="btn btn-primary" type="submit" style="width: 100%; height: 40px;
                                    border-radius: 10px; box-shadow: 3px 3px 3px #b1b1b1, -3px -3px 3px #fff; letter-spacing: 1.2px;">
                                    Add to Cart
                                </button>
                            </form>
                        </div>
                    @endforeach
                @else
                    <div class="font-semibold text-center p-4"><h1>NO PRODUCT FOUND</h1></div>
                @endif
            </div>

        </section>

    {{-- <section class="products grid grid-cols-4 px-8 mb-20 justify-center text-center items-start w-full gap-8">

        @foreach ($products as $product)
            <div class="box-container text-center">
                    <form method="GET" action="{{ route('product.view', ['id' => $product->id]) }}"
                        class="item relative p-8 bg-[#deb88757] rounded-2xl shadow-[5px_5px_20px_rgba(0,0,0,0.2)] hover:shadow-[1px_1px_15px_rgb(0,0,0,.3)] cursor-pointer transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-110 hover:bg-[#deb88757] duration-300"
                        method="POST">
                        <img src="{{ asset($product->img) }}" class="w-64" alt="">
                        <div class="name text-xl text-[#5f9ea0] pt-0 pr-0">{{ $product['name'] }}</div>
                        <div class="pt-2 pr-0 text-[#d2691e] text-2xl">₱ <span>{{ $product['price'] }}</span></div>

                        <button
                            class="btn mt-4 text-lg bg-[#199696] w-fit relative py-4 px-8 text-white font-bold uppercase text-xs rounded hover:shadow-[1px_1px_15px_rgb(0,0,0,.6)] transition delay-80 hover:-translate-y-1 hover:scale-90 duration-300"
                            type="submit">Add to Cart</button>
                    </form>
            </div>
        @endforeach
    </section> --}}

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
