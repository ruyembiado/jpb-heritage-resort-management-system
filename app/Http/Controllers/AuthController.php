<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            return redirect('/dashboard');
        }

        return view('welcome');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');
        if (auth()->attempt($credentials)) {
            return redirect('/dashboard')->with('success', 'Login successful');
        }

        return back()
            ->withErrors(['error' => 'The provided credentials do not match our records.'])
            ->withInput($request->only('email'));
    }

    public function dashboard()
    {
        $today = Carbon::today();
        $startOfWeek = Carbon::now()->startOfWeek();
        $startOfMonth = Carbon::now()->startOfMonth();
        $startOfYear = Carbon::now()->startOfYear();
        $currentYear = Carbon::now()->year;

        $visitorsToday = Visitor::whereDate('created_at', $today)->count();
        $visitorsThisWeek = Visitor::where('created_at', '>=', $startOfWeek)->count();
        $visitorsThisMonth = Visitor::where('created_at', '>=', $startOfMonth)->count();
        $visitorsThisYear = Visitor::where('created_at', '>=', $startOfYear)->count();

        // Get all Visitors for Visitor table this month
        $visitorsMonth = Visitor::where('created_at', '>=', $startOfMonth)
            ->orderBy('created_at', 'desc')
            ->get();

        // Chart: Monthly Visitors
        $monthlyVisitors = Visitor::query()
            ->selectRaw('strftime("%m", created_at) as month, count(*) as total')
            ->whereYear('created_at', $currentYear)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Initialize all months with 0 counts
        $visitorsPerMonth = array_fill(0, 12, 0);

        // Fill in actual counts
        foreach ($monthlyVisitors as $row) {
            $monthIndex = (int)$row->month - 1; 
            $visitorsPerMonth[$monthIndex] = $row->total;
        }

        $months = [
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July',
            'August',
            'September',
            'October',
            'November',
            'December'
        ];

        return view('dashboard', [
            'visitorsToday' => $visitorsToday,
            'visitorsThisWeek' => $visitorsThisWeek,
            'visitorsThisMonth' => $visitorsThisMonth,
            'visitorsThisYear' => $visitorsThisYear,
            'visitors' => $visitorsMonth,
            'visitorsPerMonth' => $visitorsPerMonth,
            'months' => $months,
        ]);
    }

    public function logout()
    {
        auth()->logout();
        return redirect('/')->with('success', 'Logout successful');
    }
}
