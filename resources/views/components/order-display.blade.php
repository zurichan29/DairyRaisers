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
                    <h6 class="text-primary">
                        PHP {{ $price . '.00' }}
                    </h6>
                </div>
            </div>
            <div class="col">
                <div class="">
                    <h6 class="text-primary">
                        {{ $quantity }} PCS
                    </h6>
                </div>
            </div>
        </div>
        <div class="border-top mb-2"></div>
        <h4 class="font-weight-bold text-primary">
            TOTAL : PHP {{ $total . '.00' }}
        </h4>

    </div>
</div>
