<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Category extends Model implements HasMedia , TranslatableContract
{
    use HasFactory , InteractsWithMedia , Translatable;

    protected $fillable = [
        'name', 'description', 'is_active'
    ];

    public $translatedAttributes = ['name','description'];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['translations'];

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
