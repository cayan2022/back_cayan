<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CampaignResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'starting_time' => $this->starting_time,
            'ending_time' => $this->ending_time,
            'image' => $this->getAvatar(),
            'users' => SimpleUserResource::collection($this->users_relation),
        ];
    }
}
