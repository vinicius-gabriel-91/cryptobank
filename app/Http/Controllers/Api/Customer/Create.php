<?php
/**
 * @author      Webjump Core Team <dev@webjump.com.br>
 * @copyright   2022 Webjump (http://www.webjump.com.br)
 * @license     http://www.webjump.com.br  Copyright
 * @link        http://www.webjump.com.br
 */
declare(strict_types=1);

namespace App\Http\Controllers\Api\Customer;

use App\Models\User;
use Psr\Log\LoggerInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\ValidationException;

class Create extends Controller
{
    private LoggerInterface $logger;
    private Response $response;

    /**
     * Class dependencies
     *
     * @param Response $response
     * @param LoggerInterface $logger
     */
    public function __construct(
        Response $response,
        LoggerInterface $logger
    ) {
        $this->logger = $logger;
        $this->response = $response;
    }

    /**
     * Handle an incoming registration request.
     *
     * @param Request $request
     * @return bool|Response
     */
    public function registerCustomer(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'taxvat' => ['required', 'string', 'max:255'],
                'address' => ['required', 'string', 'max:255'],
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

        $user = User::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'taxvat' => $request->taxvat,
            'address' => $request->address,
            'birth_date' => $request->birth_date,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        return true;
    }
}
