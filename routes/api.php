<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::prefix('master')->group(function() {
    Route::apiResource('product', 'Api\v1\ProductController');
});

Route::prefix('transaction')->group(function() {
    Route::apiResource('cart', 'Api\v1\transaction\CartController');
});
