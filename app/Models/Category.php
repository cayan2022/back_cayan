<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\Http\Filters\Filterable;
use App\Http\Filters\CategoryFilter;
class Category extends Model implements HasMedia , TranslatableContract
{
    use HasFactory , InteractsWithMedia , Translatable , Filterable;

    protected $fillable = [
        'name', 'description', 'is_active'
    ];

    public $translatedAttributes = ['name','description'];


    /**
     * The query parameter's filter of the model.
     *
     * @var string
     */
    protected $filter = CategoryFilter::class;

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
