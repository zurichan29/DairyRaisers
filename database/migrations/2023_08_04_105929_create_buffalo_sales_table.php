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
        Schema::create('buffalo_sales', function (Blueprint $table) {
            $table->id();
            $table->string('buyer_name');
            $table->string('buyer_address');
            $table->json('details')->nullable();
            $table->integer('total_quantity');
            $table->decimal('grand_total', 8, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buffalo_sales');
    }
};
