<?php

namespace App\Http\Resources;

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
            'status' => $this->status->name,
            'user_name' => $this->user->name,
            'user_phone' => $this->user->phone,
            'user_avatar' => $this->user->getAvatar(),
            'source' => $this->source->name,
            'last_employee' => $this->last_employee,
            'employee_avatar' => $this->employee_avatar,
            'created_at' => $this->created_at->diffForHumans(),
            'histories'  => OrderHistoryResource::collection($this->histories),
        ];
    }
}
