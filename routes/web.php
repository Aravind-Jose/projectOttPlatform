<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MovieListController;
use App\Mail\SignupMail;
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

Route::get('/home',[MovieListController::class, 'movieListView'])->name('home');
Route::get('/movie/{name}',[MovieListController::class, 'movieView'])->name('movie');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');
Route::get('/login', [UserController::class, 'loginView']);
Route::post('/login', [UserController::class, 'login'])->name('login');
Route::get('/registration', [UserController::class, 'registrationView'])->name('registrationView');
Route::post('/registration', [UserController::class, 'registration'])->name('registration');
Route::get('/payment', [MovieListController::class, 'paymentView'])->name('payment');
Route::get('/sendMail',[MovieListController::class, 'subscription'])->name('sendMail');