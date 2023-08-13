@extends('layouts.login-admin')

@section('content')
    <!-- component -->

    <body class="bg-gradient-primary">

        <div class="container">

            <!-- Outer Row -->
            <div class="row justify-content-center">

                <div class="col-xl-9 col-lg-12 col-md-9">

                    <div class="card o-hidden border-0 shadow-lg my-5">
                        <div class="card-body p-0">
                            <!-- Nested Row within Card Body -->
                            <div class="row">
                                <div class="col-lg-6 d-none d-lg-block bg-login-image">
                                    <h2 class="header-admin" style="width: 17rem;">Dairy Raisers</h2>
                                    <img src="/images/bg-login.png">
                                </div>
                                <div class="col-lg-6">
                                    <div style="padding-left: 25px; padding-right: 25px; padding-top: 20px;">
                                        <div class="text-center">
                                            <img src="{{ asset('images/company-logo.png') }}" class="img-fluid"
                                                style="width: 70px;" alt="company logo">
                                            <h1 class="h4">Welcome Back!</h1>
                                        </div>
                                        @if ($errors->any())
                                            <div class="">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li class="text-danger">{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                        <form class="user" action="{{ URL::secure(route('administrator.authenticate')) }}"
                                            method="POST">
                                            @csrf


                                            <div class="form-group">
                                                <input type="email" name="email" id="email" placeholder="Email"
                                                    class="form-control form-control-user">
                                            </div>
                                            <div class="form-group">
                                                <input type="password" class="form-control form-control-user"
                                                    name="password" id="password" placeholder="Password">
                                            </div>
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox small">
                                                    <input type="checkbox" class="custom-control-input" id="customCheck">
                                                    <label class="custom-control-label" for="customCheck">Remember
                                                        Me</label>
                                                </div>
                                            </div>
                                            <button class="btn btn-primary btn-user btn-block">
                                                Login</button>
                                        </form>
                                        <hr>
                                        <div class="text-center">
                                            <a class="small" href="#">Forgot Password?</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </body>
@endsection
