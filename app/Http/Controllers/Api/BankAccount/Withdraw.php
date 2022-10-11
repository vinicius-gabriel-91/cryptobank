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
 * Execute withdraw request
 */
class Withdraw extends Controller
{
    private BankAccountRepositoryInterface $bankAccountRepository;
    private TransactionLogRepositoryInterface $transactionLogRepository;

    /**
     * @param BankAccountRepositoryInterface $bankAccountRepository
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
    public function withdraw(Request $request)
    {
        $request->validate([
            'balance' => ['required', 'numeric', 'gt:0.00'],
            'bankAccount' => ['required', 'string']
        ]);
        try {
            $withdraw = $this->bankAccountRepository->withdraw(
                $request->bankAccount,
                $request->user()->id,
                (float) $request->balance
            );
            $this->transactionLogRepository->create(
                (int) $withdraw->id,
                $request->bankAccount,
                TransactionLogRepositoryInterface::WITHDRAW_CODE,
                (string) $request->balance,
            );
            return $withdraw;
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
