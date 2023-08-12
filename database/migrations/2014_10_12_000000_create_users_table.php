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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');

            $table->string('email')->unique();  
            $table->string('mobile_number');
            $table->string('password');
      
            $table->integer('email_code_count')->default(0)->nullable();
            $table->timestamp('email_code_cooldown')->nullable();
            $table->string('email_verify_token')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();

            $table->boolean('reset_password')->default(0)->nullable();
            $table->integer('reset_password_count')->default(0)->nullable();
            $table->string('reset_password_token')->nullable();
            $table->timestamp('reset_password_cooldown')->nullable();
            
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
