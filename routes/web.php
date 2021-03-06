<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::middleware(['auth:sanctum', 'verified',])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');




Route::get('/', [PostController::class, 'index'])->name('home');
Route::resource('posts', PostController::class)->only(['index', 'show']);

Route::get('posts/tag/{tagSlug}', [PostController::class, 'index'])->where('tagSlug', '[a-z]+')->name('posts.index.tag');
