<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use App\Http\Filters\SeoPageFilter;
use App\Http\Resources\SeoPageResource;
use Spatie\MediaLibrary\HasMedia;
use App\Models\Traits\HasActivation;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class SeoPage extends Model implements TranslatableContract
{
    use HasFactory, Translatable, Filterable, HasActivation;

    protected $guarded = [];

    protected $filter = SeoPageFilter::class;

    public $translatedAttributes = ['meta_name', 'meta_description', 'meta_keywords'];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['translations'];


    public function getResource(): SeoPageResource
    {
        return new SeoPageResource($this->fresh());
    }
}
