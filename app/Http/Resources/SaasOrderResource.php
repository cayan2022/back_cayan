<?php

namespace App\Http\Resources;

use App\Models\OrderHistory;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class SaasOrderResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'category' => $this->category->name,
            'status' => new StatusResource($this->status),
            'user_name' => $this->user->name,
            'user_phone' => $this->user->phone,
            'user_avatar' => $this->user->getAvatar(),
            'company_name' => $this->user->company_name,
            'spec' => $this->user->company_spec,
            'tenant' => $this->user->tenant_id
        ];
    }
}
