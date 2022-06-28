<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubStatus extends Model
{
    use HasFactory;
    protected $fillable=['name','status_id'];
    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }
}
