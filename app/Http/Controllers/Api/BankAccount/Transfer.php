<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\BankAccount;

use App\Models\BankAccount;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\Api\BankAccountRepositoryInterface;
use App\Models\Api\TransactionLogRepositoryInterface;

class Transfer extends Controller
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
    public function transfer(Request $request)
    {
        $request->validate([
            'balance' => ['required', 'numeric', 'gt:0.00'],
            'originAccount' => ['required', 'string'],
            'destinationAccount' => ['required', 'string']
        ]);
        try {
            $transfer = $this->bankAccountRepository->transfer(
                $request->originAccount,
                $request->destinationAccount,
                $request->user()->id,
                (float) $request->balance
            );
            $this->transactionLogRepository->create(
                (int) $transfer->id,
                $request->originAccount,
                TransactionLogRepositoryInterface::TRANSFER_CODE,
                (string) $request->balance,
                $request->destinationAccount,
            );
            return $transfer;
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
