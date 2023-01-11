<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Activity\GetActivitiesRequest;
use App\Repositories\Activity\ActivityRepository;
use App\Transformers\ActivityTransformer;

/**
 * Class ActivityController
 * @package App\Http\Controllers\Api
 */
class ActivityController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:users.activity');
    }

    /**
     * Paginate user activities.
     * @param GetActivitiesRequest $request
     * @param ActivityRepository $activities
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(GetActivitiesRequest $request, ActivityRepository $activities)
    {
        $result = $activities->paginateActivities(
            $request->per_page ?: 20,
            $request->search
        );

        return $this->respondWithPagination(
            $result,
            new ActivityTransformer
        );
    }
}
