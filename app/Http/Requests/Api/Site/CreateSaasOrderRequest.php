<?php

namespace App\Http\Requests\Api\Site;

use App\Models\Country;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CreateSaasOrderRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'source_id' => 'required|integer|exists:sources,id',
            'category_id' => 'required|integer|exists:categories,id',
            'branch_id' => 'required|integer|exists:branches,id',
            'phone' => ['required', Rule::phone()->country(Country::query()->pluck('iso_code')->toArray()), Rule::unique('users')->whereNull('deleted_at')],
            'email' => ['required', 'email:rfc,dns', Rule::unique('users')->whereNull('deleted_at')],
            'type' => 'required|in:1,2',
            'company_name' => 'nullable|string|max:255|unique:user_tenants,company_name',
            'company_spec' => 'nullable|string|max:255',
            'domain' => 'nullable|string|max:255|unique:user_tenants,domain',
            'password' => 'nullable|min:3|confirmed'
        ];
    }

    public function prepareForValidation()
    {
        $phone = $this->input('phone');
        if (preg_match("~^0\d+$~", $phone)) {
            $phone = '966' . substr($phone, 1);
        } elseif (preg_match("~^5\d+$~", $phone)) {
            $phone = '966' . $phone;
        }
        $this->merge([
            'phone' => $phone,
        ]);
    }
}
