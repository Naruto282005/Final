<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // User who voted
            $table->morphs('voteable'); // Can vote on posts or comments
            $table->tinyInteger('vote'); // 1 for upvote, -1 for downvote
            $table->timestamps();
            
            // Ensure user can only vote once per item
            $table->unique(['user_id', 'voteable_id', 'voteable_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('votes');
    }
};