<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Dashboard\ChangePasswordRequest;
use App\Models\User;

class ChangePasswordController extends Controller
{

    public function __construct()
    {
        $this->middleware(['role:super-admin']);
    }

    public function __invoke(ChangePasswordRequest $request)
    {
        $user = User::whereId($request->user_id)->firstOrFail();

        $user->update(['password' =>$request->password]);

        return response()->json(['message' => __('auth.change_password')]);
    }
}
