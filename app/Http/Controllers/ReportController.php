<?php

namespace App\Http\Controllers;

use App\Models\Entrance;
use App\Models\Visitor;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('report');
    }

    public function dailyReport(Request $request)
    {
        $date = $request->input('date') ?? Carbon::today()->toDateString();
        $visitors = Visitor::with('entrance', 'accommodation', 'cottage', 'meal', 'beverage', 'functionHall')
            ->whereDate('date_visit', $date)
            ->get();

        // Summarize values
        $totalVisitors = 0;
        foreach ($visitors as $visitor) {
            if ($visitor->members) {
                $totalVisitors += (int) $visitor->members;
            }
        }

        $totalEntrance = $visitors->sum(function ($visitor) {
            // Ensure 'entrance' exists and sum total_payment safely
            return $visitor->entrance ? (float) ($visitor->entrance->total_payment ?? 0) : 0;
        });

        $totalAccommodation = $visitors->sum(function ($visitor) {
            return $visitor->accommodation ? (float) ($visitor->accommodation->total_payment ?? 0) : 0;
        });

        $totalFunctionHall = $visitors->sum(function ($visitor) {
            return $visitor->functionHall ? (float) ($visitor->functionHall->total_payment ?? 0) : 0;
        });

        $totalRental = $visitors->sum(function ($visitor) {
            return $visitor->cottage ? (float) ($visitor->cottage->total_payment ?? 0) : 0;
        });

        $totalMeal = $visitors->sum(function ($visitor) {
            return $visitor->meal ? (float) ($visitor->meal->total_payment ?? 0) : 0;
        });

        $totalBeverage = $visitors->sum(function ($visitor) {
            return $visitor->beverage ? (float) ($visitor->beverage->total_payment ?? 0) : 0;
        });

        // Final report
        $report = [
            'visitors' => $totalVisitors,
            'entrance_fee' => $totalEntrance,
            'accommodation' => $totalAccommodation,
            'rental' => $totalRental,
            'meal' => $totalMeal,
            'beverage' => $totalBeverage,
            'function_hall' => $totalFunctionHall,
            'total' => $totalEntrance + $totalAccommodation + $totalRental + $totalMeal + $totalBeverage + $totalFunctionHall,
        ];

        $dayName = Carbon::parse($date)->format('l');

        return view('daily_report', [
            'report' => $report,
            'date' => $date,
            'day' => $dayName,
        ]);
    }

    public function weeklyReport(Request $request)
    {
        $selectedYear = $request->input('year') ?? Carbon::now()->year;
        $selectedMonth = $request->input('month') ?? Carbon::now()->month;
        $selectedWeek = $request->input('week');

        $startDate = Carbon::createFromDate($selectedYear, $selectedMonth, 1)->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();

        $visitors = Visitor::with('entrance', 'accommodation', 'cottage', 'meal', 'beverage', 'functionHall')
            ->whereDate('date_visit', '>=', $startDate)
            ->whereDate('date_visit', '<=', $endDate)
            ->get();

        // Group visitors by week and day
        $report = collect();

        foreach ($visitors as $visitor) {
            $weekNumber = Carbon::parse($visitor->date_visit)->weekOfMonth;
            $dayName = Carbon::parse($visitor->date_visit)->format('l');

            $entrance = $visitor->entrance->total_payment ?? 0;
            $accommodation = $visitor->accommodation->total_payment ?? 0;
            $rental = $visitor->cottage->total_payment ?? 0;
            $meal = $visitor->meal->total_payment ?? 0;
            $beverage = $visitor->beverage->total_payment ?? 0;
            $functionHall = $visitor->functionHall->total_payment ?? 0;

            if (!$report->has($weekNumber)) {
                $report->put($weekNumber, collect());
            }

            $weekData = $report->get($weekNumber);

            if (!$weekData->has($dayName)) {
                $weekData->put($dayName, [
                    'visitors' => 0,
                    'entrance_fee' => 0,
                    'accommodation' => 0,
                    'rental' => 0,
                    'meal' => 0,
                    'beverage' => 0,
                    'functionHall' => 0,
                    'total' => 0,
                ]);
            }

            $dayData = $weekData->get($dayName);

            $dayData['visitors'] += (int) $visitor->members;
            $dayData['entrance_fee'] += (float) $entrance;
            $dayData['accommodation'] += (float) $accommodation;
            $dayData['rental'] += (float) $rental;
            $dayData['meal'] += (float) $meal;
            $dayData['beverage'] += (float) $beverage;
            $dayData['functionHall'] += (float) $functionHall;
            $dayData['total'] = $dayData['entrance_fee'] + $dayData['accommodation'] + $dayData['rental'] + $dayData['meal'] + $dayData['beverage'] + $dayData['functionHall'];

            $weekData->put($dayName, $dayData);
            $report->put($weekNumber, $weekData);
        }

        // Filter to selected week
        if ($selectedWeek) {
            $report = $report->only([$selectedWeek]);
        }

        // Compute weekly totals and grand totals
        $weeklyTotal = $report->map(function ($weekDays) {
            return [
                'visitors' => $weekDays->sum('visitors'),
                'entrance_fee' => $weekDays->sum('entrance_fee'),
                'accommodation' => $weekDays->sum('accommodation'),
                'rental' => $weekDays->sum('rental'),
                'meal' => $weekDays->sum('meal'),
                'beverage' => $weekDays->sum('beverage'),
                'functionHall' => $weekDays->sum('functionHall'),
                'total' => $weekDays->sum('total'),
            ];
        });

        $grandTotal = [
            'visitors' => $weeklyTotal->sum('visitors'),
            'entrance_fee' => $weeklyTotal->sum('entrance_fee'),
            'accommodation' => $weeklyTotal->sum('accommodation'),
            'rental' => $weeklyTotal->sum('rental'),
            'meal' => $weeklyTotal->sum('meal'),
            'beverage' => $weeklyTotal->sum('beverage'),
            'functionHall' => $weeklyTotal->sum('functionHall'),
            'total' => $weeklyTotal->sum('total'),
        ];

        return view('weekly_report', [
            'report' => $report,
            'weeklyTotal' => $weeklyTotal,
            'grandTotal' => $grandTotal,
            'start_date' => $startDate->format('F d, Y'),
            'end_date' => $endDate->format('F d, Y'),
            'selected_year' => $selectedYear,
            'selected_month' => $selectedMonth,
            'selected_week' => $selectedWeek,
            'month_name' => $startDate->format('F'),
        ]);
    }


    public function monthlyReport(Request $request)
    {
        $selectedYear = $request->input('year') ?? Carbon::now()->year;
        $selectedMonth = $request->input('month') ?? Carbon::now()->month;

        $startDate = Carbon::createFromDate($selectedYear, $selectedMonth, 1)->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();

        $visitors = Visitor::with('entrance', 'accommodation', 'cottage', 'meal', 'beverage', 'functionHall')
            ->whereDate('date_visit', '>=', $startDate)
            ->whereDate('date_visit', '<=', $endDate)
            ->get();

        // Initialize monthly totals
        $monthlyData = [
            'visitors' => 0,
            'entrance_fee' => 0,
            'accommodation' => 0,
            'rental' => 0,
            'meal' => 0,
            'beverage' => 0,
            'functionHall' => 0,
            'total' => 0,
        ];

        // Calculate totals for the month
        foreach ($visitors as $visitor) {
            $monthlyData['visitors'] += (int) $visitor->members;
            $monthlyData['entrance_fee'] += (float) ($visitor->entrance->total_payment ?? 0);
            $monthlyData['accommodation'] += (float) ($visitor->accommodation->total_payment ?? 0);
            $monthlyData['rental'] += (float) ($visitor->cottage->total_payment ?? 0);
            $monthlyData['meal'] += (float) ($visitor->meal->total_payment ?? 0);
            $monthlyData['beverage'] += (float) ($visitor->beverage->total_payment ?? 0);
            $monthlyData['functionHall'] += (float) ($visitor->functionHall->total_payment ?? 0);
        }

        $monthlyData['total'] = $monthlyData['entrance_fee'] + $monthlyData['accommodation'] + $monthlyData['rental'] + $monthlyData['meal'] + $monthlyData['beverage'] + $monthlyData['functionHall'];

        // Also group by week for weekly breakdown within the month
        $weeklyBreakdown = $visitors->groupBy(function ($visitor) {
            return Carbon::parse($visitor->date_visit)->weekOfMonth;
        })->map(function ($weekVisitors, $weekNumber) {
            $weekData = [
                'visitors' => 0,
                'entrance_fee' => 0,
                'accommodation' => 0,
                'rental' => 0,
                'meal' => 0,
                'beverage' => 0,
                'functionHall' => 0,
                'total' => 0,
            ];

            foreach ($weekVisitors as $visitor) {
                $weekData['visitors'] += (int) $visitor->members;
                $weekData['entrance_fee'] += (float) ($visitor->entrance->total_payment ?? 0);
                $weekData['accommodation'] += (float) ($visitor->accommodation->total_payment ?? 0);
                $weekData['rental'] += (float) ($visitor->cottage->total_payment ?? 0);
                $weekData['meal'] += (float) ($visitor->meal->total_payment ?? 0);
                $weekData['beverage'] += (float) ($visitor->beverage->total_payment ?? 0);
                $weekData['functionHall'] += (float) ($visitor->functionHall->total_payment ?? 0);
            }

            $weekData['total'] = $weekData['entrance_fee'] + $weekData['accommodation'] + $weekData['rental'] + $weekData['meal'] + $weekData['beverage'] + $weekData['functionHall'];

            return $weekData;
        });

        return view('monthly_report', [
            'monthlyData' => $monthlyData,
            'weeklyBreakdown' => $weeklyBreakdown,
            'selected_year' => $selectedYear,
            'selected_month' => $selectedMonth,
            'month_name' => $startDate->format('F'),
            'start_date' => $startDate->format('F d, Y'),
            'end_date' => $endDate->format('F d, Y'),
        ]);
    }

    public function yearlyReport(Request $request)
    {
        $selectedYear = $request->input('year') ?? Carbon::now()->year;

        $startDate = Carbon::createFromDate($selectedYear, 1, 1)->startOfYear();
        $endDate = $startDate->copy()->endOfYear();

        $visitors = Visitor::with('entrance', 'accommodation', 'cottage', 'meal', 'beverage', 'functionHall')
            ->whereBetween('date_visit', [$startDate, $endDate])
            ->get();

        // Initialize yearly totals
        $yearlyData = [
            'visitors' => 0,
            'entrance_fee' => 0,
            'accommodation' => 0,
            'rental' => 0,
            'meal' => 0,
            'beverage' => 0,
            'functionHall' => 0,
            'total' => 0,
        ];

        // Group by month for monthly breakdown
        $monthlyBreakdown = $visitors->groupBy(function ($visitor) {
            return Carbon::parse($visitor->date_visit)->format('m'); // Group by month number
        })->map(function ($monthVisitors, $monthNumber) {
            $monthData = [
                'visitors' => 0,
                'entrance_fee' => 0,
                'accommodation' => 0,
                'rental' => 0,
                'meal' => 0,
                'beverage' => 0,
                'functionHall' => 0,
                'total' => 0,
                'month_name' => Carbon::create()->month($monthNumber)->format('F')
            ];

            foreach ($monthVisitors as $visitor) {
                $monthData['visitors'] += (int) $visitor->members;
                $monthData['entrance_fee'] += (float) ($visitor->entrance->total_payment ?? 0);
                $monthData['accommodation'] += (float) ($visitor->accommodation->total_payment ?? 0);
                $monthData['rental'] += (float) ($visitor->cottage->total_payment ?? 0);
                $monthData['meal'] += (float) ($visitor->meal->total_payment ?? 0);
                $monthData['beverage'] += (float) ($visitor->beverage->total_payment ?? 0);
                $monthData['functionHall'] += (float) ($visitor->functionHall->total_payment ?? 0);
            }

            $monthData['total'] = $monthData['entrance_fee'] + $monthData['accommodation'] + $monthData['rental'] + $monthData['meal'] + $monthData['beverage']+ $monthData['functionHall'];

            return $monthData;
        });

        // Calculate yearly totals from monthly breakdown
        foreach ($monthlyBreakdown as $monthData) {
            $yearlyData['visitors'] += $monthData['visitors'];
            $yearlyData['entrance_fee'] += $monthData['entrance_fee'];
            $yearlyData['accommodation'] += $monthData['accommodation'];
            $yearlyData['rental'] += $monthData['rental'];
            $yearlyData['meal'] += $monthData['meal'];
            $yearlyData['beverage'] += $monthData['beverage'];
            $yearlyData['functionHall'] += $monthData['functionHall'];
        }
        $yearlyData['total'] = $yearlyData['entrance_fee'] + $yearlyData['accommodation'] + $yearlyData['rental'] + $yearlyData['meal'] + $yearlyData['beverage'] + $yearlyData['functionHall'];

        // Sort monthly breakdown by month number (01-12)
        $monthlyBreakdown = $monthlyBreakdown->sortBy(function ($item, $key) {
            return (int)$key;
        });

        return view('yearly_report', [
            'yearlyData' => $yearlyData,
            'monthlyBreakdown' => $monthlyBreakdown,
            'selected_year' => $selectedYear,
            'year_name' => $selectedYear,
            'start_date' => $startDate->format('F d, Y'),
            'end_date' => $endDate->format('F d, Y'),
        ]);
    }

    public function reportType(Request $request)
    {
        $now = Carbon::now();
        $route = match ($request->report_type) {
            'daily' => route('daily.report', [
                'year' => $now->year,
                'month' => $now->month,
                'day' => $now->day,
            ]),
            'weekly' => route('weekly.report', [
                'year' => $now->year,
                'month' => $now->month,
                'week' => $now->weekOfMonth,
            ]),
            'monthly' => route('monthly.report', [
                'year' => $now->year,
                'month' => $now->month,
            ]),
            'yearly' => route('yearly.report', [
                'year' => $now->year,
            ]),
            default => abort(404, 'Invalid report type'),
        };

        return redirect($route);
    }

    public function guestReport(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        if (!$end_date) {
            $end_date = Carbon::today()->toDateString();
        }

        if (!$start_date) {
            $start_date = $end_date;
        }

        $entrances = Entrance::with('visitor', 'companions')
            ->when($start_date, function ($query) use ($start_date) {
                $query->whereDate('created_at', '>=', $start_date);
            })
            ->when($end_date, function ($query) use ($end_date) {
                $query->whereDate('created_at', '<=', $end_date);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('guest_report', compact('entrances', 'start_date', 'end_date'));
    }
}
