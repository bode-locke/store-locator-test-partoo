<?php

use App\Http\Controllers\StoreController;
use App\Http\Controllers\StorelocController;
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

Route::get('/', [StorelocController::class, 'index'])->name('index');
Route::get('/resultats', [StorelocController::class, 'results'])->name('results');
Route::get('/store/{store}', [StoreController::class, 'show'])->name('store.show');
