<x-layout>
    @include('client.components.header')
    
    @if ($addresses)
        @foreach ($addresses as $address)
            <h1>Province: {{ $address['province'] }}</h1>
            <h1>City: {{ $address['city'] }}</h1>
            <h1>Barangay: {{ $address['barangay'] }}</h1>
            <h1>Street: {{ $address['street'] }}</h1>
            <h1>Label: {{ $address['label'] }}</h1>
            <h1>Zip Code: {{ $address['zip_code'] }}</h1>
            <h1>Default: {{ $address['default'] }}</h1>
            <a href="{{ URL::secure(route('edit.address', ['id' => $address['id']])) }}">Edit Address</a>
            @if ($address['default'] != 1)
                <form action="{{ route('default.address', ['id' => $address['id']]) }}" method="post">
                    @csrf
                    <button type="submit">Make Default</button>
                </form>
            @endif
            <br>
        @endforeach
    @else
        <h1>NO ADDRESS FOUND</h1>
    @endif
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('create.address') }}" method="POST">
        @csrf

        <label for="street">Street:</label>
        <input type="text" name="street" id="street" required>
        <label for="barangay">Barangay:</label>
        <input type="text" name="barangay" id="barangay" required>
        <label for="city">City:</label>
        <input type="text" name="city" id="city" required>
        <label for="province">Province:</label>
        <input type="text" name="province" id="province" required>

        <label for="zip_code">Zip Code:</label>
        <input type="number" name="zip_code" id="zip_code" required>

        <select name="label" id="label">
            <option value="home">home</option>
            <option value="office">office</option>
        </select>

        <button type="submit">create address</button>
    </form>


    @include('client.components.footer')
</x-layout>
