<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'code' => optional($this->country)->code,
            'phone' => $this->phone,
            'type' => $this->type,
            'gender' => $this->gender,
            'is_block' => $this->is_block,
            'image' =>  $this->getAvatar() ,
            'created_at' => $this->created_at ? $this->created_at->toDateTimeString() : null,
            'created_at_formatted' =>  $this->created_at ? $this->created_at->diffForHumans() : null,
        ];
    }
}

