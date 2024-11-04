<?php

namespace App\Http\Requests\Api\Dashboard;

use App\Rules\SupportedImage;
use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateTemplateRequest extends FormRequest
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
            'slug' => ['required', 'string', 'max:255', 'unique:templates,slug'.$this->template->id],
            'description' => ['nullable', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:255'],
            'is_free' => ['nullable', 'boolean'],
            'is_default' => ['nullable', 'boolean'],
            'price' => ['nullable', 'required_if:is_free,0', 'gt:0'],
            'price_after' => ['nullable', 'string', 'max:255', 'lt:price'],
            'image' => ['nullable', new SupportedImage()]
        ]);
    }
}
