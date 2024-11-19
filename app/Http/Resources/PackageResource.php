<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PackageResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'short_description' => $this->short_description,
            'full_description' => $this->full_description,
            'is_free' => (bool)$this->is_free,
            'is_common' => (bool)$this->is_common,
            'type' => $this->type,
            'price' => $this->price,
            'annual_price' => $this->annual_price,
            'models' => $this->models(),
        ];
    }
}
