<?php

use App\Http\Controllers\Back\DashboardController;
use App\Http\Controllers\Back\PostController;
use Illuminate\Support\Facades\Route;

// Route::get('/', [DashboardController::class]);


Route::resource('posts', PostController::class)->except('show');
