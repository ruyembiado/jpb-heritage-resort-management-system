<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Visitor;
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
        $visitors = Visitor::with('entrance')
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

        // Placeholder for accommodation and rental totals
        $totalAccomodation = 0;
        $totalRental = 0;

        // Final report
        $report = [
            'visitors' => $totalVisitors,
            'entrance_fee' => $totalEntrance,
            'accomodation' => $totalAccomodation,
            'rental' => $totalRental,
            'total' => $totalEntrance + $totalAccomodation + $totalRental,
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
        $selectedWeek = $request->input('week'); // optional filtering

        $startDate = Carbon::createFromDate($selectedYear, $selectedMonth, 1)->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();

        $visitors = Visitor::with('entrance')
            ->whereBetween('date_visit', [$startDate, $endDate])
            ->get();

        // Group visitors by week and day
        $report = collect();

        foreach ($visitors as $visitor) {
            $weekNumber = Carbon::parse($visitor->date_visit)->weekOfMonth;
            $dayName = Carbon::parse($visitor->date_visit)->format('l');

            $entrance = $visitor->entrance->total_payment ?? 0;

            if (!$report->has($weekNumber)) {
                $report->put($weekNumber, collect());
            }

            $weekData = $report->get($weekNumber);

            if (!$weekData->has($dayName)) {
                $weekData->put($dayName, [
                    'visitors' => 0,
                    'entrance_fee' => 0,
                    'accomodation' => 0,
                    'rental' => 0,
                    'total' => 0,
                ]);
            }

            $dayData = $weekData->get($dayName);

            $dayData['visitors'] += (int) $visitor->members;
            $dayData['entrance_fee'] += (float) $entrance;
            // If you later include accommodation and rental relationships, update these:
            $dayData['accomodation'] += 0;
            $dayData['rental'] += 0;
            $dayData['total'] = $dayData['entrance_fee'] + $dayData['accomodation'] + $dayData['rental'];

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
                'accomodation' => $weekDays->sum('accomodation'),
                'rental' => $weekDays->sum('rental'),
                'total' => $weekDays->sum('total'),
            ];
        });

        $grandTotal = [
            'visitors' => $weeklyTotal->sum('visitors'),
            'entrance_fee' => $weeklyTotal->sum('entrance_fee'),
            'accomodation' => $weeklyTotal->sum('accomodation'),
            'rental' => $weeklyTotal->sum('rental'),
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

        $orders = Visitor::with(['items.product', 'user'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'Accepted')
            ->orWhere('status', 'Delivered')
            ->get();

        $report = $orders->groupBy(function ($order) {
            return Carbon::parse($order->created_at)->format('W'); // Group by week number
        })->map(function ($weekOrders, $weekNumber) {
            $products = [];
            $totalQuantity = 0;
            $totalAmount = 0;

            foreach ($weekOrders as $order) {
                foreach ($order->items as $item) {
                    $products[$item->product->product_name] = true;
                    $totalQuantity += $item->quantity;
                    $totalAmount += $item->quantity * $item->price;
                }
            }

            return [
                'week_number' => $weekNumber,
                'products' => implode(', ', array_keys($products)),
                'quantity' => $totalQuantity,
                'total' => $totalAmount,
            ];
        });

        return view('admin.monthly_report', [
            'report' => $report,
            'selected_year' => $selectedYear,
            'selected_month' => $selectedMonth,
            'month_name' => Carbon::createFromDate($selectedYear, $selectedMonth, 1)->format('F'),
            'start_date' => $startDate->format('F d, Y'),
            'end_date' => $endDate->format('F d, Y'),
        ]);
    }

    public function yearlyReport(Request $request)
    {
        $selectedYear = $request->input('year') ?? Carbon::now()->year;

        $startDate = Carbon::createFromDate($selectedYear, 1, 1)->startOfYear();
        $endDate = $startDate->copy()->endOfYear();

        $orders = Visitor::with(['items.product', 'user'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'Accepted')
            ->orWhere('status', 'Delivered')
            ->get();

        $report = $orders->groupBy(function ($order) {
            return Carbon::parse($order->created_at)->format('m'); // Group by month
        })->map(function ($monthOrders, $monthNumber) {
            $products = [];
            $totalQuantity = 0;
            $totalAmount = 0;

            foreach ($monthOrders as $order) {
                foreach ($order->items as $item) {
                    $products[$item->product->product_name] = true;
                    $totalQuantity += $item->quantity;
                    $totalAmount += $item->quantity * $item->price;
                }
            }

            return [
                'month_number' => $monthNumber,
                'products' => implode(', ', array_keys($products)),
                'quantity' => $totalQuantity,
                'total' => $totalAmount,
            ];
        });

        return view('admin.yearly_report', [
            'report' => $report,
            'selected_year' => $selectedYear,
            'year_name' => $selectedYear,
            'start_date' => $startDate->format('F d, Y'),
            'end_date' => $endDate->format('F d, Y'),
        ]);
    }
}
