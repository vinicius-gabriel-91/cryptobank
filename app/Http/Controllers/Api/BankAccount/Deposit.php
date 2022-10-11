<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\BankAccount;

use App\Models\BankAccount;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\Api\BankAccountRepositoryInterface;
use App\Models\Api\TransactionLogRepositoryInterface;

/**
 * Execute deposit request
 */
class Deposit extends Controller
{
    private BankAccountRepositoryInterface $bankAccountRepository;
    private TransactionLogRepositoryInterface $transactionLogRepository;

    /**
     * @param BankAccountRepositoryInterface $bankAccountRepository
     * @param TransactionLogRepositoryInterface $transactionLogRepository
     */
    public function __construct(
        BankAccountRepositoryInterface $bankAccountRepository,
        TransactionLogRepositoryInterface $transactionLogRepository
    ) {
        $this->bankAccountRepository = $bankAccountRepository;
        $this->transactionLogRepository = $transactionLogRepository;
    }

    /**
     * Process withdraw
     *
     * @param Request $request
     * @return BankAccount|JsonResponse|object
     */
    public function deposit(Request $request)
    {
        $request->validate([
            'balance' => ['required', 'numeric', 'gt:0.00'],
            'bankAccount' => ['required', 'string']
        ]);
        try {
            $deposit = $this->bankAccountRepository->deposit(
                $request->bankAccount,
                $request->user()->id,
                (float) $request->balance
            );
            $this->transactionLogRepository->create(
                (int) $deposit->id,
                $request->bankAccount,
                TransactionLogRepositoryInterface::DEPOSIT_CODE,
                (string) $request->balance,
            );
            return $deposit;
        } catch (\Exception $exception) {
            return response()
                ->json([
                    'data' => [
                        'error' => $exception->getMessage()
                    ]
                ])->setStatusCode(422);
        }
    }
}
