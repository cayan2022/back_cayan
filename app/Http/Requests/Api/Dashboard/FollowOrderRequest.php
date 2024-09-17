<?php

namespace App\Http\Requests\Api\Dashboard;

use App\Models\Status;
use App\Models\SubStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class FollowOrderRequest extends FormRequest
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
        $follow = Status::whereTranslationLike('name','%Following%')->first();
        $follow_sub_status = SubStatus::whereHas('status', function ($query) use ($follow) {
            $query->where('id', $follow->id);
        })->get()->pluck('id');

        dd($follow_sub_status);
        return [
            'order_id' => 'required|integer|exists:orders,id',
            'sub_status_id' => 'required|integer|exists:sub_statuses,id',
            'description' => 'required|string',
            'duration' => 'required|date_format:Y-m-d H:i:s',
        ];
    }
}
