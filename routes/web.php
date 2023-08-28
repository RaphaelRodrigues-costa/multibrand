<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::post('/cars', [\App\Http\Controllers\CarController::class, 'store'])->name('cars');
    Route::get('/cars-list', [\App\Http\Controllers\CarController::class, 'index'])->name('cars-list');
    Route::get('/cars-filter/name', [\App\Http\Controllers\CarController::class, 'findByName'])->name('cars-show');
    Route::delete('/cars/{id}/delete', [\App\Http\Controllers\CarController::class, 'destroy'])->name('delete');
//    Route::get('/filter-brand', [\App\Http\Controllers\CarController::class, 'index'])->name('filter-brand');

});


require __DIR__.'/auth.php';
