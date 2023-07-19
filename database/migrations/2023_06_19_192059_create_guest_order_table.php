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
        Schema::create('guest_order', function (Blueprint $table) {
            $table->id();
            $table->integer('guest_user_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('mobile_number')->unique();
            $table->string('order_number');
            $table->integer('grand_total');
            $table->string('guest_address');
            $table->string('remarks');
            $table->string('payment_method');
            $table->string('reference_number');
            $table->string('payment_reciept');
            $table->string('status')->default('Pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guest_order');
    }
};
