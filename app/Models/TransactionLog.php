<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'bank_account_id',
        'account_number',
        'transaction_type',
        'value',
        'destination_account'
    ];
}
