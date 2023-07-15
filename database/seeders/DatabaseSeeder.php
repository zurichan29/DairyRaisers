<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Product;
use App\Models\Cart;
use App\Models\User;
use App\Models\Variants;
use App\Models\ProductStock;
use App\Models\Order;
use App\Models\User_Address;
use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // VARIANTS:
        // 1. Milk
        // 2. Yogurt
        // 3. Jelly
        // 4. Frozen Dessert
        // 5. Pastillas
        // 6. Cheese

       

        User::Create([
            'first_name' => 'christian',
            'last_name' => 'Jacalne',
            'email' => 'krischang29@gmail.com',
            'password' =>  Hash::make('2329Cjay'),
            'mobile_number' => '9262189072',
            'mobile_verified_at' => Carbon::now()
        ]);

        // User::Create([
        //     'first_name' => 'admin1',
        //     'last_name' => 'test',
        //     'email' => 'christian@dairyraisers.com',
        //     'role' => 'admin',
        //     'password' => hash::make('Test123'),
        // ]);

        Admin::Create([
            'first_name' => 'administrator',
            'email' => 'christian@dairyraisers.com',
            'password' => hash::make('test123'),
        ]);

        // User_Address::Create([
        //     'user_id' => 1,
        //     'province' => 'Cavite',
        //     'city' => 'Tanza',
        //     'barangay' => 'julugan 8',
        //     'street' => 'Sta. Cecilia 2',
        //     'label' => 'home',
        //     'zip_code' => '4108',
        //     'default' => '1',
        //     'remarks' => 'This is my remark'
        // ]);

        // Order::Create([
        //     'user_id' => 1,
        //     'order_number' => 'DR-0623-1',
        //     'grand_total' => '650',
        //     'user_address' => 'Sta. Cecilia 2 julugan 8, Tanza, Cavite, 4108 Philippines',
        //     'remarks' => 'this is my remarks',
        //     'payment_method' => 'COD'
        // ]);

        Cart::Create([
            'product_id' => 1,
            'user_id' => 1,
            'quantity' => 3,
            'order_number' => 'DR-0623-1',
            'price' => 100,
            'total' => 300
        ]);

        Cart::Create([
            'product_id' => 5,
            'user_id' => 1,
            'quantity' => 7,
            'order_number' => 'DR-0623-1',
            'price' => 50,
            'total' => 350
        ]);

        Cart::Create([
            'product_id' => 2,
            'user_id' => 1,
            'quantity' => 3,
            'price' => 100,
            'total' => 300
        ]);

        Cart::Create([
            'product_id' => 17,
            'user_id' => 1,
            'quantity' => 10,
            'price' => 5,
            'total' => 50
        ]);

        Variants::Create([
            'name' => 'Yogurt'
        ]);

        Variants::Create([
            'name' => 'Pastillas'
        ]);

        Variants::Create([
            'name' => 'Milk'
        ]);

        Variants::Create([
            'name' => 'Jelly'
        ]);

        Variants::Create([
            'name' => 'Frozen Dessert'
        ]);

        Variants::Create([
            'name' => 'Cheese'
        ]);

        Product::create([
            'name' => 'Choco Milk',
            'img' => 'images/Baka.png',
            'variant' => 'Milk',
            'price' => 100
        ]);

        Product::create([
            'name' => 'Fresh Milk',
            'img' => 'images/Baka.png',
            'variant' => 'Milk',
            'price' => 100
        ]);

        Product::create([
            'name' => 'Strawberry Milk',
            'img' => 'images/Baka.png',
            'variant' => 'Milk',
            'price' => 100
        ]);

        Product::create([
            'name' => 'Plain Yogurt',
            'img' => 'images/Baka.png',
            'variant' => 'Yogurt',
            'price' => 50
        ]);

        Product::create([
            'name' => 'Strawberry Yogurt',
            'img' => 'images/Baka.png',
            'variant' => 'Yogurt',
            'price' => 50
        ]);

        Product::create([
            'name' => 'Mango Yogurt',
            'img' => 'images/Baka.png',
            'variant' => 'Yogurt',
            'price' => 50
        ]);

        Product::create([
            'name' => 'Blueberry Yogurt',
            'img' => 'images/Baka.png',
            'variant' => 'Yogurt',
            'price' => 50
        ]);

        Product::create([
            'name' => 'Patchberry Yogurt',
            'img' => 'images/Baka.png',
            'variant' => 'Yogurt',
            'price' => 50
        ]);

        Product::create([
            'name' => 'Pineapple Yogurt',
            'img' => 'images/Baka.png',
            'variant' => 'Yogurt',
            'price' => 50
        ]);

        Product::create([
            'name' => 'Mango Yogurt',
            'img' => 'images/Baka.png',
            'variant' => 'Yogurt',
            'price' => 50
        ]);

        Product::create([
            'name' => 'Milk-o-Jel',
            'img' => 'images/Baka.png',
            'variant' => 'Jelly',
            'price' => 50
        ]);

        Product::create([
            'name' => 'Plain Pastillas',
            'img' => 'images/Baka.png',
            'variant' => 'Pastillas',
            'price' => 25
        ]);

        Product::create([
            'name' => 'Cheese Pastillas',
            'img' => 'images/Baka.png',
            'variant' => 'Pastillas',
            'price' => 25
        ]);

        Product::create([
            'name' => 'Ube Pastillas',
            'img' => 'images/Baka.png',
            'variant' => 'Pastillas',
            'price' => 25
        ]);

        Product::create([
            'name' => 'Buko Pandan Pastillas',
            'img' => 'images/Baka.png',
            'variant' => 'Pastillas',
            'price' => 25
        ]);

        Product::create([
            'name' => 'Langka Pastillas',
            'img' => 'images/Baka.png',
            'variant' => 'Pastillas',
            'price' => 25
        ]);

        Product::create([
            'name' => 'Ice Candy',
            'img' => 'images/Baka.png',
            'variant' => 'Frozen Dessert',
            'price' => 5
        ]);

        Product::create([
            'name' => 'Cheese & Corn Ice Cream',
            'img' => 'images/Baka.png',
            'variant' => 'Frozen Dessert',
            'price' => 30
        ]);

        Product::create([
            'name' => 'Cookies & Cream Ice Cream',
            'img' => 'images/Baka.png',
            'variant' => 'Frozen Dessert',
            'price' => 30
        ]);

        Product::create([
            'name' => 'Choco Ice Candy',
            'img' => 'images/Baka.png',
            'variant' => 'Frozen Dessert',
            'price' => 10
        ]);

        Product::create([
            'name' => 'Mais Ice Candy',
            'img' => 'images/Baka.png',
            'variant' => 'Frozen Dessert',
            'price' => 10
        ]);


        Product::create([
            'name' => 'Mozarella Cheese',
            'img' => 'images/Baka.png',
            'variant' => 'Cheese',
            'price' => 250
        ]);

        ProductStock::create([
            'product_id' => 1,
            'stock' => 50,
            'date_created' => Carbon::now()->toDateString(),
            'expiration_date' => Carbon::now()->addDays(7)->toDateString(), 
        ]);

        ProductStock::create([
            'product_id' => 2,
            'stock' => 75,
            'date_created' => Carbon::now()->toDateString(),
            'expiration_date' => Carbon::now()->addDays(7)->toDateString(), 
        ]);

        ProductStock::create([
            'product_id' => 3,
            'stock' => 22,
            'date_created' => Carbon::now()->toDateString(),
            'expiration_date' => Carbon::now()->addDays(7)->toDateString(), 
        ]);
    }
}