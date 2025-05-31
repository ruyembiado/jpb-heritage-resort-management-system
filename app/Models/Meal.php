<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    use HasFactory;

    protected $table = 'meals';

    protected $fillable = [
        'visitor_id',
        'item_name',
        'fee',
        'quantity',
        'total_payment',
    ];

    public function visitor()
    {
        return $this->belongsTo(Visitor::class);
    }
}
