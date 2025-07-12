<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\Cottage;
use App\Models\Visitor;
use App\Models\Entrance;
use Illuminate\Http\Request;
use App\Models\Accommodation;
use App\Models\Beverage;

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

        foreach ($categories as $index => $category) {
            $filteredCategories[] = $category;
            $filteredMembers[] = isset($members[$index]) && $members[$index] !== '' ? $members[$index] : "null";
            $filteredAges[] = isset($ages[$index]) ? $ages[$index] : null;
            $filteredFees[] = isset($fees[$index]) ? $fees[$index] : null;
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

        foreach ($categories as $index => $category) {
            $filteredCategories[] = $category;
            $filteredMembers[] = isset($members[$index]) && $members[$index] !== '' ? $members[$index] : "null";
            $filteredAges[] = isset($ages[$index]) ? $ages[$index] : null;
            $filteredFees[] = isset($fees[$index]) ? $fees[$index] : null;
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
            'total_payment' => 'required',
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
            'total_payment' => $request->total_payment,
        ]);

        return redirect()->route('accommodations')->with('success', 'Accommodation added successfully.');
    }

    public function updateAccommodation(Request $request)
    {
        $request->validate([
            'accommodation_id' => 'required|exists:accommodations,id',
            'edit_rooms' => 'required|array',
            'edit_fees' => 'required|array',
            'total_payment' => 'required',
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
            'total_payment' => $request->total_payment,
        ]);

        return redirect()->route('accommodations')->with('success', 'Accommodation updated successfully.');
    }

    public function destroyAccommodation($id)
    {
        $accommodation = Accommodation::findOrFail($id);
        $accommodation->delete();
        return redirect()->route('accommodations')->with('success', 'Accommodation deleted successfully.');
    }

    public function cottages()
    {
        $visitors = Visitor::orderBy('created_at', 'desc')->limit(50)->get();
        $cottages = Cottage::orderBy('created_at', 'desc')->with('visitor')->get();

        return view('cottages', compact('visitors', 'cottages'));
    }

    public function storeCottage(Request $request)
    {
        $request->validate([
            'visitor_id' => 'required|exists:visitors,id',
            'cottage_area' => 'required',
            'cottage_type' => 'required|array',
            'quantity' => 'required|array',
            'fees' => 'required|array',
            'total_payment' => 'required',
        ]);

        $types = $request->input('cottage_type');
        $quantities = $request->input('quantity');
        $fees = $request->input('fees');

        $finalCottages = [];
        $finalQuantities = [];
        $finalFees = [];

        foreach ($types as $index => $type) {
            // If quantity is empty or not set, set it to 0
            $qty = isset($quantities[$index]) && is_numeric($quantities[$index])
                ? (int) $quantities[$index]
                : 0;

            // If fee is empty or not set, set it to 0.0
            $fee = isset($fees[$index]) && is_numeric($fees[$index])
                ? (float) $fees[$index]
                : 0.0;

            $finalCottages[] = $type;
            $finalQuantities[] = $qty;
            $finalFees[] = $fee;
        }

        Cottage::create([
            'visitor_id' => $request->visitor_id,
            'cottage_area' => $request->cottage_area,
            'cottage_type' => json_encode($finalCottages),
            'quantity' => json_encode($finalQuantities),
            'fee' => json_encode($finalFees),
            'total_payment' => $request->total_payment,
        ]);

        return redirect()->route('cottages')->with('success', 'Cottage Rental added successfully.');
    }

    public function updateCottage(Request $request)
    {
        $request->validate([
            'cottage_id' => 'required|exists:cottages,id',
            'edit_cottage_area' => 'required|string',
            'edit_cottage_types' => 'required|array',
            'quantity' => 'required|array',
            'cottage_fees' => 'required|array',
            'total_payment' => 'required|numeric',
        ]);

        $cottage = Cottage::findOrFail($request->cottage_id);

        $types = $request->input('edit_cottage_types');
        $quantities = $request->input('quantity');
        $fees = $request->input('cottage_fees');

        $finalCottages = [];
        $finalQuantities = [];
        $finalFees = [];

        foreach ($types as $index => $type) {
            $qty = isset($quantities[$index]) && is_numeric($quantities[$index]) ? (int) $quantities[$index] : 0;
            $fee = isset($fees[$index]) && is_numeric($fees[$index]) ? (float) $fees[$index] : 0.0;

            $finalCottages[] = $type;
            $finalQuantities[] = $qty;
            $finalFees[] = $fee;
        }

        $cottage->update([
            'cottage_area' => $request->input('edit_cottage_area'),
            'cottage_type' => json_encode($finalCottages),
            'quantity' => json_encode($finalQuantities),
            'fee' => json_encode($finalFees),
            'total_payment' => $request->input('total_payment'),
        ]);

        return redirect()->route('cottages')->with('success', 'Cottage Rental updated successfully.');
    }

    public function destroyCottage($id)
    {
        $cottage = Cottage::findOrFail($id);
        $cottage->delete();
        return redirect()->route('cottages')->with('success', 'Cottage Rental deleted successfully.');
    }

    public function meals()
    {
        $visitors = Visitor::orderBy('created_at', 'desc')->limit(50)->get();
        $meals = Meal::orderBy('created_at', 'desc')->with('visitor')->get();

        return view('meals', compact('visitors', 'meals'));
    }

    public function storeMeal(Request $request)
    {
        $request->validate([
            'visitor_id' => 'required|exists:visitors,id',
            'meal_items' => 'required|array',
            'meal_items.*.name' => 'required|string',
            'meal_items.*.price' => 'nullable|numeric',
            'meal_items.*.quantity' => 'nullable|integer|min:0',
            'meal_items.*.subtotal' => 'nullable|numeric',
            'total_payment' => 'required|numeric',
        ]);

        $itemNames = [];
        $quantities = [];
        $fees = [];

        foreach ($request->meal_items as $item) {
            $name = isset($item['name']) ? $item['name'] : '';
            $qty  = isset($item['quantity']) && is_numeric($item['quantity']) ? (int) $item['quantity'] : 0;
            $fee  = isset($item['price']) && is_numeric($item['price']) ? (float) $item['price'] : 0.00;

            $itemNames[] = $name;
            $quantities[] = $qty;
            $fees[] = $fee;
        }

        Meal::create([
            'visitor_id'    => $request->visitor_id,
            'item_name'     => json_encode($itemNames),
            'fee'           => json_encode($fees),
            'quantity'      => json_encode($quantities),
            'total_payment' => $request->total_payment,
        ]);

        return redirect()->route('meals')->with('success', 'Meal(s) added successfully.');
    }

    public function updateMeal(Request $request)
    {
        $request->validate([
            'meal_id' => 'required|exists:meals,id',
            'visitor_id' => 'required|exists:visitors,id',
            'meal_items' => 'required|array',
            'meal_items.*.name' => 'required|string',
            'meal_items.*.price' => 'required|numeric',
            'meal_items.*.quantity' => 'required|integer|min:0',
            'total_payment' => 'required|numeric',
        ]);

        $meal = Meal::findOrFail($request->meal_id);

        $items = $request->input('meal_items');

        $itemNames = [];
        $prices = [];
        $quantities = [];
        $subtotals = [];

        foreach ($items as $item) {
            if ($item['quantity'] > 0) {
                $itemNames[] = $item['name'];
                $prices[] = (float) $item['price'];
                $quantities[] = (int) $item['quantity'];
                $subtotals[] = (float) $item['price'] * (int) $item['quantity'];
            }
        }

        $meal->update([
            'visitor_id' => $request->input('visitor_id'),
            'item_name' => json_encode($itemNames),
            'fee' => json_encode($prices),
            'quantity' => json_encode($quantities),
            'subtotal' => json_encode($subtotals),
            'total_payment' => $request->input('total_payment'),
        ]);

        return redirect()->route('meals')->with('success', 'Meal record updated successfully.');
    }

    public function destroyMeal($id)
    {
        $meal = Meal::findOrFail($id);
        $meal->delete();
        return redirect()->route('meals')->with('success', 'Meal(s) record deleted successfully.');
    }

    public function beverages()
    {
        $visitors = Visitor::orderBy('created_at', 'desc')->limit(50)->get();
        $beverages = Beverage::orderBy('created_at', 'desc')->with('visitor')->get();

        return view('beverages', compact('visitors', 'beverages'));
    }

    public function storeBeverage(Request $request)
    {
        $request->validate([
            'visitor_id' => 'required|exists:visitors,id',
            'beverage_items' => 'required|array',
            'beverage_items.*.name' => 'required|string',
            'beverage_items.*.price' => 'nullable|numeric',
            'beverage_items.*.quantity' => 'nullable|integer|min:0',
            'beverage_items.*.subtotal' => 'nullable|numeric',
            'total_payment' => 'required|numeric',
        ]);

        $itemNames = [];
        $quantities = [];
        $fees = [];

        foreach ($request->beverage_items as $item) {
            $name = isset($item['name']) ? $item['name'] : '';
            $qty  = isset($item['quantity']) && is_numeric($item['quantity']) ? (int) $item['quantity'] : 0;
            $fee  = isset($item['price']) && is_numeric($item['price']) ? (float) $item['price'] : 0.00;

            $itemNames[] = $name;
            $quantities[] = $qty;
            $fees[] = $fee;
        }

        Beverage::create([
            'visitor_id'    => $request->visitor_id,
            'item_name'     => json_encode($itemNames),
            'fee'           => json_encode($fees),
            'quantity'      => json_encode($quantities),
            'total_payment' => $request->total_payment,
        ]);

        return redirect()->route('beverages')->with('success', 'Beverage(s) added successfully.');
    }

    public function updateBeverage(Request $request)
    {
        $request->validate([
            'beverage_id' => 'required|exists:beverages,id',
            'visitor_id' => 'required|exists:visitors,id',
            'beverage_items' => 'required|array',
            'beverage_items.*.name' => 'required|string',
            'beverage_items.*.price' => 'required|numeric',
            'beverage_items.*.quantity' => 'required|integer|min:0',
            'total_payment' => 'required|numeric',
        ]);

        $beverage = Beverage::findOrFail($request->beverage_id);

        $items = $request->input('beverage_items');

        $itemNames = [];
        $prices = [];
        $quantities = [];
        $subtotals = [];

        foreach ($items as $item) {
            if ($item['quantity'] > 0) {
                $itemNames[] = $item['name'];
                $prices[] = (float) $item['price'];
                $quantities[] = (int) $item['quantity'];
                $subtotals[] = (float) $item['price'] * (int) $item['quantity'];
            }
        }

        $beverage->update([
            'visitor_id' => $request->input('visitor_id'),
            'item_name' => json_encode($itemNames),
            'fee' => json_encode($prices),
            'quantity' => json_encode($quantities),
            'subtotal' => json_encode($subtotals),
            'total_payment' => $request->input('total_payment'),
        ]);

        return redirect()->route('beverages')->with('success', 'Beverage record updated successfully.');
    }

    public function destroyBeverage($id)
    {
        $beverage = Beverage::findOrFail($id);
        $beverage->delete();
        return redirect()->route('beverages')->with('success', 'Beverage(s) record deleted successfully.');
    }
}
