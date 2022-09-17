<?php

namespace App\Http\Resources\Reports;

use App\Models\Order;
use App\Models\Status;
use Illuminate\Http\Resources\Json\JsonResource;

class ModeratorsReportResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'total_orders' =>(int) $this->orders->count(),
            'percentage_to_all_orders'=>(float) $this->orders->count() / Order::count() ,
            'orders_statuses' => (new StatusReportCollection(Status::all()))->additional(['orders'=>$this->orders]),
        ];
    }
}
