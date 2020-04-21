<?php

namespace App\Providers;

use Github\Client;
use App\Services\GitHub\PhpGithubApi;
use Illuminate\Support\ServiceProvider;
use App\Services\GitHub\Contracts\GithubApi;

class GithubServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(GithubApi::class, function ($app) {
            return new PhpGithubApi($app->make(Client::class));
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
