<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\BankAccount;

use App\Models\BankAccount;
use Illuminate\Http\Request;
use InvalidArgumentException;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\Api\BankAccountRepositoryInterface;

/**
 * Handles Bank account creation
 */
class Create extends Controller
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
     * Creates bank account
     *
     * @param Request $request
     * @return BankAccount|JsonResponse
     */
    public function createAccount(Request $request)
    {
        try {
            return $this->bankAccountRepository->create(
                (int)$request->user()->id,
                (float)$request->balance
            );
        } catch (InvalidArgumentException $exception) {
            return response()
                ->json([
                    'data' => [
                        'success' => false,
                        'message' => $exception->getMessage()
                    ]
                ])
                ->setStatusCode(400);
        }
    }
}
