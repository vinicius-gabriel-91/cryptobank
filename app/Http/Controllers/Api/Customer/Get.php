<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Customer;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Api\CustomerRepositoryInterface;

/**
 * Customer information provider
 */
class Get extends Controller
{
    private CustomerRepositoryInterface $customerRepository;

    /**
     * Class dependencies
     *
     * @param CustomerRepositoryInterface $customerRepository
     */
    public function __construct(
        CustomerRepositoryInterface $customerRepository
    ) {
        $this->customerRepository = $customerRepository;
    }

    /**
     * Retrieves logged customer
     *
     * @param Request $request
     * @return User
     */
    public function getCustomer(Request $request): User
    {
        return $this->customerRepository->get((int) $request->user()->id);
    }
}
