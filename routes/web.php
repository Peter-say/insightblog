<?php

use App\Http\Controllers\Dashboard\BlogPostController;
use App\Http\Controllers\Dashboard\HomeController;
use App\Http\Controllers\Dashboard\UsersController;
use App\Http\Controllers\Dashboard\MetaDescription;
use App\Http\Controllers\Dashboard\SettingsController;
use App\Http\Controllers\Dashboard\WebsiteDescription;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Web\IndexController;
use App\Http\Controllers\Web\WelcomeController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [WelcomeController::class, 'welcome']);
Route::prefix('post')->as('post.')->group(function() {
    Route::get('/details/{slug}', [IndexController::class, 'details'])->name('details');
    Route::get('/tags', [IndexController::class, 'tags'])->name('tags');
    Route::get('/author', [IndexController::class, 'author'])->name('author');
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

    // meta description
  Route::get('/website-meta-description/create', [WebsiteDescription::class, 'create'])->name('website-meta-description.create');
  Route::post('/', [WebsiteDescription::class, 'store'])->name('website-meta-description.store');
  Route::get('website-meta-description/{id}', [WebsiteDescription::class, 'edit'])->name('website-meta-description.edit');
  Route::put('website-meta-description/{id}', [WebsiteDescription::class, 'update'])->name('website-meta-description.update');
  Route::delete('website-meta-description/{id}', [WebsiteDescription::class, 'destroy'])->name('website-meta-description.destroy');

  Route::get('/', [WebsiteDescription::class, 'createMetaTitle'])->name('website-title.create');
  Route::post('website-title/store', [WebsiteDescription::class, 'storeMetaTitle'])->name('website-title.store');
  Route::get('website-title/{id}/edit', [WebsiteDescription::class, 'EditMetaTitle'])->name('website-title.edit');
  Route::put('website-title/{id}/update', [WebsiteDescription::class, 'updateMetaTitle'])->name('website-title.update');

   // settings
   Route::get('/settings', [SettingsController::class, 'settings'])->name('settings');

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
