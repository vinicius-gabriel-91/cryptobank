<?php

declare(strict_types=1);

namespace App\Models\BankAccount;

use App\Models\BankAccount;
use InvalidArgumentException;
use Facade\FlareClient\Time\Time;
use Illuminate\Validation\UnauthorizedException;
use App\Models\Api\BankAccountRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BankAccountRepository implements BankAccountRepositoryInterface
{
    private BankAccount $account;
    private Time $time;

    /**
     * @param BankAccount $account
     * @param Time $time
     */
    public function __construct(
        BankAccount $account,
        Time $time
    ) {
        $this->account = $account;
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
            throw new UnauthorizedException(
                "The account number does not match any bank account for current customer"
            );
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
     * Execute withdraw procedure
     *
     * @param string $accountNumber
     * @param int $customerId
     * @param float $value
     * @return BankAccount
     */
    public function withdraw(string $accountNumber, int $customerId, float $value): BankAccount
    {
        $account = $this->get($customerId, $accountNumber);
        if ((float) $account->balance < $value) {
            throw new InvalidArgumentException("Unavailable account balance");
        }
        (float) $account->balance -= $value;
        $account->save();

        return $account;
    }

    /**
     * Execute deposit procedure
     *
     * @param string $accountNumber
     * @param int $customerId
     * @param float $value
     * @return BankAccount
     */
    public function deposit(string $accountNumber, int $customerId, float $value): BankAccount
    {
        $account = $this->get($customerId, $accountNumber);
        if ($value <= 0.00) {
            throw new InvalidArgumentException("Value has to be greater than 0.00");
        }
        (float) $account->balance += $value;
        $account->save();

        return $account;
    }

    /**
     * Execute transfer procedure
     *
     * @param string $originAccount
     * @param string $destinationAccount
     * @param int $customerId
     * @param float $balance
     * @return BankAccount
     */
    public function transfer(
        string $originAccount,
        string $destinationAccount,
        int $customerId,
        float $balance
    ): BankAccount {
        $originAccountObject = $this->withdraw($originAccount, $customerId, $balance);
        $destinationAccountObject = $this->account->where('account_number', $destinationAccount)->firstOrFail();
        $this->deposit($destinationAccount, (int) $destinationAccountObject->user_id, $balance);
        return $originAccountObject;
    }
}
