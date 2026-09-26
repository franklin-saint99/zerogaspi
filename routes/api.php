<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\AuthController;

Route::post('/login', [
 AuthController::class,
 'login'
]);
Route::middleware('auth:sanctum')->group(function () {
 Route::get('/user', [
 AuthController::class,
 'me'
 ]);
 Route::post('/logout', [
 AuthController::class,
 'logout'
 ]);
});


Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{product}', [
 ProductController::class,
 'show'
]);
Route::get('/test', function () {
 return response()->json([
 'message' => 'API Laravel fonctionne'
 ]);
});