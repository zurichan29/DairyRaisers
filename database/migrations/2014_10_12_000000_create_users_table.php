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
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->integer('email_code_count')->default(0)->nullable();
            $table->timestamp('email_code_cooldown')->nullable();
            $table->string('email_verify_token')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('mobile_number')->unique()->nullable();
            $table->integer('otp_count')->default(0)->nullable();
            $table->timestamp('verify_otp_cooldown')->nullable();            
            $table->integer('otp_resend_attempt')->default(0)->nullable();
            $table->timestamp('otp_resend_cooldown')->nullable();            
            $table->timestamp('otp_expires_at')->nullable();
            $table->string('mobile_verify_otp')->nullable();
            $table->timestamp('mobile_verified_at')->nullable();
            $table->string('password')->nullable();
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
