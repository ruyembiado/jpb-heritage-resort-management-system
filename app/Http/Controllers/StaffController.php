<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Staff;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function index()
    {
        $staffs = Staff::orderBy('id', 'desc')->get();

        return view('staff', compact('staffs'));
    }

    function store(Request $request)
    {
        $validated = $request->validate([
            'staff_id' => 'required|unique:staffs,staff_id',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'email' => 'required|email|unique:staffs,email',
            'gender' => 'required|in:Male,Female',
            'address' => 'required|string',
            'birthdate' => 'required|date',
            'designation' => 'required|string',
            'date_hired' => 'required|date',
            'status' => 'required',
            'date_resigned' => 'nullable|date|after_or_equal:date_hired',
        ]);

        Staff::create($validated);

        return redirect()->back()->with('success', 'Staff added successfully.');
    }

    function update(Request $request)
    {
        $staff = Staff::findOrFail($request->id);
        $request->validate([
            'staff_id' => 'required',
            'first_name' => 'required',
            'middle_name' => 'nullable',
            'last_name' => 'required',
            'contact_number' => 'required',
            'email' => 'required|email',
            'gender' => 'required',
            'address' => 'required',
            'birthdate' => 'required',
            'designation' => 'required',
            'date_hired' => 'required',
            'status' => 'required',
            'date_resigned' => 'nullable',
        ]);

        if ($request->date_resigned === null) {
            $request->merge(['date_resigned' => null]);
        }

        $staff->update($request->all());

        return redirect()->back()->with('success', 'Staff updated successfully.');
    }

    public function destroy($id)
    {
        $staff = Staff::findOrFail($id);
        $staff->delete();
        return redirect()->route('staff')->with('success', 'Staff deleted successfully.');
    }

    public function attendance(Request $request)
    {
        $date = $request->date ?? date('Y-m-d');
        $carbon = Carbon::parse($date);

        $monthName = $carbon->format('F');
        $year = $carbon->year;

        $startMonth = $carbon->copy()->startOfMonth();
        $endMonth = $carbon->copy()->endOfMonth();

        $midMonth = $startMonth->copy()->addDays(14);

        $period1 = "{$monthName} 1 - 15, {$year}";
        $period2 = "{$monthName} 16 - {$carbon->format('t')}, {$year}";

        $dates = collect(CarbonPeriod::create($startMonth, $endMonth))
            ->map(fn($d) => $d->format('Y-m-d'));

        $staffs = Staff::where('status', 'Hired')
            ->with([
                'attendancesMonth' => function ($query) use ($carbon) {
                    $query->whereMonth('date', $carbon->month)
                        ->whereYear('date', $carbon->year);
                },
                'attendanceToday' => function ($query) use ($date) {
                    $query->whereDate('date', $date);
                }
            ])
            ->get();

        return view('attendance', compact(
            'staffs',
            'date',
            'dates',
            'midMonth',
            'period1',
            'period2'
        ));
    }

    public function timeIn(Request $request, $id)
    {
        $validated = $request->validate([
            'time_in' => 'required|date_format:H:i',
            'date' => 'required|date',
        ]);

        Attendance::updateOrCreate(
            [
                'staff_id' => $id,
                'date' => $validated['date'],
            ],
            [
                'time_in' => $validated['time_in'],
            ]
        );

        return back()->with('success', 'Time-in saved.');
    }

    public function timeOut(Request $request, $id)
    {
        $validated = $request->validate([
            'time_out' => 'required|date_format:H:i',
            'date' => 'required|date',
        ]);

        $attendance = Attendance::firstOrCreate(
            [
                'staff_id' => $id,
                'date' => $validated['date'],
            ]
        );

        $attendance->update([
            'time_out' => $validated['time_out'],
        ]);

        return back()->with('success', 'Time-out saved.');
    }
}
