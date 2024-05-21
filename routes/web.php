<?php

use App\Http\Controllers\CrudController;
use App\Http\Controllers\TestController;
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
    // return view('welcome');
    return redirect('/test');
});

Route::get('/test', [TestController::class, 'index'])->name('test');
Route::resource('/crud', CrudController::class);
Route::post('/anagram-check', [TestController::class, 'anagramCheck'])->name('anagram.check');
Route::post('/frequency-check', [TestController::class, 'frequencyLetter'])->name('frequency.check');
Route::post('/matrix-generator', [TestController::class,'matrixGenerator'])->name('matrix.generator');