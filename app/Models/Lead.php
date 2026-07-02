<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'service_requested',
        'budget',
        'country',
        'source',
        'status',
        'notes',
        'assigned_staff_id',
    ];
}
