<?php

declare(strict_types=1);

namespace App\Models\Api;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Provides customer entity functionalities
 */
interface CustomerRepositoryInterface
{
    public const CREATE_CUSTOMER_REQUIRED_FIELDS = [
        'name',
        'last_name',
        'taxvat',
        'address',
        'birth_date',
        'email',
        'password'
    ];

    public const EDIT_CUSTOMER_REQUIRED_FIELDS = [
        'name',
        'last_name',
        'address',
        'email'
    ];

    /**
     * Retrieves customer by id
     *
     * @throws ModelNotFoundException
     * @param int $customerId
     * @return User
     */
    public function get(int $customerId): User;

    /**
     * Exclude customer by id
     *
     * @throws ModelNotFoundException
     * @param int $customerId
     * @return bool
     */
    public function delete(int $customerId): bool;

    /**
     * Creates new user
     *
     * @param array $customerData
     * @return User
     */
    public function create(array $customerData): User;

    /**
     * Updates existing user
     *
     * @param int $customerId
     * @param array $customerData
     * @return User
     */
    public function edit(int $customerId, array $customerData): User;
}
