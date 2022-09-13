<?php

use App\Http\Controllers\Api\Customer\Edit;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Customer\Get;
use App\Http\Controllers\Api\Customer\Delete;
use App\Http\Controllers\Api\Customer\Create;
use App\Http\Controllers\Api\Customer\Auth\Authenticate;

Route::post('login', [Authenticate::class, 'login'])->prefix('customer');
Route::post('create', [Create::class, 'createCustomer'])->prefix('customer');
Route::get('user', [Get::class, 'getCustomer'])->middleware('auth:sanctum')->prefix('customer');
Route::put('edit', [Edit::class, 'editCustomer'])->middleware('auth:sanctum')->prefix('customer');
Route::get('logout', [Authenticate::class, 'logout'])->middleware('auth:sanctum')->prefix('customer');
Route::delete('delete', [Delete::class, 'deleteCustomer'])->middleware('auth:sanctum')->prefix('customer');
