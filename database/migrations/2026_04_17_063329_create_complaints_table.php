<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->foreignId('complainant_id')->constrained()->onDelete('cascade');
            $table->string('complaint_number')->unique();
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            $table->foreignId('department_id')->constrained()->onDelete('cascade');
            $table->string('category');
            $table->text('address_location');
            $table->string('title');
            $table->text('description');
            $table->enum('status', ['draft', 'pending', 'under_review', 'in_progress', 'resolved', 'rejected', 'appealed'])->default('pending');
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->text('admin_remarks')->nullable();
            $table->text('resolution_details')->nullable();
            
            // Tracking
            $table->foreignId('assigned_to')->nullable()->constrained('users');
            $table->timestamp('last_updated_at')->nullable();
            
            $table->timestamps();
            
            // Indexes
            $table->index('complaint_number');
            $table->index('status');
            $table->index('department');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};