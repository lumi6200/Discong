<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [Controller::class, 'home'])->name('home');

Route::post('/post', [Controller::class, 'post'])->name('post');

Route::post('/signup', [Controller::class, 'signUpPost'])->name('signUpPost');

Route::post('/login', [Controller::class, 'loginPost'])->name('loginPost');

Route::post('/logout', [Controller::class, 'logout'])->name('logout');

// Profile
Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');

// Account
Route::patch('/update', [ProfileController::class, 'updatePost'])->name('updatePost');
Route::delete('/delete', [ProfileController::class, 'delete'])->name('delete');

// Posts
Route::delete('/delete-post/{post}', [ProfileController::class, 'deletePost'])->name('deletePost');
Route::patch('/update-post/{post}', [ProfileController::class,'update'])->name('update');
