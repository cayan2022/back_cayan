<?php

namespace App\Http\Requests\Api\Dashboard;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class StoreProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::guard('sanctum')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'gender' => ['required', 'string', Rule::in(User::GENDERS)],
            'email' => ['required', 'email:rfc,dns', Rule::unique('users', 'email')],
            'country_id' => 'required|numeric|exists:countries,id',
            'phone' => 'required|string|max:255|unique:users,phone',
            'role_id' => 'required|numeric|exists:roles,id',
            'password' => ['required', 'confirmed', 'string', Password::defaults()],
            'image' => 'nullable|mimes:jpg,jpeg,png,svg'
        ];
    }
}
