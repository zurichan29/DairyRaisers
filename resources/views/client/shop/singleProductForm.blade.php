@extends('layouts.client')
@section('content')

    <div class="container mt-5" style="margin-bottom: 100px;">
        <div class="card" style="display:flex; max-width: 750px; min-height: 400px; margin:auto; margin-bottom:30px; padding:30px;
        background-color: #ecf0f3; border-radius: 15px; box-shadow: 13px 13px 20px #cbced1, -13px -13px 20px #fff;">
            <form action="{{ route('product.add', ['id' => $product->id]) }}" method="POST"
                class="row g-0">
                <a href="{{ route('shop') }}"></a>

                @csrf
                <div class="col-md-6 border-end">	
                    <div class="d-flex flex-column justify-content-center">	
                        <div class="main_image">
                            <img src="{{ asset('images/Baka.png') }}" width="350" alt="">
                        </div>
                    </div>
                </div>

                <div class="col-md-6" style="margin-top: 20px;">	
                    <div class="p-3 right-side">	
                        <div class="mb-4">
                            <h1 class="text-center" style="color: #666;">{{ $product->name }}</h1>
                        </div>
                        <input type="number" name="quantity" value="1"
                            class="form-control text-center">
                        <button class="btn btn-primary mt-4" type="submit" style="width: 100%; height: 40px;
                        border-radius: 10px; box-shadow: 3px 3px 3px #b1b1b1, -3px -3px 3px #fff; letter-spacing: 1.2px;">
                            Add to Cart</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="text-center" style="margin-top: 7rem; margin-bottom:3rem;">
        <h1 style="color:#007bff; margin-bottom:3rem; text-transform:uppercase;">
            <strong>You May Also Like</strong>
        </h1>
        <section class="justify-center text-center items-center" style="display:flex;">

            @foreach ($randomProducts as $product)
                <div style="display:flex; max-width: 220px; max-height: 300px; margin:auto; margin-bottom:30px; padding:30px;
                    background-color: #ecf0f3; border-radius: 15px; box-shadow: 13px 13px 20px #cbced1, -13px -13px 20px #fff;">
                    <a href="">
                        <div>
                            <img src="{{ asset('images/Baka.png') }}" class="" alt="" style="width: 100%; border-radius: 4px 4px 0 0;
                            -webkit-border-radius: 4px 4px 0 0;">
                        </div>
                        <div class="panel-body text-center" style="margin-bottom: 50px">
                            <h1 class="" style="font-size: 20px;"><strong>{{ $product->name }}</strong></h1>
                            <p class="pt-2" style=" border: none; outline: none; background: none; font-size:1rem; color: #666; padding: 10px 15px 10px 10px; margin-bottom: 20px; border-radius: 10px; box-shadow: inset 5px 5px 5px #cbced1, inset -5px -5px 5px #fff;">
                                ₱ {{ $product->price }}
                            </p>
                        </div>
                        {{-- <a href="{{ route() }}"></a> --}}
                    </a>
                </div>
            @endforeach

        </section>
    </div>

@endsection
