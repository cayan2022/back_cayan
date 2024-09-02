<?php

namespace App\Http\Resources;

use App\Models\SourceClicks;
use Illuminate\Http\Resources\Json\JsonResource;

class SourceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $clicks = [];
        $sourceClicks = SourceClicks::where('source_id',$this->id)->get();
        foreach ($sourceClicks as $key => $sourceClick) {
            $clicks[$sourceClick->clickable_type] = $sourceClick->clicks;
        }
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'short_description'=>$this->short_description,
            'is_block'=>$this->is_block,
            'identifier'=>$this->identifier,
            'url'=>$this->url,
            'clicks' => $clicks,
            'image'=>$this->getAvatar(),
            'translations'=> $this->getTranslationsArray()
        ];
    }
}
