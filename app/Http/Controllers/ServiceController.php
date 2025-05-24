<?php

namespace App\Http\Controllers;

use App\Models\Accommodation;
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
            'fee' => 'nullable|array',
            'total_payment' => 'required',
        ]);

        $categories = $request->input('category');
        $members = $request->input('members');
        $ages = $request->input('age');
        $fees = $request->input('fee');

        $filteredCategories = [];
        $filteredMembers = [];
        $filteredAges = [];
        $filteredFees = [];

        foreach ($members as $index => $count) {
            if (!empty($count) && is_numeric($count)) {
                $filteredCategories[] = $categories[$index] ?? null;
                $filteredMembers[] = $count;
                $filteredAges[] = $ages[$index] ?? null;
                $filteredFees[] = $fees[$index] ?? null;
            }
        }

        Entrance::create([
            'visitor_id' => $request->visitor_id,
            'category' => json_encode($filteredCategories),
            'members' => json_encode($filteredMembers),
            'age' => json_encode($filteredAges),
            'fee' => json_encode($filteredFees),
            'total_payment' => $request->total_payment,
        ]);

        return redirect()->route('entrances')->with('success', 'Entrance added successfully.');
    }

    public function updateEntrance(Request $request)
    {
        $request->validate([
            'visitor_id' => 'required|exists:visitors,id',
            'category' => 'required|array',
            'members' => 'required|array',
            'age' => 'nullable|array',
            'fee' => 'nullable|array',
            'total_payment' => 'required',
        ]);

        $categories = $request->input('category');
        $members = $request->input('members');
        $ages = $request->input('age');
        $fees = $request->input('fee');

        $filteredCategories = [];
        $filteredMembers = [];
        $filteredAges = [];
        $filteredFees = [];

        foreach ($members as $index => $count) {
            if (!empty($count) && is_numeric($count)) {
                $filteredCategories[] = $categories[$index] ?? null;
                $filteredMembers[] = $count;
                $filteredAges[] = $ages[$index] ?? null;
                $filteredFees[] = $fees[$index] ?? null;
            }
        }

        $entrance = Entrance::findOrFail($request->entrance_id);
        $entrance->update([
            'visitor_id' => $request->visitor_id,
            'category' => json_encode($filteredCategories),
            'members' => json_encode($filteredMembers),
            'age' => json_encode($filteredAges),
            'fee' => json_encode($filteredFees),
            'total_payment' => $request->total_payment,
        ]);

        return redirect()->route('entrances')->with('success', 'Entrance updated successfully.');
    }

    public function destroyEntrance($id)
    {
        $entrance = Entrance::findOrFail($id);
        $entrance->delete();
        return redirect()->route('entrances')->with('success', 'Entrance fee deleted successfully.');
    }

    public function accommodations()
    {
        $visitors = Visitor::orderBy('created_at', 'desc')->limit(50)->get();
        $accommodations = Accommodation::orderBy('created_at', 'desc')->with('visitor')->get();

        return view('accommodations', compact('visitors', 'accommodations'));
    }

    public function storeAccommodation(Request $request)
    {
        $request->validate([
            'visitor_id' => 'required|exists:visitors,id',
            'rooms' => 'required|array',
            'fees' => 'required|array',
        ]);

        $checked = $request->input('checked');
        $rooms = $request->input('rooms');
        $fees = $request->input('fees');

        $filteredRooms = [];
        $filteredFees = [];

        foreach ($rooms as $index => $room) {
            if (in_array($room, $checked)) {
                $filteredRooms[] = $room;
                $filteredFees[] = $fees[$index] ?? 0;
            }
        }

        // Check if at least one room was selected
        if (empty($filteredRooms)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Please select at least one room.');
        }

        Accommodation::create([
            'visitor_id' => $request->visitor_id,
            'room' => json_encode($filteredRooms),
            'fee' => json_encode($filteredFees),
        ]);

        return redirect()->route('accommodations')->with('success', 'Accommodation added successfully.');
    }

    public function updateAccommodation(Request $request)
    {
        $request->validate([
            'accommodation_id' => 'required|exists:accommodations,id',
            'edit_rooms' => 'required|array',
            'edit_fees' => 'required|array',
        ]);

        $checked = $request->input('checked', []);
        $rooms = $request->input('edit_rooms');
        $fees = $request->input('edit_fees');

        $filteredRooms = [];
        $filteredFees = [];

        foreach ($rooms as $index => $room) {
            if (in_array($room, $checked)) {
                $filteredRooms[] = $room;
                $filteredFees[] = $fees[$index] ?? 0;
            }
        }

        $accommodation = Accommodation::findOrFail($request->accommodation_id);
        $accommodation->update([
            'room' => json_encode($filteredRooms),
            'fee' => json_encode($filteredFees),
        ]);

        return redirect()->route('accommodations')->with('success', 'Accommodation updated successfully.');
    }

    public function destroyAccommodation($id)
    {
        $accommodation = Accommodation::findOrFail($id);
        $accommodation->delete();
        return redirect()->route('accommodations')->with('success', 'Accommodation deleted successfully.');
    }
}
