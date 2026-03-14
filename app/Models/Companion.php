<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Companion extends Model
{
    use HasFactory;

    protected $table = 'companions';

    protected $fillable = [
        'visitor_id',
        'entrance_id',
        'name',
        'age',
        'isPWD',
        'address',
        'fee',
    ];

    public function visitor()
    {
        return $this->belongsTo(Visitor::class, 'visitor_id');
    }

    public function entrance()
    {
        return $this->belongsTo(Entrance::class, 'entrance_id');
    }
}
