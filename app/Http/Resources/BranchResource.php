<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BranchResource extends JsonResource
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
            'city'=>$this->city,
            'address'=>$this->address,
            'phone'=>$this->phone,
            'whatsapp_phone'=>$this->whatsapp_phone,
            'map_link'=>$this->map_link,
            'short_description'=>$this->short_description,
            'description'=>$this->description,
            'is_active'=>$this->is_active
        ];
    }
}
