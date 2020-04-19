<?php

use Illuminate\Support\Facades\Route;

Route::get('/', App\Http\Controllers\HomeController::class)->middleware('auth');

Route::prefix('auth')->group(base_path('routes/auth.php'));
