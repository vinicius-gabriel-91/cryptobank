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
     * @return array
     */
    public function getCustomer(Request $request): array
    {
        $customer = $this->customerRepository->get((int) $request->user()->id);
        $customerData = $customer->toArray();
        unset($customerData['address']);
        $address = json_decode($customer->address, true);
        return array_merge($customerData, $address);
    }
}
