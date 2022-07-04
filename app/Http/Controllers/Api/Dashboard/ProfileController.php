<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ProfileRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;

class ProfileController extends Controller
{

    public function getEmployees()
    {
        $users = User::whereType(User::MODERATOR)->get();

        return UserResource::collection($users);
    }
    /**
     * Display the authenticated user resource.
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function show(Request $request)
    {
        return $request->user()->getResource();
    }

    /**
     * Update the authenticated user profile.
     *
     * @param  \App\Http\Requests\Accounts\Api\ProfileRequest  $request
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function update(ProfileRequest $request)
    {
        $user = $request->user();

        $user->update($request->validated());

        if($request->hasFile('image') && $request->file('image')->isValid()){
            $user->clearMediaCollection('images'); // clear old images
            $user->addMediaFromRequest('image')->toMediaCollection('images');
        }

        return $user->getResource();
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => __('auth.logged_out')]);
    }
}
