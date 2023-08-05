@if ($products)
    @foreach ($products as $product)
        <div class="box-container col-md-4 text-center" style="display:flex; max-width: 300px; min-height: 400px; margin:auto; margin-bottom:30px; padding:30px;
            background-color: #ecf0f3; border-radius: 15px; box-shadow: 13px 13px 20px #cbced1, -13px -13px 20px #fff;">
            <form method="GET" action="{{ URL::secure(route('product.view', ['id' => $product->id])) }}"
                class="item" method="POST">
                <img src="{{ asset($product->img) }}" alt="" style="width: 60%; border-radius: 4px 4px 0 0; -webkit-border-radius: 4px 4px 0 0;">
                <div class="panel-body text-center" style="margin-bottom: 50px">
                    <h4>
                        <a class="name pro-title"><strong>{{ $product->name }}</strong></a>
                    </h4>
                    <p class="price" style="width: 100%; border: none; outline: none; background: none;
                    font-size:1rem; color: #666; padding: 10px 15px 10px 10px; margin-bottom: 20px; border-radius: 10px;
                    box-shadow: inset 5px 5px 5px #cbced1, inset -5px -5px 5px #fff;">₱ {{ $product->price }} </p>
                </div>                
                <button
                    class="btn btn-primary" type="submit" style="width: 100%; height: 40px;
                    border-radius: 10px; box-shadow: 3px 3px 3px #b1b1b1, -3px -3px 3px #fff; letter-spacing: 1.2px;">
                    Add to Cart
                </button>
            </form>
        </div>
    @endforeach
@else
    <div class="">
        <h1>NO PRODUCT FOUND</h1>
    </div>
@endif
