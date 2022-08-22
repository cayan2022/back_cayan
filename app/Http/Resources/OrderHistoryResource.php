<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderHistoryResource extends JsonResource
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
            'order_id' => $this->order->id,
            'sub_status' => $this->substatus->name,
            'employee_name' => $this->employee->name,
            'employee_avatar' => $this->employee->getAvatar(),
            'duration' => $this->duration,
            'description' => $this->description,
            'last_update' => $this->updated_at->diffForHumans(),
            'created_at' => $this->created_at->toTimeString()
        ];
    }
}
