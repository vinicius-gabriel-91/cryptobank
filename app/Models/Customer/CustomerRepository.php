<?php

declare(strict_types=1);

namespace App\Models\Customer;

use App\Models\Api\CustomerRepositoryInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Provides customer entity functionalities
 */
class CustomerRepository implements CustomerRepositoryInterface
{
    private User $user;

    public function __construct(
        User $user
    ) {
        $this->user = $user;
    }

    /**
     * Provides customer exclusion
     *
     * @throws ModelNotFoundException
     * @param int $customerId
     * @return bool
     */
    public function delete(int $customerId): bool
    {
        return $this->get($customerId)->delete();
    }

    /**
     * Retrieves customer by id
     *
     * @throws ModelNotFoundException
     * @param int $customerId
     * @return User
     */
    public function get(int $customerId): User
    {
        $user = $this->user->find($customerId);
        if (!$user) {
            throw new ModelNotFoundException(
                __("Could not find customer with id $customerId" )
            );
        }
        return $user;
    }
}
