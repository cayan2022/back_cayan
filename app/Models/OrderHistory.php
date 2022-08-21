<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderHistory extends Model
{
    use HasFactory;

    public function employee()
    {
        return $this->belongsTo(User::class,'user_id')->where('type','!=','patient');
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
