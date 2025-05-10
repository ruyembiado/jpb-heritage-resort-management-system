<?php

namespace App\Http\Controllers;

use App\Models\Entrance;
use App\Models\Visitor;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        return view('services');
    }

    public function entrances()
    {
        $visitors = Visitor::orderBy('created_at', 'desc')->limit(50)->get();
        $entrances = Entrance::orderBy('created_at', 'desc')->with('visitor')->get();

        return view('entrances', compact('visitors', 'entrances'));
    }

    public function storeEntrance(Request $request)
    {
        $request->validate([
            'visitor_id' => 'required|exists:visitors,id',
            'category' => 'required|array',
            'members' => 'required|array',
            'age' => 'nullable|array',
            'total_payment' => 'required',
        ]);

        $categories = $request->input('category');
        $members = $request->input('members');
        $ages = $request->input('age');

        $filteredCategories = [];
        $filteredMembers = [];
        $filteredAges = [];

        foreach ($members as $index => $count) {
            if (!empty($count) && is_numeric($count)) {
                $filteredCategories[] = $categories[$index] ?? null;
                $filteredMembers[] = $count;
                $filteredAges[] = $ages[$index] ?? null;
            }
        }

        Entrance::create([
            'visitor_id' => $request->visitor_id,
            'category' => json_encode($filteredCategories),
            'members' => json_encode($filteredMembers),
            'age' => json_encode($filteredAges),
            'total_payment' => $request->total_payment,
        ]);

        return redirect()->route('entrances')->with('success', 'Entrance added successfully.');
    }
}
