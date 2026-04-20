<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('complainants', function (Blueprint $table) {
            $table->id();
            $table->string('cnic_number')->unique();
            $table->string('name');
            $table->enum('gender', ['male', 'female', 'other']);
            $table->string('contact_number');
            $table->enum('id_type', ['cnic', 'snic', 'passport']);
            $table->string('email')->unique();
            $table->string('province');
            $table->string('district');
            $table->text('postal_address');
            $table->string('cnic_front_path')->nullable();
            $table->string('cnic_back_path')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
            
            // Indexes
            $table->index('cnic_number');
            $table->index('email');
            $table->index('contact_number');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('complainants');
    }
};