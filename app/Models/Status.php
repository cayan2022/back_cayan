<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model implements TranslatableContract
{
    use HasFactory , Translatable;

    protected $fillable=['name'];

    public $translatedAttributes = ['name'];

    protected $with=['subStatuses'];

    public function subStatuses()
    {
        return $this->hasMany(SubStatus::class);
    }
}
