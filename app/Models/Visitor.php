<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $table = 'visitors';

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'contact_number',
        'gender',
        'age',
        'members',
        'address',
        'date_visit'
    ];

    public function entrance()
    {
        return $this->hasOne(Entrance::class, 'visitor_id');
    }
}
