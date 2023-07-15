<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\educationController;
use App\Http\Controllers\experienceController;
use App\Http\Controllers\pageController;
use App\Http\Controllers\profileController;
use App\Http\Controllers\settingController;
use App\Http\Controllers\skillController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::redirect('home', 'dashboard');

Route::get('/auth', [authController::class, "index"])->name('login');
Route::get('/auth/redirect', [authController::class, "redirect"])->middleware('guest');
Route::get('/auth/callback', [authController::class, "callback"])->middleware('guest');
Route::get('/auth/logout', [authController::class, "logout"]);

Route::prefix('dashboard')->middleware('auth')->group(
    function () {
        Route::get('/', [pageController::class, 'index']);
        Route::resource('pages', pageController::class);
        Route::resource('experiences', experienceController::class);
        Route::resource('educations', educationController::class);
        Route::get('skills', [skillController::class, 'index'])->name('skills.index');
        Route::post('skills', [skillController::class, 'update'])->name('skills.update');
        Route::get('profile', [profileController::class, 'index'])->name('profile.index');
        Route::post('profile', [profileController::class, 'update'])->name('profile.update');
        Route::get('setting', [settingController::class, 'index'])->name('setting.index');
        Route::post('setting', [settingController::class, 'update'])->name('setting.update');
    }
);
