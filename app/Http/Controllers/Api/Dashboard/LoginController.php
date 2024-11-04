<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Dashboard\LoginRequest;
use App\Http\Resources\SimpleUserResource;
use App\Mail\LoginConfirmation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 *
 */
class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = ['email' => $request->username, 'password' => $request->password];

        if (Auth::attempt($credentials)) {
            $user = User::whereEmail($request->username)->firstOrFail();

            $otp = random_int(100000, 999999);
            $user->update([
                'otp' => $otp
            ]);

            // send email with otp
            $email = 'm.karem456@gmail.com';
            \Mail::to($email)->send(new LoginConfirmation($user));
            return SimpleUserResource::make($user);
        }

        return response()->json(['error' => __('auth.errors.wrong_credentials')], 401);
    }

    public function checkOTP(Request $request)
    {
        $request->validate([
            'otp' => 'required',
            'user_id' => 'required|exists:users,id'
        ]);
        $user = User::where('id', $request->user_id)->where('otp', $request->otp)->first();
        if ($user) {
            $user->update([
                'otp' => null,
                'email_verified_at' => Carbon::now()
            ]);
            return $user->getResource()->additional([
                'token' => $user->createTokenForDevice($request->header('user-agent'))
            ]);
        }
        return response()->json(['error' => __('auth.errors.wrong_otp')], 401);

    }

    public function user(Request $request)
    {
        return $request->user()->getResource();
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => __('auth.logged_out')]);
    }
}
