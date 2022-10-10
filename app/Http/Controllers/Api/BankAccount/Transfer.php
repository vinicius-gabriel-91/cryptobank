<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\BankAccount;

use App\Models\BankAccount;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\Api\BankAccountRepositoryInterface;

class Transfer extends Controller
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
    public function transfer(Request $request)
    {
        $request->validate([
            'balance' => ['required', 'numeric', 'gt:0.00'],
            'originAccount' => ['required', 'string'],
            'destinationAccount' => ['required', 'string']
        ]);
        try {
            return $this->bankAccountRepository->transfer(
                $request->originAccount,
                $request->destinationAccount,
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
