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
}
