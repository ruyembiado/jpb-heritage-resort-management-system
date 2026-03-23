<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accommodation extends Model
{
    use HasFactory;

    protected $table = 'accommodations';

    protected $fillable = [
        'visitor_id',
        'room',
        'quantity',
        'fee',
        'status',
        'total_payment',
    ];

    protected $casts = [
        'room' => 'array',
        'quantity' => 'array',
        'fee' => 'array',
    ];

    public function visitor()
    {
        return $this->belongsTo(Visitor::class, 'visitor_id');
    }
}
