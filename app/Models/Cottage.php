<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cottage extends Model
{
    use HasFactory;

    protected $table = 'cottages';

    protected $fillable = [
        'visitor_id',
        'cottage_area',
        'cottage_type',
        'quantity',
        'fee',
        'status',
        'total_payment',
    ];

    public function visitor()
    {
        return $this->belongsTo(Visitor::class, 'visitor_id');
    }
}