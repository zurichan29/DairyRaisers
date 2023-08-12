@extends('layouts.client')
@section('content')
    <!-- Remove Confirmation Modal -->
    <div class="modal fade" id="removeConfirmationModal" tabindex="-1" aria-labelledby="removeConfirmationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel">Confirmation</h5>
                    <button type="button" class="close" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to remove the selected address?
                </div>
                <div class="modal-footer">
                    <form method="POST" id="removeAddressForm">
                        @csrf
                        <input type="hidden" name="address_id" id="remove_address_id">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-danger" id="confirmRemoveButton">Yes</button>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!--Default Confirmation Modal -->
    <div class="modal fade" id="defaultConfirmationModal" tabindex="-1" aria-labelledby="defaultConfirmationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel">Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to make this address as default?
                </div>
                <div class="modal-footer">
                    <form method="POST" id="defaultAddressForm">
                        @csrf
                        <input type="hidden" name="address_id" id="default_address_id">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-danger" id="confirmDefaultButton">Yes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="">
        <p>ADDRESSES</p>
    </div>

    <a href="{{ route('address.create') }}" class="btn btn-primary">Create Address</a>

    <button type="button" id="edit-button" class="btn btn-primary">Edit Address</button>
    <button type="button" id="remove-button" class="btn btn-danger">Remove Address</button>
    <button type="button" id="default-button" class="btn btn-info">Set to Default</button>

    <div class="container">
        <div class="row" id="user-address">
            @foreach ($addresses as $key => $value)
                <div class="col">
                    <div class="card shadow">
                        <div class="card-header text-center">
                            <input type="radio" class="btn-check" name="select-address" value="{{ $value->id }}"
                                id="address-{{ $key + 1 }}" autocomplete="off">
                            <label class="btn btn-outline-success" for="address-{{ $key + 1 }}">select</label>
                            <p>Address {{ $key + 1 }}</p>
                        </div>
                        <div class="card-body">
                            <p>{{ $value->default }}</p>
                            <p>{{ $key + 1 }}</p>
                            <p>{{ $value->region }}</p>
                            <p>{{ $value->province }}</p>
                            <p>{{ $value->municipality }}</p>
                            <p>{{ $value->barangay }}</p>
                            <p>{{ $value->street }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>


    <script>
        $(document).ready(function() {

            $("#edit-button").click(function() {
                var selectedAddress = $("input[name='select-address']:checked").val();
                if (selectedAddress) {
                    var url = "{{ route('address.edit', ['id' => ':id']) }}";
                    url = url.replace(':id', selectedAddress);
                    location.href = url;
                } else {
                    NotifyUser('error', 'Error', 'No address selected.');
                }
            });

            $("#remove-button").click(function() {
                var selectedAddress = $("input[name='select-address']:checked").val();
                if (selectedAddress) {
                    $('#removeConfirmationModal').modal('show');
                } else {
                    NotifyUser('error', 'Error', 'No address selected.');
                }
            });

            $("#cancelRemoveButton, #removeConfirmationModal .close").click(function() {
                $('#removeConfirmationModal').modal('hide');
            });

            // Handle the removal confirmation
            $("#confirmRemoveButton").click(function() {
                var selectedAddress = $("input[name='select-address']:checked").val();
                if (selectedAddress) {
                    // Update the form action with the selected address ID
                    var formAction = "{{ route('address.delete', ['id' => 'ADDRESS_ID']) }}";
                    formAction = formAction.replace('ADDRESS_ID', selectedAddress);
                    $("#removeAddressForm").attr("action", formAction);

                    $('#removeAddressForm').submit(); // Submit the form
                }
            });

            $("#default-button").click(function() {
                var selectedAddress = $("input[name='select-address']:checked").val();
                if (selectedAddress) {
                    $('#defaultConfirmationModal').modal('show');
                } else {
                    NotifyUser('error', 'Error', 'No address selected.');
                }
            });

            $("#canceldefaultButton, #defaultConfirmationModal .close").click(function() {
                $('#defaultConfirmationModal').modal('hide');
            });

            // Handle the removal confirmation
            $("#confirmDefaultButton").click(function() {
                var selectedAddress = $("input[name='select-address']:checked").val();
                if (selectedAddress) {
                    // Update the form action with the selected address ID
                    var formAction = "{{ route('address.default', ['id' => 'ADDRESS_ID']) }}";
                    formAction = formAction.replace('ADDRESS_ID', selectedAddress);
                    $("#defaultAddressForm").attr("action", formAction);

                    $('#defaultAddressForm').submit();
                }
            });
        });
    </script>
@endsection
