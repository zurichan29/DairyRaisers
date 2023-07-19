@extends('layouts.client')
@section('content')

    <form action="{{ URL::secure(route('email.create')) }}" method="POST">
        @csrf
        <input type="email" name="email" placeholder="add email">
        <button type="submit" name="submit">create</button>
    </form>

@endsection