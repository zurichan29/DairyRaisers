@extends('layouts.client')
@section('content')

    <div class="contact mb-5">

        <section class="row items-center">

            <div class="box">
                <div class="mb-5 text-center">
                    <h1 style="color:#007bff; margin-bottom:3rem; margin-top:1rem; text-transform:uppercase;"><strong>CONTACT US</strong>
                    </h1>
                </div>

                <!-- Start Contact -->
                <section id="contact-us" class="contact-us section">
                    <div class="container">
                            <div class="contact-head">
                                <div class="row">
                                    <div class="col-lg-6 col-12 padding-left" style="padding-right:0;">
                                        <div class="image">
                                            <img src="{{asset('images/glass.png')}}" alt="#" style="width:100%; height:100%;">
                                        </div>	
                                    </div>
                                    <div class="col-lg-6 col-12 padding-right" style="padding-left:0; ">
                                        <div class="content bg-light" style="margin-left:3rem; padding-left:3rem; padding-right:3rem; padding-top:4rem; height: 100%; position:relative;">
                                            <div class="single-info">
                                                <h4 class="title" style="font-size: 20px"><strong>Call Us :</strong></h4>
                                                    <p><i class="fas fa-phone"></i>
                                                        (+63)997-251-4142
                                                    </p>
                                                    <p><i class="fas fa-phone"></i>
                                                        (+63)932-548-8081
                                                    </p>
                                            </div>
                                            <hr>
                                            <div class="single-info">
                                                <h4 class="title" style="font-size: 20px"><strong>Email Us :</strong></h4>
                                                    <p><i class="fa fa-envelope-open"></i>
                                                        gentridairympc@ymail.com
                                                    </p>
                                            </div>
                                            <hr>
                                            <div class="single-info">
                                                <h4 class="title" style="font-size: 20px"><strong>Follow Us :</strong></h4>
                                                    <p><i class="fa-brands fa-facebook"></i>
                                                        General Trias Dairy Raisers Mutipurpose Cooperative
                                                    </p>
                                                    <p><i class="fa-brands fa-instagram"></i>
                                                        @gentrisbest
                                                    </p>
                                                    <p><i class="fa-brands fa-twitter"></i>
                                                        @gentrisbest
                                                    </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </section>
                <!--/ End Contact -->

                <!-- Map Section -->
                <div class="mb-5 text-center" style="margin-top:5rem;">
                    <h1 style="color:#007bff; margin-top:1rem; text-transform:uppercase;">
                        <strong>Visit Us</strong>
                    </h1>
                    <p class=" relative leading-6 text-xl text-[#003e41]" style="margin-bottom:3rem;"><i class="fas fa-map-marker-alt"></i>
                        Purok 1, Brgy Santiago, City of General Trias, Cavite</p>

                </div>

                <div class="map-section">

                    <p><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3865.3657770287914!2d120.9013200742781!3d14.348231183207199!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397d4c92faaa113%3A0x65ebb40a08965c8f!2sGeneral%20Trias%20Dairy%20Processing%20Center!5e0!3m2!1sen!2sph!4v1690569286407!5m2!1sen!2sph" width="1250" height="480" style="border:.5rem;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe></p>

                </div>
                <!--/ End Map Section -->

                <!--<div class="sq text-center">

                    <h2 class="heads items-center" style="text-transform:uppercase; font-size:20px;">
                        <strong>Call us :</strong>
                    </h2>
                    <p class="relative leading-6 text-xl text-[#003e41] mb-2"> <i class="fas fa-phone"></i>
                        (+63)997-251-4142 </p>
                    <p class="relative leading-6 text-xl text-[#003e41] mb-14"> <i class="fas fa-phone"></i>
                        (+63)932-548-8081 </p>
                    <hr>
                    <h2 class="heads items-center" style="text-transform:uppercase; font-size:20px;">
                        <strong>message us :</strong>
                    </h2>
                    <p class="relative leading-6 text-xl text-[#003e41] mb-14"> <i class="fa-solid fa-envelope"></i>
                        gentridairympc@ymail.com
                    </p>
                    <hr>
                    <h2 class="heads items-center" style="text-transform:uppercase; font-size:20px;">
                        <strong>follow us :</strong>
                    </h2>
                    <p class="relative leading-6 text-xl text-[#003e41] mb-2"><i class="fa-brands fa-facebook"></i>
                        General Trias Dairy Raisers Mutipurpose Cooperative </p>
                    <p class="relative leading-6 text-xl text-[#003e41] mb-2"><i class="fa-brands fa-instagram"></i>
                        @gentrisbest</p>
                    <p class="relative leading-6 text-xl text-[#003e41] mb-14"><i class="fa-brands fa-twitter"></i>
                        @gentrisbest</p>
                    <hr>
                    <h2 class="heads items-center" style="text-transform:uppercase; font-size:20px;">
                        <strong>Visit our physical store :</strong>
                    </h2>
                    <p class=" relative leading-6 text-xl text-[#003e41] mb-14"><i class="fas fa-map-marker-alt"></i>
                        Purok 1, Brgy Santiago, City of General Trias, Cavite</p>
                </div>-->

            </div>

        </section>
    </div>

@endsection
