<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTenant extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'active_models' => 'array',
        'templates' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
