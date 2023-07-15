@extends('layouts.client')
@section('content')
    @include('client.components.header')

    <div class="faqs left-0 w-full h-[145vh]">

        <section class="row flex items-center">

            <div class="box w-[70%] ml-[12rem]">
                <div class="justify-center text-center items-center uppercase">
                    <h1 class="title text-center my-10 text-[#199696] text-5xl font-bold">contact us</h1>
                </div>

                <div
                    class="sq absolute items-center text-center top-[230px] left-[15%] w-[70%] h-[105%] bg-[#deb88757] rounded-[4rem] border-dashed border-8 border-[#199696] shadow-[1px_1px_15px_rgb(0,0,0,1)] z-[-1]">

                    <h2
                        class="heads items-center relative text-center uppercase text-[#9c7848] text-3xl mb-4 mt-12 font-semibold">
                        🐮 Call us 🐮</h2>
                    <p class="relative leading-6 text-xl text-[#003e41] mb-2"> <i class="fas fa-phone"></i>
                        (+63)997-251-4142 </p>
                    <p class="relative leading-6 text-xl text-[#003e41] mb-14"> <i class="fas fa-phone"></i>
                        (+63)932-548-8081 </p>

                    <h2
                        class="heads items-center relative text-center uppercase text-[#9c7848] text-3xl mb-4 ml-[2rem] font-semibold">
                        🐮 message us 🐮</h2>
                    <p class="relative leading-6 text-xl text-[#003e41] mb-14"> <i class="fa-solid fa-envelope"></i>
                        gentridairympc@ymail.com </p>

                    <h2
                        class="heads items-center relative text-center uppercase text-[#9c7848] text-3xl mb-4 ml-[2rem] font-semibold">
                        🐮 follow us 🐮</h2>
                    <p class="relative leading-6 text-xl text-[#003e41] mb-2"><i class="fa-brands fa-facebook"></i>
                        General Trias Dairy Raisers Mutipurpose Cooperative </p>
                    <p class="relative leading-6 text-xl text-[#003e41] mb-2"><i class="fa-brands fa-instagram"></i>
                        @gentrisbest</p>
                    <p class="relative leading-6 text-xl text-[#003e41] mb-14"><i class="fa-brands fa-twitter"></i>
                        @gentrisbest</p>

                    <h2
                        class="heads items-center relative text-center uppercase text-[#9c7848] text-3xl mb-4 ml-[2rem] font-semibold">
                        🐮 Visit our physical store 🐮</h2>
                    <p class=" relative leading-6 text-xl text-[#003e41] mb-14"><i class="fas fa-map-marker-alt"></i>
                        Purok 1, Brgy Santiago, City of General Trias, Cavite</p>
                </div>

            </div>

        </section>
    </div>

    @include('client.components.footer')
@endsection
