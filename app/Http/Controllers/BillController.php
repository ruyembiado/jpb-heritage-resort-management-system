<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use Illuminate\Http\Request;

class BillController extends Controller
{
    public function index(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $letter = $request->letter;

        $visitors = Visitor::with('entrance', 'accommodation', 'functionHall', 'cottage', 'meal', 'beverage')
            ->when($start_date, function ($query) use ($start_date) {
                $query->whereDate('created_at', '>=', $start_date);
            })
            ->when($end_date, function ($query) use ($end_date) {
                $query->whereDate('created_at', '<=', $end_date);
            })
            ->when($letter, function ($query) use ($letter) {
                $query->where('first_name', 'like', $letter . '%');
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('bill', compact('visitors'));
    }

    public function bill_history()
    {
        $visitors = Visitor::orderBy('created_at', 'desc')->with('entrance', 'accommodation', 'functionHall', 'cottage', 'meal', 'beverage')
            ->get();

        return view('bill_history', compact('visitors'));
    }
}
