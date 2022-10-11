<?php
declare(strict_types=1);

namespace App\Models\Api;

use App\Models\TransactionLog;

interface TransactionLogRepositoryInterface
{
    const DEPOSIT_CODE = 'deposit';
    const WITHDRAW_CODE = 'withdraw';
    const TRANSFER_CODE = 'transfer';

    /**
     * Creates log register
     *
     * @param int $bankAccountId
     * @param string $accountNumber
     * @param string $transactionType
     * @param string $value
     * @param string $destinationAccount
     * @return TransactionLog
     */
    public function create(
        int $bankAccountId,
        string $accountNumber,
        string $transactionType,
        string $value,
        string $destinationAccount
    ): TransactionLog;
}
