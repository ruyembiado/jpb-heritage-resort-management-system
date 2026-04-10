<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VisitorController extends Controller
{

    public function index(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $query = Visitor::orderBy('created_at', 'desc');

        if ($start_date && $end_date) {
            $query->whereBetween('date_visit', [$start_date, $end_date]);
        }
        // else {
        //     $query->whereDate('date_visit', now()->toDateString());
        // }

        $visitors = $query->get();

        return view('logbook', compact('visitors', 'start_date', 'end_date'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'middle_name' => 'nullable',
            'last_name' => 'required',
            'contact_number' => 'required',
            'gender' => 'required',
            'age' => 'required',
            'members' => 'required',
            'address' => 'required',
            'date_visit' => 'required',
        ]);

        // Log the request data
        Log::info('Visitor data:', $request->all());

        // Attempt to create a visitor
        try {
            $visitor = Visitor::create($request->all());
            Log::info('Visitor created:', $visitor->toArray());
        } catch (\Exception $e) {
            Log::error('Error creating visitor: ' . $e->getMessage());
        }

        return redirect()->route('logbook')->with('success', 'Visitor added successfully.');
    }

    public function update(Request $request)
    {
        $visitor = Visitor::findOrFail($request->visitor_id);

        $request->validate([
            'first_name' => 'required',
            'middle_name' => 'required',
            'last_name' => 'required',
            'contact_number' => 'required',
            'gender' => 'required',
            'age' => 'required',
            'members' => 'required',
            'address' => 'required',
            'date_visit' => 'required',
        ]);

        // Log the request data
        Log::info('Visitor update data:', $request->all());
        // Attempt to update the visitor

        try {
            $visitor->update($request->all());
            Log::info('Visitor updated:', $visitor->toArray());
        } catch (\Exception $e) {
            Log::error('Error updating visitor: ' . $e->getMessage());
        }
        return redirect()->route('logbook')->with('success', 'Visitor updated successfully.');
    }

    public function destroy($id)
    {
        $visitor = Visitor::findOrFail($id);
        $visitor->delete();
        return redirect()->route('logbook')->with('success', 'Visitor deleted successfully.');
    }

    public function getVisitorMembers($visitor_id)
    {
        $visitor = Visitor::findOrFail($visitor_id);
        return response()->json([
            'members' => $visitor->members,
        ]);
    }
}
