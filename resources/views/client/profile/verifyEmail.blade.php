@extends('layouts.client')
@section('content')
    @include('client.components.header')
    <h1>verify your email: {{ $user->email }}</h1>
    <form method="POST" action="{{ URL::secure(route('email.resend')) }}">
        @csrf
        <button type="submit">SEND CODE AGAIN</button>
    </form>
    <a href="{{ URL::secure(route('email.change-show')) }}">Change Email</a>

    @include('client.components.footer')
@endsection
