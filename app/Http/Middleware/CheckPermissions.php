<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class CheckPermissions
{
    protected $auth;
    /**
     * Creates a new instance of the middleware.
     *
     * @param Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param $permissions
     * @param bool $allRequired
     * @return mixed
     */
    public function handle($request, Closure $next, $permissions, $allRequired = true)
    {
        if (! is_array($permissions)) {
            $permissions = explode("|", $permissions);
        }

        if ($this->auth->guest() || ! $request->user()->hasPermission($permissions, $allRequired)) {
            abort(403, "Forbidden.");
        }

        return $next($request);
    }
}
