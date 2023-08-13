@if ($addresses->isNotEmpty())
    @foreach ($addresses as $key => $value)
        <div class="col">
            <div class="card shadow d-flex flex-fill h-100">
                <div class="card-header d-flex justify-content-between align-items-center text-center">
                    <p class="fw-bold">Address #{{ $key + 1 }}
                        @if ($value->default == 1)
                            <span class="ms-2 badge rounded-pill bg-danger">
                                <span id="cartCount">default</span>
                        @endif
                    </p>
                    <div class="dropdown">
                        <button class="btn rounded-3 btn-light" type="button" id="actionsDropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa-solid fa-ellipsis-vertical"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="actionsDropdown">
                            <a href="{{ route('address.edit', ['id' => $value->id]) }}" class="dropdown-item">
                                Edit
                            </a>
                            <buttton type="button" class="dropdown-item default-button"
                                data-address-id="{{ $value->id }}" data-toggle="modal"
                                data-target="#confirmDefaultModal">
                                Set as default
                            </buttton>
                            <button type="button" class="dropdown-item remove-button"
                                data-address-id="{{ $value->id }}" data-toggle="modal"
                                data-target="#confirmDeleteModal">
                                Remove
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <p>{{ $value->street . ' ' . ucwords(strtolower($value->barangay)) . ', ' . ucwords(strtolower($value->municipality)) . ', ' . ucwords(strtolower($value->province)) . ', ' . $value->zip_code . ' Philippines' }}
                    </p>
                </div>
            </div>
        </div>
    @endforeach
@else
    <p>You have no address yet. Please create in order to make a purchase.</p>
@endif
