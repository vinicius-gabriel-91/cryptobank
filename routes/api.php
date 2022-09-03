<?php

use App\Http\Controllers\Api\Customer\Delete;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Customer\Create;
use App\Http\Controllers\Api\Customer\Auth\Authenticate;


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
Route::post('register', [Create::class, 'registerCustomer']);
Route::delete('delete', [Delete::class, 'deleteCustomer'])->middleware('auth:sanctum');
Route::post('login', [Authenticate::class, 'login']);
Route::get('logout', [Authenticate::class, 'logout'])->middleware('auth:sanctum');
