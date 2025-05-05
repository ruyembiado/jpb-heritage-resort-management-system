<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function index()
    {
        $staffs = Staff::orderBy('id', 'desc')->get();
        
        return view('staff', compact('staffs'));
    }
}
