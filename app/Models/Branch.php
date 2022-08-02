<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Filters\Filterable;
use App\Http\Filters\BranchFilter;
class Branch extends Model
{
    use HasFactory , Translatable;

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

    protected $filter = BranchFilter::class;

    public $translatedAttributes = ['name', 'short_description','description'];

    protected $casts = [
        'phone'=>'string',
        'whatsapp_phone'=>'string',
        'is_active'=>'boolean'
    ];
}
