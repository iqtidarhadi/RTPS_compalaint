<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Drop existing tables if they exist (clean slate)
        Schema::dropIfExists('connections');
        Schema::dropIfExists('nodes');
        Schema::dropIfExists('flows');
        
        // Flows table
        Schema::create('flows', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('color_theme')->default('default');
            $table->timestamps();
        });

        // Nodes table - using consistent column names
        Schema::create('nodes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('flow_id')->constrained()->onDelete('cascade');
            $table->string('node_id')->unique();  // Changed from node_uuid to node_id
            $table->string('node_type');
            $table->string('label');
            $table->decimal('position_x', 10, 2);
            $table->decimal('position_y', 10, 2);
            $table->integer('width')->default(180);
            $table->integer('height')->default(78);
            $table->json('metadata')->nullable();
            $table->timestamps();
            
            $table->index('flow_id');
            $table->index('node_id');
        });

        // Connections table
        Schema::create('connections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('flow_id')->constrained()->onDelete('cascade');
            $table->string('connection_id')->unique();  // Changed from connection_uuid
            $table->string('from_node_id');  // References node_id, not id
            $table->string('to_node_id');    // References node_id, not id
            $table->string('label')->nullable();
            $table->string('connection_type')->default('default');
            $table->json('style')->nullable();
            $table->timestamps();
            
            $table->index('flow_id');
            $table->index(['from_node_id', 'to_node_id']);
            $table->foreign('from_node_id')->references('node_id')->on('nodes')->onDelete('cascade');
            $table->foreign('to_node_id')->references('node_id')->on('nodes')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('connections');
        Schema::dropIfExists('nodes');
        Schema::dropIfExists('flows');
    }
};
