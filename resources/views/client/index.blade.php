@extends('layouts.client')
@section('content')
    <!--slider-->
    <style>
       
        @media only screen and (max-width: 767px) {

            .container-box {
                margin-bottom: 25px;
            }

            .index-title {
                font-size: 23px !important;
            }

            .index-sub-title {
                font-size: 20px !important;
            }

            .index-image {
                width: 40px !important;
            }

            .index-p {
                font-size: 12px !important;
            }

            .carousel-item-name {
                font-size: 17px !important;
            }

            .carousel-image {
                width: 40px !important;
            }

            .carousel-items {
                flex-direction: column !important;
            }

            .index-about-section {
                flex-direction: column !important;
                gap: 25px !important;
            }
        }

    </style>


    <div id="carouselExampleIndicators" class="carousel mb-5 slide container-box" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100" src="{{ asset('images/bg.jpg') }}" alt="First slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="{{ asset('images/bg-slide2.jpg') }}" alt="Second slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="{{ asset('images/bg-slide3.png') }}" alt="Third slide">
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <section class="features-icons bg-light text-center my-5 container-box">
        <div class="container">
            <div class="mb-5">
                <h1 style="color:#007bff; margin-bottom:4rem;"><strong class="index-title">WHAT WE OFFER</strong></h1>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3" style="max-width: 17rem;">
                        <div class="features-icons-icon d-flex" style="height: 7rem;"><i class="fa-solid fa-tag"
                                style="font-size: 4.5rem; margin-left: 6.5rem;"></i></div>
                        <h3 style="font-size: 22px; font-weight: 600; margin-bottom: 15px; text-transform: uppercase; color:#007bff;"
                            class="index-sub-title fs-4 ">
                            Affordable Products
                        </h3>
                        <p style="font-size:13px; color:#666; text-transform:uppercase;" class="lead mb-0 index-p">
                            Everyone can be healthy in an affordable price!
                        </p>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3" style="max-width: 17rem;">
                        <div class="features-icons-icon d-flex" style="height: 7rem;"><i class="fa-solid fa-cow"
                                style="font-size: 4.5rem; margin-left: 5rem;"></i></div>
                        <h3 style="font-size: 22px; font-weight: 600; margin-bottom: 15px; text-transform: uppercase; color:#007bff;"
                            class="index-sub-title">
                            Fresh Milk
                        </h3>
                        <p style="font-size:13px; color:#666; text-transform:uppercase;" class="lead mb-0 index-p">
                            Featuring products that made from buffalos milk!
                        </p>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="features-icons-item mx-auto mb-0 mb-lg-3" style="max-width: 17rem;">
                        <div class="features-icons-icon d-flex" style="height: 7rem;"><i
                                class="fa-solid fa-hand-holding-dollar" style="font-size: 4.5rem; margin-left: 5rem;"></i>
                        </div>
                        <h3 style="font-size: 22px; font-weight: 600; margin-bottom: 15px; text-transform: uppercase; color:#007bff;"
                            class="index-sub-title">
                            Flexible Payments
                        </h3>
                        <p style="font-size:13px; color:#666; text-transform:uppercase;" class="lead mb-0 index-p">
                            Easy to order with your own devices, with flexible payment methods!
                        </p>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3" style="max-width: 17rem;">
                        <div class="features-icons-icon d-flex" style="height: 7rem;"><i class="fa-regular fa-circle-check"
                                style="font-size: 4.5rem; margin-left: 5.5rem;"></i>
                        </div>
                        <h3 style="font-size: 22px; font-weight: 600; margin-bottom: 15px; text-transform: uppercase; color:#007bff;"
                            class="index-sub-title">
                            Quality Control Passed
                        </h3>
                        <p style="font-size:13px; color:#666; text-transform:uppercase;" class="lead mb-0 index-p">
                            Featuring the good quality products passed in quality control!
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Start about us Area -->
    <section class="cown-down my-5 container-box">
        <div class="container-fluid p-0">
            <div class="d-flex index-about-section align-items-center justify-content-between g-0">
                <div class="">
                    <div class="image">
                        <img src="{{ asset('images/dairy.jpg') }}" alt="#" style="width:100%; height:100%;"
                            class="img-fluid img-carousel">
                    </div>
                </div>
                <div class="">
                    <div class="content">
                        <div class="heading-block text-center">
                            <h1 class="title text-primary">
                                <strong class="index-sub-title">ABOUT US</strong>
                            </h1>
                            <p class="index-p text fs-5">The General
                                Trias Dairy Raisers Multi-Purpose Cooperative is an authorized distributor of dairy
                                products, from
                                7-21 dairy products and flavor variants.
                                They also promote dairying and dairy enterprise that improves the quality of life of the
                                carabao
                                raisers.
                            </p>
                            <a href="{{ route('about') }}">
                                <button class="btn btn-primary mt-2">
                                    Know More</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /End about us Area -->


    <div id="myCarousel" class="text-center carousel slide my-5 container-box" data-ride="carousel" data-interval="0">
        <!-- Carousel indicators -->
        <h1 class="text-primary mb-2"><strong class="index-sub-title">PRODUCT VARIANTS</strong></h1>
        <ol class="carousel-indicators" style="	bottom: -50px;">
            <li data-target="#myCarousel" data-slide-to="0" class="active"
                style="width: 10px; height: 10px; margin: 4px;
                  border-radius: 50%; border-color: transparent; border: none; background: rgba(0, 0, 0, 0.6);">
            </li>
            <li data-target="#myCarousel" data-slide-to="1"
                style="	width: 10px; height: 10px; margin: 4px;
                  border-radius: 50%; border-color: transparent; border: none; background: rgba(0, 0, 0, 0.2);">
            </li>
        </ol>
        <!-- Wrapper for carousel items -->
        <div class="carousel-inner">
            <div class="carousel-item active" style="min-height: 330px; text-align: center; overflow: hidden;">
                <div class="d-flex carousel-items align-items-center justify-content-around">
                    <div class="">
                        <div class="thumb-wrapper" style="text-align: center;">
                            <div class="img-box" style="height: 160px; width: 100%; position: relative;">
                                <img src="{{ asset('images/cheeses.png') }}" class="img-carousel img-fluid mx-auto d-block"
                                    alt=""
                                    style="	max-width: 100%; max-height: 100%;
                          display: inline-block; position: absolute; bottom: 0; margin: 0 auto; left: 0; right: 0;">
                            </div>
                            <div class="thumb-content">
                                <h4 style="font-size: 25px; margin: 10px 0; color:#007bff">
                                    <strong class="carousel-item-name">Cheeses</strong>
                                </h4>
                                <div class="star-rating">
                                    <ul class="list-inline">
                                        <li class="list-inline-item" style="padding: 0;">
                                            <i class="fa fa-star"style="font-size: 14px; color: #ffc000;"></i>
                                        </li>
                                        <li class="list-inline-item" style="padding: 0;">
                                            <i class="fa fa-star"style="font-size: 14px; color: #ffc000;"></i>
                                        </li>
                                        <li class="list-inline-item" style="padding: 0;">
                                            <i class="fa fa-star"style="font-size: 14px; color: #ffc000;"></i>
                                        </li>
                                        <li class="list-inline-item" style="padding: 0;">
                                            <i class="fa fa-star"style="font-size: 14px; color: #ffc000;"></i>
                                        </li>
                                        <li class="list-inline-item" style="padding: 0;">
                                            <i class="fa fa-star"style="font-size: 14px; color: #ffc000;"></i>
                                        </li>
                                    </ul>
                                </div>
                                <a href="{{ route('shop') }}" class="btn btn-primary" style="margin-top: 5px;">Shop
                                    Now</a>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <div class="thumb-wrapper" style="text-align: center;">
                            <div class="img-box" style="height: 160px; width: 100%; position: relative;">
                                <img src="{{ asset('images/frozen.png') }}" class="img-fluid img-carousel mx-auto d-block" alt=""
                                    style="max-width: 100%; max-height: 100%;
                            display: inline-block; position: absolute;">
                            </div>
                            <div class="thumb-content">
                                <h4 style="font-size: 25px; color:#007bff">
                                    <strong>Frozen
                                        Desserts</strong>
                                </h4>
                                <div class="star-rating">
                                    <ul class="list-inline">
                                        <li class="list-inline-item" style="padding: 0;">
                                            <i class="fa fa-star"style="font-size: 14px; color: #ffc000;"></i>
                                        </li>
                                        <li class="list-inline-item" style="padding: 0;">
                                            <i class="fa fa-star"style="font-size: 14px; color: #ffc000;"></i>
                                        </li>
                                        <li class="list-inline-item" style="padding: 0;">
                                            <i class="fa fa-star"style="font-size: 14px; color: #ffc000;"></i>
                                        </li>
                                        <li class="list-inline-item" style="padding: 0;">
                                            <i class="fa fa-star"style="font-size: 14px; color: #ffc000;"></i>
                                        </li>
                                        <li class="list-inline-item" style="padding: 0;">
                                            <i class="fa fa-star"style="font-size: 14px; color: #ffc000;"></i>
                                        </li>
                                    </ul>
                                </div>
                                <a href="{{ route('shop') }}" class="btn btn-primary" style="margin-top: 5px;">Shop
                                    Now</a>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <div class="thumb-wrapper" style="text-align: center;">
                            <div class="img-box" style="	height: 160px; width: 100%; position: relative;">
                                <img src="{{ asset('images/jelly.png') }}" class="img-fluid img-carousel mx-auto d-block" alt=""
                                    style="	max-width: 100%; max-height: 100%;
                            display: inline-block; position: absolute; bottom: 0;">
                            </div>
                            <div class="thumb-content">
                                <h4 style="font-size: 25px; color:#007bff">
                                    <strong>Jelly</strong>
                                </h4>
                                <div class="star-rating">
                                    <ul class="list-inline">
                                        <li class="list-inline-item" style="padding: 0;">
                                            <i class="fa fa-star"style="font-size: 14px; color: #ffc000;"></i>
                                        </li>
                                        <li class="list-inline-item" style="padding: 0;">
                                            <i class="fa fa-star"style="font-size: 14px; color: #ffc000;"></i>
                                        </li>
                                        <li class="list-inline-item" style="padding: 0;">
                                            <i class="fa fa-star"style="font-size: 14px; color: #ffc000;"></i>
                                        </li>
                                        <li class="list-inline-item" style="padding: 0;">
                                            <i class="fa fa-star"style="font-size: 14px; color: #ffc000;"></i>
                                        </li>
                                        <li class="list-inline-item" style="padding: 0;">
                                            <i class="fa fa-star"style="font-size: 14px; color: #ffc000;"></i>
                                        </li>
                                    </ul>
                                </div>
                                <a href="{{ route('shop') }}" class="btn btn-primary" style="margin-top: 5px;">Shop
                                    Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-item" style="min-height: 330px; text-align: center; overflow: hidden;">
                <div class="d-flex carousel-items align-items-center justify-content-around">
                    <div class="">
                        <div class="thumb-wrapper" style="text-align: center;">
                            <div class="img-box" style="height: 160px; width: 100%; position: relative;">
                                <img src="{{ asset('images/milks.png') }}" class="img-fluid img-carousel mx-auto d-block" alt=""
                                    style="	max-width: 100%; max-height: 100%;
                            display: inline-block; position: absolute;">
                            </div>
                            <div class="thumb-content">
                                <h4 style="font-size: 25px; color:#007bff">
                                    <strong>Milks</strong>
                                </h4>
                                <div class="star-rating">
                                    <ul class="list-inline">
                                        <li class="list-inline-item" style="padding: 0;">
                                            <i class="fa fa-star"style="font-size: 14px; color: #ffc000;"></i>
                                        </li>
                                        <li class="list-inline-item" style="padding: 0;">
                                            <i class="fa fa-star"style="font-size: 14px; color: #ffc000;"></i>
                                        </li>
                                        <li class="list-inline-item" style="padding: 0;">
                                            <i class="fa fa-star"style="font-size: 14px; color: #ffc000;"></i>
                                        </li>
                                        <li class="list-inline-item" style="padding: 0;">
                                            <i class="fa fa-star"style="font-size: 14px; color: #ffc000;"></i>
                                        </li>
                                        <li class="list-inline-item" style="padding: 0;">
                                            <i class="fa fa-star"style="font-size: 14px; color: #ffc000;"></i>
                                        </li>
                                    </ul>
                                </div>
                                <a href="{{ route('shop') }}" class="btn btn-primary" style="margin-top: 5px;">Shop
                                    Now</a>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <div class="thumb-wrapper" style="text-align: center;">
                            <div class="img-box" style="height: 160px; width: 100%; position: relative;">
                                <img src="{{ asset('images/pastillas.png') }}" class="img-fluid img-carousel mx-auto d-block" alt=""
                                    style="	max-width: 100%; max-height: 100%;
                            display: inline-block; position: absolute;">
                            </div>
                            <div class="thumb-content">
                                <h4 style="font-size: 25px; margin: 10px 0; color:#007bff">
                                    <strong>Pastillas</strong>
                                </h4>
                                <div class="star-rating">
                                    <ul class="list-inline">
                                        <li class="list-inline-item" style="padding: 0;">
                                            <i class="fa fa-star"style="font-size: 14px; color: #ffc000;"></i>
                                        </li>
                                        <li class="list-inline-item" style="padding: 0;">
                                            <i class="fa fa-star"style="font-size: 14px; color: #ffc000;"></i>
                                        </li>
                                        <li class="list-inline-item" style="padding: 0;">
                                            <i class="fa fa-star"style="font-size: 14px; color: #ffc000;"></i>
                                        </li>
                                        <li class="list-inline-item" style="padding: 0;">
                                            <i class="fa fa-star"style="font-size: 14px; color: #ffc000;"></i>
                                        </li>
                                        <li class="list-inline-item" style="padding: 0;">
                                            <i class="fa fa-star"style="font-size: 14px; color: #ffc000;"></i>
                                        </li>
                                    </ul>
                                </div>
                                <a href="{{ route('shop') }}" class="btn btn-primary" style="margin-top: 5px;">Shop
                                    Now</a>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <div class="thumb-wrapper" style="text-align: center;">
                            <div class="img-box" style="height: 160px; width: 100%; position: relative;">
                                <img src="{{ asset('images/yoghurt.png') }}" class="img-fluid carousel-img mx-auto d-block" alt=""
                                    style="max-width: 100%; max-height: 100%;
                            display: inline-block; position: absolute;">
                            </div>
                            <div class="thumb-content">
                                <h4 style="font-size: 25px; color:#007bff">
                                    <strong>Yoghurts</strong>
                                </h4>
                                <div class="star-rating">
                                    <ul class="list-inline">
                                        <li class="list-inline-item" style="padding: 0;">
                                            <i class="fa fa-star"style="font-size: 14px; color: #ffc000;"></i>
                                        </li>
                                        <li class="list-inline-item" style="padding: 0;">
                                            <i class="fa fa-star"style="font-size: 14px; color: #ffc000;"></i>
                                        </li>
                                        <li class="list-inline-item" style="padding: 0;">
                                            <i class="fa fa-star"style="font-size: 14px; color: #ffc000;"></i>
                                        </li>
                                        <li class="list-inline-item" style="padding: 0;">
                                            <i class="fa fa-star"style="font-size: 14px; color: #ffc000;"></i>
                                        </li>
                                        <li class="list-inline-item" style="padding: 0;">
                                            <i class="fa fa-star"style="font-size: 14px; color: #ffc000;"></i>
                                        </li>
                                    </ul>
                                </div>
                                <a href="{{ route('shop') }}" class="btn btn-primary" style="margin-top: 5px;">Shop
                                    Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Carousel controls -->
        <a class="carousel-control-prev" href="#myCarousel" data-slide="prev"
            style="height: 100px;width: 40px; background: none; margin: auto 0;">
            <i class="fa fa-angle-left"
                style="font-size: 30px; position: absolute; top: 50%; display: inline-block; margin: -16px 0 0 0;
                  z-index: 5; left: 0; right: 0; color: #007bff; text-shadow: none; font-weight: bold; margin-left: -3px;">
            </i>
        </a>
        <a class="carousel-control-next" href="#myCarousel" data-slide="next"
            style="height: 100px; width: 40px; background: none; margin: auto 0;">
            <i class="fa fa-angle-right"
                style="font-size: 30px; position: absolute; top: 50%; display: inline-block; margin: -16px 0 0 0;
                  z-index: 5; left: 0; right: 0; color: #007bff; text-shadow: none; font-weight: bold; margin-right: -3px;">
            </i>
        </a>
    </div>
   
@endsection
