<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Dashboard\ProfileRequest;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{


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
