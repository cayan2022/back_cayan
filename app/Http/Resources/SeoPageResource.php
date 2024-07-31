<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SeoPageResource extends JsonResource
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
            'page_name'=>$this->page_name,
            'meta_name'=>$this->meta_name,
            'meta_description'=>$this->meta_description,
            'meta_keywords'=>$this->meta_keywords,
            'translations'=> $this->getTranslationsArray()
        ];
    }
}
