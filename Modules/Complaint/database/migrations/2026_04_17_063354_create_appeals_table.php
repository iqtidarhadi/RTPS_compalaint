<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appeals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('complaint_id')->constrained()->onDelete('cascade');
            $table->unsignedTinyInteger('appeal_level')->default(1);
            $table->foreignId('appeal_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('remarks')->nullable();
            $table->foreignId('complainant_id')->constrained()->onDelete('cascade');
            $table->string('appeal_number')->unique();
            $table->date('first_appeal_date');
            $table->text('appeal_description');
            $table->enum('status', ['pending', 'under_review', 'approved', 'rejected'])->default('pending');
            $table->text('review_remarks')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users');
            $table->timestamps();
            
            // Indexes
            $table->index('appeal_level');
            $table->index('appeal_by');
            $table->index('appeal_number');
            $table->index('status');
            $table->index('first_appeal_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appeals');
    }
};