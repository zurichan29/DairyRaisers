@extends('layouts.client')
@section('content')
    <div style="max-width: 350px; min-height:fit-content; margin: 80px auto; padding: 30px 30px 30px 30px; background-color: #ecf0f3; border-radius: 15px; box-shadow: 13px 13px 20px #cbced1, -13px -13px 20px #fff;">

        <form action="{{ URL::secure(route('email.create')) }}" method="POST">
            @csrf
            <input type="email" name="email" placeholder="Add Email" style="width: 100%; border: none; outline: none; background: none; font-size:1rem; color: #666; padding: 10px 15px 10px 10px; margin-bottom: 20px; border-radius: 10px; box-shadow: inset 8px 8px 8px #cbced1, inset -8px -8px 8px #fff;">
            <button type="submit" name="submit" class="btn btn-primary" style=" height: 40px; border-radius: 10px; box-shadow: 3px 3px 3px #b1b1b1, -3px -3px 3px #fff; letter-spacing: 1.2px;">
                Create
            </button>
        </form>
    </div>
@endsection