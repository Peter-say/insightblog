<?php

namespace App\Providers;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\NavigationLink;
use App\Models\User;
use App\Policies\BlogCommentPolicy;
use App\Policies\BlogPostPolicy;
use App\Policies\CommentPolicy;
use App\Policies\UserPolicy;
use Egulias\EmailValidator\Parser\Comment;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    protected $policies = [
        BlogPost::class => BlogPostPolicy::class,
        Comment::class => BlogCommentPolicy::class,
        User::class => UserPolicy::class,
    ];
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        $this->policies;

        Gate::define('manage-users', function (User $user) {
            return $user->isAdmin() || $user->isModerator();
        });
        Gate::define('manage-blogs', function (User $user) {
            return $user->isAdmin() || $user->isModerator() || $user->isAuthor();
        });
        Gate::define('manage-comments', function (User $user) {
            return $user->isAdmin() || $user->isModerator() || $user->isAuthor();
        });

        Gate::define('manage-settings', function (User $user) {
            return $user->isAdmin() || $user->isModerator() || $user->isAuthor();
        });


        // Check if the navigation_links table exists before fetching data
        if (Schema::hasTable('navigation_links')) {
            // Fetch navigation links from the database
            $navs = NavigationLink::where('parent_id', null)->get();
        } else {
            // Set $navs to an empty collection or array if the table does not exist
            $navs = collect(); // or use $navs = [];
        }

        // Fetch categories from the database
        $categories = BlogCategory::all();

        // Share $categories and $navs with all views
        View::share(['categories' => $categories, 'navs' => $navs]);
    }
}
