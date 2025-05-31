@extends('layouts.auth')
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0">Weekly Report</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-4">
                <form method="GET" action="{{ route('weekly.report') }}" class="d-print-none">
                    <div class="d-flex gap-2 align-items-center flex-row">
                        <!-- Year Selector -->
                        <div class="d-flex flex-column">
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
                        <div class="d-flex flex-column">
                            <label for="month" class="form-label mb-0">Select Month:</label>
                            <select name="month" id="month" class="form-control form-control-sm"
                                onchange="this.form.submit()">
                                @for ($m = 1; $m <= 12; $m++)
                                    <option value="{{ $m }}"
                                        {{ request('month', $selected_month) == $m ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::createFromDate($selected_year, $m, 1)->format('F') }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <!-- Week Selector -->
                        <div class="d-flex flex-column">
                            <label for="week" class="form-label mb-0">Select Week:</label>
                            <select name="week" id="week" class="form-control form-control-sm"
                                onchange="this.form.submit()">
                                @foreach (range(1, \Carbon\Carbon::createFromDate($selected_year, $selected_month, 1)->endOfMonth()->weekOfMonth) as $week)
                                    <option value="{{ $week }}"
                                        {{ request('week', $selected_week) == $week ? 'selected' : '' }}>
                                        Week {{ $week }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>

                <div class="print-buttons">
                    <button onclick="printReport()" class="btn btn-sm btn-primary d-print-none">
                        <i class="fas fa-print"></i> Print Report
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
                            <h2 class="mb-0">Week {{ $selected_week }} Report for {{ $month_name }}
                                {{ $selected_year }}</h2>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="date mb-1 text-start">
                                <p class="m-0">Year:
                                    {{ \Carbon\Carbon::createFromDate($selected_year, $selected_month, 1)->format('Y') }}
                                </p>
                                <p class="m-0">Month:
                                    {{ \Carbon\Carbon::createFromDate($selected_year, $selected_month, 1)->format('F') }}
                                </p>
                                <p class="m-0">Week:
                                    {{ $selected_week }}
                                </p>
                            </div>
                        </td>
                    </tr>
                </table>

                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Day</th>
                                <th>No. of Visitors</th>
                                <th>Entrance Fee</th>
                                <th>Accommodation</th>
                                <th>Cottage Rental</th>
                                <th>Meals</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($report->isEmpty())
                                <tr>
                                    <td colspan="7" class="text-center">No data available for this week.</td>
                                </tr>
                            @else
                                @foreach ($report as $weekNumber => $weekDays)
                                    @foreach ($weekDays as $dayName => $dayData)
                                        <tr>
                                            <td>{{ $dayName }}</td>
                                            <td>{{ $dayData['visitors'] }}</td>
                                            <td>₱{{ number_format($dayData['entrance_fee'], 2) }}</td>
                                            <td>₱{{ number_format($dayData['accommodation'], 2) }}</td>
                                            <td>₱{{ number_format($dayData['rental'], 2) }}</td>
                                            <td>₱{{ number_format($dayData['meal'], 2) }}</td>
                                            <td>₱{{ number_format($dayData['total'], 2) }}</td>
                                        </tr>
                                    @endforeach
                                @endforeach
                                <tr class="bg-light">
                                    <td class="text-start h6">Grand Total</td>
                                    <td class="h6">{{ $grandTotal['visitors'] }}</td>
                                    <td class="h6">₱{{ number_format($grandTotal['entrance_fee'], 2) }}</td>
                                    <td class="h6">₱{{ number_format($grandTotal['accommodation'], 2) }}</td>
                                    <td class="h6">₱{{ number_format($grandTotal['rental'], 2) }}</td>
                                    <td class="h6">₱{{ number_format($grandTotal['meal'], 2) }}</td>
                                    <td class="h6">₱{{ number_format($grandTotal['total'], 2) }}</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <div class="col-12 d-flex justify-content-end print-footer">
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
                    'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css'
                ],
            });
        }
    </script>
@endsection
