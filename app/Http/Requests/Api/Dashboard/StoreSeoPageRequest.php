<?php

namespace App\Http\Requests\Api\Dashboard;

use App\Rules\SupportedImage;
use Illuminate\Support\Facades\Auth;
use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Foundation\Http\FormRequest;

class StoreSeoPageRequest extends FormRequest
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
            'page_name' => 'required|string|max:255|unique:seo_pages,page_name',
            '%meta_name%' => ['required', 'string', 'max:255'],
            '%meta_description%' => ['required', 'string'],
            '%meta_keywords%' => 'required|string|max:255',
        ]);
    }
}
