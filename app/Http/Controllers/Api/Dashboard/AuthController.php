<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Dashboard\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    /**
     * Handle a login request to the application.
     *
     * @param  \App\Http\Requests\Api\Dashboard\LoginRequest  $request
     * @return UserResource|JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $type = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        $credentials = [$type => $request->username, 'password' => $request->password];

        if (Auth::attempt($credentials)) {
            $user = User::whereEmail($request->username)
                ->orWhere('phone', $request->username)
                ->orWhere('name', $request->username)->firstOrFail();
            if($user->is_active == false){
                return response()->json(['error' => 'Your account has been banned'], 403);
            }

            return $this->getAuthUserResponse($user->fresh());
        }
        return response()->json(['error' => 'credentials are incorrect!'], 403);
    }


    /**
     * @param  User  $user
     * @return UserResource
     */
    private function getAuthUserResponse(User $user): UserResource
    {
        return $user->getResource()->additional([
            'token' => $user->createTokenForDevice(request()->header('user-agent')),
        ]);
    }
}
