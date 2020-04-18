<?php

Route::post('register', \App\Http\Controllers\Auth\RegistrationController::class);
Route::post('login', App\Http\Controllers\Auth\LoginController::class);
