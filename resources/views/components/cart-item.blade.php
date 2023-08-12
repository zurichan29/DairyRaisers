<div class="row align-items-center mb-3">
    <div class="col-3">
        <img src="{{ asset($itemImage) }}" class="img-fluid" alt="Item picture">
    </div>
    <div class="col">
        <p class="font-weight-normal mb-0">
            {{ $itemName }}
            <span class="text-secondary">
                {{ ' | ' . $itemVariant }}
            </span>
        </p>
        <div class="row">
            <div class="col">
                <p class="text-secondary fw-light mb-0">
                    {{ $itemPrice }}
                </p>
            </div>
            <div class="col">
                <p class="text-secondary fw-light mb-0">
                    Quantity: {{ $itemQuantity }}
                </p>
            </div>
        </div>
        <div class="border-top mt-0 mb-1"></div>
        <p class="font-weight-bold">
            Total: {{ $itemTotal }}
        </p>
    </div>
</div>
