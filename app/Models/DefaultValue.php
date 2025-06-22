<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DefaultValue extends Model
{
    use HasFactory;

    protected $fillable = ['kg_price', 'hourly_rate', 'rent'];
}