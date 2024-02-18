<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BaristaController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CafeController;
use App\Http\Controllers\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['middleware' => ['auth:api', 'role:cafe']], function () {
    Route::post('addMenu',[CafeController::class, 'addMenu']);
    Route::post('addCafe',[CafeController::class, 'addCafe']);
    Route::post('addBooksCafe',[CafeController::class, 'addBooksCafe']);
});
Route::group(['middleware' => ['auth:api', 'role:toko_buku']], function () {
    Route::post('addBooks',[BookController::class, 'addBooks']);
});

Route::group(['middleware' => ['auth:api', 'role:barista']], function () {
    Route::post('addBaristaCafe',[BaristaController::class, 'addBaristaCafe']);
    Route::put('confirmTransaction/{id_transaction}',[BaristaController::class, 'confirmTransaction']);
});

Route::get('getCafe',[CafeController::class, 'getCafe']);
Route::get('getAllBooks',[BookController::class, 'show']);

Route::post('addTransaction',[TransactionController::class, 'index']);
Route::get('getAllTransaction/{id_cafe}',[TransactionController::class, 'getAllTransaction']);
Route::get('getTransaction/{id_cafe}',[TransactionController::class, 'getTransaction']);

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout']);


