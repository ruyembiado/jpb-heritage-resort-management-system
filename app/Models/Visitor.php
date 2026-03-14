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
        'isPWD',
        'members',
        'address',
        'date_visit'
    ];

    public function entrance()
    {
        return $this->hasOne(Entrance::class, 'visitor_id');
    }

    public function accommodation()
    {
        return $this->hasOne(Accommodation::class, 'visitor_id');
    }

    public function functionHall()
    {
        return $this->hasOne(FunctionHall::class, 'visitor_id');
    }

    public function cottage()
    {
        return $this->hasOne(Cottage::class, 'visitor_id');
    }

    public function meal()
    {
        return $this->hasOne(Meal::class, 'visitor_id');
    }

    public function beverage()
    {
        return $this->hasOne(Beverage::class, 'visitor_id');
    }
}
