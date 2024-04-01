<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BoatController;
use App\Http\Controllers\Auth\AuthController;


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

Route::group(['middleware' => 'web'], function () {
    Route::redirect('/', '/boats');

    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware('auth.boats')->group(function () {
        Route::get('/boats/create', [BoatController::class, 'create'])->name('boats.create');
        Route::post('/boats', [BoatController::class, 'store'])->name('boats.store');
        Route::get('/boats/{boat}/edit', [BoatController::class, 'edit'])->name('boats.edit');
        Route::put('/boats/{boat}', [BoatController::class, 'update'])->name('boats.update');
        Route::delete('/boats/{boat}', [BoatController::class, 'destroy'])->name('boats.destroy');
    });

    Route::get('/boats/{slug}', [BoatController::class, 'show'])->where('slug', '[a-z0-9-]+')->name('boats.showId');
    Route::get('/boats/{id}', [BoatController::class, 'show'])->where('id', '[0-9]+')->name('boats.showSlug');
    Route::get('/boats', [BoatController::class, 'index'])->name('boats.index');
});