<x-layout>
    @include('client.components.header')

    <form method="POST" action="{{ URL::secure(route('register.validate')) }}">
        @csrf
        <label for="mobile_number">Enter Mobile Number:</label>
        <input type="number" id="mobile_number" name="mobile_number" value="{{ old('mobile_number') }}">
        @error('mobile_number')
            <p>{{ $message }}</p>
        @enderror
        <button type="submit">submit</button>
    </form>

    @include('client.components.footer')
</x-layout>
