@extends('layouts.client')
@section('content')
    @include('client.components.header')
    <script>
        var cont = 0;

        function loopSlider() {
            var xx = setInterval(function() {
                switch (cont) {
                    case 0: {
                        $("#slider-1").fadeOut(400);
                        $("#slider-2").delay(400).fadeIn(400);
                        $("#sButton1").removeClass("bg-[#5f9ea098]");
                        $("#sButton2").addClass("bg-[#5f9ea098]");
                        cont = 1;

                        break;
                    }
                    case 1: {

                        $("#slider-2").fadeOut(400);
                        $("#slider-1").delay(400).fadeIn(400);
                        $("#sButton2").removeClass("bg-[#5f9ea098]");
                        $("#sButton1").addClass("bg-[#5f9ea098]");

                        cont = 0;

                        break;
                    }


                }
            }, 8000);

        }

        function reinitLoop(time) {
            clearInterval(xx);
            setTimeout(loopSlider(), time);
        }

        function sliderButton1() {

            $("#slider-2").fadeOut(400);
            $("#slider-1").delay(400).fadeIn(400);
            $("#sButton2").removeClass("bg-[#5f9ea098]");
            $("#sButton1").addClass("bg-[#5f9ea098]");
            reinitLoop(4000);
            cont = 0

        }

        function sliderButton2() {
            $("#slider-1").fadeOut(400);
            $("#slider-2").delay(400).fadeIn(400);
            $("#sButton1").removeClass("bg-[#5f9ea098]");
            $("#sButton2").addClass("bg-[#5f9ea098]");
            reinitLoop(4000);
            cont = 1

        }

        $(window).ready(function() {
            $("#slider-2").hide();
            $("#sButton1").addClass("bg-[#5f9ea098]");


            loopSlider();

        });
    </script>

    <div class="sliderAx home-bg w-full h-[38rem] bg-cover bg-center leading-normal rounded-2xl border-[.3rem] border-solid border-[#199696] object-fill">
        <div id="slider-1" class="container">
            <div class="w-auto text-white">


                <h3 class="uppercase text-[5.5rem] absolute inset-7 top-[28%] left-10 text-[#deb887] font-bold">
                    Gentri's <span class="text-[#5f9ea0]">Best</span></h3>
                <p class="left-20 absolute top-[47%] text-center text-4xl text-cyan-800 uppercase font-semibold">
                    Dependable is what we are.</p>
                <p class="left-44 absolute text-2xl top-[55%] text-left text-[#deb887] uppercase font-bold">Quality milk
                    since 2005</p>
                <a href="{{ URL::secure(route('about')) }}" class="option-btn bg-[#d3a870] absolute w-fit py-4 px-8 text-white font-bold uppercase text-xs rounded top-[28rem] ml-28 hover:shadow-[1px_1px_15px_rgb(0,0,0,.3)] transition delay-80 hover:-translate-y-1 hover:scale-90 duration-300">
                    Know More</a>
                <div>
                    <a href="{{ URL::secure(route('shop')) }}"
                        class="bg-[#199696] w-fit absolute py-4 px-8 text-white font-bold uppercase text-xs rounded top-[28rem] ml-[25rem] hover:shadow-[1px_1px_15px_rgb(0,0,0,.3)] transition delay-80 hover:-translate-y-1 hover:scale-90 duration-300">Shop
                        Now</a>
                </div>
                <div class="back-image">
                    <img src="{{ asset('images/hero-img.png') }}" class="w-[750px] absolute top-[20%] left-[43%]">
                </div>             
            </div> <!-- container -->
            <br>
        </div>

        <div id="slider-2" class="container mx-2">
            <div class="w-auto text-white">

                <div class="back-image">
                    <img src="{{ asset('images/bg5.png') }}"
                        class="w-[715px] absolute top-[13.3%] right-[46.8%] rounded-xl">
                </div>
                <h3 class="uppercase text-[5.2rem] absolute inset-7 top-[28%] left-[54.5%] text-[#deb887] font-bold">
                    Gentri's <span class="text-[#5f9ea0]">Best</span></h3>
                <p class="right-16 absolute top-[47%] text-center text-4xl text-cyan-800 uppercase font-semibold">
                    Dependable is what we are.</p>
                <p class="right-44 absolute text-2xl top-[55%] text-right text-[#deb887] uppercase font-bold">Quality
                    milk since 2005</p>
                <a href="{{ URL::secure(route('about')) }}"
                    class="option-btn bg-[#d3a870] w-fit absolute py-4 px-8 text-white font-bold uppercase text-xs rounded top-[28rem] ml-[52rem] hover:shadow-[1px_1px_15px_rgb(0,0,0,.3)] transition delay-80 hover:-translate-y-1 hover:scale-90 duration-300">
                    Know More</a>
                <div>
                    <a href="{{ URL::secure(route('shop')) }}"
                        class="bg-[#199696] w-fit absolute py-4 px-8 text-white font-bold uppercase text-xs rounded top-[28rem] ml-[68rem] hover:shadow-[1px_1px_15px_rgb(0,0,0,.3)] transition delay-80 hover:-translate-y-1 hover:scale-90 duration-300">Shop
                        Now</a>
                </div>
            </div> <!-- container -->
            <br>
        </div>
    </div>
    <div class="flex justify-between w-12 mx-auto pb-2 mt-4">
        <button id="sButton1" onclick="sliderButton1()" class="bg-[#199696] rounded-full w-4 pb-2"></button>
        <button id="sButton2" onclick="sliderButton2() " class="bg-[#199696] rounded-full w-4 p-2"></button>
    </div>

    <div class="pt-[7%] w-[100%] h-[110vh]">
        <section class="reviews pt-0.5">
            <h1 class="title text-center mb-8 uppercase text-[#199696] text-5xl font-bold">What we offer?</h1>

            <div
                class="box-container pl-28 pt-8 flex items-center justify-center text-white text-center uppercase grid grid-cols-5 gap-x-64 w-full">

                <div
                    class="box w-[250px] h-[350px] cursor-pointer pt-1 pr-2.5 mt-0 mr-3.5 bg-[#d3a870] rounded-2xl shadow-[5px_5px_20px_rgba(0,0,0,0.2)] hover:shadow-[1px_1px_15px_rgb(0,0,0,.3)] cursor-pointer transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-110 duration-300">
                    <img src="images/cow-head.jpg" alt=""
                        class="h-48 w-48 py-1 pr-1 mt-0 mr-10 rounded-xl ml-[30px]">
                    <div class="stars pt-4 text-yellow-200">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <h3 class="pt-1 pl-1 mt-4 text-xl font-semibold">FRESH MILKS from buffalos</h3>
                </div>

                <div
                    class="box w-[250px] h-[350px] cursor-pointer pt-1 pr-2.5 mt-0 mr-3.5 bg-[#d3a870] rounded-2xl shadow-[5px_5px_20px_rgba(0,0,0,0.2)] hover:shadow-[1px_1px_15px_rgb(0,0,0,.3)] cursor-pointer transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-110 duration-300">
                    <img src="images/farmer.jpg" alt=""
                        class="h-48 w-48 py-1 pr-1 mt-0 mr-10 rounded-2xl ml-[30px]">
                    <div class="stars pt-4 text-yellow-200">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <h3 class="pt-1 pl-1 mt-4 text-xl font-semibold">products that GOOD FOR ALL AGES</h3>
                </div>

                <div
                    class="box w-[250px] h-[350px] cursor-pointer pt-1 pr-2.5 mt-0 mr-3.5 bg-[#d3a870] rounded-2xl shadow-[5px_5px_20px_rgba(0,0,0,0.2)] hover:shadow-[1px_1px_15px_rgb(0,0,0,.3)] cursor-pointer transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-110 duration-300">
                    <img src="images/carton.jpg" alt=""
                        class="h-48 w-48 py-1 pr-1 mt-0 mr-10 rounded-2xl ml-[30px]">
                    <div class="stars pt-4 text-yellow-200">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <h3 class="pt-1 pl-1 mt-4 text-xl font-semibold">QUALITY PASSED</h3>
                </div>

                <div
                    class="box w-[250px] h-[350px] cursor-pointer pt-1 pr-2.5 mt-0 mr-3.5 bg-[#d3a870] rounded-2xl shadow-[5px_5px_20px_rgba(0,0,0,0.2)] hover:shadow-[1px_1px_15px_rgb(0,0,0,.3)] cursor-pointer transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-110 duration-300">
                    <img src="{{ asset('images/payment.jpg') }}" alt=""
                        class="h-48 w-48 py-1 pr-1 mt-0 mr-10 rounded-2xl ml-[30px]">
                    <div class="stars pt-4 text-yellow-200">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <h3 class="pt-1 pl-1 mt-4 text-xl font-semibold">DIFFERENT PAYMENT METHODS</h3>
                </div>

            </div>

        </section>
    </div>

    <div class="choose absolute w-full h-[160vh]">
        <div class="back-image t-[43%] pl-[3%]">
            <img src="images/glass.png" alt="" class="absolute w-[600px]">
        </div>
        <section class="row flex items-center min-h-[90vh] bg-[#fff8dc]">
            <div class="box w-full">
                <h3 class="flex mb-16 uppercase text-[#199696] text-5xl pl-[53%] font-bold">Why choose us?
                </h3>
                <p
                    class="flex t-[60%] pl-[43%] pr-10 leading-6 text-justify text-2xl text-[#d3a870] z-[1] font-semibold">
                    The General
                    Trias Dairy Raisers Multi-Purpose Cooperative is an authorized distributor of dairy products, from
                    7-21 dairy products and flavor variants.
                    They also promote dairying and dairy enterprise that improves the quality of life of the carabao
                    raisers.</p>
                <a href="{{ URL::secure(route('contact')) }}"
                    class="option-btn pl-10 pr-10 top-20 ml-[63%] bg-[#199696] w-fit relative py-4 px-8 text-white font-bold uppercase text-xs rounded hover:shadow-[1px_1px_15px_rgb(0,0,0,.6)] transition delay-80 hover:-translate-y-1 hover:scale-90 duration-300">
                    Contact Us</a>
            </div>

        </section>
    </div>

    <div class="choose absolute top-[2110px] w-full h-[100vh]">
        <section class="mission">

            <div class="row flex items-center min-h-[5vh]">

                <div class="box z-[1]">
                    <h3 class="absolute text-6xl uppercase t-[1px] left-[13%] pb-[6%] text-[#d3a870] font-bold">Our
                        Mission</h3>
                    <p class="absolute w-[400px] pt-[14%] left-[12%] font-semibold leading-6 text-justify text-2xl text-white">Ang
                        pinaninindigang kontribusyon ng General Trias Dairy Raisers Multi-Purpose Cooperative upang
                        makamit ang pananaw na ito ay ang patuloy na pagpapalakas ng kasapian, pagpapaunlad ng kanilang
                        kaalaman at kasanayan, pagsuporta sa pagtaas ng kita ng mga kasapi at pagbibigay ng serbisyo sa
                        anyo ng puhunan, pagbebenta ng mga produkto, at pagproseso ng kanilang produkto.</p>
                </div>

                <div class="box-vision z-[1]">
                    <h3 class="absolute text-6xl uppercase t-[1px] left-[60%] pb-[7%] text-[#199696] font-bold">Our
                        Vision</h3>
                    <p class="absolute w-[400px] pt-[15%] left-[58%] font-semibold leading-6 text-justify text-2xl text-white">Isang
                        maunlad, malakas, at nagkakaisang kooperatiba na tutulong upang mapaunlad ang kalagayang
                        pangkabuhayan ng mga kasapi at ng buong komunidad sa pangkalakalan.</p>
                </div>

                <div
                    class="sq absolute top-[150px] left-[7%] w-[40%] h-[60%] bg-[#d3a870] rounded-[5rem] border-dashed border-8 border-[#199696] shadow-[1px_1px_15px_rgb(0,0,0,.6)]">
                </div>
                <div
                    class="sqs absolute top-[150px] left-[53%] w-[40%] h-[60%] bg-[#199696] rounded-[5rem] border-dashed border-8 border-[#d3a870] shadow-[1px_1px_15px_rgb(0,0,0,.6)]">
                </div>

            </div>

        </section>
    </div>

    <div class="pt-[1350px] w-[100%] h-[120vh] pb-[940px]">
        <section class="reviews pt-16 bg-[#fff8dc]">
            <h1
                class="title mb-12 justify-center text-center items-center uppercase text-[#199696] text-5xl font-bold">
                Product Variants</h1>

            <div class="box-container py-10 text-center w-full font-semibold items-center capitalize justify-center grid grid-cols-3 px-[15rem]">

                <div
                    class="box w-[15rem] h-[20rem] mb-8 p-4 bg-yellow-50 border-dashed border-4 rounded-xl border-[#d3a870] rounded-2xl shadow-[5px_5px_20px_rgba(0,0,0,0.2)] hover:shadow-[1px_1px_15px_rgb(0,0,0,.3)] transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-110 hover:bg-[#fff8dc] duration-300">
                    <img src="images/milks.png" class="w-full" alt="Milk">
                    <h3 class="text-[#199696] pb-6 pt-0 pr-0 text-2xl">Milk</h3>
                </div>

                <div
                    class="box w-[15rem] h-[20rem] mb-8 p-4 bg-yellow-50 border-dashed border-4 rounded-xl border-[#d3a870] rounded-2xl shadow-[5px_5px_20px_rgba(0,0,0,0.2)] hover:shadow-[1px_1px_15px_rgb(0,0,0,.3)] transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-110 hover:bg-[#fff8dc] duration-300">
                    <img src="images/yoghurt.png" class="w-full" alt="Yoghurt">
                    <h3 class="text-[#199696] pb-6 pt-0 pr-0 text-2xl">Yoghurt</h3>
                </div>

                <div
                    class="box w-[15rem] h-[20rem] mb-8 p-4 bg-yellow-50 border-dashed border-4 rounded-xl border-[#d3a870] rounded-2xl shadow-[5px_5px_20px_rgba(0,0,0,0.2)] hover:shadow-[1px_1px_15px_rgb(0,0,0,.3)] transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-110 hover:bg-[#fff8dc] duration-300">
                    <img src="images/jelly.png" class="w-full" alt="Jelly">
                    <h3 class="text-[#199696] pb-6 pt-0 pr-0 text-2xl">Jelly</h3>
                </div>

                <div
                    class="box w-[15rem] h-[20rem] mb-8 p-4 bg-yellow-50 border-dashed border-4 rounded-xl border-[#d3a870] rounded-2xl shadow-[5px_5px_20px_rgba(0,0,0,0.2)] hover:shadow-[1px_1px_15px_rgb(0,0,0,.3)] transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-110 hover:bg-[#fff8dc] duration-300">
                    <img src="images/frozen.png" class="w-full" alt="Frozen Desserts">
                    <h3 class="text-[#199696] pb-6 pt-0 pr-0 text-2xl">Frozen Desserts</h3>
                </div>

                <div
                    class="box w-[15rem] h-[20rem] mb-8 p-4 bg-yellow-50 border-dashed border-4 rounded-xl border-[#d3a870] rounded-2xl shadow-[5px_5px_20px_rgba(0,0,0,0.2)] hover:shadow-[1px_1px_15px_rgb(0,0,0,.3)] transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-110 hover:bg-[#fff8dc] duration-300">
                    <img src="images/pastillas.png" class="w-full" alt="Pastillas">
                    <h3 class="text-[#199696] pb-6 pt-0 pr-0 text-2xl">Pastillas</h3>
                </div>

                <div
                    class="box w-[15rem] h-[20rem] mb-8 p-4 bg-yellow-50 border-dashed border-4 rounded-xl border-[#d3a870] rounded-2xl shadow-[5px_5px_20px_rgba(0,0,0,0.2)] hover:shadow-[1px_1px_15px_rgb(0,0,0,.3)] transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-110 hover:bg-[#fff8dc] duration-300">
                    <img src="images/cheeses.png" class="w-full" alt="Cheese">
                    <h3 class="text-[#199696] pb-6 pt-0 pr-0 text-2xl">Cheese</h3>
                </div>

            </div>

        </section>
    </div>


    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>
    
    @include('client.components.footer')
@endsection
