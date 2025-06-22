<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Delivery extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'client_id',
        'glacons_kg',
        'is_paid',
        'payment_date',
    ];

    protected $casts = [
        'is_paid' => 'boolean',
        'payment_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}