<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MealController;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\UefaController;
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

Route::controller(UefaController::class)->group(function () {
    Route::get('/uefa', 'index')->name('uefa');
});

Route::controller(SiteController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::get('/logout', 'logout')->name('logout');
});

Route::resources([
    'categories' => CategoryController::class,
    'meals' => MealController::class,
]);

Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'processLogin')->name('processLogin');
});

Route::controller(SignupController::class)->group(function () {
    Route::get('/signup', 'signup')->name('signup');
    Route::post('/signup', 'processSignup')->name('processSignup');
});
