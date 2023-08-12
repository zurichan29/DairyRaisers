<div class="row p-2">
    <div class="col-md-12">
        @foreach ($dataArray as $item)
            <div class="row align-items-center mb-3">
                <div class="col-3">
                    <img src="{{ asset($item['img']) }}" class="img-fluid" alt="Item picture">
                </div>
                <div class="col">
                    <p class="font-weight-normal mb-0">
                        {{ $item->product->name }}
                        <span class="text-secondary">
                            {{ ' | ' . $item->product->variant }}
                        </span>
                    </p>
                    <div class="row">
                        <div class="col">
                            <p class="text-secondary fw-light mb-0">
                                ₱{{ $item->price . '.00' }}
                            </p>
                        </div>
                        <div class="col">
                            <p class="text-secondary fw-light mb-0">
                                Quantity: {{ $item->quantity }}
                            </p>
                        </div>
                    </div>
                    <div class="border-top mt-0 mb-1"></div>
                    <p class="font-weight-bold">
                        Total: ₱{{ $item->price * $item->quantity . '.00' }}
                    </p>
                </div>
            </div>
        @endforeach
        <div class="d-grid ">
            <a href="{{ route('checkout') }}" class="btn btn-sm btn-primary">Checkout</a>
        </div>
    </div>
</div>
