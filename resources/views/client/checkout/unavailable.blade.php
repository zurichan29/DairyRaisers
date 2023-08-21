@extends('layouts.client')
@section('content')
    <div class="">
        @if ($notificationMessage)
            <p>{{ $notificationMessage }}</p>
        @endif
    </div>
@endsection