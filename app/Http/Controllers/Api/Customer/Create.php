<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Customer;

use Psr\Log\LoggerInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rules;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use App\Models\Api\CustomerRepositoryInterface;

/**
 * Class for customer creation
 */
class Create extends Controller
{
    private LoggerInterface $logger;
    private Response $response;
    private CustomerRepositoryInterface $customerRepository;

    /**
     * Class dependencies
     *
     * @param CustomerRepositoryInterface $customerRepository
     * @param Response $response
     * @param LoggerInterface $logger
     */
    public function __construct(
        CustomerRepositoryInterface $customerRepository,
        Response $response,
        LoggerInterface $logger
    ) {
        $this->logger = $logger;
        $this->response = $response;
        $this->customerRepository = $customerRepository;
    }

    /**
     * Handle an incoming registration request.
     *
     * @param Request $request
     * @return JsonResponse|Response
     */
    public function createCustomer(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'taxvat' => ['required', 'string', 'max:255', 'unique:users'],
                'street' => ['required', 'string', 'max:255'],
                'street_number' => ['required', 'string', 'max:255'],
                'complement' => ['required', 'string', 'max:255'],
                'post_code' => ['required', 'string', 'max:255'],
                'city' => ['required', 'string', 'max:255'],
                'state' => ['required', 'string', 'max:255'],
                'birth_date' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', Rules\Password::defaults()],
            ]);
        } catch (ValidationException $exception) {
            $this->logger->error($exception->getMessage());
            $this->response->setStatusCode(422, $exception->getMessage());
            $result = [
                'message' => $exception->getMessage(),
                'parameters' => $request->all()
            ];
            return $this->response->setContent($result);
        }
        $address = json_encode([
            'street' => $request->street,
            'street_number' =>$request->street_number,
            'complement' =>$request->complement,
            'post_code' => $request->post_code,
            'city' => $request->city,
            'state' => $request->state
        ]);
        $customerData = array_merge($request->all(), ['address' => $address]);

        $user = $this->customerRepository->create($customerData);
        $token = $user->createToken('auth_token');

        return response()
            ->json([
                'data' => [
                    'token' => $token->plainTextToken
                ]
            ]);
    }
}
