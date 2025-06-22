<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Worklog extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'hours_worked',
        'work_date',
        'is_paid',
        'payment_date',
    ];

    protected $casts = [
        'work_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}