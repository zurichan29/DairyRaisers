<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            // $table->integer('user_id')->nullable();
            $table->string('order_number');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile_number')->nullable();
            $table->string('store_name')->nullable();
            $table->integer('grand_total');
            $table->string('address')->nullable();
            $table->string('remarks')->nullable();
            $table->string('comments')->nullable();
            $table->string('shipping_option');
            $table->integer('delivery_fee')->nullable();
            $table->string('payment_method');
            $table->string('reference_number')->nullable();
            $table->string('payment_receipt')->nullable();
            $table->string('status')->default('Pending');
            // Add columns for order items
            $table->json('items')->nullable();

            // Polymorphic relationship columns
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->string('customer_type'); // (GUEST, REGISTERED, OR RETAILER)
            $table->string('ip_address')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
        Schema::dropIfExists('items');
    }
};
