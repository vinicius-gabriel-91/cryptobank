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
     * Retrieves customer bank account list
     *
     * @param int $customerId
     * @return mixed
     */
    public function getList(int $customerId);

    /**
     * Updates bank account balance
     *
     * @param string $accountNumber
     * @param float $newBalance
     * @return BankAccount
     */
    public function updateBalance(string $accountNumber, float $newBalance): BankAccount;
}
