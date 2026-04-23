@extends('layouts.auth')
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div class="d-flex">
            <i class="fa fa-money-bill fa-2x text-dark me-2"></i>
            <div class="d-flex flex-column">
                <h1 class="h3 mb-0 text">BILL INCOME</h1>
                <h6 class="mb-0">Report | Monthly Report</h6>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-4">
                <form method="GET" action="{{ route('monthly.report') }}" class="d-print-none col-md-3">
                    <div class="row g-2 align-items-center">
                        <div class="d-flex flex-column col-md-6">
                            <label for="year" class="form-label mb-0">Select Year:</label>
                            <select name="year" id="year" class="form-control form-control-sm"
                                onchange="this.form.submit()">
                                @for ($y = date('Y'); $y >= 2024; $y--)
                                    <option value="{{ $y }}"
                                        {{ request('year', $selected_year) == $y ? 'selected' : '' }}>
                                        {{ $y }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <!-- Month Selector -->
                        <div class="d-flex flex-column col-md-6">
                            <label for="month" class="form-label mb-0">Select Month:</label>
                            <select name="month" id="month" class="form-control form-control-sm"
                                onchange="this.form.submit()">
                                @foreach (range(1, 12) as $month)
                                    <option value="{{ $month }}"
                                        {{ request('month', $selected_month) == $month ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::create()->month($month)->format('F') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>

                <div class="print-buttons d-flex gap-1">
                    <button onclick="printReport()" class="btn btn-sm btn-success d-print-none bg-theme-primary">
                        <i class="fas fa-print"></i> Print Report
                    </button>
                    <button onclick="exportExcel()" class="btn btn-sm btn-success d-print-none">
                        <i class="fas fa-file-excel"></i> Export Excel
                    </button>
                </div>
            </div>

            <div id="print-section">
                <table class="report-header m-auto" width="100%" cellspacing="0" cellpadding="0"
                    style="border-collapse: collapse;">
                    <tr>
                        <td style="vertical-align: middle;" class="text-center">
                            <div class="d-flex align-items-center justify-content-center gap-1">
                                <div class="company-logo">
                                    <img src="{{ asset('public/img/jbp-icon.jpg') }}" alt="Company Logo"
                                        style="height: 100px; display: block;" />
                                </div>
                                <div class="company-text">
                                    <h4 class="mb-0">JPB Oasis: Heritage Inland Resort</h4>
                                    <p class="mb-0">Progreso Street Illauod, Bugasong, Antique</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center">
                            <h2 class="mb-0">{{ $month_name }} {{ $selected_year }} Report</h2>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="date mb-1 text-start">
                                <p class="m-0">Month: {{ \Carbon\Carbon::parse($start_date)->format('F Y') }}</p>
                                <p class="m-0">Year: {{ $selected_year }}</p>
                            </div>
                        </td>
                    </tr>
                </table>

                <div class="table-responsive report-table">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead class="">
                            <tr>
                                <th class="text-center align-middle" rowspan="2">WEEK</th>
                                <th class="text-center align-middle" rowspan="2">NO. OF VISITORS</th>
                                <th class="text-center text-center" colspan="6">SERVICES</th>
                                <th class="text-center align-middle" rowspan="2">TOTAL BILL INCOME</th>
                            </tr>
                            <tr>
                                <th class="text-center">ENTRANCE FEE</th>
                                <th class="text-center">COTTAGE FEE</th>
                                <th class="text-center">FUNCTION HALL</th>
                                <th class="text-center">ROOM ACCOMMODATION</th>
                                <th class="text-center">FOODS</th>
                                <th class="text-center">DRINKS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($weeklyBreakdown->isEmpty())
                                <tr>
                                    <td colspan="9" class="text-center">No data available for this month.</td>
                                </tr>
                            @else
                                @foreach ($weeklyBreakdown as $weekNumber => $weekData)
                                    <tr>
                                        <td class="text-center">Week {{ $weekNumber }}</td>
                                        <td class="text-center">{{ $weekData['visitors'] }}</td>
                                        <td class="text-center">₱{{ number_format($weekData['entrance_fee'], 2) }}</td>
                                        <td class="text-center">₱{{ number_format($weekData['rental'], 2) }}</td>
                                        <td class="text-center">₱{{ number_format($weekData['functionHall'], 2) }}</td>
                                        <td class="text-center">₱{{ number_format($weekData['accommodation'], 2) }}</td>
                                        <td class="text-center">₱{{ number_format($weekData['meal'], 2) }}</td>
                                        <td class="text-center">₱{{ number_format($weekData['beverage'], 2) }}</td>
                                        <td class="text-center">₱{{ number_format($weekData['total'], 2) }}</td>
                                    </tr>
                                @endforeach
                                <tr class="">
                                    <td class="h6 text-center text-uppercase">Grand Total</td>
                                    <td class="h6 text-center">{{ $weeklyBreakdown->sum('visitors') }}</td>
                                    <td class="h6 text-center">
                                        ₱{{ number_format($weeklyBreakdown->sum('entrance_fee'), 2) }}</td>
                                    <td class="h6 text-center">₱{{ number_format($weeklyBreakdown->sum('rental'), 2) }}
                                    </td>
                                    <td class="h6 text-center">
                                        ₱{{ number_format($weeklyBreakdown->sum('functionHall'), 2) }}</td>
                                    <td class="h6 text-center">
                                        ₱{{ number_format($weeklyBreakdown->sum('accommodation'), 2) }}</td>
                                    <td class="h6 text-center">₱{{ number_format($weeklyBreakdown->sum('meal'), 2) }}</td>
                                    <td class="h6 text-center">₱{{ number_format($weeklyBreakdown->sum('beverage'), 2) }}
                                    </td>
                                    <td class="h6 text-center">₱{{ number_format($weeklyBreakdown->sum('total'), 2) }}</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <div class="col-12 d-flex justify-content-end print-footer mt-4">
                    <div class="d-flex flex-column justify-content-end align-items-center">
                        <strong>JOEL P. BARCELO</strong>
                        <span>JPB Oasis: Inland Resort Owner</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function printReport() {
            printJS({
                printable: 'print-section',
                type: 'html',
                css: [
                    '{{ asset('public/css/styles.css') }}',
                    '{{ asset('public/css/bootstrap.min.css') }}'
                ],
                style: `
                    .report-table table td, .report-table table th {
                        border: 1px solid #000;
                    }
                `
            });
        }

        function exportExcel() {
            let headers = [
                "Week",
                "No. of Visitors",
                "Entrance Fee",
                "Cottage Fee",
                "Function Hall",
                "Room Accommodation",
                "Foods",
                "Drinks",
                "Total Bill Income"
            ];

            let data = [
                @if ($weeklyBreakdown->isEmpty())
                    ["No data available for this month."]
                @else
                    @foreach ($weeklyBreakdown as $weekNumber => $weekData)
                        [
                            "Week {{ $weekNumber }}",
                            "{{ $weekData['visitors'] }}",
                            "₱{{ number_format($weekData['entrance_fee'], 2) }}",
                            "₱{{ number_format($weekData['rental'], 2) }}",
                            "₱{{ number_format($weekData['functionHall'], 2) }}",
                            "₱{{ number_format($weekData['accommodation'], 2) }}",
                            "₱{{ number_format($weekData['meal'], 2) }}",
                            "₱{{ number_format($weekData['beverage'], 2) }}",
                            "₱{{ number_format($weekData['total'], 2) }}"
                        ],
                    @endforeach

                    [
                        "Grand Total",
                        "{{ $weeklyBreakdown->sum('visitors') }}",
                        "₱{{ number_format($weeklyBreakdown->sum('entrance_fee'), 2) }}",
                        "₱{{ number_format($weeklyBreakdown->sum('rental'), 2) }}",
                        "₱{{ number_format($weeklyBreakdown->sum('functionHall'), 2) }}",
                        "₱{{ number_format($weeklyBreakdown->sum('accommodation'), 2) }}",
                        "₱{{ number_format($weeklyBreakdown->sum('meal'), 2) }}",
                        "₱{{ number_format($weeklyBreakdown->sum('beverage'), 2) }}",
                        "₱{{ number_format($weeklyBreakdown->sum('total'), 2) }}"
                    ]
                @endif
            ];

            let worksheet = XLSX.utils.aoa_to_sheet([headers, ...data]);
            let workbook = XLSX.utils.book_new();

            XLSX.utils.book_append_sheet(workbook, worksheet, "Monthly Report");

            XLSX.writeFile(
                workbook,
                "monthly_report_{{ $month_name }}_{{ $selected_year }}.xlsx"
            );
        }
    </script>
@endsection
