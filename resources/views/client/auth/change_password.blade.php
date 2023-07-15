@extends('layouts.client')
@section('content')
    @include('client.components.header')
    <form method="POST" action="{{ URL::secure(route('forgot_password.change', ['mobile_number' => $mobile_number])) }}">
        
    </form>


    @include('client.components.footer')
@endsection
