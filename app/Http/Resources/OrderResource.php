<?php

namespace App\Http\Resources;

use App\Models\OrderHistory;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'category' => $this->category->name,
            'status' => new StatusResource($this->status),
            'user_name' => $this->user->name,
            'user_phone' => $this->user->phone,
            'user_avatar' => $this->user->getAvatar(),
            'source' => $this->source->name,
            'branch' => $this->branch->name,
            'last_employee' => $this->last_employee,
            'employee_avatar' => $this->employee_avatar,
            'created_at' => $this->created_at->diffForHumans(),
            'histories' => OrderHistoryResource::collection($this->histories),
            'followup_date' => $this->FollowUpDate(),
        ];
    }

    private function FollowUpDate()
    {
        if ($this->status_id == 2 && $this->histories != null) {
            $follow_up_date = new Carbon($this->histories->first()->duration);
            if ($follow_up_date != null) {
                $now = Carbon::now();
                if ($now->greaterThan($follow_up_date)) {
                    return $this->FollowUpDateArray($follow_up_date, $now, 0, '#E9F6E7');
                } elseif ($follow_up_date->between($now, $now->addDays(2))) {
                    return $this->FollowUpDateArray($follow_up_date, $now, 1, '#FFF6E5');
                } else {
                    return $this->FollowUpDateArray($follow_up_date, $now, 2, '#FBE9E9');
                }
            }
        }

        return null;
    }

    private function FollowUpDateArray($follow_up_date, $now, $status, $color)
    {
        return [
            'date' => $follow_up_date,
            'time' => $now->diff($follow_up_date)->format('%yy-%m-%d %H:%I:%S'),
            'status' => $status,
            'color' => $color,
        ];
    }
}