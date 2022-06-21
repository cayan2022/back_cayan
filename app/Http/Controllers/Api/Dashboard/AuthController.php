<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{


    /**
     * Handle a register request to the application using firebase.
     *
     * @param RegisterRequest $request
     */

    public function register(RegisterRequest $request)
    {
        $user = User::create($request->validated());

        return $this->getAuthUserResponse($user->fresh());
    }

    /**
     * Handle a login request to the application.
     *
     * @param LoginRequest $request
     */
    public function login(LoginRequest $request)
    {
        $type = filter_var($request->username,
            FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        $credentials = [$type => $request->username, 'password' => $request->password,];

        if (Auth::attempt($credentials)) {
            $user = User::whereEmail($request->username)->orWhere('phone', $request->username)
                ->orWhere('name', $request->username)->firstOrFail();

            return $this->getAuthUserResponse($user->fresh());
        }
        return response()->json(['error' => 'phone or password is not incorrect!'], 403);
    }


    /**
     * @param User $user
     */
    private function getAuthUserResponse(User $user)
    {
        return $user->getResource()->additional([
            'token' => $user->createTokenForDevice(request()->header('user-agent')),
        ]);
    }
}
