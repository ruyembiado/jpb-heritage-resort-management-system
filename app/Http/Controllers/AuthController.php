<?php

namespace App\Http\Controllers;

use App\Models\Entrance;
use App\Models\Service;
use App\Models\Visitor;
use Carbon\Carbon;
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

        return back()->withErrors(['error' => 'The provided credentials do not match our records.']);
    }

    public function dashboard(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $letter = $request->letter;

        $selectedYear = $request->year ?? Carbon::now()->year;

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

        $today = Carbon::today();
        $startOfWeek = Carbon::now()->startOfWeek();
        $startOfMonth = Carbon::now()->startOfMonth();
        $startOfYear = Carbon::now()->startOfYear();
        // $currentYear = Carbon::now()->year;

        $visitorsToday = Visitor::whereDate('created_at', $today)->count();
        $visitorsThisWeek = Visitor::where('created_at', '>=', $startOfWeek)->count();
        $visitorsThisMonth = Visitor::where('created_at', '>=', $startOfMonth)->count();
        $visitorsThisYear = Visitor::where('created_at', '>=', $startOfYear)->count();

        // Visitors table
        $visitorsMonth = Visitor::where('created_at', '>=', $startOfMonth)
            ->orderBy('created_at', 'desc')
            ->get();

        $visitorsWithUnpaidBills = $visitorsMonth->filter(function ($visitor) {
            $services = [
                $visitor->entrance,
                $visitor->accommodation,
                $visitor->cottage,
                $visitor->meal,
                $visitor->beverage
            ];

            foreach ($services as $service) {
                if ($service && isset($service->status) && $service->status !== 'Paid') {
                    return true; 
                }
            }

            return false; 
        });

        /*
    |--------------------------------------------------------------------------
    | BILL COMPUTATION
    |--------------------------------------------------------------------------
    */

        $totalBills = 0; // amount
        $paidBills = 0; // count
        $unpaidBills = 0; // count

        $visitorsForBills = Visitor::with([
            'entrance',
            'accommodation',
            'cottage',
            'meal',
            'beverage',
            'functionHall'
        ])->get();

        foreach ($visitorsForBills as $visitor) {

            $services = [
                $visitor->entrance,
                $visitor->accommodation,
                $visitor->cottage,
                $visitor->meal,
                $visitor->beverage,
                $visitor->functionHall,
            ];

            foreach ($services as $service) {

                if ($service) {

                    // TOTAL AMOUNT
                    $totalBills += $service->total_payment ?? 0;

                    // COUNT STATUS
                    if ($service->status === 'Paid') {
                        $paidBills++;
                    } else {
                        $unpaidBills++;
                    }
                }
            }
        }

        /*
    |--------------------------------------------------------------------------
    | CHART DATA
    |--------------------------------------------------------------------------
    */

        $monthlyVisitors = Visitor::query()
            ->selectRaw('strftime("%m", created_at) as month, count(*) as total')
            ->whereYear('created_at', $selectedYear)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $visitorsPerMonth = array_fill(0, 12, 0);

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

        $entranceFees = Service::where('service_type', 'entrance_fee')->get();

        return view('dashboard', [
            'visitorsToday' => $visitorsToday,
            'visitorsThisWeek' => $visitorsThisWeek,
            'visitorsThisMonth' => $visitorsThisMonth,
            'visitorsThisYear' => $visitorsThisYear,

            'totalBills' => $totalBills,
            'paidBills' => $paidBills,
            'unpaidBills' => $unpaidBills,

            'visitors' => $visitorsMonth,
            'visitorsPerMonth' => $visitorsPerMonth,
            'months' => $months,

            'entrances' => $entrances,
            'selectedYear' => $selectedYear,
            'visitorsWithUnpaidBills' => $visitorsWithUnpaidBills,
            'entranceFees' => $entranceFees
        ]);
    }

    public function logout()
    {
        auth()->logout();
        return redirect('/')->with('success', 'Logout successful');
    }
}
