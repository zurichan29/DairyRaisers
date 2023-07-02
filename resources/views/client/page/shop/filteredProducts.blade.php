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
    <div class="w-2/4 text-xl font-semibold text-center p-4">
        <h1>NO PRODUCT FOUND</h1>
    </div>
@endif
