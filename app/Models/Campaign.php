<?php

namespace App\Models;

use App\Http\Filters\CampaignFilter;
use App\Http\Filters\Filterable;
use App\Http\Resources\CampaignResource;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Campaign extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia,Filterable;


    protected $guarded = [];

    protected $filter= CampaignFilter::class;

    public const MEDIA_COLLECTION_NAME = 'campaign_avatar';
    public const MEDIA_COLLECTION_URL = 'images/campaign.png';

    protected $casts = [
        'users' => 'array', // Automatically casts to array from JSON
    ];

    public function getResource(): CampaignResource
    {
        return new CampaignResource($this->fresh());
    }

    /*Relations*/
    public function getUsersRelationAttribute()
    {
        // Check if 'tags' field exists and is an array
        if (is_array($this->users)) {
            return User::whereIn('id', $this->users)->get();  // Fetch related Tag models
        }
        return collect();  // Return empty collection if no tags
    }

    /*Helpers*/
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
