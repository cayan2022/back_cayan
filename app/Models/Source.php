<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'identifier',
        'short_description',
        'description',
        'is_active'
    ];
    protected $casts = [
        'identifier' => 'string',
        'is_active' => 'boolean',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function getLinkAttribute(): string
    {
        $identifier=$this->identifier;
        return config('app.url')."/?_source=$identifier";
    }
}
