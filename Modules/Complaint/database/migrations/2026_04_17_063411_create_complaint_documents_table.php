<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('complaint_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('complaint_id')->nullable()->constrained('complaints')->cascadeOnDelete();
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->morphs('documentable'); // Can belong to complaint, appeal, or complainant
            $table->string('document_type'); // screenshot, cnic_front, cnic_back, copy_of_appeal, supporting_docs
            $table->string('file_name');
            $table->string('file_path');
            $table->string('file_size')->nullable();
            $table->string('mime_type')->nullable();
            $table->timestamps();
            
            $table->index('complaint_id');
            $table->index('uploaded_by');
            $table->index('document_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('complaint_documents');
    }
};