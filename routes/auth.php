<?php

Route::middleware('guest')->group(function () {
    Route::post('register', \App\Http\Controllers\Auth\RegistrationController::class);
    Route::post('login', App\Http\Controllers\Auth\LoginController::class);
});
