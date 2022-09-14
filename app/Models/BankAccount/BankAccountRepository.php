<?php

declare(strict_types=1);

namespace App\Models\BankAccount;

use App\Models\BankAccount;
use InvalidArgumentException;
use Facade\FlareClient\Time\Time;
use Illuminate\Validation\UnauthorizedException;
use App\Models\Api\BankAccountRepositoryInterface;
use App\Models\Services\Validations\ArgumentsValidator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BankAccountRepository implements BankAccountRepositoryInterface
{
    private BankAccount $account;
    private ArgumentsValidator $argumentsValidator;
    private Time $time;

    public function __construct(
        BankAccount $account,
        ArgumentsValidator $argumentsValidator,
        Time $time
    ) {
        $this->account = $account;
        $this->argumentsValidator = $argumentsValidator;
        $this->time = $time;
    }

    /**
     * Retrieves bank account by account number
     *
     * @param int $customerId
     * @param string $accountNumber
     * @throws UnauthorizedException
     * @throws ModelNotFoundException
     * @return BankAccount
     */
    public function get(int $customerId, string $accountNumber): BankAccount
    {
        $account = $this->account->where('account_number', $accountNumber)->firstOrFail();
        if ((int) $account->user_id != $customerId) {
            throw new UnauthorizedException();
        }
        return $account;
    }

    /**
     * Exclude bank account by account number
     *
     * @param string $accountNumber
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function delete(string $accountNumber): bool
    {
        // TODO: Implement delete() method.
        return true;
    }

    /**
     * Creates new bank account
     *
     * @param int $customerId
     * @param float $balance
     * @throws InvalidArgumentException
     * @return BankAccount
     */
    public function create(int $customerId, float $balance): BankAccount
    {
        if ($balance < 100) {
            throw new InvalidArgumentException(
                "The first deposit has to be at least 100.00"
            );
        }

        return BankAccount::create([
            'user_id' => $customerId,
            'account_number' => $this->time->getCurrentTime(),
            'balance' => $balance
        ]);
    }

    /**
     * Retrieves customer bank account list
     *
     * @param int $customerId
     * @return mixed
     */
    public function getList(int $customerId)
    {
        return;
    }

    /**
     * Updates bank account balance
     *
     * @param string $accountNumber
     * @param float $newBalance
     * @return BankAccount
     */
    public function updateBalance(string $accountNumber, float $newBalance): BankAccount
    {
        return new BankAccount();
    }
}
