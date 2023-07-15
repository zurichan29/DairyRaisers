@include('client.components.header')

<div class="faqs left-0 w-full h-full">
            <div class="items-left flex text-2xl justify-between pl-8 pt-28">
                <div class="font-semibold delay-75 text-[#5f9ea0] items-center text-center">
                    <a href="/cart" class="title text-center my-10 text-[#199696] hover:underline">Cart <i class="fa-solid fa-angle-right"></i></a>
                    <a href="/checkout" class="title text-center my-10 text-[#199696] hover:underline">Information <i class="fa-solid fa-angle-right"></i></a>
                    <a href="/payment" class="title text-center my-10 text-[#199696] font-bold hover:underline">Payment</a>
                </div>
            </div>
    <section class="row flex items-center mt-16">
            
        <div class="box w-[70%] ml-[12rem]">
            
            <div class="justify-center text-center items-center uppercase">
                <h1 class="title text-center mb-10 text-[#199696] text-4xl font-bold">Select Payment Method</h1>
            </div>

            <div class="box-container w-[50%] ml-[15rem] py-8 grid items-center justify-center gap-4 text-xl bg-[#deb88757] rounded-[3rem] border-[#199696] shadow-[1px_1px_15px_rgb(0,0,0,.6)] text-[#c98c3e] font-bold text-left uppercase z-[-1]">
    
                <div>
                    <input type="radio" value="cash" name="payment" class="cursor-pointer"><span class="mt-4"> Cash on Delivery</span>
                </div>
                <div>
                    <input type="radio" value="cash" name="payment" class="cursor-pointer"><span class="mt-4"> GCash</span>
                </div>
                <div>
                    <input type="radio" value="cash" name="payment" class="cursor-pointer"><span class="mt-4"> Credit Card</span>
                </div>
            </div>
            <div class="flex flex-wrap pl-[40%] py-10 z-[1]">
                <a href="/checkout" class="btn capitalize px-[4rem] text-lg p-[.5rem] relative rounded-3xl text-white text-center bg-[#199696] shadow-[0_.5rem_1rem_rgba(0,0,0,0.3)] hover:shadow-[1px_1px_15px_rgb(0,0,0,.6)]">
                Confirm</a>
            </div>
        </div>
                
    </section>
</div>



<div class="pt-[30%]">
    @include('client.components..footer')
</div>
