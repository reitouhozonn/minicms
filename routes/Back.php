<?php

use App\Http\Controllers\Back\DashboardController;
use App\Http\Controllers\Back\PostController;
use Illuminate\Support\Facades\Route;

// Route::get('/', [DashboardController::class]);


Route::resource('posts', PostController::class);

Route::group(['middleware' => 'can:admin'], function () {
    Route::resource('users', 'Usercontroller')->except('show');
});
