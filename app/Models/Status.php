<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;
    protected $fillable=['name'];
    protected $with=['subStatuses'];

    public function subStatuses()
    {
        return $this->hasMany(SubStatus::class);
    }
}
