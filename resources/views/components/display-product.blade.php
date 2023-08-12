    <div class="row align-items-center mb-4">
        <div class="col-3">
            <img src="{{ asset($img) }}" class="img-fluid" alt="Item picture">
        </div>
        <div class="col-9">
            <h6 class="font-weight-normal">
                {{ $name }}
                <span class="text-secondary">
                    {{ ' | ' . $variant }}
                </span>
            </h6>
            <div class="row gx-5">
                <div class="col">
                    <div class="">
                        <h6 class="text-secondary">
                            ₱{{ $price }}.00
                        </h6>
                    </div>
                </div>
                <div class="col">
                    <div class="">
                        <h6 class="text-secondary">
                            {{ $quantity }} PCS
                        </h6>
                    </div>
                </div>
            </div>
            <div class="border-top border-secondary mb-2"></div>
            <h5 class="font-weight-bold">
                Total: ₱{{ $total }}.00
            </h5>
        </div>
    </div>
