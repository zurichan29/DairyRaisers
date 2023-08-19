@foreach ($productsData as $product)
    @php
        $productData = Product::findOrFail($product['product_id']);
    @endphp

    <div class="col-md-4">
        <p>{{ $productData->name }}</p>
        <p class="fw-bold">Price: ₱{{ $product['price'] }}.00</p>
        <div class="form-floating mb-3">
            <input type="number" class="form-control quantity-input" id="quantity_{{ $productData->id }}"
                value="{{ $product['quantity'] }}" min="1">
                <label for="quantity_{{ $productData->id }}">Quantity *</label>
        </div>
        <div class="form-floating mb-3">
            <input type="number" class="form-control discount-input" id="discount_{{ $productData->id }}"
                value="{{ $product['discount'] }}" min="0">
                <label for="quantity_{{ $productData->id }}">Discount (optional)</label>
        </div>
        <p class="fw-bold">Total: ₱{{ $product['total'] }}.00</p>
    </div>

    @php
        $total += $product['total'];
    @endphp
@endforeach
