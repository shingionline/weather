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
        Schema::create('forecast_readings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('location_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->float('high');
            $table->float('low');
            $table->float('precipitation_prob');
            $table->timestamps();
        
            $table->unique(['location_id', 'date']); // Avoid duplicates
            $table->index('date'); // Global daily forecasts
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forecast_readings');
    }
};
