<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\Customer\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Validation\Rules;
use Illuminate\Http\Request;
use Psr\Log\LoggerInterface;

/**
 * Handles customer authentication
 */
class Authenticate extends Controller
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
     * Provides login service
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|Response
     */
    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => ['required', 'string', 'email', 'max:255'],
                'password' => ['required', Rules\Password::defaults()],
            ]);
        } catch (\Exception $exception) {
            $this->logger->error($exception->getMessage());
            $this->response->setStatusCode(422, $exception->getMessage());
            $result = [
                'message' => $exception->getMessage(),
                'parameters' => $request->all()
            ];
            return $this->response->setContent($result);
        }
        $credentials = $request->only('email', 'password');

        if (!auth()->attempt($credentials)) {
            abort(401, 'Invalid credentials');
        }

        $token = auth()->user()->createToken('auth_token');

        return response()
            ->json([
                'data' => [
                    'token' => $token->plainTextToken
                ]
            ]);

    }

    /**
     * Provides logout service
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->user()->currentAccessToken()->delete();

        return response()->json([], 204);
    }
}
