@extends('layouts.auth')
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0">Daily Report</h1>
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
                            <div class="d-flex align-items-center justify-content-center">
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

                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No. of Visitors</th>
                                <th>Entrance Fee</th>
                                <th>Accomodation</th>
                                <th>Cottage Rental</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($report['visitors'] == 0)
                                <tr>
                                    <td colspan="5" class="text-center">No data available for this date.</td>
                                </tr>
                            @else
                                <tr>
                                    <td>{{ $report['visitors'] }}</td>
                                    <td>₱{{ number_format($report['entrance_fee'], 2) }}</td>
                                    <td>₱{{ number_format($report['accomodation'], 2) }}</td>
                                    <td>₱{{ number_format($report['rental'], 2) }}</td>
                                    <td>₱{{ number_format($report['total'], 2) }}</td>
                                </tr>
                                <tr class="bg-light">
                                    <td colspan="4" class="text-start h6">Grand Total:</td>
                                    <td class="h6">₱{{ number_format($report['total'], 2) }}</td>
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
