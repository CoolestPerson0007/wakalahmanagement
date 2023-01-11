<?php

namespace App\Http\Controllers\Api\Profile;

use App\Events\User\UpdatedProfileDetails;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\User\UpdateProfileDetailsRequest;
use App\Http\Requests\User\UpdateProfileLoginDetailsRequest;
use App\Repositories\User\UserRepository;
use App\Transformers\UserTransformer;

/**
 * Class DetailsController
 * @package App\Http\Controllers\Api\Profile
 */
class AuthDetailsController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Updates user profile details.
     * @param UpdateProfileLoginDetailsRequest $request
     * @param UserRepository $users
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateProfileLoginDetailsRequest $request, UserRepository $users)
    {
        $user = $request->user();

        $data = $request->only(['email', 'username', 'password']);

        $user = $users->update($user->id, $data);

        return $this->respondWithItem($user, new UserTransformer);
    }
}
