<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BoatController;

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
    Route::get('/boats', [BoatController::class, 'index'])->name('boats.index');
    Route::get('/boats/{boat}', [BoatController::class, 'show'])->name('boats.show');
    Route::get('/boats/create', [BoatController::class, 'create'])->name('boats.create');
    Route::post('/boats', [BoatController::class, 'store'])->name('boats.store');
    Route::get('/boats/{boat}/edit', [BoatController::class, 'edit'])->name('boats.edit');
    Route::put('/boats/{boat}', [BoatController::class, 'update'])->name('boats.update');
    Route::delete('/boats/{boat}', [BoatController::class, 'destroy'])->name('boats.destroy');
});