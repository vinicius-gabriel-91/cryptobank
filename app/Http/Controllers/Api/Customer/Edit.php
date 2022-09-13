<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Customer;

use App\Models\User;
use Psr\Log\LoggerInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rules;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use App\Models\Api\CustomerRepositoryInterface;
use App\Models\Services\Validations\ArgumentsValidator;

class Edit extends Controller
{
    private LoggerInterface $logger;
    private Response $response;
    private CustomerRepositoryInterface $customerRepository;
    private ArgumentsValidator $argumentsValidator;

    /**
     * Class dependencies
     *
     * @param CustomerRepositoryInterface $customerRepository
     * @param Response $response
     * @param LoggerInterface $logger
     * @param ArgumentsValidator $argumentsValidator
     */
    public function __construct(
        CustomerRepositoryInterface $customerRepository,
        Response $response,
        LoggerInterface $logger,
        ArgumentsValidator $argumentsValidator
    ) {
        $this->logger = $logger;
        $this->response = $response;
        $this->customerRepository = $customerRepository;
        $this->argumentsValidator = $argumentsValidator;
    }

    /**
     * Updates current customer information
     *
     * @param Request $request
     * @return \App\Models\User|Response
     */
    public function editCustomer(Request $request)
    {
        try {
            $this->argumentsValidator->validateArguments(
            CustomerRepositoryInterface::EDIT_CUSTOMER_REQUIRED_FIELDS,
            $request->all()
        );
        } catch (\Exception $exception) {
            $this->logger->error($exception->getMessage());
            $this->response->setStatusCode(422, $exception->getMessage());
            $result = [
                'message' => $exception->getMessage(),
                'parameters' => $request->all()
            ];
            return $this->response->setContent($result);
        }

        return $this->customerRepository->edit((int) $request->user()->id, $request->all());
    }
}
