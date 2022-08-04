<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Filters\Filterable;
use App\Http\Filters\SourceFilter;
class Source extends Model
{
    use HasFactory , Translatable , Filterable;

    protected $fillable = [
        'name',
        'identifier',
        'short_description',
        'description',
        'is_active'
    ];

    public $translatedAttributes = ['name','short_description','description'];

    protected $casts = [
        'identifier' => 'string',
        'is_active' => 'boolean',
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['translations'];

    /**
     * The query parameter's filter of the model.
     *
     * @var string
     */
    protected $filter = SourceFilter::class;

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
