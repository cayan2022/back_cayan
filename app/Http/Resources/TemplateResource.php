<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TemplateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'slug' => $this->slug,
            'is_default' => (boolean)$this->is_default,
            'is_block' => (boolean)$this->is_block,
            'is_free' => (boolean)$this->is_free,
            'price' => $this->price ?? null,
            'price_after' => $this->price_after ?? null,
            'type' => $this->type,
            'avatar' => $this->getAvatar(),
        ];
    }
}
