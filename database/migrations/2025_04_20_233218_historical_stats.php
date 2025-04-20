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
        Schema::create('historical_stats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('location_id')->constrained()->onDelete('cascade');
            $table->tinyInteger('month');
            $table->float('avg_temp');
            $table->float('max_temp');
            $table->float('min_temp');
            $table->timestamps();
        
            $table->unique(['location_id', 'month']); // Only one row per month per location
            $table->index('month'); // Fast access by month
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historical_stats');
    }
};
