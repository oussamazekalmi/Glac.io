<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role',
        'status',
        'vacation_days',
        'vacation_start',
    ];

    protected $casts = [
        'vacation_start' => 'date',
    ];

    public function deliveries()
    {
        return $this->hasMany(Delivery::class);
    }

    public function worklogs()
    {
        return $this->hasMany(Worklog::class);
    }
}