<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\BankAccount;

use App\Models\BankAccount;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\UnauthorizedException;
use App\Models\BankAccount\BankAccountRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Retrieves bank account for current customer
 */
class Get extends Controller
{
    private BankAccountRepository $bankAccountRepository;

    /**
     * @param BankAccountRepository $bankAccountRepository
     */
    public function __construct(
        BankAccountRepository $bankAccountRepository
    ) {
        $this->bankAccountRepository = $bankAccountRepository;
    }

    /**
     * Retrieves customer bank account
     *
     * @param Request $request
     * @return BankAccount|JsonResponse|object
     */
    public function getAccount(Request $request)
    {
        try {
            return $this->bankAccountRepository->get((int)$request->user()->id, $request->accountNumber);
        } catch (UnauthorizedException $exception) {
            return response()
                ->json([
                    'data' => [
                        'error' => $exception->getMessage()
                    ]
                ])
                ->setStatusCode(403);
        } catch (ModelNotFoundException $exception) {
            return response()
                ->json([
                    'data' => [
                        'error' => "Bank account not found"
                    ]
                ])
                ->setStatusCode(400);
        }
    }

    public function getAccountList(Request $request): Collection
    {
        return $request->user()->accounts;
    }
}
