<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Country extends Model implements HasMedia,TranslatableContract
{
    use HasFactory,InteractsWithMedia,Translatable;

    public $translatedAttributes = ['name'];
    protected $fillable=['code'];

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
