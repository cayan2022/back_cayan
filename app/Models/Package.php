<?php

namespace App\Models;

use App\Http\Resources\PackageResource;
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

    public function getResource(): PackageResource
    {
        return new PackageResource($this->fresh());
    }
    public function models()
    {
        return AppModel::whereIn('id', $this->models)->select('id', 'name')->get();
    }
}
