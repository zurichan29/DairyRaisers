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
        Schema::create('buffalo', function (Blueprint $table) {
            $table->id();
            $table->string('gender');
            $table->integer('age')->nullable();
            $table->integer('quantity_sold');
            $table->timestamp('date_sold')->nullable();
            $table->string('buyers_name');
            $table->string('buyers_address');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buffalo');
    }
};
