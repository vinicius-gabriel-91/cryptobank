<?php

use App\Http\Controllers\Api\BankAccount\Transfer;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Customer\Get;
use App\Http\Controllers\Api\Customer\Edit;
use App\Http\Controllers\Api\Customer\Delete;
use App\Http\Controllers\Api\Customer\Create;
use App\Http\Controllers\Api\BankAccount\Deposit;
use App\Http\Controllers\Api\BankAccount\Withdraw;
use App\Http\Controllers\Api\Customer\Auth\Authenticate;
use App\Http\Controllers\Api\BankAccount\Get as GetBankAccount;
use App\Http\Controllers\Api\BankAccount\Create as CreateAccount;
use App\Http\Controllers\Api\TansactionLog\Get as GetTransactions;

Route::post('/customer/login', [Authenticate::class, 'login']);
Route::post('/customer/create', [Create::class, 'createCustomer']);
Route::get('/customer/user', [Get::class, 'getCustomer'])->middleware('auth:sanctum');
Route::put('/customer/edit', [Edit::class, 'editCustomer'])->middleware('auth:sanctum');
Route::post('/account/deposit', [Deposit::class, 'deposit'])->middleware('auth:sanctum');
Route::post('/account/transfer', [Transfer::class, 'transfer'])->middleware('auth:sanctum');
Route::post('/account/withdraw', [Withdraw::class, 'withdraw'])->middleware('auth:sanctum');
Route::get('/customer/logout', [Authenticate::class, 'logout'])->middleware('auth:sanctum');
Route::delete('/customer/delete', [Delete::class, 'deleteCustomer'])->middleware('auth:sanctum');
Route::post('/account/create', [CreateAccount::class, 'createAccount'])->middleware('auth:sanctum');
Route::get('/account/accountList', [GetBankAccount::class, 'getAccountList'])->middleware('auth:sanctum');
Route::get('/account/account/{accountNumber}', [GetBankAccount::class, 'getAccount'])->middleware('auth:sanctum');
Route::get('/account/transactions/{accountNumber}', [GetTransactions::class, 'getTransactions'])->middleware('auth:sanctum');
