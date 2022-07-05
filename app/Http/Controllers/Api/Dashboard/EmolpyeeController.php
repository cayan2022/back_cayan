<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Dashboard\RegisterRequest;
use App\Http\Requests\Api\Dashboard\EmployeeRequest;
use App\Models\User;
use App\Http\Resources\UserResource;


class EmolpyeeController extends Controller
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

        if($request->hasFile('image') && $request->file('image')->isValid()){
            $user->addMediaFromRequest('image')->toMediaCollection('images');
        }

        return $this->getAuthUserResponse($user->fresh());
    }

    public function getEmployees()
    {
        $users = User::whereType(User::MODERATOR)->get();

        return UserResource::collection($users);
    }

    public function ban(EmployeeRequest $request)
    {
        $user = User::whereId($request->user_id)->firstOrFail();

        $user->update(['is_active' =>false]);

        return response()->json(['message' => __('auth.ban')]);
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
