@extends('layouts.client')
@section('content')

    <p>{{ $user->mobile_number }}</p>
    <form action="{{ route('edit.name') }}" method="POST">
        @csrf
        <input type="text" name="first_name" value="{{ $user->first_name }}" placeholder="name">
        <input type="text" name="last_name" value="{{ $user->last_name }}" placeholder="name">
        <button type="submit">change</button>
    </form>
    @if ($user->email)
        <p>{{ $user->email }}</p>
    @else
        <a href="{{ URL::secure(route('email.form')) }}">Create an email</a>
    @endif


    <a href="{{ route('profile.address') }}">go to address</a>
    <a href="{{ url()->previous() }}">go back</a>

@endsection
