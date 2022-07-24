<?php

namespace App\Http\Requests\Api\Dashboard;

use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
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

        return RuleFactory::make([
            '%name%' => ['required','string','unique:category_translations,name'],
            '%description%' => ['required','string'],
            'is_active' => 'required|boolean',
            'image' => 'required|image|mimes:jpg,jpeg,png,svg',
        ]);
    }
}
