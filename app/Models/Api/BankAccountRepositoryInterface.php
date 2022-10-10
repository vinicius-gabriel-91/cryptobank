<?php

declare(strict_types=1);

namespace App\Models\Api;

use App\Models\BankAccount;
use Illuminate\Database\Eloquent\ModelNotFoundException;

interface BankAccountRepositoryInterface
{
    /**
     * Retrieves bank account by account number
     *
     * @param int $customerId
     * @param string $accountNumber
     * @return BankAccount
     * @throws ModelNotFoundException
     */
    public function get(int $customerId, string $accountNumber): BankAccount;

    /**
     * Exclude bank account by account number
     *
     * @throws ModelNotFoundException
     * @param string $accountNumber
     * @return mixed
     */
    public function delete(string $accountNumber): bool;

    /**
     * Creates new bank account
     *
     * @param int $customerId
     * @param float $balance
     * @return BankAccount
     */
    public function create(int $customerId, float $balance): BankAccount;

    /**
     * Execute withdraw procedure
     *
     * @param string $accountNumber
     * @param int $customerId
     * @param float $value
     * @return BankAccount
     */
    public function withdraw(string $accountNumber, int $customerId, float $value): BankAccount;

    /**
     * Execute deposit procedure
     *
     * @param string $accountNumber
     * @param int $customerId
     * @param float $value
     * @return BankAccount
     */
    public function deposit(string $accountNumber, int $customerId, float $value): BankAccount;

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
    ): BankAccount;
}
