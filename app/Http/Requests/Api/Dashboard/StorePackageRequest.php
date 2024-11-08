<?php

namespace App\Http\Requests\Api\Dashboard;

use App\Rules\SupportedImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Astrotomic\Translatable\Validation\RuleFactory;

class StorePackageRequest extends FormRequest
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
        return RuleFactory::make([
            'name' => ['required', 'string', 'max:255'],
            'short_description' => ['required', 'string'],
            'full_description' => ['required', 'string'],
            'price' => ['required', 'string', 'gt:0'],
            'annual_price' => ['nullable', 'string', 'gt:0'],
            'modules' => ['required', 'array'],
            'modules.*' => ['required', 'exists:modules,id'],
        ]);
    }
}
