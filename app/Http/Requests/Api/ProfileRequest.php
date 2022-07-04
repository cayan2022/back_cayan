<?php

namespace App\Http\Requests\Api;

use App\Models\User;
use App\Rules\PasswordRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
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
        return Auth::check();
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
            'email'    => ['required','email:rfc,dns',Rule::unique('users','email')->ignore(auth()->id())],
            'country_id'    => 'required|numeric|exists:countries,id',
            'phone'    => ['required','string','max:255',Rule::unique('users','phone')->ignore( auth()->id())],
            'password' => ['required', 'confirmed','string', Password::defaults()],
        ];
    }
}
