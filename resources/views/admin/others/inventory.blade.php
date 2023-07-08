<x-admin-layout>

    <input type="checkbox" id="nav-toggle">
    <div class="sidebar fixed left-0 top-0 h-full z-[100] w-[250px] bg-sky-300 text-[#fff8dc]">
        <div class="sidebar-brand py-4 pr-0 pl-2 h-24 text-white">
            <div class="user-wrapper flex">
                <img src="{{asset('images/Baka.png')}}" width="55px" height="55px" alt="error">
                <h1 class="h-[40px] text-2xl font-bold pt-2 pl-2 text-[#fff8dc]">G T D R M P C</h1>
            </div>
        </div>
        <div class="sidebar-menu mt-2">
            <ul>
                <li class="w-full my-8 pl-4 text-[#fff8dc] hover:text-[#deb887] hover:bg-[#fff8dc] cursor-pointer">
                    <a href="/admin_dashboard" class="pl-4 block text-lg hover:text-[#d3a870]"><i class="fa-solid fa-gauge"></i>
                        <span class="text-xl pr-4"> Dashboard</span></a>
                </li>
                <li class="w-full my-8 pl-4 text-[#fff8dc] hover:text-[#deb887] hover:bg-[#fff8dc] cursor-pointer">
                    <a href="/admin/customers" class="pl-4 block text-lg hover:text-[#d3a870]"><i class="fa-solid fa-users"></i>
                        <span class="text-xl pr-4"> Customers</span></a>
                </li>
                <li class="w-full my-8 pl-4 text-[#fff8dc] hover:text-[#deb887] hover:bg-[#fff8dc] cursor-pointer">
                    <a href="Orders.html" class="pl-4 block text-lg hover:text-[#d3a870]"><i class="fa-solid fa-cart-shopping"></i>
                        <span class="text-xl pr-4"> Orders</span></a>
                </li>
            
                <li class="w-full my-8 pl-4 text-[#fff8dc] hover:text-[#deb887] hover:bg-[#fff8dc] cursor-pointer">
                    <a href="/admin/inventory" class="pl-4 block text-lg hover:text-[#d3a870]"><i class="fa-solid fa-receipt"></i>
                        <span class="text-xl pr-4"> Inventory</span></a>
                </li>
                <li class="w-full mt-24 mb-8 pl-4 text-[#fff8dc] hover:text-[#deb887] hover:bg-[#fff8dc] cursor-pointer">
                    <a href="/login" class="pl-4 block text-lg hover:text-[#d3a870]"><i class="fa-solid fa-power-off"></i>
                        <span class="text-xl pr-4">Logout</span></a>
                </li>
            </ul>
        </div>
    </div>
    <div class="main-content ml-[250px]">
        <header class="admin-header bg-[#fff8dc] flex justify-between py-4 pr-4 shadow-md fixed left-[250px] top-0 z-[100]">
            <h2 class="admin-label text-[#5f9ea0] text-xl pt-2">
                <label for="nav-toggle">
                    <span class="fa-solid fa-bars cursor-pointer ml-6 pr-4 text-2xl"></span>
                </label>

                Inventory
            </h2>

            <div class="search-wrapper border-[.1rem] rounded-lg border-solid border-[#5f9ea0] h-12 flex items-center">
                <span class="fa-solid fa-magnifying-glass inline-block pt-0 px-4 text-xl cursor-pointer text-[#5f9ea0]"></span>
                <input type="search" placeholder="Search here" class="h-full p-2 border-0 outline-0"/>
            </div>

            <div class="user-wrapper flex items-center">
                <img src="images/farmer.jpg" width="40px" height="40px" alt="" class=" rounded-full border-solid border-[#5f9ea0] mr-4 cursor-pointer">
                <div>
                    <h4 class="text-[#5f9ea0]">User</h4>
                    <small class="inline-block cursor-pointer text-[#d3a870]">Admin</small>
                </div>
            </div>
        </header>
    

        <main class="pt-24 px-5">
            
            <div class="recent-grid mt-8 grid gap-4 grid-cols-[100%]">
                <div class="projects">
                    <div class="card bg-white rounded-lg">
                        <div class="card-header p-4 flex justify-between items-center border-b-[.1rem] border-solid border-[#136d6d]">
                            <h2>Recent Orders</h2>
                            <button>See all</button>
                        </div>

                        
                            <div class="table-responsive w-full">
                                <table class="border-collapse">
                                    <div class="card-header p-4 flex justify-between items-center border-b-[.1rem] border-solid border-[#136d6d]">
                                        <tr>
                                            <th>Product Name</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                        </tr>
                                    </div>
                                </table>
                            </div>
                        
                    </div>
                </div>
                
            </div>
        </main>
    </div>
</x-admin-layout>
   <!-- Add your inventory content here -->
    <table class="table pt-24 px-5">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            <!-- Loop through your inventory items and display them -->
            @foreach ($inventory as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->price }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
