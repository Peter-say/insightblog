<?php

use App\Http\Controllers\Dashboard\BlogCommentController;
use App\Http\Controllers\Dashboard\BlogPostController;
use App\Http\Controllers\Dashboard\HomeController;
use App\Http\Controllers\Dashboard\UsersController;
use App\Http\Controllers\Dashboard\MetaDescription;
use App\Http\Controllers\Dashboard\SettingsController;
use App\Http\Controllers\Dashboard\WebsiteDescription;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Web\CommentController;
use App\Http\Controllers\Web\IndexController;
use App\Http\Controllers\Web\WelcomeController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [WelcomeController::class, 'welcome']);
Route::get('search-page', [WelcomeController::class, 'searchPage'])->name('search-page');
Route::get('search', [WelcomeController::class, 'search'])->name('search');
Route::get('/category/{name}', [IndexController::class, 'blogByCategory'])->name('category');
Route::prefix('post')->as('post.')->group(function () {
    Route::get('/{slug}/details', [IndexController::class, 'details'])->name('details');
    Route::get('/tag/{tag}', [IndexController::class, 'blogByTags'])->name('tags');
    Route::get('/author', [IndexController::class, 'author'])->name('author');

    Route::post('/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
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
    Route::get('user/create', [UsersController::class, 'create'])->name('user.create');
    Route::post('user/store', [UsersController::class, 'store'])->name('user.store');
    Route::delete('user/destroy/{id}', [UsersController::class, 'destroy'])->name('user.destroy');
    Route::patch('user/{user}/role', [UsersController::class, 'updateRole'])->name('user.role');
    Route::post('/user/send-login-details/{userId}', [UsersController::class, 'sendLoginDetails'])->name('user.send-login-details');
    Route::patch('/user/{id}/verify-email', [UsersController::class, 'verifyEmail'])->name('user.verify-email');

    // meta description
    Route::get('/website-meta-description/create', [WebsiteDescription::class, 'create'])->name('website-meta-description.create');
    Route::post('/website-meta-description', [WebsiteDescription::class, 'store'])->name('website-meta-description.store');
    Route::get('website-meta-description/{id}', [WebsiteDescription::class, 'edit'])->name('website-meta-description.edit');
    Route::put('website-meta-description/{id}', [WebsiteDescription::class, 'update'])->name('website-meta-description.update');
    Route::delete('website-meta-description/{id}', [WebsiteDescription::class, 'destroy'])->name('website-meta-description.destroy');

    Route::get('/website-title/create', [WebsiteDescription::class, 'createMetaTitle'])->name('website-title.create');
    Route::post('website-title/store', [WebsiteDescription::class, 'storeMetaTitle'])->name('website-title.store');
    Route::get('website-title/{id}/edit', [WebsiteDescription::class, 'EditMetaTitle'])->name('website-title.edit');
    Route::put('website-title/{id}/update', [WebsiteDescription::class, 'updateMetaTitle'])->name('website-title.update');

    // settings
    Route::get('/settings', [SettingsController::class, 'settings'])->name('settings');

    Route::resource('comments', BlogCommentController::class);
    Route::post('/comments/{comment}/approve', [BlogCommentController::class, 'approve'])->name('comments.approve');
    Route::post('/comments/{comment}/reject', [BlogCommentController::class, 'reject'])->name('comments.reject');
   
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
