<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Carbon\Carbon;
use App\Models\Cart;
use App\Models\User;
use App\Models\Admin;
use App\Models\Order;
use App\Models\OnlineShopper;
use App\Models\Retailer;
use App\Models\Buffalo;
use App\Models\Product;
use App\Models\Variants;
use App\Models\MilkStock;
use App\Models\ProductStock;
use App\Models\User_Address;
use App\Models\PaymentMethod;
use App\Models\Sales;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        User::Create([
            'first_name' => 'Christian Jay',
            'last_name' => 'Jacalne',
            'email' => 'krischang29@gmail.com',
            'password' =>  Hash::make('2329Cjay'),
            'mobile_number' => '9262189072',
            'mobile_verified_at' => Carbon::now()
        ]);

        User::Create([
            'first_name' => 'Laarni',
            'last_name' => 'Lalic',
            'email' => 'laarnimarielalic@gmail.com',
            'password' =>  Hash::make('2329Marie'),
            'mobile_number' => '9972654850',
            'mobile_verified_at' => Carbon::now()
        ]);

        $this->seedStaffs();

        PaymentMethod::Create([
            'type' => 'Gcash',
            'account_name' => 'Christian Jay Jacalne',
            'account_number' => '09262189072',
            'status' => 'ACTIVATED'
        ]);

        User_Address::Create([
            'user_id' => 1,
            'region' => 'REGION IV-A',
            'province' => 'CAVITE',
            'municipality' => 'TANZA',
            'barangay' => 'JULUGAN VIII',
            'street' => 'Sta. Cecilia 2',
            'label' => 'home',
            'zip_code' => '4108',
            'default' => '1',
            'remarks' => 'This is my remark'
        ]);

        User_Address::Create([
            'user_id' => 2,
            'region' => 'REGION IV-A',
            'province' => 'CAVITE',
            'municipality' => 'BACOOR CITY',
            'barangay' => 'ALIMA',
            'street' => 'street 22221',
            'label' => 'home',
            'zip_code' => '4109',
            'default' => '1',
            'remarks' => 'This is my remark'
        ]);

        // Seed online shoppers and retailers
        $this->seedOnlineShoppers();
        $this->seedRetailers();

        // Seed orders with their respective items
        $this->seedOrders();
        $this->seedSalesData();

        // Cart::Create([
        //     'product_id' => 1,
        //     'user_id' => 1,
        //     'quantity' => 3,
        //     'order_number' => 'DR-0723-1',
        //     'price' => 100,
        //     'total' => 300
        // ]);

        // Cart::Create([
        //     'product_id' => 5,
        //     'user_id' => 1,
        //     'quantity' => 7,
        //     'order_number' => 'DR-0623-1',
        //     'price' => 50,
        //     'total' => 350
        // ]);

        // Cart::Create([
        //     'product_id' => 2,
        //     'user_id' => 1,
        //     'quantity' => 3,
        //     'price' => 100,
        //     'total' => 300
        // ]);

        // Cart::Create([
        //     'product_id' => 17,
        //     'user_id' => 1,
        //     'quantity' => 10,
        //     'price' => 5,
        //     'total' => 50
        // ]);

        $this->seedProducts();
        // $table->string('gender');
        // $table->integer('age');
        // $table->integer('quantity_sold');
        // $table->timestamps('date_sold');
        // $table->string('buyers_name');
        // $table->string('buyers_address');
        Buffalo::create([
            'gender' => 'Female',
            'age' => null,
            'quantity_sold' => 2,
            'date_sold' => Carbon::now()->toDateString(),
            'buyers_name' => 'Shania',
            'buyers_address' =>  'Santiago, General Trias',
        ]);


        Buffalo::create([
            'gender' => 'Female',
            'age' => null,
            'quantity_sold' => 2,
            'date_sold' => Carbon::now()->toDateString(),
            'buyers_name' => 'Shania',
            'buyers_address' =>  'Santiago, General Trias',
        ]);

        MilkStock::create([
            'date_created' => Carbon::now()->toDateString(),
            'quantity' => '20',
        ]);
    }

    private function seedStaffs()
    {
        Admin::create([
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'access' => json_encode(['inventory', 'orders', 'staff_management', 'payment_methods', 'activity_logs', 'buffalos_and_milk']), // Convert to JSON
            'is_verified' => true,
            'is_admin' => true,
            'password' => Hash::make('test123'),
        ]);

        Admin::create([
            'name' => 'Employee 1',
            'email' => 'employee1@example.com',
            'access' => json_encode(['orders']), // Convert to JSON
            'is_verified' => true,
            'password' => Hash::make('mypassword1'),
        ]);

        Admin::create([
            'name' => 'Employee 2',
            'email' => 'employee2@example.com',
            'access' => json_encode(['inventory', 'activity_logs']), // Convert to JSON
            'is_verified' => true,
            'password' => Hash::make('mypassword2'),
        ]);
    }

    private function seedProducts()
    {
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
            'variants_id' => 3,
            'price' => 100,
            'stocks' => 100,
            'status' => 'AVAILABLE',
        ]);

        Product::create([
            'name' => 'Fresh Milk',
            'img' => 'images/Baka.png',
            'variants_id' => 3,
            'price' => 100,
            'stocks' => 100,
            'status' => 'AVAILABLE',
        ]);

        Product::create([
            'name' => 'Strawberry Milk',
            'img' => 'images/Baka.png',
            'variants_id' => 3,
            'price' => 100,
            'stocks' => 100,
            'status' => 'AVAILABLE',
        ]);

        Product::create([
            'name' => 'Plain Yogurt',
            'img' => 'images/Baka.png',
            'variants_id' => 1,
            'price' => 50,
            'stocks' => 100,
            'status' => 'AVAILABLE',
        ]);

        Product::create([
            'name' => 'Strawberry Yogurt',
            'img' => 'images/Baka.png',
            'variants_id' => 1,
            'price' => 50,
            'stocks' => 100,
            'status' => 'AVAILABLE',
        ]);

        Product::create([
            'name' => 'Mango Yogurt',
            'img' => 'images/Baka.png',
            'variants_id' => 1,
            'price' => 50,
            'stocks' => 100,
            'status' => 'AVAILABLE',
        ]);

        Product::create([
            'name' => 'Blueberry Yogurt',
            'img' => 'images/Baka.png',
            'variants_id' => 1,
            'price' => 50,
            'stocks' => 100,
            'status' => 'AVAILABLE',
        ]);

        Product::create([
            'name' => 'Patchberry Yogurt',
            'img' => 'images/Baka.png',
            'variants_id' => 1,
            'price' => 50,
            'stocks' => 100,
            'status' => 'AVAILABLE',
        ]);

        Product::create([
            'name' => 'Pineapple Yogurt',
            'img' => 'images/Baka.png',
            'variants_id' => 1,
            'price' => 50,
            'stocks' => 100,
            'status' => 'AVAILABLE',
        ]);

        Product::create([
            'name' => 'Mango Yogurt',
            'img' => 'images/Baka.png',
            'variants_id' => 1,
            'price' => 50,
            'stocks' => 100,
            'status' => 'AVAILABLE',
        ]);

        Product::create([
            'name' => 'Milk-o-Jel',
            'img' => 'images/Baka.png',
            'variants_id' => 4,
            'price' => 50,
            'stocks' => 100,
            'status' => 'AVAILABLE',
        ]);

        Product::create([
            'name' => 'Plain Pastillas',
            'img' => 'images/Baka.png',
            'variants_id' => 2,
            'price' => 25,
            'stocks' => 100,
            'status' => 'AVAILABLE',
        ]);

        Product::create([
            'name' => 'Cheese Pastillas',
            'img' => 'images/Baka.png',
            'variants_id' => 2,
            'price' => 25,
            'stocks' => 100,
            'status' => 'AVAILABLE',
        ]);

        Product::create([
            'name' => 'Ube Pastillas',
            'img' => 'images/Baka.png',
            'variants_id' => 2,
            'price' => 25,
            'stocks' => 100,
            'status' => 'AVAILABLE',
        ]);

        Product::create([
            'name' => 'Buko Pandan Pastillas',
            'img' => 'images/Baka.png',
            'variants_id' => 2,
            'price' => 25,
            'stocks' => 100,
            'status' => 'AVAILABLE',
        ]);

        Product::create([
            'name' => 'Langka Pastillas',
            'img' => 'images/Baka.png',
            'variants_id' => 2,
            'price' => 25,
            'stocks' => 100,
            'status' => 'AVAILABLE',
        ]);

        Product::create([
            'name' => 'Ice Candy',
            'img' => 'images/Baka.png',
            'variants_id' => 5,
            'price' => 5,
            'stocks' => 100,
            'status' => 'AVAILABLE',
        ]);

        Product::create([
            'name' => 'Cheese & Corn Ice Cream',
            'img' => 'images/Baka.png',
            'variants_id' => 5,
            'price' => 30,
            'stocks' => 100,
            'status' => 'AVAILABLE',
        ]);

        Product::create([
            'name' => 'Cookies & Cream Ice Cream',
            'img' => 'images/Baka.png',
            'variants_id' => 5,
            'price' => 30,
            'stocks' => 100,
            'status' => 'AVAILABLE',
        ]);

        Product::create([
            'name' => 'Choco Ice Candy',
            'img' => 'images/Baka.png',
            'variants_id' => 5,
            'price' => 10,
            'stocks' => 100,
            'status' => 'AVAILABLE',
        ]);

        Product::create([
            'name' => 'Mais Ice Candy',
            'img' => 'images/Baka.png',
            'variants_id' => 5,
            'price' => 10,
            'stocks' => 100,
            'status' => 'AVAILABLE',
        ]);


        Product::create([
            'name' => 'Mozarella Cheese',
            'img' => 'images/Baka.png',
            'variants_id' => 6,
            'price' => 250,
            'stocks' => 100,
            'status' => 'AVAILABLE',
        ]);
    }

    private function seedOnlineShoppers()
    {
        // Online Shopper 1
        $onlineShopper1 = OnlineShopper::create([
            'user_id' => 1, // Replace with the actual user ID of the first online shopper
            // Add other online shopper-specific details
        ]);

        // Online Shopper 2
        $onlineShopper2 = OnlineShopper::create([
            'user_id' => 2, // Replace with the actual user ID of the second online shopper
            // Add other online shopper-specific details
        ]);
    }

    private function seedRetailers()
    {
        // Retailer 1
        $retailer1 = Retailer::create([
            'first_name' => 'Retailer 1 First Name',
            'last_name' => 'Retailer 1 Last Name',
            'store_name' => 'Retailer 1 Store',
            'mobile_number' => '1111111111',
            'region' => 'REGION I',
            'province' => 'ILOCOS NORTE',
            'municipality' => 'BACARRA',
            'barangay' => 'CABULALAAN',
            'street' => 'street 1111',
            'zip_code' => '4001',
            'complete_address' => 'street 1111 BRGY. CABULALAAN, BACARRA, ILOCOS NORTE, REGION I 4001, PHILIPPINES',
            'remarks' => 'remarks 11111'
            // Add other retailer-specific details
        ]);

        // Retailer 2
        $retailer2 = Retailer::create([
            'first_name' => 'Retailer 2 First Name',
            'last_name' => 'Retailer 2 Last Name',
            'store_name' => 'Retailer 2 Store',
            'mobile_number' => '2222222222',
            'region' => 'REGION II',
            'province' => 'BATANES',
            'municipality' => 'BASCO',
            'barangay' => 'SAN ANTONIO',
            'street' => 'street 2222',
            'zip_code' => '4002',
            'complete_address' => 'street 2222 BRGY. SAN ANTONIO, BASCO, BATANES, REGION II 4002, PHILIPPINES',
            'remarks' => 'remarks 22222'
            // Add other retailer-specific details
        ]);
    }
    private function seedOrders()
    {
        // Orders for Online Shopper 1
        $order1 = Order::create([
            'order_number' => 'DR08231',
            'customer_id' => 1, // Replace with the actual online shopper ID (e.g., $onlineShopper1->id)
            'customer_type' => 'online_shopper',
            'items' => [
                [
                    'product_id' => 1,
                    'price' => 100,
                    'discount' => 0,
                    'quantity' => 2,
                    'total' => 200,
                ],
                [
                    'product_id' => 4,
                    'price' => 50,
                    'discount' => 0,
                    'quantity' => 3,
                    'total' => 150,
                ],
                // Add more items as needed
            ],
            'grand_total' => 350,
            'address' => 'Sta. Cecilia 2 BRGY. JULUGAN VIII, TANZA, CAVITE, REGION IV-A 4108, PHILIPPINES',
            'shipping_option' => 'Delivery',
            'payment_method' => 'Gcash',
            'reference_number' => '123456789B',
        ]);

        // Orders for Online Shopper 2
        $order2 = Order::create([
            'order_number' => 'DR08232',
            'customer_id' => 2, // Replace with the actual online shopper ID (e.g., $onlineShopper2->id)
            'customer_type' => 'online_shopper',
            'items' => [
                [
                    'product_id' => 2,
                    'price' => 100,
                    'discount' => 0,
                    'quantity' => 3,
                    'total' => 300,
                ],
                // Add more items as needed
            ],
            'grand_total' => 300,
            'address' => 'street 22221 BRGY. ALIMA, BACOOR CITY, CAVITE, REGION IV-A 4109, PHILIPPINES',
            'shipping_option' => 'Delivery',
            'payment_method' => 'Gcash',
            'reference_number' => '987654321A',
        ]);

        // Orders for Retailer 1
        $order3 = Order::create([
            'order_number' => 'DR08233',
            'customer_id' => 1, // Replace with the actual retailer ID (e.g., $retailer1->id)
            'customer_type' => 'retailer',
            'items' => [
                [
                    'product_id' => 3,
                    'price' => 100,
                    'discount' => 10,
                    'quantity' => 5,
                    'total' => 450,
                ],
                // Add more items as needed
            ],
            'grand_total' => 450,
            'address' => 'street 1111 BRGY. CABULALAAN, BACARRA, ILOCOS NORTE, REGION I 4001, PHILIPPINES',
            'shipping_option' => 'Delivery',
            'payment_method' => 'Gcash',
            'reference_number' => '987654321F',
        ]);

        // Orders for Retailer 2
        $order4 = Order::create([
            'order_number' => 'DR08234',
            'customer_id' => 2, // Replace with the actual retailer ID (e.g., $retailer2->id)
            'customer_type' => 'retailer',
            'items' => [
                [
                    'product_id' => 4,
                    'price' => 50,
                    'discount' => 2,
                    'quantity' => 10,
                    'total' => 480,
                ],
                // Add more items as needed
            ],
            'grand_total' => 480,
            'address' => 'street 2222 BRGY. SAN ANTONIO, BASCO, BATANES, REGION II 4002, PHILIPPINES',
            'shipping_option' => 'Delivery',
            'payment_method' => 'Gcash',
            'reference_number' => '123456789G',
        ]);
    }

    private function seedSalesData(): void
    {
        $currentDate = Carbon::now();
        $lastMonthDate = $currentDate->copy()->subMonth();

        // Create sales data for the current month
        Sales::create([
            'category' => 'Products',
            'name' => 'Choco Milk', // Product name
            'price' => 100, // Product price
            'quantity' => 50, // Product quantity sold
            'amount' => 1500.00,
            'created_at' => $currentDate,
        ]);

        Sales::create([
            'category' => 'Buffalo',
            'name' => 'Buffalo', // Product name
            'price' => 2300.50, // Product price
            'quantity' => 2, // Number of buffaloes sold
            'amount' => 4601.00, // Total sales for buffaloes
            'created_at' => $currentDate,
        ]);

        Sales::create([
            'category' => 'Milk',
            'name' => 'Milk', // Product name
            'price' => 1800.75, // Product price per liter
            'quantity' => 3, // Number of liters of milk sold
            'amount' => 5420.25, // Total sales for milk
            'created_at' => $currentDate,
        ]);

        // Create sales data for the last month
        Sales::create([
            'category' => 'Products',
            'name' => 'Choco Milk', // Product name
            'price' => 100, // Product price
            'quantity' => 25, // Product quantity sold
            'amount' => 2500.00,
            'created_at' => $lastMonthDate,
        ]);

        Sales::create([
            'category' => 'Buffalo',
            'name' => 'Buffalo', // Product name
            'price' => 1800.25, // Product price
            'quantity' => 1, // Number of buffaloes sold
            'amount' => 1800.25, // Total sales for buffaloes
            'created_at' => $lastMonthDate,
        ]);

        Sales::create([
            'category' => 'Milk',
            'name' => 'Milk', // Product name
            'price' => 2100.50, // Product price per liter
            'quantity' => 2, // Number of liters of milk sold
            'amount' => 4201.00, // Total sales for milk
            'created_at' => $lastMonthDate,
        ]);
    }
}
