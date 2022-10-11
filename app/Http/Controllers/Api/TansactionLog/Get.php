<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\TansactionLog;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Api\BankAccountRepositoryInterface;

class Get
{
    private BankAccountRepositoryInterface $bankAccountRepository;

    /**
     * @param BankAccountRepositoryInterface $bankAccountRepository
     */
    public function __construct(
        BankAccountRepositoryInterface $bankAccountRepository
    )
    {
        $this->bankAccountRepository = $bankAccountRepository;
    }

    /**
     * retrieve transactions
     *
     * @param Request $request
     * @return Collection
     */
    public function getTransactions(Request $request): Collection
    {
        return
            $this->bankAccountRepository->get((int) $request->user()->id, $request->accountNumber)->transactions;
    }
}
