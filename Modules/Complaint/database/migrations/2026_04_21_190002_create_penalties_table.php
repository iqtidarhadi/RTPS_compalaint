<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penalties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('complaint_id')->constrained()->cascadeOnDelete();
            $table->foreignId('officer_id')->nullable()->constrained('users')->nullOnDelete();
            $table->decimal('amount', 12, 2);
            $table->text('reason');
            $table->string('status')->default('pending');
            $table->timestamps();

            $table->index('complaint_id');
            $table->index('officer_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penalties');
    }
};
