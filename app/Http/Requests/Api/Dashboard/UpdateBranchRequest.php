<?php

namespace App\Http\Requests\Api\Dashboard;

use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBranchRequest extends FormRequest
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
            '%name%' => ['required','string','unique:branch_translations,name'],
            '%description%' => ['required','string'],
            '%short_description%' => ['required','string'],
            'city' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|numeric',
            'whatsapp_phone' => 'required|numeric',
            'map_link' => 'required|url',
            'is_active' => 'required|boolean',
        ]);
    }
}
