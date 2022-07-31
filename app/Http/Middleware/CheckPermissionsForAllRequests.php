<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Spatie\Permission\Exceptions\UnauthorizedException;

class CheckPermissionsForAllRequests
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        //dd(auth('sanctum')->user());
        $authGuard = auth('sanctum')->user();

       // dd($authGuard);

        if ($authGuard->guest()) {
            throw UnauthorizedException::notLoggedIn();
        }

        //dd($authGuard->getPermissions);
        $route = request()->route()->getName();

        $toArray= explode('.', $route);

        $permissionName = Str::ucfirst(implode(' ', array_splice($toArray, -2)));

        if ($authGuard->hasPermissionTo($permissionName)) {
            return $next($request);
        }


        throw UnauthorizedException::forPermissions(array($permissionName));
    }
}
