<?php

namespace App\Http\Controllers\Api\Auth;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Events\User\LoggedIn;
use App\Events\User\LoggedOut;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\Auth\Api\JWT;

/**
 * Class LoginController
 * @package App\Http\Controllers\Api\Auth
 */
class AuthController extends ApiController
{
    public function __construct()
    {
        $this->middleware('guest')->only('login');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Attempt to log the user in and generate unique
     * JWT token on successful authentication.
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->getCredentials();

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return $this->errorUnauthorized('Invalid credentials.');
            }
        } catch (JWTException $e) {
            return $this->errorInternalError('Could not create token.');
        }

        $user = auth()->user();

        if ($user->isBanned()) {
            $this->invalidateToken($token);
            return $this->errorUnauthorized('Your account is banned by administrators.');
        }

        if ($user->isUnconfirmed()) {
            $this->invalidateToken($token);
            return $this->errorUnauthorized('Please confirm your email address first.');
        }

        if (setting('single_device_login'))
        {
            $last_token = $user->last_token;
            $user->last_token = $token;
            $user->save();

            if ($last_token)
                $this->invalidateToken($last_token);
        }

        event(new LoggedIn);

        return $this->respondWithArray(compact('token'));
    }

    private function invalidateToken($token)
    {
        JWTAuth::setToken($token);
        JWTAuth::invalidate();
    }

    /**
     * Logout user and invalidate token.
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        event(new LoggedOut);

        auth()->logout();

        return $this->respondWithSuccess();
    }
}
