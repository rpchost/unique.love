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
        Schema::create('matches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('potential_match_id')->constrained('users')->onDelete('cascade');
            $table->tinyInteger('compatibility_score');
            $table->boolean('user_liked')->default(false);
            $table->boolean('match_liked')->default(false);
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();

            // Ensure unique pairs
            $table->unique(['user_id', 'potential_match_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matches');
    }
};
