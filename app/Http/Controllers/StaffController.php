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

        $staff->update($request->all());

        return redirect()->back()->with('success', 'Staff updated successfully.');
    }

    public function destroy($id)
    {
        $staff = Staff::findOrFail($id);
        $staff->delete();
        return redirect()->route('staff')->with('success', 'Staff deleted successfully.');
    }
}
