<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\FamiliesController;



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



Route::get('/', [FamiliesController::class, 'index'])->name('families');
Route::get('/families', [FamiliesController::class, 'index'])->name('get-families');

Route::post('store-family', [FamiliesController::class, 'store']);
Route::post('edit-family', [FamiliesController::class, 'edit']);
Route::post('delete-family', [FamiliesController::class, 'destroy']);
