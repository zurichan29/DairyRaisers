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
use App\Models\User_Address;
use App\Models\PaymentMethod;
use App\Models\Sales;
use App\Models\DeliveryFee;
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
        $this->seedUserandAddress();


        $this->seedStaffs();

        PaymentMethod::Create([
            'type' => 'Gcash',
            'img' => 'images/payment_method/gcash_barcode.jpg',
            'account_name' => 'Christian Jay Jacalne',
            'account_number' => '09262189072',
            'status' => 'ACTIVATED'
        ]);

        $this->seedOnlineShoppers();
        $this->seedRetailers();

        $this->seedOrders();
        $this->seedSalesData();
        $this->seedProducts();
        $this->seedBuffalo();

        $data = [
            [
                'municipality' => 'ALFONSO',
                'fee' => 50,
                'zip_code' => '4123',
            ],
            [
                'municipality' => 'AMADEO',
                'fee' => 50,
                'zip_code' => '4119',
            ],
            [
                'municipality' => 'BACOOR CITY',
                'fee' => 50,
                'zip_code' => '4102',
            ],
            [
                'municipality' => 'CARMONA',
                'fee' => 50,
                'zip_code' => '4116',
            ],
            [
                'municipality' => 'CAVITE CITY',
                'fee' => 50,
                'zip_code' => '4100',
            ],
            [
                'municipality' => 'DASMARIÑAS CITY',
                'fee' => 50,
                'zip_code' => '4114',
            ],
            [
                'municipality' => 'GEN. MARIANO ALVAREZ',
                'fee' => 50,
                'zip_code' => '4117',
            ],
            [
                'municipality' => 'GENERAL EMILIO AGUINALDO',
                'fee' => 50,
                'zip_code' => '4124',
            ],
            [
                'municipality' => 'GENERAL TRIAS CITY',
                'fee' => 50,
                'zip_code' => '4107',
            ],
            [
                'municipality' => 'IMUS',
                'fee' => 50,
                'zip_code' => '4103',
            ],
            [
                'municipality' => 'INDANG',
                'fee' => 50,
                'zip_code' => '4122',
            ],
            [
                'municipality' => 'KAWIT',
                'fee' => 50,
                'zip_code' => '4104',
            ],
            [
                'municipality' => 'MAGALLANES',
                'fee' => 50,
                'zip_code' => '4113',
            ],
            [
                'municipality' => 'MARAGONDON',
                'fee' => 50,
                'zip_code' => '4112',
            ],
            [
                'municipality' => 'MENDEZ (MENDEZ-NUÑEZ)',
                'fee' => 50,
                'zip_code' => '4121',
            ],
            [
                'municipality' => 'NAIC',
                'fee' => 50,
                'zip_code' => '4110',
            ],
            [
                'municipality' => 'NOVELETA',
                'fee' => 50,
                'zip_code' => '4105',
            ],
            [
                'municipality' => 'ROSARIO',
                'fee' => 50,
                'zip_code' => '4106',
            ],
            [
                'municipality' => 'SILANG',
                'fee' => 50,
                'zip_code' => '4118',
            ],
            [
                'municipality' => 'TAGAYTAY CITY',
                'fee' => 50,
                'zip_code' => '4120',
            ],
            [
                'municipality' => 'TANZA',
                'fee' => 50,
                'zip_code' => '4108',
            ],
            [
                'municipality' => 'TERNATE',
                'fee' => 50,
                'zip_code' => '4111',
            ],
            [
                'municipality' => 'TRECE MARTIRES CITY',
                'fee' => 50,
                'zip_code' => '4109',
            ],
        ];

        DeliveryFee::Insert($data);
    }
    private function seedUserandAddress()
    {
        User::Create([
            'first_name' => 'Christian Jay',
            'last_name' => 'Jacalne',
            'email' => 'sample@gmail.com',
            'password' =>  Hash::make('2329Cjay'),
            'mobile_number' => '9262189071',
            'email_verified_at' => Carbon::now(),
        ]);

        User::Create([
            'first_name' => 'Laarni',
            'last_name' => 'Lalic',
            'email' => 'myasd@gmail.com',
            'password' =>  Hash::make('2329Marie'),
            'mobile_number' => '9972654851',
            'email_verified_at' => Carbon::now(),
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
    }

    private function seedStaffs()
    {
        Admin::create([
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'access' => json_encode(['inventory', 'orders', 'staff_management', 'payment_methods', 'activity_logs', 'buffalo_management']), // Convert to JSON
            'is_verified' => true,
            'is_admin' => true,
            'password' => Hash::make('test123'),
        ]);

        Admin::create([
            'name' => 'Employee 1',
            'email' => 'employee1@example.com',
            'access' => json_encode(['orders', 'buffalo_management']), // Convert to JSON
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
            'name' => 'Choco Milk (1L)',
            'img' => 'images/products/choco_milk_large.png',
            'variants_id' => 3,
            'price' => 135,
            'stocks' => 100,
            'status' => 'AVAILABLE',
        ]);

        Product::create([
            'name' => 'Choco Milk (200ml)',
            'img' => 'images/products/choco_milk_small.png',
            'variants_id' => 3,
            'price' => 40,
            'stocks' => 100,
            'status' => 'AVAILABLE',
        ]);

        Product::create([
            'name' => 'Fresh Milk (1L)',
            'img' => 'images/products/fresh_milk_large.png',
            'variants_id' => 3,
            'price' => 145,
            'stocks' => 100,
            'status' => 'AVAILABLE',
        ]);

        Product::create([
            'name' => 'Fresh Milk (200ml)',
            'img' => 'images/products/fresh_milk_small.png',
            'variants_id' => 3,
            'price' => 40,
            'stocks' => 100,
            'status' => 'AVAILABLE',
        ]);

        Product::create([
            'name' => 'Strawberry Milk (1L)',
            'img' => 'images/products/strawberry_milk_large.png',
            'variants_id' => 3,
            'price' => 170,
            'stocks' => 100,
            'status' => 'AVAILABLE',
        ]);

        Product::create([
            'name' => 'Strawberry Milk (200ml)',
            'img' => 'images/products/strawberry_milk_small.png',
            'variants_id' => 3,
            'price' => 50,
            'stocks' => 100,
            'status' => 'AVAILABLE',
        ]);

        Product::create([
            'name' => 'Plain Yogurt',
            'img' => 'images/products/plain_yogurt.png',
            'variants_id' => 1,
            'price' => 50,
            'stocks' => 100,
            'status' => 'AVAILABLE',
        ]);

        Product::create([
            'name' => 'Strawberry Yogurt',
            'img' => 'images/products/strawberry_yogurt.png',
            'variants_id' => 1,
            'price' => 55,
            'stocks' => 100,
            'status' => 'AVAILABLE',
        ]);

        Product::create([
            'name' => 'Mango Yogurt',
            'img' => 'images/products/mango_yogurt.png',
            'variants_id' => 1,
            'price' => 55,
            'stocks' => 100,
            'status' => 'AVAILABLE',
        ]);

        Product::create([
            'name' => 'Blueberry Yogurt',
            'img' => 'images/products/blueberry_yogurt.png',
            'variants_id' => 1,
            'price' => 55,
            'stocks' => 100,
            'status' => 'AVAILABLE',
        ]);

        Product::create([
            'name' => 'Patchberry Yogurt',
            'img' => 'images/products/patchberry_yogurt.png',
            'variants_id' => 1,
            'price' => 55,
            'stocks' => 100,
            'status' => 'AVAILABLE',
        ]);

        Product::create([
            'name' => 'Pineapple Yogurt',
            'img' => 'images/products/pineapple_yogurt.png',
            'variants_id' => 1,
            'price' => 55,
            'stocks' => 100,
            'status' => 'AVAILABLE',
        ]);

        Product::create([
            'name' => 'Milk-o-Jel',
            'img' => 'images/products/milk_o_jel.png',
            'variants_id' => 4,
            'price' => 22,
            'stocks' => 100,
            'status' => 'AVAILABLE',
        ]);

        Product::create([
            'name' => 'Plain Pastillas (20pcs)',
            'img' => 'images/products/plain_pastillas.png',
            'variants_id' => 2,
            'price' => 75,
            'stocks' => 100,
            'status' => 'AVAILABLE',
        ]);

        Product::create([
            'name' => 'Cheese Pastillas (20pcs)',
            'img' => 'images/products/cheese_pastillas.png',
            'variants_id' => 2,
            'price' => 75,
            'stocks' => 100,
            'status' => 'AVAILABLE',
        ]);

        Product::create([
            'name' => 'Ube Pastillas (20pcs)',
            'img' => 'images/products/ube_pastillas.png',
            'variants_id' => 2,
            'price' => 75,
            'stocks' => 100,
            'status' => 'AVAILABLE',
        ]);

        Product::create([
            'name' => 'Buko Pandan Pastillas (20pcs)',
            'img' => 'images/products/plain_pastillas.png',
            'variants_id' => 2,
            'price' => 75,
            'stocks' => 100,
            'status' => 'AVAILABLE',
        ]);

        Product::create([
            'name' => 'Langka Pastillas (20pcs)',
            'img' => 'images/products/cheese_pastillas.png',
            'variants_id' => 2,
            'price' => 75,
            'stocks' => 100,
            'status' => 'AVAILABLE',
        ]);

        Product::create([
            'name' => 'Corn Cheese Ice Cream',
            'img' => 'images/products/cheese_icecream.png',
            'variants_id' => 5,
            'price' => 30,
            'stocks' => 100,
            'status' => 'AVAILABLE',
        ]);

        Product::create([
            'name' => 'Ube Cheese Ice Cream',
            'img' => 'images/products/ube_icecream.png',
            'variants_id' => 5,
            'price' => 30,
            'stocks' => 100,
            'status' => 'AVAILABLE',
        ]);

        Product::create([
            'name' => 'Cookies & Cream Ice Cream',
            'img' => 'images/products/cookies_icecream.png',
            'variants_id' => 5,
            'price' => 30,
            'stocks' => 100,
            'status' => 'AVAILABLE',
        ]);

        Product::create([
            'name' => 'Ube Ice Candy',
            'img' => 'images/products/ube_ice_candy.jpg',
            'variants_id' => 5,
            'price' => 7,
            'stocks' => 100,
            'status' => 'AVAILABLE',
        ]);

        Product::create([
            'name' => 'Choco Ice Candy',
            'img' => 'images/products/ice_candy.jpg',
            'variants_id' => 5,
            'price' => 7,
            'stocks' => 100,
            'status' => 'AVAILABLE',
        ]);

        Product::create([
            'name' => 'Mais Ice Candy',
            'img' => 'images/products/ice_candy.jpg',
            'variants_id' => 5,
            'price' => 7,
            'stocks' => 100,
            'status' => 'AVAILABLE',
        ]);

        Product::create([
            'name' => 'Buko Pandan Ice Candy',
            'img' => 'images/products/pandan_ice_candy.jpg',
            'variants_id' => 5,
            'price' => 7,
            'stocks' => 100,
            'status' => 'AVAILABLE',
        ]);

        Product::create([
            'name' => 'Plain Kesong Puti',
            'img' => 'images/products/plain_cheese.png',
            'variants_id' => 6,
            'price' => 80,
            'stocks' => 100,
            'status' => 'AVAILABLE',
        ]);

        Product::create([
            'name' => 'Kasilyo',
            'img' => 'images/products/kasilyo_cheese.png',
            'variants_id' => 6,
            'price' => 30,
            'stocks' => 100,
            'status' => 'AVAILABLE',
        ]);

        Product::create([
            'name' => 'Mozzarella Cheese',
            'img' => 'images/products/cheese.png',
            'variants_id' => 6,
            'price' => 200,
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
            'name' => 'Christian Jay Jacalne',
            'mobile_number' => '9262189072',
            'email' => 'krischang29@gmail.com',
            'order_number' => 'DR08231',
            'customer_id' => 1, // Replace with the actual online shopper ID (e.g., $onlineShopper1->id)
            'customer_type' => 'online_shopper',
            'items' => [
                [
                    'product_id' => 1,
                    'name' => 'Choco Milk',
                    'variant' => 'Milk',
                    'price' => 100,
                    'discount' => 0,
                    'quantity' => 2,
                    'total' => 200,
                    'img' => 'images/baka.png',
                ],
                [
                    'product_id' => 4,
                    'name' => 'Plain Yoghurt',
                    'variant' => 'Yoghurt',
                    'price' => 50,
                    'discount' => 0,
                    'quantity' => 3,
                    'total' => 150,
                    'img' => 'images/baka.png',
                ],
                // Add more items as needed
            ],
            'grand_total' => 350,
            'address' => 'Sta. Cecilia 2 Brgt. Julugan viii, Tanza, Cavite 4108, Philippines',
            'shipping_option' => 'Delivery',
            'payment_method' => 'Gcash',
            'reference_number' => '123456789B',
        ]);

        // Orders for Online Shopper 2
        $order2 = Order::create([
            'name' => 'Christian Jay Jacalne',
            'mobile_number' => '9262189072',
            'email' => 'krischang29@gmail.com',
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
            'address' => 'street 22221 Brgy. Alima, Baccor City, Cavite  4109, Philippines',
            'shipping_option' => 'Delivery',
            'payment_method' => 'Gcash',
            'reference_number' => '987654321A',
        ]);

        // Orders for Retailer 1
        $order3 = Order::create([
            'name' => 'Christian Jay Jacalne',
            'mobile_number' => '9262189072',
            'email' => 'krischang29@gmail.com',
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
            'address' => 'street 1111 Brgy. Cabulalan, Bacarra, Ilocos Norte  4001, Philippines',
            'shipping_option' => 'Delivery',
            'payment_method' => 'Gcash',
            'reference_number' => '987654321F',
        ]);

        // Orders for Retailer 2
        $order4 = Order::create([
            'name' => 'Christian Jay Jacalne',
            'mobile_number' => '9262189072',
            'email' => 'krischang29@gmail.com',
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
            'address' => 'street 2222 Brgy. San Antonio, Basco, Batanes 4002, Philippines',
            'shipping_option' => 'Delivery',
            'payment_method' => 'Gcash',
            'reference_number' => '123456789G',
        ]);

        $order4 = Order::create([
            'name' => 'Christian Jay Jacalne',
            'mobile_number' => '9262189072',
            'email' => 'krischang29@gmail.com',
            'order_number' => 'DR08234',
            'customer_id' => null,
            'customer_type' => 'guest',
            'items' => [
                [
                    'product_id' => 4,
                    'price' => 50,
                    'discount' => 2,
                    'quantity' => 10,
                    'total' => 480,
                ],
            ],
            'grand_total' => 480,
            'address' => 'street 2222 Brgy. San Antonio, Basco, Batanes 4002, Philippines',
            'shipping_option' => 'Delivery',
            'payment_method' => 'Gcash',
            'reference_number' => '123456789G',
        ]);
    }

    private function seedSalesData(): void
    {
        // Create sales data for 2022
        for ($i = 1; $i <= 12; $i++) {
            $currentDate = Carbon::create(2022, $i, 1);
            $lastMonthDate = $currentDate->copy()->subMonth();

            Sales::create([
                'category' => 'Products',
                'name' => 'Choco Milk', // Product name
                'price' => 100, // Product price
                'quantity' => rand(10, 100), // Product quantity sold
                'amount' => rand(1000, 2000),
                'created_at' => $currentDate,
            ]);
            Sales::create([
                'category' => 'Products',
                'name' => 'Fresh Milk', // Product name
                'price' => 100, // Product price
                'quantity' => rand(10, 100), // Product quantity sold
                'amount' => rand(1000, 2000),
                'created_at' => $currentDate,
            ]);

            Sales::create([
                'category' => 'Products',
                'name' => 'Plain Yoghurt', // Product name
                'price' => 50, // Product price
                'quantity' => rand(10, 100), // Product quantity sold
                'amount' => rand(1000, 2000),
                'created_at' => $currentDate,
            ]);

            Sales::create([
                'category' => 'Buffalo',
                'name' => 'Buffalo', // Product name
                'price' => rand(1000, 5000), // Product price
                'quantity' => rand(10, 100), // Product quantity sold
                'amount' => rand(1000, 2000),
                'created_at' => $currentDate,
            ]);
        }

        // Create sales data for 2023
        for ($i = 1; $i <= 12; $i++) {
            $currentDate = Carbon::create(2023, $i, 1);
            $lastMonthDate = $currentDate->copy()->subMonth();

            Sales::create([
                'category' => 'Products',
                'name' => 'Choco Milk', // Product name
                'price' => 100, // Product price
                'quantity' => rand(10, 100), // Product quantity sold
                'amount' => rand(1000, 2000),
                'created_at' => $currentDate,
            ]);
            Sales::create([
                'category' => 'Products',
                'name' => 'Fresh Milk', // Product name
                'price' => 100, // Product price
                'quantity' => rand(10, 100), // Product quantity sold
                'amount' => rand(1000, 2000),
                'created_at' => $currentDate,
            ]);

            Sales::create([
                'category' => 'Products',
                'name' => 'Plain Yoghurt', // Product name
                'price' => 50, // Product price
                'quantity' => rand(10, 100), // Product quantity sold
                'amount' => rand(1000, 2000),
                'created_at' => $currentDate,
            ]);

            Sales::create([
                'category' => 'Buffalo',
                'name' => 'Buffalo', // Product name
                'price' => rand(1000, 5000), // Product price
                'quantity' => rand(10, 100), // Product quantity sold
                'amount' => rand(1000, 2000),
                'created_at' => $currentDate,
            ]);
        }

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
    }

    private function seedBuffalo()
    {

        Buffalo::create([
            'gender' => 'male',
            'age' => 'baby',
            'quantity' => 100,
        ]);
        Buffalo::create([
            'gender' => 'male',
            'age' => 'adult',
            'quantity' => 100,
        ]);
        Buffalo::create([
            'gender' => 'female',
            'age' => 'baby',
            'quantity' => 100,
        ]);
        Buffalo::create([
            'gender' => 'female',
            'age' => 'adult',
            'quantity' => 100,
        ]);
    }
}
