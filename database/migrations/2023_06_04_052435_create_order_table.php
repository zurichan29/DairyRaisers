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
        Schema::create('order', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id'); // Cart checkout column is true
            $table->string('order_number');
            $table->integer('grand_total');
            $table->string('user_address');
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
        Schema::dropIfExists('order');
    }
};
