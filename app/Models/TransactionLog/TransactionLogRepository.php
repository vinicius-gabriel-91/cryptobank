<?php
declare(strict_types=1);

namespace App\Models\TransactionLog;

use App\Models\Api\TransactionLogRepositoryInterface;
use App\Models\TransactionLog;

class TransactionLogRepository implements TransactionLogRepositoryInterface
{
    /**
     * Creates log register
     *
     * @param int $bankAccountId
     * @param string $accountNumber
     * @param string $transactionType
     * @param string $value
     * @param string|null $destinationAccount
     * @return TransactionLog
     */
    public function create(
        int $bankAccountId,
        string $accountNumber,
        string $transactionType,
        string $value,
        string $destinationAccount = null
    ): TransactionLog {
        return TransactionLog::create([
            'bank_account_id' => $bankAccountId,
            'account_number' => $accountNumber,
            'transaction_type' => $transactionType,
            'value' => $value,
            'destination_account' => $destinationAccount
        ]);
    }
}
