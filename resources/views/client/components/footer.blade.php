<footer class="footer bg-[#136d6d]">

    <section class="box-container grid gap-8 items-start grid-cols-4 text-[#ffe4c4] pb-14 px-5">

        <div class="mt-14 pl-14">
            <a href="{{ URL::secure(route('index')) }}"><img src="{{ asset('images/Baka.png') }}" alt=""
                    class="logo w-[100px] hover:animate-pulse ml-[4.5rem]" /></a>
            <p class="block pt-3.5 pr-0 min-w-fit"> <i class="fas fa-map-marker-alt"></i> Purok 1, Brgy Santiago, City
                of General Trias, Cavite </p>
        </div>

        <div class="box mt-14 pl-20">
            <h3 class="uppercase mb-8 text-xl">Quick Links</h3>
            <a href="{{ URL::secure(route('index')) }}" class="block pt-3.5 pr-0 min-w-fit hover:underline"> <i
                    class="fa-solid fa-house text-[#ffe4c4]"></i> Home</a>
            <a href="{{ URL::secure(route('shop')) }}" class="block pt-3.5 pr-0 min-w-fit hover:underline"> <i
                    class="fa-solid fa-shop text-[#ffe4c4]"></i> Products</a>
            <a href="{{ URL::secure(route('about')) }}" class="block pt-3.5 pr-0 min-w-fit hover:underline"> <i
                    class="fa-solid fa-fingerprint text-[#ffe4c4]"></i> About</a>
        </div>

        <div class="box mt-14 pl-8">
            <h3 class="uppercase mb-8 text-xl">Get In Touch</h3>
            <p class="block pt-3.5 pr-0 min-w-fit"> <i class="fas fa-phone"></i> (+63)997-251-4142 </p>
            <p class="block pt-3.5 pr-0 min-w-fit"> <i class="fas fa-phone"></i> (+63)932-548-8081 </p>
            <p class="block pt-3.5 pr-0 min-w-fit"> <i class="fa-solid fa-envelope"></i> gentridairympc@ymail.com </p>
        </div>

        <div class="box mt-14 pl-14">
            <h3 class="uppercase mb-8 text-xl">Follow Us</h3>
            <div class="flex gap-10 pt-3">

                <a href="https://web.facebook.com/gentridairy"><i
                        class="fa-brands fa-facebook text-2xl text-[#ffe4c4] cursor-pointer transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-110 duration-300"></i></a>

                <a href="https://www.instagram.com/gentrisbest/"><i
                        class="fa-brands fa-instagram text-2xl text-[#ffe4c4] cursor-pointer transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-110 duration-300"></i></a>

                <a href="https://twitter.com/gentrisbest"><i
                        class="fa-brands fa-twitter text-2xl text-[#ffe4c4] cursor-pointer transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-110 duration-300"></i></a>

            </div>
        </div>

    </section>
    <div
        class="grid grid-cols-2 py-6 px-8 bg-[#136d6d] leading-normal border-t-[.1rem] border-solid border-[#5f9ea0] font-semibold text-[#ffe4c4]">
        <div class="pt-1 uppercase">
            <a href="/terms" class="hover:underline mr-10">Terms of Services</a>
            <a href="https://goo.gl/maps/Lv1hLeXSM7RcxyE76" class="hover:underline">Store Map</a>
        </div>
        <div>
            <p class="credit text-right text-xl">
                Copyright &copy; <?= date('Y') ?><span class=""> Dairy Raisers</span></p>
        </div>
    </div>
</footer>

{{-- <footer class="footer bg-[#5f9ea0]">

    <section class="box-container grid gap-8 items-start grid-cols-4 text-[#ffe4c4] pl-[8rem] pb-4">

        <div class="box mt-5">
            <h3 class="uppercase mb-5 text-xl">Quick Links</h3>
            <a href="/" class="block pt-3.5 pr-0 min-w-fit hover:underline hover:text-[#d3a870]"> <i
                    class="fa-solid fa-house text-[#ffe4c4]"></i> Home</a>
            <a href="/product" class="block pt-3.5 pr-0 min-w-fit hover:underline hover:text-[#d3a870]"> <i
                    class="fa-solid fa-shop text-[#ffe4c4]"></i> Shop</a>
            <a href="/about" class="block pt-3.5 pr-0 min-w-fit hover:underline hover:text-[#d3a870]"> <i
                    class="fa-solid fa-fingerprint text-[#ffe4c4]"></i> About</a>
            <a href="/contact" class="block pt-3.5 pr-0 min-w-fit hover:underline hover:text-[#d3a870]"> <i
                    class="fa-solid fa-address-book text-[#ffe4c4]"></i> Contact</a>
        </div>

        <div class="box mt-5">
            <h3 class="uppercase mb-5 text-xl">Extra Links</h3>
            <a href="/cart" class="block pt-3.5 pr-0 min-w-fit hover:underline hover:text-[#d3a870]"> <i
                    class="fa-solid fa-cart-shopping text-[#ffe4c4]"></i> Cart </a>
            <a href="/login" class="block pt-3.5 pr-0 min-w-fit hover:underline hover:text-[#d3a870]"> <i
                    class="fa-solid fa-right-to-bracket text-[#ffe4c4]"></i> Login </a>
            <a href="/register" class="block pt-3.5 pr-0 min-w-fit hover:underline hover:text-[#d3a870]"> <i
                    class="fa-solid fa-user-plus text-[#ffe4c4]"></i> Register </a>
        </div>

        <div class="box mt-5">
            <h3 class="uppercase mb-5 text-xl">Contact Info</h3>
            <p class="block pt-3.5 pr-0 min-w-fit"> <i class="fas fa-phone"></i> (+63)997-251-4142 </p>
            <p class="block pt-3.5 pr-0 min-w-fit"> <i class="fas fa-phone"></i> (+63)932-548-8081 </p>
            <p class="block pt-3.5 pr-0 min-w-fit"> <i class="fa-solid fa-envelope"></i> gentridairympc@ymail.com </p>
            <p class="block pt-3.5 pr-0 min-w-fit"> <i class="fas fa-map-marker-alt"></i> Purok 1, Brgy Santiago, City
                of General Trias, Cavite </p>
        </div>

        <div class="box mt-5">
            <h3 class="uppercase mb-5 text-xl">Follow Us</h3>
            <a link="#" class="block pt-3.5 pr-0 min-w-fit hover:underline hover:text-[#d3a870]"> <i
                    class="fa-brands fa-facebook text-[#ffe4c4]"></i> Facebook </a>
            <a href="#" class="block pt-3.5 pr-0 min-w-fit hover:underline hover:text-[#d3a870]"> <i
                    class="fa-brands fa-instagram text-[#ffe4c4]"></i> Instagram </a>
            <a href="#" class="block pt-3.5 pr-0 min-w-fit hover:underline hover:text-[#d3a870]"> <i
                    class="fa-brands fa-twitter text-[#ffe4c4]"></i> Twitter </a>
        </div>

    </section>

    <p
        class="credit pt-5 pr-2 pb-4 leading-normal border-t-[.1rem] border-solid border-[#136d6d] text-center text-xl text-[#333]">
        &copy; <?= date('Y') ?> by <span class="text-[#ffe4c4]">Dairy Raisers</span> | All Rights Reserved. </p>

</footer> --}}

<script src="{{ asset('js/cart.js') }}"></script>
