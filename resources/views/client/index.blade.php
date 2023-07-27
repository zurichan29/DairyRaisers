@extends('layouts.client')
@section('content')

    <!--slider-->
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
      <ol class="carousel-indicators">
        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
      </ol>
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img class="d-block w-100" src="{{asset('images/bg.jpg')}}" alt="First slide">
        </div>
        <div class="carousel-item">
          <img class="d-block w-100" src="{{asset('images/bg-slide2.jpg')}}" alt="Second slide">
        </div>
        <div class="carousel-item">
          <img class="d-block w-100" src="{{asset('images/bg-slide3.png')}}" alt="Third slide">
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

    <section class="features-icons bg-light text-center mt-4" style="padding-top: 4rem; padding-bottom: 5rem;">
      <div class="container">
          <div class="mb-5">
            <h1 style="color:#007bff; margin-bottom:4rem;"><strong>WHAT WE OFFER</strong></h1>
          </div>
          <div class="row">
              <div class="col-lg-3">
                  <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3" style="max-width: 17rem;">
                      <div class="features-icons-icon d-flex" style="height: 7rem;"><i class="fa-solid fa-tag" style="font-size: 4.5rem; margin-left: 6.5rem;"></i></div>
                      <h3 style="font-size: 22px; font-weight: 600; margin-bottom: 15px; text-transform: uppercase; color:#007bff;">
                        Affordable Products
                      </h3>
                      <p class="lead mb-0" style="font-size:13px; color:#666; text-transform:uppercase;">
                        Everyone can be healthy in an affordable price!
                      </p>
                  </div>
              </div>
              <div class="col-lg-3">
                  <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3" style="max-width: 17rem;">
                      <div class="features-icons-icon d-flex" style="height: 7rem;"><i class="fa-solid fa-cow" style="font-size: 4.5rem; margin-left: 5rem;"></i></div>
                      <h3 style="font-size: 22px; font-weight: 600; margin-bottom: 15px; text-transform: uppercase; color:#007bff;">
                        Fresh Milk
                      </h3>
                      <p class="lead mb-0" style="font-size:13px; color:#666; text-transform:uppercase;">
                        Featuring products that made from buffalos milk!
                      </p>
                  </div>
              </div>
              <div class="col-lg-3">
                  <div class="features-icons-item mx-auto mb-0 mb-lg-3" style="max-width: 17rem;">
                      <div class="features-icons-icon d-flex" style="height: 7rem;"><i class="fa-solid fa-hand-holding-dollar" style="font-size: 4.5rem; margin-left: 5rem;"></i></div>
                      <h3 style="font-size: 22px; font-weight: 600; margin-bottom: 15px; text-transform: uppercase; color:#007bff;">
                        Flexible Payments
                      </h3>
                      <p class="lead mb-0" style="font-size:13px; color:#666; text-transform:uppercase;">
                        Easy to order with your own devices, with flexible payment methods!
                      </p>
                  </div>
              </div>
              <div class="col-lg-3">
                <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3" style="max-width: 17rem;">
                    <div class="features-icons-icon d-flex" style="height: 7rem;"><i class="fa-regular fa-circle-check" style="font-size: 4.5rem; margin-left: 5.5rem;"></i></div>
                    <h3 style="font-size: 22px; font-weight: 600; margin-bottom: 15px; text-transform: uppercase; color:#007bff;">
                      Quality Control Passed
                    </h3>
                    <p class="lead mb-0" style="font-size:13px; color:#666; text-transform:uppercase;">
                      Featuring the good quality products passed in quality control!
                    </p>
                </div>
            </div>
          </div>
      </div>
    </section>
    <!-- Start about us Area -->
    <section class="cown-down mt-4" style="padding-bottom: 5rem; position: relative; overflow:hidden;">
      <div class="section-inner">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-6 col-10 padding-right" style="padding-right:0;">
              <div class="image">
                <img src="{{asset('images/glass.png')}}" alt="#" style="width:100%; height:100%;">
              </div>	
            </div>	
            <div class="col-lg-6 col-12 padding-left" style="padding-right:0;">
              <div class="content bg-light" style="text-align: center; height: 100%; position:relative;">
                <div class="heading-block" style="position:absolute; left:0; top:45%; transform:translateY(-50%); padding: 75px;">
                  <h1 class="title" style="margin-bottom: 50px; color:#007bff;">
                    <strong>ABOUT US</strong>
                  </h1>
                  <p class="text" style="font-size:15px; color:#666; text-transform:uppercase; text-align: justify;">The General
                    Trias Dairy Raisers Multi-Purpose Cooperative is an authorized distributor of dairy products, from
                    7-21 dairy products and flavor variants.
                    They also promote dairying and dairy enterprise that improves the quality of life of the carabao
                    raisers.
                  </p>
                    <a href="{{ route('about') }}" >
                    <button class="btn btn-primary" style="margin-top: 4rem;">
                    Know More</button></a>
                </div>
              </div>	
            </div>	
          </div>
        </div>
      </div>
    </section>
    <!-- /End about us Area -->
    <section class="text-center" style="padding-bottom: 5rem;">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="mb-5">
              <h1 style="color:#007bff; margin-bottom:4rem;"><strong>PRODUCT VARIANTS</strong></h1>
            </div>
            <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="0" style="margin: 10px auto;">
              <!-- Carousel indicators -->
              <ol class="carousel-indicators" style="	bottom: -50px;">
                <li data-target="#myCarousel" data-slide-to="0" class="active" style="width: 10px; height: 10px; margin: 4px;
                  border-radius: 50%; border-color: transparent; border: none; background: rgba(0, 0, 0, 0.6);">
                </li>
                <li data-target="#myCarousel" data-slide-to="1" style="	width: 10px; height: 10px; margin: 4px;
                  border-radius: 50%; border-color: transparent; border: none; background: rgba(0, 0, 0, 0.2);">
                </li>
              </ol>   
              <!-- Wrapper for carousel items -->
              <div class="carousel-inner" style="margin-left:6rem;">
                <div class="carousel-item active" style="min-height: 330px; text-align: center; overflow: hidden;">
                  <div class="row">
                    <div class="col-sm-3" style="margin: 1rem">
                      <div class="thumb-wrapper" style="text-align: center;">
                        <div class="img-box" style="height: 160px; width: 100%; position: relative;">
                          <img src="{{asset('images/cheeses.png')}}" class="img-fluid" alt="" style="	max-width: 100%; max-height: 100%;
                          display: inline-block; position: absolute; bottom: 0; margin: 0 auto; left: 0; right: 0;">
                        </div>
                        <div class="thumb-content">
                          <h4 style="font-size: 20px; margin: 10px 0; color:#007bff"><strong>Cheeses</strong></h4>
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
                          <a href="{{ route('shop') }}" class="btn btn-primary" style="margin-top: 5px;">Shop Now</a>
                        </div>						
                      </div>
                    </div>
                    <div class="col-sm-3" style="margin: 1rem">
                      <div class="thumb-wrapper" style="text-align: center;">
                        <div class="img-box" style="height: 160px; width: 100%; position: relative;">
                          <img src="{{asset('images/frozen.png')}}" class="img-fluid" alt="" style="max-width: 100%; max-height: 100%;
                            display: inline-block; position: absolute; bottom: 0; margin: 0 auto; left: 0; right: 0;">
                        </div>
                        <div class="thumb-content">
                          <h4 style="font-size: 20px; margin: 10px 0; color:#007bff"><strong>Frozen Desserts</strong></h4>
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
                          <a href="{{ route('shop') }}" class="btn btn-primary" style="margin-top: 5px;">Shop Now</a>
                        </div>						
                      </div>
                    </div>									
                    <div class="col-sm-3" style="margin: 1rem">
                      <div class="thumb-wrapper" style="text-align: center;">
                        <div class="img-box" style="	height: 160px; width: 100%; position: relative;">
                          <img src="{{asset('images/jelly.png')}}" class="img-fluid" alt="" style="	max-width: 100%; max-height: 100%;
                            display: inline-block; position: absolute; bottom: 0; margin: 0 auto; left: 0; right: 0;">
                        </div>
                        <div class="thumb-content">
                          <h4 style="font-size: 20px; margin: 10px 0; color:#007bff"><strong>Jelly</strong></h4>
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
                          <a href="{{ route('shop') }}" class="btn btn-primary" style="margin-top: 5px;">Shop Now</a>
                        </div>						
                      </div>
                    </div>
                  </div>
                </div>
                <div class="carousel-item" style="min-height: 330px; text-align: center; overflow: hidden;">
                  <div class="row">
                    <div class="col-sm-3" style="margin: 1rem">
                      <div class="thumb-wrapper" style="text-align: center;">
                        <div class="img-box" style="height: 160px; width: 100%; position: relative;">
                          <img src="{{asset('images/milks.png')}}" class="img-fluid" alt="" style="	max-width: 100%; max-height: 100%;
                            display: inline-block; position: absolute; bottom: 0; margin: 0 auto; left: 0; right: 0;">
                        </div>
                        <div class="thumb-content">
                          <h4 style="font-size: 20px; margin: 10px 0; color:#007bff"><strong>Milks</strong></h4>
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
                          <a href="{{ route('shop') }}" class="btn btn-primary" style="margin-top: 5px;">Shop Now</a>
                        </div>						
                      </div>
                    </div>
                    <div class="col-sm-3" style="margin: 1rem">
                      <div class="thumb-wrapper" style="text-align: center;">
                        <div class="img-box" style="height: 160px; width: 100%; position: relative;">
                          <img src="{{asset('images/pastillas.png')}}" class="img-fluid" alt="" style="	max-width: 100%; max-height: 100%;
                            display: inline-block; position: absolute; bottom: 0; margin: 0 auto; left: 0; right: 0;">
                        </div>
                        <div class="thumb-content">
                          <h4 style="font-size: 20px; margin: 10px 0; color:#007bff"><strong>Pastillas</strong></h4>
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
                          <a href="{{ route('shop') }}" class="btn btn-primary" style="margin-top: 5px;">Shop Now</a>
                        </div>						
                      </div>
                    </div>
                    <div class="col-sm-3" style="margin: 1rem">
                      <div class="thumb-wrapper" style="text-align: center;">
                        <div class="img-box" style="height: 160px; width: 100%; position: relative;">
                          <img src="{{asset('images/yoghurt.png')}}" class="img-fluid" alt="" style="max-width: 100%; max-height: 100%;
                            display: inline-block; position: absolute; bottom: 0; margin: 0 auto; left: 0; right: 0;">
                        </div>
                        <div class="thumb-content">
                          <h4 style="font-size: 20px; margin: 10px 0; color:#007bff"><strong>Yoghurts</strong></h4>
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
                          <a href="{{ route('shop') }}" class="btn btn-primary" style="margin-top: 5px;">Shop Now</a>
                        </div>						
                      </div>
                    </div>						
                  </div>
                </div>
              </div>
              <!-- Carousel controls -->
              <a class="carousel-control-prev" href="#myCarousel" data-slide="prev" style="height: 100px;width: 40px; background: none; margin: auto 0;">
                <i class="fa fa-angle-left" style="font-size: 30px; position: absolute; top: 50%; display: inline-block; margin: -16px 0 0 0;
                  z-index: 5; left: 0; right: 0; color: #007bff; text-shadow: none; font-weight: bold; margin-left: -3px;">
                </i>
              </a>
              <a class="carousel-control-next" href="#myCarousel" data-slide="next" style="height: 100px; width: 40px; background: none; margin: auto 0;">
                <i class="fa fa-angle-right" style="font-size: 30px; position: absolute; top: 50%; display: inline-block; margin: -16px 0 0 0;
                  z-index: 5; left: 0; right: 0; color: #007bff; text-shadow: none; font-weight: bold; margin-right: -3px;">
                </i>
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>
    
@endsection
