<?php

namespace App\Http\Controllers\Api\Authorization;

use Cache;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Events\Role\PermissionsUpdated;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Role\CreateRoleRequest;
use App\Http\Requests\Role\RemoveRoleRequest;
use App\Http\Requests\Role\UpdateRolePermissionsRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Repositories\Role\RoleRepository;
use App\Repositories\User\UserRepository;
use App\Role;
use App\Transformers\PermissionTransformer;
use App\Transformers\RoleTransformer;

/**
 * Class RolePermissionsController
 * @package App\Http\Controllers\Api
 */
class RolePermissionsController extends ApiController
{
    /**
     * @var RoleRepository
     */
    private $roles;

    public function __construct(RoleRepository $roles)
    {
        $this->roles = $roles;
        $this->middleware('auth');
        $this->middleware('permission:permissions.manage');
    }

    public function show(Role $role)
    {
        return $this->respondWithCollection(
            $role->cachedPermissions(),
            new PermissionTransformer
        );
    }

    /**
     * Update specified role.
     * @param Role $role
     * @param UpdateRolePermissionsRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Role $role, UpdateRolePermissionsRequest $request)
    {
        $this->roles->updatePermissions(
            $role->id,
            $request->permissions
        );

        event(new PermissionsUpdated);

        return $this->respondWithCollection(
            $role->cachedPermissions(),
            new PermissionTransformer
        );
    }
}
