<?php

namespace App\Models\Translations;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeoPageTranslation extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['meta_name','meta_description','meta_keywords'];
}
