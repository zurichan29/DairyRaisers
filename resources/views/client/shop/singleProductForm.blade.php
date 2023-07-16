@extends('layouts.client')
@section('content')

    <div class=" flex justify-center items-center py-28">

        <div class=" box-container text-center">

            <form action="{{ route('product.add', ['productId' => $product->id]) }}" method="POST"
                class=" relative p-4 w-[20rem] bg-[#deb88757] justify-center text-center rounded-2xl shadow-[5px_5px_20px_rgba(0,0,0,0.2)]">
                <a href="{{ route('shop') }}"><i
                        class="fa-solid fa-circle-xmark flex text-xl ml-[270px] text-red-500 cursor-pointer"></i></a>

                @csrf
                <img src="{{ asset('images/Baka.png') }}" class="w-[10rem] ml-16" alt="">
                <h1 class="text-[#d2691e] text-2xl font-semibold pb-5">{{ $product->name }}</h1>
                <input type="number" name="quantity" value="1"
                    class="justify-center text-center font-semibold text-[#199696] px-4 py-2 rounded-xl">
                <button type="submit"
                    class="mt-10 mb-3 text-lg bg-[#199696] w-fit relative py-4 px-8 text-white font-bold uppercase text-xs rounded hover:shadow-[1px_1px_15px_rgb(0,0,0,.6)] transition delay-80 hover:-translate-y-1 hover:scale-90 duration-300">
                    Add to Cart</button>
            </form>
        </div>
    </div>

    <div class="p-8 pb-20 bg-[#fff8dc]">
        <div class="pb-16 flex justify-center items-center font-semibold text-[#199696] text-2xl">You May Also Like
        </div>
        <section class=" grid grid-cols-5 gap-8 justify-center text-center items-center w-full">

            @foreach ($randomProducts as $product)
                <div
                    class="p-4 h-[20rem] bg-[#deb88757] rounded-2xl shadow-[5px_5px_20px_rgba(0,0,0,0.2)] hover:shadow-[1px_1px_15px_rgb(0,0,0,.3)] cursor-pointer transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-110 hover:bg-[#deb88757] duration-300">
                    <a href="">
                        <img src="{{ asset('images/Baka.png') }}" class="w-[10rem] ml-6" alt="">
                        <h1 class="text-[#d2691e] text-xl font-semibold pb-5">{{ $product->name }}</h1>
                        <p class="pt-2 pr-0 text-[#199696] text-xl">₱ {{ $product->price }}</p>
                        {{-- <a href="{{ route() }}"></a> --}}
                    </a>
                </div>
            @endforeach

        </section>
    </div>

@endsection
