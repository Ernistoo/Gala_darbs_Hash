<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProviderAuth;
use App\Models\Post;
use App\Models\User;
use App\Models\Challenge;
use App\Policies\PostPolicy;
use App\Policies\UserPolicy;
use App\Policies\ChallengePolicy;

class AppServiceProvider extends ServiceProvider
{
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
        \Gate::policy(Post::class, PostPolicy::class);
        \Gate::policy(User::class, UserPolicy::class);
        \Gate::policy(Challenge::class, ChallengePolicy::class);
    }
}
