<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('complaints', function (Blueprint $table) {
            if (!Schema::hasColumn('complaints', 'tracking_number')) {
                $table->string('tracking_number')->nullable()->after('id');
                $table->index('tracking_number');
            }

            if (!Schema::hasColumn('complaints', 'citizen_id')) {
                $table->foreignId('citizen_id')->nullable()->after('tracking_number')->constrained('users')->nullOnDelete();
            }

            if (!Schema::hasColumn('complaints', 'current_level')) {
                $table->string('current_level')->nullable()->after('department_id');
            }

            if (!Schema::hasColumn('complaints', 'current_stage')) {
                $table->string('current_stage')->nullable()->after('current_level');
            }

            if (!Schema::hasColumn('complaints', 'decision_notes')) {
                $table->text('decision_notes')->nullable()->after('description');
            }

            if (!Schema::hasColumn('complaints', 'penalty_amount')) {
                $table->decimal('penalty_amount', 12, 2)->nullable()->default(0)->after('decision_notes');
            }

            if (!Schema::hasColumn('complaints', 'assigned_to')) {
                $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            }

            if (!Schema::hasColumn('complaints', 'priority')) {
                $table->string('priority')->nullable()->default('medium');
            }
        });
    }

    public function down(): void
    {
        Schema::table('complaints', function (Blueprint $table) {
            foreach (['current_stage', 'decision_notes', 'penalty_amount'] as $column) {
                if (Schema::hasColumn('complaints', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
