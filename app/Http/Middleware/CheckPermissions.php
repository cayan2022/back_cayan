<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 *
 */
class CheckPermissions
{

    /**
     * @param  Request  $request
     * @param  Closure  $next
     * @return $this|mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $authGuard = app('auth')->guard('sanctum');

        $exception = static fn ($msg)=> response()->json( ['message'=>$msg], 403);

        if ($authGuard->guest()) {
            return $exception(trans('auth.errors.not_login'));
        }

        $route = request()->route()->getName();

        if (!is_string($route)) {
            return $exception(trans('auth.errors.wrong_route'));
        }

        $routeNameToArray= explode('.', $route);
        //get last to element of array ex: (countries index) and convert to string then make first word Capitalize
        $permissionName = Str::ucfirst(implode(' ', array_splice($routeNameToArray, -2)));

        $permission=Permission::where('name',$permissionName)
            ->where('guard_name','api')
            ->first();

        if (is_null($permission)) {
            return $exception(trans('auth.errors.wrong_route'));
        }

        if ($authGuard->user()->hasPermissionTo($permissionName,'api')) {
            return $next($request);
        }

        return $exception(trans('auth.errors.has_no_permission'));

    }
}
