<?php

namespace App\Http\Resources\Reports;

use App\Models\Order;
use App\Models\Status;
use App\Models\Source;
use App\Models\SourceClicks;
use App\Http\Resources\StatusResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SourcesReportResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $count = Order::count();

        $clicks = [];
        $sourceClicks = SourceClicks::where('source_id',$this->id)->get();
        foreach ($sourceClicks as $key => $sourceClick) {
            $clicks[$sourceClick->clickable_type] = $sourceClick->clicks;
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'short_description' => $this->short_description,
            'total_orders' =>(int) $this->orders->count(),
            'clicks' => $clicks,
            'percentage_to_all_orders' => $count > 0 ? ((float)$this->orders->count() / Order::count()) : 0,
            'orders_statuses' => (new StatusReportCollection(Status::all()))->additional(['orders'=>$this->orders]),
        ];
    }
}
