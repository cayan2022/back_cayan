<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
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
            'id'=>$this->id,
            'name'=>$this->name,
            'short_description'=>$this->short_description,
            'description'=>$this->description,
            'is_active'=>$this->is_active,
            'image'=>$this->getAvatar(),
            'category'=>new CategoryResource($this->category),
        ];
    }
}
