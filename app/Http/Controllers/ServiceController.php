<?php

namespace App\Http\Controllers;

use App\Models\Accommodation;
use App\Models\Beverage;
use App\Models\Companion;
use App\Models\Cottage;
use App\Models\Entrance;
use App\Models\FunctionHall;
use App\Models\Meal;
use App\Models\Service;
use App\Models\Visitor;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::orderBy('created_at', 'desc')->get();

        return view('services_setting', compact('services'));
    }

    public function add_service(Request $request)
    {
        $request->validate([
            'service_name' => 'required|string|max:255',
            'service_category' => 'nullable|string|max:255',
            'service_type' => 'required|string|max:255',
            'food_category' => 'nullable|string|max:255',
            'food_type' => 'nullable|string|max:255',
            'fee' => 'required|numeric|min:0',
        ]);

        Service::create([
            'service_name' => $request->service_name,
            'service_category' => $request->service_category ?? null,
            'service_type' => $request->service_type,
            'food_category' => $request->food_category ?? null,
            'food_type' => $request->food_type ?? null,
            'fee' => $request->fee,
        ]);

        return redirect()->back()->with('success', 'Service added successfully.');
    }

    public function update_service(Request $request, $id)
    {
        $request->validate([
            'service_name' => 'required|string|max:255',
            'service_category' => 'nullable|string|max:255',
            'service_type' => 'required|string|max:255',
            'food_category' => 'nullable|string|max:255',
            'food_type' => 'nullable|string|max:255',
            'fee' => 'required|numeric|min:0',
        ]);

        $service = Service::findOrFail($id);
        $service->update([
            'service_name' => $request->service_name,
            'service_category' => $request->service_category ?? null,
            'service_type' => $request->service_type,
            'food_category' => $request->food_category ?? null,
            'food_type' => $request->service_type == 'foods' ? $request->food_type : ($request->service_type == 'drinks' ? $request->drink_type : null),
            'fee' => $request->fee,
        ]);

        return redirect()->back()->with('success', 'Service updated successfully.');
    }

    public function delete_service($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();
        return redirect()->back()->with('success', 'Service deleted successfully.');
    }

    public function entrances(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $letter = $request->letter;

        $entranceFees = Service::where('service_type', 'entrance_fee')->get();

        // $visitors = Visitor::orderBy('created_at', 'desc')->limit(50)->get();
        $entrances = Entrance::with('visitor', 'companions')
            ->when($start_date, function ($query) use ($start_date) {
                $query->whereDate('created_at', '>=', $start_date);
            })
            ->when($end_date, function ($query) use ($end_date) {
                $query->whereDate('created_at', '<=', $end_date);
            })
            ->when($letter, function ($query) use ($letter) {
                $query->whereHas('visitor', function ($q) use ($letter) {
                    $q->where('first_name', 'like', $letter . '%');
                });
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('entrances', compact('entrances', 'start_date', 'end_date', 'letter', 'entranceFees'));
    }

    public function create_entrance_bill(Request $request)
    {
        $visitor = Visitor::create([
            'first_name' => $request->guest_first_name,
            'middle_name' => $request->guest_middle_name,
            'last_name' => $request->guest_last_name,
            'contact_number' => $request->guest_contact_number,
            'gender' => $request->guest_gender,
            'age' => $request->guest_age,
            'isPWD' => $request->guest_is_pwd ? 1 : 0,
            'address' => $request->guest_address,
            'date_visit' => $request->date_visit,
            'members' => $request->guest_members,
        ]);

        $entrance = Entrance::create([
            'visitor_id' => $visitor->id,
            'status' => $request->payment_status ?? 'unpaid',
            'total_payment' => $request->total_fee,
        ]);

        if ($request->guest_members > 0) {
            foreach ($request->companion_name as $index => $name) {
                Companion::create([
                    'visitor_id' => $visitor->id,
                    'entrance_id' => $entrance->id,
                    'name' => $name,
                    'gender' => $request->companion_gender[$index],
                    'age' => $request->companion_age[$index],
                    'isPWD' => $request->companion_is_pwd[$index] ?? 0,
                    'address' => $request->companion_address[$index],
                    'fee' => $request->companion_fee[$index],
                ]);
            }
        }

        return redirect()->route('entrances')->with('success', 'Visitor and entrance added successfully.');
    }

    public function update_entrance_bill(Request $request)
    {
        $entrance = Entrance::findOrFail($request->entrance_id);

        $visitor = $entrance->visitor;
        $visitor->update([
            'first_name' => $request->edit_guest_first_name,
            'middle_name' => $request->edit_guest_middle_name,
            'last_name' => $request->edit_guest_last_name,
            'contact_number' => $request->edit_guest_contact_number,
            'gender' => $request->edit_guest_gender,
            'age' => $request->edit_guest_age,
            'isPWD' => $request->edit_guest_is_pwd ? 1 : 0,
            'address' => $request->edit_guest_address,
            'date_visit' => $request->edit_date_visit,
            'members' => $request->edit_guest_members,
        ]);

        $entrance->update([
            'status' => $request->edit_payment_status ?? 'Unpaid',
            'total_payment' => $request->edit_total_fee,
        ]);

        Companion::where('entrance_id', $entrance->id)->delete();
        if ($request->edit_guest_members > 0 && $request->has('edit_companion_name')) {
            foreach ($request->edit_companion_name as $index => $name) {
                if (empty($name)) continue;

                Companion::create([
                    'visitor_id' => $visitor->id,
                    'entrance_id' => $entrance->id,
                    'name' => $name,
                    'gender' => $request->edit_companion_gender[$index] ?? 'Male',
                    'age' => $request->edit_companion_age[$index] ?? 0,
                    'isPWD' => isset($request->edit_companion_is_pwd[$index]) ? 1 : 0,
                    'address' => $request->edit_companion_address[$index] ?? '',
                    'fee' => $request->edit_companion_fee[$index] ?? 0,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Visitor and entrance updated successfully.');
    }

    public function delete_visitor_entrance($id)
    {
        $visitor = Visitor::findOrFail($id);
        $visitor->delete();

        return redirect()->route('entrances')->with('success', 'Visitor data deleted successfully.');
    }

    public function accommodations(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $letter = $request->letter;

        $visitors = Visitor::orderBy('created_at', 'desc')->limit(50)->get();
        $accommodations = Accommodation::with('visitor')
            ->when($start_date, function ($query) use ($start_date) {
                $query->whereDate('created_at', '>=', $start_date);
            })
            ->when($end_date, function ($query) use ($end_date) {
                $query->whereDate('created_at', '<=', $end_date);
            })
            ->when($letter, function ($query) use ($letter) {
                $query->whereHas('visitor', function ($q) use ($letter) {
                    $q->where('first_name', 'like', $letter . '%');
                });
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $accommodationFees = Service::where('service_type', 'accommodation')->get();
        $functionFees = Service::where('service_type', 'function_hall')->get();

        return view('accommodations', compact('visitors', 'accommodations', 'accommodationFees', 'functionFees'));
    }

    public function functionhalls(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $letter = $request->letter;

        $visitors = Visitor::orderBy('created_at', 'desc')->limit(50)->get();
        $functionhalls = FunctionHall::with('visitor')
            ->when($start_date, function ($query) use ($start_date) {
                $query->whereDate('created_at', '>=', $start_date);
            })
            ->when($end_date, function ($query) use ($end_date) {
                $query->whereDate('created_at', '<=', $end_date);
            })
            ->when($letter, function ($query) use ($letter) {
                $query->whereHas('visitor', function ($q) use ($letter) {
                    $q->where('first_name', 'like', $letter . '%');
                });
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $accommodationFees = Service::where('service_type', 'accommodation')->get();
        $functionFees = Service::where('service_type', 'function_hall')->get();

        return view('function_halls', compact('visitors', 'functionhalls', 'accommodationFees', 'functionFees'));
    }

    public function storeAccommodationFunctionHall(Request $request)
    {
        $request->validate([
            'visitor_id' => 'required|exists:visitors,id',
            'accommodation_service_names' => 'required|array',
            'accommodation_quantities' => 'required|array',
            'accommodation_fees' => 'required|array',
            'accommodation_total' => 'required|numeric|min:0',
            'accommodation_payment_status' => 'required|in:Paid,Unpaid',
            'functionhall_service_names' => 'required|array',
            'functionhall_quantities' => 'required|array',
            'functionhall_fees' => 'required|array',
            'functionhall_total' => 'required|numeric|min:0',
            'functionhall_payment_status' => 'required|in:Paid,Unpaid',
        ]);

        // Process Accommodation data
        $accommodationTypes = $request->input('accommodation_service_names');
        $accommodationQuantities = $request->input('accommodation_quantities');
        $accommodationFees = $request->input('accommodation_fees');

        $finalAccommodationRooms = [];
        $finalAccommodationQuantities = [];
        $finalAccommodationFees = [];

        foreach ($accommodationTypes as $index => $room) {
            // Handle checkbox values - check if it's checked (value = 1)
            $qty = isset($accommodationQuantities[$index]) && $accommodationQuantities[$index] == 1 ? 1 : 0;

            // Get the fee value
            $fee = isset($accommodationFees[$index]) && is_numeric($accommodationFees[$index])
                ? (float) $accommodationFees[$index]
                : 0.0;

            // Only include if quantity is 1 (checked)
            if ($qty == 1) {
                $finalAccommodationRooms[] = $room;
                $finalAccommodationQuantities[] = $qty;
                $finalAccommodationFees[] = $fee;
            }
        }

        // Process Function Hall data
        $functionHallTypes = $request->input('functionhall_service_names');
        $functionHallQuantities = $request->input('functionhall_quantities');
        $functionHallFees = $request->input('functionhall_fees');

        $finalFunctionHallTypes = [];
        $finalFunctionHallQuantities = [];
        $finalFunctionHallFees = [];

        foreach ($functionHallTypes as $index => $type) {
            // Handle checkbox values - check if it's checked (value = 1)
            $qty = isset($functionHallQuantities[$index]) && $functionHallQuantities[$index] == 1 ? 1 : 0;

            // Get the fee value
            $fee = isset($functionHallFees[$index]) && is_numeric($functionHallFees[$index])
                ? (float) $functionHallFees[$index]
                : 0.0;

            // Only include if quantity is 1 (checked)
            if ($qty == 1) {
                $finalFunctionHallTypes[] = $type;
                $finalFunctionHallQuantities[] = $qty;
                $finalFunctionHallFees[] = $fee;
            }
        }

        // Check if at least one accommodation or function hall is selected
        if (empty($finalAccommodationRooms) && empty($finalFunctionHallTypes)) {
            return redirect()->back()
                ->with('error', 'Please select at least one accommodation or function hall.')
                ->withInput();
        }

        // Store accommodation data if any selected
        if (!empty($finalAccommodationRooms)) {
            Accommodation::create([
                'visitor_id' => $request->visitor_id,
                'room' => json_encode($finalAccommodationRooms),
                'quantity' => json_encode($finalAccommodationQuantities),
                'fee' => json_encode($finalAccommodationFees),
                'status' => $request->accommodation_payment_status,
                'total_payment' => $request->accommodation_total,
            ]);
        }

        // Store function hall data if any selected
        if (!empty($finalFunctionHallTypes)) {
            FunctionHall::create([
                'visitor_id' => $request->visitor_id,
                'function_hall_type' => json_encode($finalFunctionHallTypes),
                'quantity' => json_encode($finalFunctionHallQuantities),
                'fee' => json_encode($finalFunctionHallFees),
                'status' => $request->functionhall_payment_status,
                'total_payment' => $request->functionhall_total,
            ]);
        }

        return redirect()->route('accommodations')->with('success', 'Accommodation and function hall fees added successfully.');
    }

    public function updateAccommodationFunctionHall(Request $request) {}

    public function destroyAccommodation($id)
    {
        $accommodation = Accommodation::findOrFail($id);
        $accommodation->delete();
        return redirect()->route('accommodations')->with('success', 'Accommodation fee deleted successfully.');
    }

    public function destroyFunctionHall($id)
    {
        $functionhall = FunctionHall::findOrFail($id);
        $functionhall->delete();
        return redirect()->route('funcionhalls')->with('success', 'Function hall fee deleted successfully.');
    }

    public function cottages(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $letter = $request->letter;

        $visitors = Visitor::orderBy('created_at', 'desc')->limit(50)->get();
        $cottages = Cottage::with('visitor')
            ->when($start_date, function ($query) use ($start_date) {
                $query->whereDate('created_at', '>=', $start_date);
            })
            ->when($end_date, function ($query) use ($end_date) {
                $query->whereDate('created_at', '<=', $end_date);
            })
            ->when($letter, function ($query) use ($letter) {
                $query->whereHas('visitor', function ($q) use ($letter) {
                    $q->where('first_name', 'like', $letter . '%');
                });
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $cottageFees = Service::where('service_type', 'cottage_fee')->get();

        return view('cottages', compact('visitors', 'cottages', 'cottageFees'));
    }

    public function storeCottage(Request $request)
    {
        $request->validate([
            'visitor_id' => 'required|exists:visitors,id',
            'cottage_area' => 'required',
            'cottage_type' => 'required|array',
            'quantity' => 'required|array',
            'fees' => 'required|array',
            'total_payment' => 'required|numeric|min:0',
            'payment_status' => 'required|in:Paid,Unpaid'
        ]);

        $types = $request->input('cottage_type');
        $quantities = $request->input('quantity');
        $fees = $request->input('fees');

        $finalCottages = [];
        $finalQuantities = [];
        $finalFees = [];

        foreach ($types as $index => $type) {
            // Handle checkbox values - check if it's checked (value = 1)
            $qty = isset($quantities[$index]) && $quantities[$index] == 1 ? 1 : 0;

            // Get the fee value
            $fee = isset($fees[$index]) && is_numeric($fees[$index])
                ? (float) $fees[$index]
                : 0.0;

            // Only include if quantity is 1 (checked)
            if ($qty == 1) {
                $finalCottages[] = $type;
                $finalQuantities[] = $qty;
                $finalFees[] = $fee;
            }
        }

        // If no cottages selected, return error
        if (empty($finalCottages)) {
            return redirect()->back()
                ->with('error', 'Please select at least one cottage.')
                ->withInput();
        }

        Cottage::create([
            'visitor_id' => $request->visitor_id,
            'cottage_area' => $request->cottage_area,
            'cottage_type' => json_encode($finalCottages),
            'quantity' => json_encode($finalQuantities),
            'fee' => json_encode($finalFees),
            'total_payment' => $request->total_payment,
            'status' => $request->payment_status,
        ]);

        return redirect()->route('cottages')->with('success', 'Cottage fee added successfully.');
    }

    public function updateCottage(Request $request)
    {
        $request->validate([
            'cottage_id' => 'required|exists:cottages,id',
            'visitor_id' => 'required|exists:visitors,id',
            'cottage_area' => 'required',
            'cottage_type' => 'required|array',
            'quantity' => 'required|array',
            'fees' => 'required|array',
            'total_payment' => 'required|numeric|min:0',
            'payment_status' => 'required|in:Paid,Unpaid'
        ]);

        $types = $request->input('cottage_type');
        $quantities = $request->input('quantity');
        $fees = $request->input('fees');

        $finalCottages = [];
        $finalQuantities = [];
        $finalFees = [];

        foreach ($types as $index => $type) {
            // Handle checkbox values
            $qty = isset($quantities[$index]) && $quantities[$index] == 1 ? 1 : 0;

            // Get the fee value
            $fee = isset($fees[$index]) && is_numeric($fees[$index])
                ? (float) $fees[$index]
                : 0.0;

            // Only include if quantity is 1 (checked)
            if ($qty == 1) {
                $finalCottages[] = $type;
                $finalQuantities[] = $qty;
                $finalFees[] = $fee;
            }
        }

        // If no cottages selected, return error
        if (empty($finalCottages)) {
            return redirect()->back()
                ->with('error', 'Please select at least one cottage.')
                ->withInput();
        }

        $cottage = Cottage::findOrFail($request->cottage_id);
        $cottage->update([
            'visitor_id' => $request->visitor_id,
            'cottage_area' => $request->cottage_area,
            'cottage_type' => json_encode($finalCottages),
            'quantity' => json_encode($finalQuantities),
            'fee' => json_encode($finalFees),
            'total_payment' => $request->total_payment,
            'status' => $request->payment_status,
        ]);

        return redirect()->route('cottages')->with('success', 'Cottage fee updated successfully.');
    }

    public function destroyCottage($id)
    {
        $cottage = Cottage::findOrFail($id);
        $cottage->delete();
        return redirect()->route('cottages')->with('success', 'Cottage fee deleted successfully.');
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
