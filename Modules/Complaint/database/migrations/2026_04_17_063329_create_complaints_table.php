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
            $table->string('tracking_number')->unique()->nullable();
            $table->foreignId('citizen_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('complainant_id')->constrained()->onDelete('cascade');
            $table->string('complaint_number')->unique();
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            $table->foreignId('department_id')->constrained()->onDelete('cascade');
            $table->string('current_level')->default('spo');
            $table->string('category');
            $table->text('address_location');
            $table->string('title');
            $table->text('description');
            $table->enum('status', ['draft', 'submitted', 'pending', 'under_review', 'in_progress', 'resolved', 'rejected', 'appealed', 'closed'])->default('submitted');
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
            $table->index('tracking_number');
            $table->index('citizen_id');
            $table->index('complaint_number');
            $table->index('status');
            $table->index('department_id');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};