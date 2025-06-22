<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fisc extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'equipment_name', 'amount', 'month', 'year'];
}