<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use Illuminate\Http\Request;

class BillController extends Controller
{
    public function index(Request $request)
    {
        $visitors = Visitor::orderBy('created_at', 'desc')->with('entrance', 'accommodation')->get();
        return view('bill', compact('visitors'));
    }
}
