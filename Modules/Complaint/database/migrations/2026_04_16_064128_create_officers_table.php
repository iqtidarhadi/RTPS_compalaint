<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('officers', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('dept_id');
            $table->string('name', 100);
            $table->string('designation', 100);
            $table->string('email', 100)->unique();
            $table->string('phone', 20)->nullable();
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->foreign('dept_id')
                ->references('id')
                ->on('departments')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('officers');
    }
};
    /**
     * Reverse the migrations.
     */

