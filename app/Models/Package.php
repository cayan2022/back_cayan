<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];


    protected $casts = [
        'is_block' => 'boolean',
        'models' => 'array',
    ];

    public function models()
    {
        return Model::whereIn('id', $this->models)->select('id', 'name')->get();
    }
}
