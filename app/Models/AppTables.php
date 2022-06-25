<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppTables extends Model
{
    /**
     * Fillable fields for mass assignment
     *
     * @var array
     */
    protected $table = 'app_tables';
    
    protected $fillable = ["title", "title_ar",'is_active'];
}
