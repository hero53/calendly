<?php

use App\Http\Controllers\DateController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [DateController::class, 'index'])->name('date.index.get');
Route::get('/get_date', [DateController::class, 'getDate'])->name('date.all.get');
Route::post('/get_chrono', [DateController::class, 'getChrono'])->name('date.chrono.all.get');
