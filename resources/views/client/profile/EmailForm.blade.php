@extends('layouts.client')
@section('content')
    @include('client.components.header')
    <form action="{{ URL::secure(route('email.create')) }}" method="POST">
        @csrf
        <input type="email" name="email" placeholder="add email">
        <button type="submit" name="submit">create</button>
    </form>
    @include('client.components.footer')
@endsection