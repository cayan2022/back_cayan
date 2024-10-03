<?php

namespace App\Http\Resources;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Resources\Json\JsonResource;

class SaasOrderResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id ?? $this->user->id,
            'user_name' => $this->user->name,
            'user_phone' => $this->user->phone,
            'user_avatar' => $this->user->getAvatar(),
            'email' => $this->user->email,
            'company_name' => $this->user?->tenant?->company_name,
            'company_spec' => $this->user?->tenant?->company_spec,
            'domain' => $this->user?->tenant?->domain,
            'is_paid' => (boolean)$this->user?->tenant?->is_paid,
            'expired_at' => $this->user?->tenant?->expired_at,
            'status' => !$this->user->is_block,
            'password' => decrypt($this->user?->tenant?->tenant_pass) ?? null
        ];
    }
}
