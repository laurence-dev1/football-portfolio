<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Bookmark\BookmarkMatch;
use App\Policies\Bookmark\BookmarkMatchPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        BookmarkMatch::class => BookmarkMatchPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
