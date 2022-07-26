<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Service extends Model implements  TranslatableContract
{
    use HasFactory , Translatable;

    protected $fillable = [
        'category_id',
        'name',
        'short_description',
        'description',
        'is_active'
    ];

    public $translatedAttributes = ['name', 'short_description','description'];
    protected $casts = [
        'is_active' => 'boolean'
    ];
    protected $with=['category'];
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
