<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'phone',
        'address',
        'status',
    ];

    public function deliveries()
    {
        return $this->hasMany(Delivery::class);
    }
}