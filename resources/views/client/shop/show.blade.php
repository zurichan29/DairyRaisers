@extends('layouts.client')
@section('content')

    <div class="justify-center text-center items-center uppercase pb-10">
        <h1 class="title text-center mt-10 mb-14 text-[#199696] text-5xl font-bold">Taste the Gentri's Best</h1>
    </div>

    <section class="p-category flex pb-14 px-6 text-xl text-white text-center uppercase">

        <form action="{{ URL::secure(route('shop')) }}" method="GET" class="items-left text-left w-[30%] mr-10">
            <div>
                <label class="bg-[#5f9ea0] py-2 pl-3 pr-[30px] rounded-t-2xl font-semibold">Filter by Variant<i class="fa-solid fa-filter ml-[50px]"></i></label>
            </div>
            <div class=" py-4 h-[8%] pl-5 text-base font-semibold uppercase">
                <div class="pt-1 pb-2">
                    <label class="text-[#d2691e]">
                        <input type="checkbox" name="variants[]" value="Milk" class="cursor-pointer">
                        <span class="ml-4">Milk</span>
                    </label>
                </div>
                <div class="pt-1 pb-2">
                    <label class="text-[#d2691e]">
                        <input type="checkbox" name="variants[]" value="Yoghurt" class="cursor-pointer">
                        <span class="ml-4">Yoghurt</span>
                    </label>
                </div>
                <div class="pt-1 pb-2">    
                    <label class="text-[#d2691e]">
                        <input type="checkbox" name="variants[]" value="Pastillas" class="cursor-pointer">
                        <span class="ml-4">Pastillas</span>
                    </label>
                </div>
                <div class="pt-1 pb-2">
                    <label class="text-[#d2691e]">
                        <input type="checkbox" name="variants[]" value="Jelly" class="cursor-pointer">
                        <span class="ml-4">Jelly</span>
                    </label>
                </div>
                <div class="pt-1 pb-2">
                    <label class="text-[#d2691e]">
                        <input type="checkbox" name="variants[]" value="Frozen Dessert" class="cursor-pointer">
                        <span class="ml-4">Frozen Dessert</span>
                    </label>
                </div>
                <div class="pt-1 pb-2">
                    <label class="text-[#d2691e]">
                        <input type="checkbox" name="variants[]" value="Cheese" class="cursor-pointer">
                        <span class="ml-4">Cheese</span>
                    </label>
                </div>
            </div>

            <div class="pt-[15rem]">
                <div>
                    <label class="bg-[#5f9ea0] py-2 pl-3 pr-[30px] rounded-t-2xl font-semibold">Sort by Price <i class="fa-solid fa-sort ml-[90px]"></i></label>
                </div>
                <div class="pt-2">
                    <select name="sort_by" class="text-[#d2691e] text-base font-semibold pt-2 pb-4 h-[8%] pl-5 pr-[118px] cursor-pointer">
                        <option value="" class="text-base font-semibold cursor-pointer">None</option>
                        <option value="low_to_high" class="text-base font-semibold cursor-pointer">Lowest to Highest</option>
                        <option value="high_to_low" class="p-text-base font-semibold cursor-pointer">Highest to Lowest</option>
                    </select>
                </div>
            </div>
        </form>
    
        <!-- Display filtered products / or all products -->
        <div id="filtered-products" class="products grid grid-cols-3 px-4 justify-center text-center items-start w-full gap-8">
            @if ($products)
                @foreach ($products as $product)
                    <div class="box-container text-center">
                        <form method="GET" action="{{ URL::secure(route('product.view', ['id' => $product->id])) }}"
                            class="item relative p-8 bg-[#deb88757] rounded-2xl shadow-[5px_5px_20px_rgba(0,0,0,0.2)] hover:shadow-[1px_1px_15px_rgb(0,0,0,.3)] cursor-pointer transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-110 hover:bg-[#deb88757] duration-300"
                            method="POST">
                            <img src="{{ asset($product->img) }}" class="w-full" alt="">
                            <div class="name text-xl text-[#5f9ea0] pt-0 pr-0 capitalize">{{ $product->name }}</div>
                            <div class="pt-2 pr-0 text-[#d2691e] text-2xl">₱ <span>{{ $product->price }}</span></div>
                            <button
                                class="btn mt-4 text-lg bg-[#199696] w-fit relative py-4 px-8 text-white font-bold uppercase text-xs rounded hover:shadow-[1px_1px_15px_rgb(0,0,0,.6)] transition delay-80 hover:-translate-y-1 hover:scale-90 duration-300"
                                type="submit">Add to Cart</button>
                        </form>
                    </div>
                @endforeach
            @else
                <div class="w-2/4 text-xl font-semibold text-center p-4"><h1>NO PRODUCT FOUND</h1></div>
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
