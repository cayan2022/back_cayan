<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PermissionResource extends JsonResource
{
    public function toArray($request)
    {
        $name = explode(' ', trim($this->name));
        return [
            'id' => $this->id,
            'name' => __('Roles.' . $name[0]),
            'type' => __('Roles.' . $this->type)
        ];
    }
}
