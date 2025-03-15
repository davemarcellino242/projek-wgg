<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContentController;

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
//     return view('index');
// });

Route::get('/', [ContentController::class, 'index'])->name('content.index');
Route::post('/content/store', [ContentController::class, 'store'])->name('content.store');
Route::delete('/content/{id}', [ContentController::class, 'destroy'])->name('content.destroy');
Route::put('/content/{id}', [ContentController::class, 'update'])->name('content.update');
