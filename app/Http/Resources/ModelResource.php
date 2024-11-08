<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ModelResource extends JsonResource
{
    public function toArray($request)
    {
        $locale = $request->header('Accept-Language');
        return [
            'id' => $this->id,
            'name' => $locale == 'ar' ? $this->name : $this->name_en,
        ];
    }
}
