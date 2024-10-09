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
        // Fetch the 'Following' status and related sub-status IDs
        $follow = Status::whereTranslationLike('name', '%Following%')->first();
        $follow_sub_status = $follow
            ? SubStatus::where('status_id', $follow->id)->pluck('id')->toArray()
            : [];

        // Set the duration rule dynamically based on sub_status_id
        $duration_rule = request()?->has('sub_status_id') && !in_array(request()->sub_status_id, $follow_sub_status, true)
            ? 'nullable|date_format:Y-m-d H:i:s'
            : 'required|date_format:Y-m-d H:i:s';

        return [
            'order_id' => 'required|integer|exists:orders,id',
            'sub_status_id' => 'required|integer|exists:sub_statuses,id',
            'description' => 'required|string',
            'duration' => $duration_rule,
        ];
    }
}
