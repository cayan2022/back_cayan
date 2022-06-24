<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'short_description',
        'description',
        'is_active'
    ];
    protected $casts = [
        'is_active' => 'boolean'
    ];
    protected $with=['category'];
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
