<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('complaint_status_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('complaint_id')->constrained()->onDelete('cascade');
            $table->string('complaint_number')->nullable();
            $table->enum('old_status', [
                'draft', 'pending', 'under_review', 'in_progress', 
                'resolved', 'rejected', 'appealed', 'closed'
            ])->nullable();
            $table->enum('new_status', [
                'draft', 'pending', 'under_review', 'in_progress', 
                'resolved', 'rejected', 'appealed', 'closed'
            ]);
            $table->text('remarks')->nullable();
            $table->text('internal_notes')->nullable();
            $table->foreignId('changed_by')->constrained('users');
            $table->string('changed_by_name')->nullable();
            $table->string('changed_by_role')->nullable(); // admin, officer, complainant
            $table->timestamp('changed_at')->useCurrent();
            $table->integer('time_taken_hours')->nullable(); // Time spent in previous status
            $table->timestamps();
            
            // Indexes for better performance
            $table->index('complaint_id');
            $table->index('new_status');
            $table->index('changed_at');
            $table->index('changed_by');
            $table->index(['complaint_id', 'changed_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('complaint_status_history');
    }
};