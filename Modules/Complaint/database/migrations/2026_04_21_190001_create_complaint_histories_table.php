<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('complaint_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('complaint_id')->constrained()->cascadeOnDelete();
            $table->foreignId('action_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('role')->nullable();
            $table->string('decision');
            $table->text('remarks')->nullable();
            $table->decimal('penalty_amount', 12, 2)->nullable()->default(0);
            $table->timestamps();

            $table->index('complaint_id');
            $table->index('action_by');
            $table->index('role');
            $table->index('decision');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('complaint_histories');
    }
};
