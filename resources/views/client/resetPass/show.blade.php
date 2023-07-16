@extends('layouts.client')
@section('content')

    <form method="POST" action="{{ route('forgot_password.validate') }}">
        @csrf
        <label for="mobile_number">Enter Mobile Number</label>
        <input type="number" name="mobile_number" id="mobile_number" value="{{ old('mobile_number') }}" required>
        @error('mobile_number')
            <div class="error">{{ $message }}</div>
        @enderror
        <button type="submit">Submit</button>
    </form>

@endsection