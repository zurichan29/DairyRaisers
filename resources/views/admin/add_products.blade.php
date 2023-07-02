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

                Dashboard
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
    <section class="add-products">

        <h1 class="title">Add New Product</h1>

        <form action="" method="POST" enctype="multipart/form-data">
            <div class="flex">
                <div class="inputBox">
                    <input type="text" name="name" class="box" required placeholder="Enter product name">
                    <select name="category" class="box" required>
                        <option value="" selected disabled>Select Category</option>
                            <option value="milks">Milks</option>
                            <option value="ice-creams">Ice Creams</option>
                            <option value="cheese">Cheese</option>
                            <option value="yoghurts&jelly">Yoghurts & Jelly</option>
                    </select>
                </div>
                <div class="inputBox">
                <input type="number" min="0" name="price" class="box" required placeholder="Enter product price">
                <input type="file" name="image" required class="box" accept="image/jpg, image/jpeg, image/png, image/jfif">
                </div>
            </div>
            <textarea name="details" class="box" required placeholder="Enter product description" cols="30" rows="10"></textarea>
            <input type="submit" class="btn" value="Add product" name="add_product">
        </form>
        
    </section>

    <section class="show-products">

        <h1 class="title">Products Added</h1>

        <div class="box-container">
            @foreach ($addProducts as $item)
            <div class="box">
                <img src="" alt="">
                <div class="name"></div>
                <div class="cat"></div>
                <div class="price">P</div>
                <div class="details"></div>
                <div class="flex-btn">
                    <a href="admin_update_product.php?update=" class="option-btn">Update</a>
                    <a href="admin_products.php?delete=" class="delete-btn" onclick="return confirm('Delete this product?');">Delete</a>

                </div>
            </div>
            @endforeach
        </div>

    </section>

</x-admin-layout>