<?php

use App\Livewire\PostList;
use App\Livewire\CreatePost;
use App\Livewire\PostDetail;
use App\Livewire\EditPost; // ✅ ADD THIS
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Home page - shows all posts
Route::get('/', PostList::class)->name('home');

// Authentication routes (provided by Laravel Breeze)
require __DIR__.'/auth.php';

// Protected routes - require authentication
Route::middleware(['auth'])->group(function () {
    // Create new post
    Route::get('/post/create', CreatePost::class)->name('post.create');
    
    // ✅ ADD THIS: Edit post
    Route::get('/post/{id}/edit', EditPost::class)->name('post.edit');
});

// Public post detail - anyone can view
Route::get('/post/{id}', PostDetail::class)->name('post.show');