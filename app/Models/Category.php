<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Category extends Model implements HasMedia
{
    use HasFactory , InteractsWithMedia , HasTranslations;

    protected $fillable = [
        'name',
        'description',
        'is_active'
    ];
    public $translatable = ['name','description'];

    protected $casts=[
        'is_active'=>'boolean'
    ];
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

}
