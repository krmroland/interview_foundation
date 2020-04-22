<?php

use App\Http\Controllers\Auth as Auth;

Route::middleware('guest')->group(function () {
    Route::get('/', Auth\RenderAuthenticationViewController::class)->name('auth');
    Route::post('register', Auth\RegistrationController::class);
    Route::post('login', Auth\LoginController::class);
});

Route::middleware('auth')->group(function () {
    Route::put('githubToken', Auth\UpdateGithubTokenController::class);
    Route::delete('githubToken', Auth\DeleteGithubTokenController::class);
    Route::get('starredGithubRepositories', Auth\GetGithubStarredReposController::class);
});
