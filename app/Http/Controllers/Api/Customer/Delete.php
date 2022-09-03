<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Api\CustomerRepositoryInterface;

/**
 * Provides customer exclusion functionality
 */
class Delete extends Controller
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
     * Process customer exclusion request
     *
     * @param Request $request
     * @return bool
     */
    public function deleteCustomer(Request $request): bool
    {
        return $this->customerRepository->delete((int) $request->user()->id);
    }
}
