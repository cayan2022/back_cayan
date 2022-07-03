<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ProfileRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class ProfileController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    public function __construct(Request $request)
    {
        App::setLocale($request->header('Accept-Language'));
        $this->language = App::getLocale();
    }

    /**
     * Display the authenticated user resource.
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function show()
    {
        $user = auth()->user();

        return $user->getResource();
    }


    /**
     * Update the authenticated user profile.
     *
     * @param \App\Http\Requests\Accounts\Api\ProfileRequest $request
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function update(ProfileRequest $request)
    {
        $user = auth()->user();

        $user->update($request->validated());

        return $user->getResource();
    }

    public function logout ()
    {
        $user = auth()->user();

        $user->tokens()->delete();

        return response()->json(['data'=>'User Logout Successfully'],200);
    }
}
