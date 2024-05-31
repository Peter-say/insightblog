<?php

use App\Http\Controllers\Dashboard\BlogPostController;
use App\Http\Controllers\Dashboard\HomeController;
use App\Http\Controllers\Dashboard\UsersController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::prefix('dashboard')->as('dashboard.')->middleware(['auth', 'verified'])->group(function () {
    Route::get('home', [HomeController::class, 'home'])->name('home');
    Route::resource('blog', BlogPostController::class);

    Route::post('blog/upload-image', [BlogPostController::class, 'uploadImage'])->name('blog.upload-image');
    Route::get('search/blogs', [BlogPostController::class, 'searchBlogs'])->name('search.blogs');
    Route::put('/blog/{id}/update-featured', [BlogPostController::class, 'updateFeatured'])->name('blog.featured');

    Route::get('users', [UsersController::class, 'index'])->name('users');
    Route::delete('user/destroy/{id}', [UsersController::class, 'destroy'])->name('user.destroy');
    Route::patch('user/{user}/role', [UsersController::class, 'updateRole'])->name('user.role');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
