<?php

namespace App\Http\Controllers\Api\Auth\Password;

use App\Events\User\RequestedPasswordResetEmail;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Auth\PasswordRemindRequest;
use App\Notifications\ResetPassword;
use App\Repositories\User\UserRepository;
use Password;

class RemindController extends ApiController
{
    /**
     * Create a new password controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Send a reset link to the given user.
     *
     * @param PasswordRemindRequest $request
     * @param UserRepository $users
     * @return \Illuminate\Http\Response
     */
    public function index(PasswordRemindRequest $request, UserRepository $users)
    {
        $user = $users->findByEmail($request->email);

        $token = Password::getRepository()->create($user);

        $user->notify(new ResetPassword($token));

        event(new RequestedPasswordResetEmail($user));

        return $this->respondWithSuccess();
    }
}
