<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FunctionHall extends Model
{
    use HasFactory;

    protected $table = 'function_halls';

    protected $fillable = [
        'visitor_id',
        'function_hall_type',
        'fee',
        'status',
        'total_payment',
    ];
}
