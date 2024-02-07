<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\SizeController;
use App\Http\Controllers\API\StockController;

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

//User
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

//Order
Route::post('/order', [OrderController::class, 'create']);
Route::get('/order', [OrderController::class, 'index']);
Route::put('/order/{id}', [OrderController::class, 'update']);
Route::delete('/order/{id}', [OrderController::class, 'destroy']);

//Category
Route::post('/category', [CategoryController::class, 'create']);
Route::get('/category', [CategoryController::class, 'index']);
Route::put('/category/{id}', [CategoryController::class, 'update']);
Route::delete('/category/{id}', [CategoryController::class, 'destroy']);

//Product
Route::post('/product', [ProductController::class, 'create']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/product/{id}', [ProductController::class, 'find']);
Route::put('/product/{id}', [ProductController::class, 'update']);
Route::delete('/product/{id}', [ProductController::class, 'destroy']);

//Size
Route::post('/size', [SizeController::class, 'create']);
Route::get('/size', [SizeController::class, 'index']);
Route::put('/size/{id}', [SizeController::class, 'update']);
Route::delete('/size/{id}', [SizeController::class, 'destroy']);

//Product_Size_Quantity
Route::post('/stock', [StockController::class, 'create']);
Route::get('/stock', [StockController::class, 'index']);
Route::put('/stock/{id}', [StockController::class, 'update']);
Route::delete('/stock/{id}', [StockController::class, 'destroy']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
