<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FamilyController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/family', [FamilyController::class, 'index']);
Route::get('/family/children', [FamilyController::class, 'children']);
Route::get('/family/grandchildren', [FamilyController::class, 'grandchildren']);
Route::post('/family', [FamilyController::class, 'store']);
Route::post('/family/{id}', [FamilyController::class, 'update']);
Route::delete('/family/{id}', [FamilyController::class, 'destroy']);
