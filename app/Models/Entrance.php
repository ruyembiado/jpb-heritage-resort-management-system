<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entrance extends Model
{
    use HasFactory;

    protected $table = 'entrances';

    protected $fillable = [
        'visitor_id',
        'category',
        'members',
        'age',
        'total_payment',
    ];

    function visitor()
    {
        return $this->belongsTo(Visitor::class);
    }
}
