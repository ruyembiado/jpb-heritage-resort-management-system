<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    protected $table = 'staffs';

    protected $fillable = [
        'staff_id',
        'first_name',
        'middle_name',
        'last_name',
        'contact_number',
        'email',
        'gender',
        'address',
        'birthdate',
        'date_hired',
        'date_resigned',
        'designation',
        'status'
    ];
}
