<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\BankAccount;

use App\Models\BankAccount;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\Api\BankAccountRepositoryInterface;

/**
 * Execute deposit request
 */
class Deposit extends Controller
{
    private BankAccountRepositoryInterface $bankAccountRepository;

    /**
     * @param BankAccountRepositoryInterface $bankAccountRepository
     */
    public function __construct(
        BankAccountRepositoryInterface $bankAccountRepository
    ) {
        $this->bankAccountRepository = $bankAccountRepository;
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
            return $this->bankAccountRepository->deposit(
                $request->bankAccount,
                $request->user()->id,
                (float) $request->balance
            );
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
