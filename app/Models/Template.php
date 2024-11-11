<?php

namespace App\Models;

use App\Http\Filters\Filterable;
use App\Http\Filters\TemplateFilter;
use App\Http\Resources\TemplateResource;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Template extends Model implements HasMedia
{
    use InteractsWithMedia, Filterable;

    protected $guarded = [];
    protected $filter = TemplateFilter::class;

    protected $casts = [
        'is_block' => 'boolean',
        'is_default' => 'boolean',
        'is_free' => 'boolean',
    ];

    public const MEDIA_COLLECTION_NAME = 'template_avatar';
    public const MEDIA_COLLECTION_URL = 'images/partner.png';

    public function getResource(): TemplateResource
    {
        return new TemplateResource($this->fresh());
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
