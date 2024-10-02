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
            'user_name' => $this->user->name,
            'user_phone' => $this->user->phone,
            'user_avatar' => $this->user->getAvatar(),
            'email' => $this->user->email,
            'company_name' => $this->user?->tenant?->company_name,
            'company_spec' => $this->user?->tenant?->company_spec,
            'domain' => $this->user?->tenant?->domain,
            'is_paid' => (boolean) $this->user?->tenant->is_paid,
            'expired_at' => $this->user?->tenant?->expired_at
        ];
    }
}
