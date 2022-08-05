<?php

namespace App\Http\Requests\Api\Dashboard;

use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSourceRequest extends FormRequest
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
            '%name%' => ['required','string','max:255'],
            '%short_description%' => ['required','string'],
            '%description%' => ['required','string'],
            'identifier' => 'required|url',
            'is_active' => 'required|boolean',

        ]);
    }
}
