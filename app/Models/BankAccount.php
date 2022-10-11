<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BankAccount extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'account_number',
        'balance'
    ];

    /**
     * Defines transactions relationship
     *
     * @return HasMany
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(TransactionLog::class);
    }
}
