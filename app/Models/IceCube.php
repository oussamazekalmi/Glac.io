<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IceCube extends Model
{

    protected $fillable = ['user_id', 'date', 'kg', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
