<?php

declare(strict_types=1);

namespace App\Models\Customer;

use App\Models\User;
use InvalidArgumentException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Models\Api\CustomerRepositoryInterface;
use App\Models\Services\Validations\ArgumentsValidator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Provides customer entity functionalities
 */
class CustomerRepository implements CustomerRepositoryInterface
{
    private User $user;
    private ArgumentsValidator $argumentsValidator;

    /**
     * @param User $user
     * @param ArgumentsValidator $argumentsValidator
     */
    public function __construct(
        User $user,
        ArgumentsValidator $argumentsValidator
    ) {
        $this->user = $user;
        $this->argumentsValidator = $argumentsValidator;
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
                "Could not find customer with id $customerId"
            );
        }
        return $user;
    }

    /**
     * Creates new user
     *
     * @param array $customerData
     * @throws InvalidArgumentException
     * @return User
     */
    public function create(array $customerData): User
    {
        $this->argumentsValidator->validateArguments(
            self::CREATE_CUSTOMER_REQUIRED_FIELDS,
            $customerData
        );

        $user = User::create([
            'name' => $customerData['name'],
            'last_name' => $customerData['last_name'],
            'taxvat' => $customerData['taxvat'],
            'address' => $customerData['address'],
            'birth_date' => $customerData['birth_date'],
            'email' => $customerData['email'],
            'password' => Hash::make($customerData['password']),
        ]);

        event(new Registered($user));

        return $user;
    }

    /**
     * Updates existing user
     *
     * @param int $customerId
     * @param array $customerData
     * @throws InvalidArgumentException
     * @return User
     */
    public function edit(int $customerId, array $customerData): User
    {
        $this->argumentsValidator->validateArguments(
            self::EDIT_CUSTOMER_REQUIRED_FIELDS,
            $customerData
        );

        $user = $this->get($customerId);
        foreach (self::EDIT_CUSTOMER_REQUIRED_FIELDS as $property) {
            if (isset($customerData[$property]) != '') {
                $user->$property = $customerData[$property];
            }
        }
        $user->save();

        return $user;
    }
}
