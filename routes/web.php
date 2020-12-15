<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SalesController;
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

Route::get('/sales',[SalesController::class,'index'])->name('sales.index');
Route::post('/sales',[SalesController::class,'upload'])->name('sales.upload');
Route::get('/batch/{id}',[SalesController::class,'batch'])->name('sales.upload');
Route::get('/progress',[SalesController::class,'batchInProgress'])->name('sales.upload');