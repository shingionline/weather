<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('current_readings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('location_id')->constrained()->onDelete('cascade');
            $table->timestamp('timestamp');
            $table->float('temperature');
            $table->float('humidity');
            $table->float('wind_speed');
            $table->string('conditions');
            $table->timestamps();
        
            $table->index(['location_id', 'timestamp']); // Optimized for ordering/filtering by time
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('current_readings');
    }
};
