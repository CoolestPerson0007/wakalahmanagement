<?php

namespace App\Http\Controllers\Api\Profile;

use App\Events\User\UpdatedProfileDetails;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\User\UpdateProfileDetailsRequest;
use App\Repositories\User\UserRepository;
use App\Transformers\UserTransformer;

/**
 * Class DetailsController
 * @package App\Http\Controllers\Api\Profile
 */
class DetailsController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Handle user details request.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return $this->respondWithItem(
            auth()->user(),
            new UserTransformer
        );
    }

    /**
     * Updates user profile details.
     * @param UpdateProfileDetailsRequest $request
     * @param UserRepository $users
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateProfileDetailsRequest $request, UserRepository $users)
    {
        $user = $request->user();

        $data = collect($request->all());

        $data = $data->only([
            'first_name', 'last_name','email','ic_number','phone', 'wakalah_type', 
            'wakalah_id', 'institution_name','bank_account', 'bank_name',
        ])->toArray();

        if (! isset($data['country_id'])) {
            $data['country_id'] = $user->country_id;
        }

        $user = $users->update($user->id, $data);

        event(new UpdatedProfileDetails);

        return $this->respondWithItem($user, new UserTransformer);
    }
}
