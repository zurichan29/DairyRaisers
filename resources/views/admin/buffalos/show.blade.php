@extends('layouts.admin')

@section('content')
    @if (session('no_access'))
        <div class="alert alert-danger mt-3">
            {{ session('no_access') }}
        </div>
    @else

        {{--@dd($buffalo_sales)--}}
        <div class="card">
            <div class="card-body mx-4">
                <div class="container">
                    <h4>
                        Invoice <i class="fa-solid fa-credit-card text-primary"></i>
                    </h4>
                    <div class="row">
                        <hr style="border: 1px solid black;">
                        <ul class="list-unstyled">
                            <li class="text-black">Buyer :</li>
                            <li class="text-muted mt-1"><span class="text-black">Address :</li>
                            <li class="text-black mt-1">Date :</li>
                        </ul>
                        <hr style="border: 1px solid black;">
                    </div>
                    <div class="row">
                        <div class="col-xl-10">
                            <p>Quantity : <span>0</span> Buffalo(s)</p>
                        </div>
                        <div class="col-xl-2">
                            <p class="float-end">0.00</p>
                        </div>
                    </div>

                    <div class="row">
                        <hr style="border: 1px solid black;">
                        </div>
                        <div class="row text-black">
                
                        <div class="col-xl-12">
                            <p class="float-end fw-bold">Total :<span>0</span>.00</p>
                        </div>
                        <hr>
                    </div>
          
                </div>
            </div>
        </div>

    @endif
@endsection
