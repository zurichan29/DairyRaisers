@extends('layouts.client')
@section('content')

    <h1>verify your email: {{ $user->email }}</h1>
    <form method="POST" action="{{ URL::secure(route('email.resend')) }}">
        @csrf
        <button type="submit">SEND CODE AGAIN</button>
    </form>
    <a href="{{ URL::secure(route('email.change-show')) }}">Change Email</a>

@endsection
