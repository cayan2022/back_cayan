<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'city',
        'address',
        'phone',
        'whatsapp_phone',
        'map_link',
        'short_description',
        'description',
        'is_active'
    ];
    protected $casts = [
        'phone'=>'string',
        'whatsapp_phone'=>'string',
        'is_active'=>'boolean'
    ];
}
