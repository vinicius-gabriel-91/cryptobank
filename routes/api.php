<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Customer\Get;
use App\Http\Controllers\Api\Customer\Edit;
use App\Http\Controllers\Api\Customer\Delete;
use App\Http\Controllers\Api\Customer\Create;
use App\Http\Controllers\Api\Customer\Auth\Authenticate;
use App\Http\Controllers\Api\BankAccount\Get as GetBankAccount;
use App\Http\Controllers\Api\BankAccount\Create as CreateAccount;

Route::post('/customer/login', [Authenticate::class, 'login']);
Route::post('/customer/create', [Create::class, 'createCustomer']);
Route::get('/customer/user', [Get::class, 'getCustomer'])->middleware('auth:sanctum');
Route::put('/customer/edit', [Edit::class, 'editCustomer'])->middleware('auth:sanctum');
Route::get('/customer/logout', [Authenticate::class, 'logout'])->middleware('auth:sanctum');
Route::delete('/customer/delete', [Delete::class, 'deleteCustomer'])->middleware('auth:sanctum');
Route::post('/account/create', [CreateAccount::class, 'createAccount'])->middleware('auth:sanctum');
Route::get('/account/account/{accountNumber}', [GetBankAccount::class, 'getAccount'])->middleware('auth:sanctum');
