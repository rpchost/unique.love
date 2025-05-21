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
        Schema::create('user_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('interested_in')->nullable(); // 'male', 'female', 'all', etc.
            $table->json('age_range')->nullable(); // Store as [min, max]
            $table->integer('distance_preference')->nullable(); // in kilometers/miles
            $table->json('interests')->nullable(); // Store interest IDs or tags
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_preferences');
    }
};
