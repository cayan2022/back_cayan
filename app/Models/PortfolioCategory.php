<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use App\Http\Filters\PortfolioCategoryFilter;
use App\Http\Resources\PortfolioCategoryResource;
use App\Models\Traits\HasActivation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class PortfolioCategory extends Model implements HasMedia, TranslatableContract
{
    use HasFactory;
    use InteractsWithMedia;
    use Translatable;
    use Filterable;
    use HasActivation;
    use SoftDeletes;

    protected $fillable = [
        'is_block'
    ];

    public $translatedAttributes = [
        'name',
        'description'
    ];

    protected $casts = [
        'is_block' => 'boolean'
    ];

    /**
     * The query parameter's filter of the model.
     *
     * @var string
     */
    protected $filter = PortfolioCategoryFilter::class;

    public const MEDIA_COLLECTION_NAME = 'portfolio_category_avatar';
    public const MEDIA_COLLECTION_URL = 'images/category.png';

    /**
     * @return PortfolioCategoryResource
     */
    public function getResource(): PortfolioCategoryResource
    {
        return new PortfolioCategoryResource($this->fresh());
    }

    public function getAvatar()
    {
        return $this->getFirstMediaUrl(self::MEDIA_COLLECTION_NAME);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(self::MEDIA_COLLECTION_NAME)
            ->useFallbackUrl(asset(self::MEDIA_COLLECTION_URL))
            ->useFallbackPath(asset(self::MEDIA_COLLECTION_URL));
    }
}