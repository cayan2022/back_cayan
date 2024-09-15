<?php

namespace App\Http\Requests\Api\Dashboard;

use App\Rules\SupportedImage;
use Illuminate\Support\Facades\Auth;
use Astrotomic\Translatable\Validation\RuleFactory;
use Illuminate\Foundation\Http\FormRequest;

class StoreCampaignRequest extends FormRequest
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
            'description' => ['required', 'string'],
            'starting_time' => ['required', 'date'],
            'ending_time' => ['required', 'date', 'after:starting_time'],
            'users' => ['required', 'array'],
            'image' => ['nullable', new SupportedImage()]
        ]);
    }
}
