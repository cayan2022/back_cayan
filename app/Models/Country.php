<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Country extends Model implements HasMedia
{
    use HasFactory,HasTranslations,InteractsWithMedia;
    protected $fillable=['name','code'];
    public $translatable = ['name'];
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
    public function getAvatar()
    {
        return $this->getFirstMediaUrl('country_avatar');
    }
    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('country_avatar')
            ->useFallbackUrl(asset('images/anonymous-country.jpg'))
            ->useFallbackPath(asset('images/anonymous-country.jpg'));
    }
}
