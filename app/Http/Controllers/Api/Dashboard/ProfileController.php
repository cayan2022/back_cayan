<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Dashboard\StoreProfileRequest;
use App\Http\Requests\Api\Dashboard\UpdateProfileRequest;
use App\Http\Resources\UserResource;
use App\Models\User;

/**
 *
 */
class ProfileController extends Controller
{


    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $users = User::whereType(User::MODERATOR)->paginate();

        return UserResource::collection($users);
    }

    /**
     * @param  StoreProfileRequest  $request
     * @return mixed
     */
    public function store(StoreProfileRequest $request)
    {
        $user = User::create($request->validated());

        if($request->hasFile('image') && $request->file('image')->isValid()){
            $user->addMediaFromRequest('image')->toMediaCollection('images');
        }
        return $user->getResource()->additional(['token' => $user->createTokenForDevice($request->header('user-agent'))]);
    }
    /**
     * Display the user resource.
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function show(User $user)
    {
        return $user->getResource();
    }

    /**
     * Update the user profile.
     * @param UpdateProfileRequest $request
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function update(UpdateProfileRequest $request,User $user)
    {
        $user->update($request->validated());

        if($request->hasFile('image') && $request->file('image')->isValid()){
            $user->clearMediaCollection('images');
            $user->addMediaFromRequest('image')->toMediaCollection('images');
        }

        return $user->getResource();
    }

    /**
     * @param  User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(User $user)
    {
        $user->tokens()->delete();

        return response()->json(['message' => __('auth.logged_out')]);
    }

    /**
     * @param  User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function block(User $user)
    {
        $user->block();
        return response()->json(['message'=>__('auth.success_operation')]);
    }
    /**
     * @param  User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function active(User $user)
    {
        $user->active();
        return response()->json(['message'=>__('auth.success_operation')]);
    }
}
