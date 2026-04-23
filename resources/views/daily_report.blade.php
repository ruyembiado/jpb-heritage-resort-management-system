@extends('layouts.auth')
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div class="d-flex">
            <i class="fa fa-money-bill fa-2x text-dark me-2"></i>
            <div class="d-flex flex-column">
                <h1 class="h3 mb-0 text">BILL INCOME</h1>
                <h6 class="mb-0">Report | Daily Report</h6>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-4">
                <form method="GET" action="{{ route('daily.report') }}" class="d-print-none">
                    <div class="d-flex flex-column align-items-start" style="width: auto;">
                        <label for="date" class="mb-0">Select Date:</label>
                        <input type="date" name="date" value="{{ $date }}"
                            class="form-control form-control-sm" style="width: auto;" onchange="this.form.submit()" />
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
                            <h2 class="mb-0">Daily Report</h2>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="date mb-1 text-start">
                                <p class="m-0">Day: {{ \Carbon\Carbon::parse($date)->format('l') }}</p>
                                <p class="m-0">Date: {{ \Carbon\Carbon::parse($date)->format('F d, Y') }}</p>
                            </div>
                        </td>
                    </tr>
                </table>

                <div class="table-responsive report-table">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th rowspan="2" class="text-center align-middle">NO. OF VISITORS</th>
                                <th colspan="6" class="text-center">SERVICES</th>
                                <th rowspan="2" class="text-center align-middle">TOTAL BILL INCOME</th>
                            </tr>
                            <tr>
                                <th>ENTRANCE FEE</th>
                                <th>COTTAGE FEE</th>
                                <th>FUNCTION HALL</th>
                                <th>ROOM ACCOMMODATION</th>
                                <th>FOODS</th>
                                <th>DRINKS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($report['visitors'] == 0)
                                <tr>
                                    <td colspan="8" class="text-center">No data available for this date.</td>
                                </tr>
                            @else
                                <tr>
                                    <td class="text-center">{{ $report['visitors'] }}</td>
                                    <td class="text-center">₱{{ number_format($report['entrance_fee'], 2) }}</td>
                                    <td class="text-center">₱{{ number_format($report['rental'], 2) }}</td>
                                    <td class="text-center">₱{{ number_format($report['function_hall'], 2) }}</td>
                                    <td class="text-center">₱{{ number_format($report['accommodation'], 2) }}</td>
                                    <td class="text-center">₱{{ number_format($report['meal'], 2) }}</td>
                                    <td class="text-center">₱{{ number_format($report['beverage'], 2) }}</td>
                                    <td class="text-center">₱{{ number_format($report['total'], 2) }}</td>
                                </tr>
                                <tr class="bg-light">
                                    <td colspan="7" class="text-start h6 text-uppercase">Grand Total:</td>
                                    <td class="h6 text-center">₱{{ number_format($report['total'], 2) }}</td>
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
                @if ($report['visitors'] == 0)
                    ["No data available for this date."]
                @else
                    [
                        "{{ $report['visitors'] }}",
                        "₱{{ number_format($report['entrance_fee'], 2) }}",
                        "₱{{ number_format($report['rental'], 2) }}",
                        "₱{{ number_format($report['function_hall'], 2) }}",
                        "₱{{ number_format($report['accommodation'], 2) }}",
                        "₱{{ number_format($report['meal'], 2) }}",
                        "₱{{ number_format($report['beverage'], 2) }}",
                        "₱{{ number_format($report['total'], 2) }}"
                    ],
                    [
                        "Grand Total",
                        "",
                        "",
                        "",
                        "",
                        "",
                        "",
                        "₱{{ number_format($report['total'], 2) }}"
                    ]
                @endif
            ];

            let worksheet = XLSX.utils.aoa_to_sheet([headers, ...data]);
            let workbook = XLSX.utils.book_new();

            XLSX.utils.book_append_sheet(workbook, worksheet, "Daily Report");

            XLSX.writeFile(workbook, "daily_report_{{ $date }}.xlsx");
        }
    </script>
@endsection
