<?php

namespace App\Http\Requests\Api;

use App\Models\User;
use App\Rules\PasswordRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'     => 'required|string|max:255',
            'gender'   => ['required', 'string', Rule::in(User::GENDERS)],
            'email'    => 'required|email:rfc,dns|unique:users,email,' . auth()->id(),
            'phone'    => 'required|string|max:255|unique:users,phone,'. auth()->id(),
            'password' => ['required', 'confirmed','string', Password::defaults()],
        ];
    }
}
