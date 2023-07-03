<x-layout>
    @include('client.components.header')

    <div class="faqs left-0 w-full h-[170vh]">

        <section class="row flex items-center">

            <div class="box w-[70%] ml-[12rem]">
                <div class="justify-center text-center items-center uppercase">
                    <h1 class="title text-center my-10 text-[#199696] text-5xl font-bold">frequently asked questions</h1>
                </div>

                <div
                    class="sq absolute top-[230px] left-[15%] w-[70%] h-[130%] bg-[#deb88757] rounded-[4rem] border-dashed border-8 border-[#199696] shadow-[1px_1px_15px_rgb(0,0,0,1)] z-[-1]">

                    <h2
                        class="heads items-center text-left relative text-left uppercase text-[#9c7848] text-3xl mb-4 ml-20 mt-10 font-semibold">
                        🐮 What time do you deliver?</h2>
                    <p
                        class="left-32 w-[710px] relative leading-8 text-justify items-center text-xl text-[#003e41] mb-[4rem]">
                        🥛 Delivery times differ depending on the area. We typically start our deliveries at 8 am and
                        end at 6 pm.</p>

                    <h2
                        class="heads items-center text-left relative text-left uppercase text-[#9c7848] text-3xl mb-4 ml-20 font-semibold">
                        🐮 Do you offer discounts for bulk buying?</h2>
                    <p
                        class="left-32 w-[710px] relative leading-8 text-justify items-center text-xl text-[#003e41] mb-[4rem]">
                        🥛 Yes, we sure do. We don’t operate off a set-price list. A pricing structure is prepared
                        specifically for each individual customer based on the quantity and range of products.</p>

                    <h2
                        class="heads items-center text-left relative text-left uppercase text-[#9c7848] text-3xl mb-4 ml-20 font-semibold">
                        🐮 Do you have a physical store?</h2>
                    <p
                        class="left-32 w-[710px] relative leading-8 text-justify items-center text-xl text-[#003e41] mb-[4rem]">
                        🥛 Yes, we have. The address is Barangay Santiago General Trias City, Cavite.</p>

                    <h2
                        class="heads items-center text-left relative text-left uppercase text-[#9c7848] text-3xl mb-4 ml-20 font-semibold">
                        🐮 What is the right temperature at which to <br> store milk?</h2>
                    <p class="left-32 w-[710px] relative leading-8 text-justify items-center text-xl text-[#003e41]">🥛
                        Milk should be stored at or below 2° C to ensure it stays fresh for as long as possible. Storage
                        above this temperature will drastically reduce the shelf life of the milk. If you leave milk on
                        the counter for 1 hour, it loses as much freshness as it does one day in the refrigerator.</p>
                </div>

            </div>

        </section>
    </div>

    @include('client.components.footer')
</x-layout>
