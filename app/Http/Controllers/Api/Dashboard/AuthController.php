<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Handle a register request to the application using firebase.
     *
     * @param  RegisterRequest  $request
     * @return UserResource
     */

    public function register(RegisterRequest $request)
    {
        $user = User::create($request->validated());

        return $this->getAuthUserResponse($user->fresh());
    }

    /**
     * Handle a login request to the application.
     *
     * @param  LoginRequest  $request
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
