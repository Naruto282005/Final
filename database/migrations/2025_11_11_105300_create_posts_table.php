<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Links to user who created post
            $table->string('title'); // Post title
            $table->text('content'); // Post content/description
            $table->string('category')->default('general'); // Technology category
            $table->integer('vote_count')->default(0); // Total votes (upvotes - downvotes)
            $table->integer('comment_count')->default(0); // Number of comments
            $table->timestamps(); // created_at and updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};