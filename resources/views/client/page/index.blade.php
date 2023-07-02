<x-layout>

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

    <div class="sliderAx home-bg w-full h-full">
        <div id="slider-1" class="container mx-2">
            <div
                class="bg-cover bg-center bg-[#fff8dc] w-[104%] text-white leading-normal rounded-2xl border-[.3rem] border-solid border-[#199696] py-[15rem] object-fill">

                <div class="back-image">
                    <img src="{{ asset('images/backg.png') }}" class="w-[730px] absolute top-[20%] left-[43%]">
                </div>
                <h3 class="uppercase text-[5.5rem] absolute inset-7 top-[30%] left-10 text-[#deb887] font-bold">
                    Gentri's <span class="text-[#5f9ea0]">Best</span></h3>
                <p class="left-20 absolute top-[49%] text-center text-4xl text-cyan-800 uppercase font-semibold">
                    Dependable is what we are.</p>
                <p class="left-44 absolute text-2xl top-[57%] text-left text-[#deb887] uppercase font-bold">Quality milk
                    since 2005</p>
                <a href="{{ URL::secure(route('about')) }}"
                    class="option-btn bg-[#d3a870] w-fit relative py-4 px-8 text-white font-bold uppercase text-xs rounded top-[8.5rem] ml-32 hover:shadow-[1px_1px_15px_rgb(0,0,0,.3)] transition delay-80 hover:-translate-y-1 hover:scale-90 duration-300">
                    Know More</a>
                <div>
                    <a href="{{ URL::secure(route('shop')) }}"
                        class="bg-[#199696] w-fit relative py-4 px-8 text-white font-bold uppercase text-xs rounded top-28 ml-[24rem] hover:shadow-[1px_1px_15px_rgb(0,0,0,.3)] transition delay-80 hover:-translate-y-1 hover:scale-90 duration-300">Shop
                        Now</a>
                </div>
            </div> <!-- container -->
            <br>
        </div>

        <div id="slider-2" class="container mx-2">
            <div
                class="bg-cover bg-center bg-[#fff8dc] w-[104%] text-white leading-normal rounded-2xl border-[.3rem] border-solid border-[#199696] py-[15rem] object-fill">

                <div class="back-image">
                    <img src="{{ asset('images/bg5.png') }}"
                        class="w-[627px] absolute top-[17.1%] right-[52.6%] rounded-xl">
                </div>
                <h3 class="uppercase text-[5.5rem] absolute inset-7 top-[30%] left-[50%] text-[#deb887] font-bold">
                    Gentri's <span class="text-[#5f9ea0]">Best</span></h3>
                <p class="right-28 absolute top-[49%] text-center text-4xl text-cyan-800 uppercase font-semibold">
                    Dependable is what we are.</p>
                <p class="right-52 absolute text-2xl top-[57%] text-right text-[#deb887] uppercase font-bold">Quality
                    milk since 2005</p>
                <a href="{{ URL::secure(route('about')) }}"
                    class="option-btn bg-[#d3a870] w-fit relative py-4 px-8 text-white font-bold uppercase text-xs rounded top-[8.5rem] ml-[49rem] hover:shadow-[1px_1px_15px_rgb(0,0,0,.3)] transition delay-80 hover:-translate-y-1 hover:scale-90 duration-300">
                    Know More</a>
                <div>
                    <a href="{{ URL::secure(route('shop')) }}"
                        class="bg-[#199696] w-fit relative py-4 px-8 text-white font-bold uppercase text-xs rounded top-28 ml-[66rem] hover:shadow-[1px_1px_15px_rgb(0,0,0,.3)] transition delay-80 hover:-translate-y-1 hover:scale-90 duration-300">Shop
                        Now</a>
                </div>
            </div> <!-- container -->
            <br>
        </div>
    </div>
    <div class="flex justify-between w-12 mx-auto pb-2">
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
                    <h3 class="pt-1 pl-1 mt-4 text-xl">FRESH MILKS from buffalos</h3>
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
                    <h3 class="pt-1 pl-1 mt-4 text-xl">products that GOOD FOR ALL AGES</h3>
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
                    <h3 class="pt-1 pl-1 mt-4 text-xl">QUALITY PASSED</h3>
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
                    <h3 class="pt-1 pl-1 mt-4 text-xl">DIFFERENT PAYMENT METHODS</h3>
                </div>

            </div>

        </section>
    </div>

    <div class="choose absolute w-full h-[160vh]">
        <div class="back-image  t-[43%] pl-[3%]">
            <img src="images/glass.png" alt="" class="absolute w-[600px]">
        </div>
        <section class="row flex items-center min-h-[90vh] bg-[#fff8dc]">
            <div class="box w-full">
                <h3 class="flex mb-16 uppercase text-[#199696] text-5xl pl-[53%] font-bold">Why choose us?
                </h3>
                <p
                    class="w-[700px] t-[60%] ml-[43%] leading-6 text-justify text-2xl text-[#d3a870] z-[1] font-semibold">
                    The General
                    Trias Dairy Raisers Multi-Purpose Cooperative is an authorized distributor of dairy products, from
                    7-21 dairy products and flavor variants.
                    They also promote dairying and dairy enterprise that improves the quality of life of the carabao
                    raisers.</p>
                <a href="/contact?contact-us"
                    class="option-btn pl-10 pr-10 top-20 ml-[63%] bg-[#199696] w-fit relative py-4 px-8 text-white font-bold uppercase text-xs rounded hover:shadow-[1px_1px_15px_rgb(0,0,0,.6)] transition delay-80 hover:-translate-y-1 hover:scale-90 duration-300">
                    Contact Us</a>
            </div>

        </section>
    </div>

    <div class="choose absolute top-[2100px] w-full h-[100vh]">
        <section class="mission">

            <div class="row flex items-center min-h-[5vh]">

                <div class="box z-[1]">
                    <h3 class="absolute text-6xl uppercase t-[1px] left-[13%] pb-[6%] text-[#d3a870] font-bold">Our
                        Mission</h3>
                    <p class="absolute w-[400px] pt-[14%] left-[12%] leading-6 text-justify text-2xl text-white">Ang
                        pinaninindigang kontribusyon ng General Trias Dairy Raisers Multi-Purpose Cooperative upang
                        makamit ang pananaw na ito ay ang patuloy na pagpapalakas ng kasapian, pagpapaunlad ng kanilang
                        kaalaman at kasanayan, pagsuporta sa pagtaas ng kita ng mga kasapi at pagbibigay ng serbisyo sa
                        anyo ng puhunan, pagbebenta ng mga produkto, at pagproseso ng kanilang produkto.</p>
                </div>

                <div class="box-vision z-[1]">
                    <h3 class="absolute text-6xl uppercase t-[1px] left-[60%] pb-[7%] text-[#199696] font-bold">Our
                        Vision</h3>
                    <p class="absolute w-[400px] pt-[15%] left-[58%] leading-6 text-justify text-2xl text-white">Isang
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

    <div class="pt-[1390px] w-[100%] h-[100vh]">
        <section class="reviews pt-1">
            <h1
                class="title mb-12 justify-center text-center items-center uppercase text-[#199696] text-5xl font-bold">
                Product Variants</h1>

            <div
                class="box-container pt-8 text-center w-full items-center justify-center grid grid-cols-4 gap-8 pl-8 pr-6">

                <div
                    class="box w-[18rem] h-[24.5rem] p-6 bg-[#deb88757] rounded-2xl shadow-[5px_5px_20px_rgba(0,0,0,0.2)] hover:shadow-[1px_1px_15px_rgb(0,0,0,.3)] transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-110 hover:bg-[#deb88757] duration-300">
                    <img src="images/fresh.png" class="w-full" alt="">
                    <h3 class="text-[#199696] pb-6 pt-0 pr-0 text-2xl">Milks</h3>
                    <a href="/product?category=milks"
                        class="btn bg-[#199696] w-fit relative py-3 px-6 text-white font-bold uppercase text-xs rounded hover:shadow-[1px_1px_15px_rgb(0,0,0,.6)] transition delay-80 hover:-translate-y-1 hover:scale-90 duration-300">
                        Shop Now</a>
                </div>

                <div
                    class="box w-[18rem] h-[24.5rem] p-6 bg-[#deb88757] rounded-2xl shadow-[5px_5px_20px_rgba(0,0,0,0.2)] hover:shadow-[1px_1px_15px_rgb(0,0,0,.3)] transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-110 hover:bg-[#deb88757] duration-300">
                    <img src="images/yoghurt.png" class="w-full" alt="">
                    <h3 class="text-[#199696] pb-6 pt-0 pr-0 text-2xl">Yoghurts</h3>
                    <a href="/product?category=yoghurts"
                        class="btn bg-[#199696] w-fit relative py-3 px-6 text-white font-bold uppercase text-xs rounded hover:shadow-[1px_1px_15px_rgb(0,0,0,.6)] transition delay-80 hover:-translate-y-1 hover:scale-90 duration-300">
                        Shop Now</a>
                </div>

                <div
                    class="box w-[18rem] h-[24.5rem] p-6 bg-[#deb88757] rounded-2xl shadow-[5px_5px_20px_rgba(0,0,0,0.2)] hover:shadow-[1px_1px_15px_rgb(0,0,0,.3)] transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-110 hover:bg-[#deb88757] duration-300">
                    <img src="images/jelly.png" class="w-full alt="">
                    <h3 class="text-[#199696] pb-6 pt-0 pr-0 text-2xl">Jelly</h3>
                    <a href="/product?category=jelly"
                        class="btn bg-[#199696] w-fit relative py-3 px-6 text-white font-bold uppercase text-xs rounded hover:shadow-[1px_1px_15px_rgb(0,0,0,.6)] transition delay-80 hover:-translate-y-1 hover:scale-90 duration-300">
                        Shop Now</a>
                </div>

                <div
                    class="box w-[18rem] h-[24.5rem] p-6 bg-[#deb88757] rounded-2xl shadow-[5px_5px_20px_rgba(0,0,0,0.2)] hover:shadow-[1px_1px_15px_rgb(0,0,0,.3)] cursor-pointer transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-110 hover:bg-[#deb88757] duration-300">
                    <img src="images/ice.png" class="w-full" alt="">
                    <h3 class="text-[#199696] pb-6 pt-0 pr-0 text-2xl">Frozen Desserts</h3>
                    <a href="/product?shop=frozen-desserts"
                        class="btn bg-[#199696] w-fit relative py-3 px-6 text-white font-bold uppercase text-xs rounded hover:shadow-[1px_1px_15px_rgb(0,0,0,.6)] transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-110 duration-300">
                        Shop Now</a>
                </div>

                <div
                    class="box w-[18rem] h-[24.5rem] p-6 bg-[#deb88757] rounded-2xl shadow-[5px_5px_20px_rgba(0,0,0,0.2)] hover:shadow-[1px_1px_15px_rgb(0,0,0,.3)] cursor-pointer transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-110 hover:bg-[#deb88757] duration-300">
                    <img src="images/pastillas.png" class="w-full" alt="">
                    <h3 class="text-[#199696] pb-6 pt-0 pr-0 text-2xl">Pastillas</h3>
                    <a href="/product?category=pastillas"
                        class="btn bg-[#199696] w-fit relative py-3 px-6 text-white font-bold uppercase text-xs rounded hover:shadow-[1px_1px_15px_rgb(0,0,0,.6)] transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-110 duration-300">
                        Shop Now</a>
                </div>

                <div
                    class="box w-[18rem] h-[24.5rem] p-6 bg-[#deb88757] rounded-2xl shadow-[5px_5px_20px_rgba(0,0,0,0.2)] hover:shadow-[1px_1px_15px_rgb(0,0,0,.3)] cursor-pointer transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-110 hover:bg-[#deb88757] duration-300">
                    <img src="images/keso.png" class="w-full" alt="">
                    <h3 class="text-[#199696] pb-6 pt-0 pr-0 text-2xl">Cheeses</h3>
                    <a href="/product?category=cheeses"
                        class="btn bg-[#199696] w-fit relative py-3 px-6 text-white font-bold uppercase text-xs rounded hover:shadow-[1px_1px_15px_rgb(0,0,0,.6)] transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-110 duration-300">
                        Shop Now</a>
                </div>

                <div
                    class="box py-12 w-[18rem] h-[24.5rem] px-6 bg-[#deb88757] rounded-xl shadow-[5px_5px_20px_rgba(0,0,0,0.2)] hover:shadow-[1px_1px_15px_rgb(0,0,0,.3)] cursor-pointer transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-110 hover:bg-[#deb88757] duration-300">
                    <a href="{{ route('shop') }}" class="btn">
                        <img src="images/backg.png" class="w-full mb-20" alt="">
                        <a href="{{ route('shop') }}"
                            class="btn bg-[#199696] w-fit relative py-3 px-6 text-white font-bold uppercase text-xs rounded hover:shadow-[1px_1px_15px_rgb(0,0,0,.6)] transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-110 duration-300">
                            See all</a>
                </div>

            </div>

        </section>
    </div>


    
    @include('client.components.footer')
</x-layout>
