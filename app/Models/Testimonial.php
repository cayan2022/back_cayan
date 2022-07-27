<?php

namespace App\Models;

use App\Http\Resources\TestimonialResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Testimonial extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'user_name',
        'comment',
        'is_active'
    ];
    public const MEDIA_COLLECTION_NAME = 'testimonial_avatar';
    public const MEDIA_COLLECTION_URL = 'images/testimonial.png';
    protected $casts = [
        'is_active' => 'boolean',
    ];
    /*Helpers*/
    /**
     * @return TestimonialResource
     */
    public function getResource(): TestimonialResource
    {
        return new TestimonialResource($this->fresh());
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

    /*
     * Scopes
     * */
    public function scopeWhereActivationIs($query, bool $bool)
    {
        return $query->where('is_active', $bool);
    }
}
