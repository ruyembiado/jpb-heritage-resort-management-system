@extends('layouts.auth') <!-- Extend the main layout -->

@section('content')
    <!-- Start the content section -->
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div class="d-flex">
            <i class="fa fa-address-book fa-2x text-dark me-2"></i>
            <div class="d-flex flex-column">
                <h1 class="h3 mb-0 text">LIST OF GUEST</h1>
                <h6 class="mb-0">Report | Guest Report</h6>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3 bg-theme-primary p-4">
                <!-- Date Filter -->
                <form method="GET" action="" id="dateRangeForm">
                    <div class="d-flex justify-content-center gap-2 align-items-center">
                        <div class="d-flex align-items-start flex-column">
                            <label class="mb-0 me-0 p-1 bg-theme-primary text-light">Select Date:</label>
                            <input type="date" name="start_date" value="{{ request('start_date') }}"
                                class="form-control form-control-sm rounded-0"
                                onchange="document.getElementById('dateRangeForm').submit();">
                        </div>
                    </div>
                </form>

                <div class="print-buttons d-flex gap-1">
                    <button onclick="printReport()" class="btn btn-sm btn-secondary d-print-none text-light">
                        <i class="fas fa-print"></i> Print Report
                    </button>
                    <button onclick="exportExcel()" class="btn btn-sm bg-green-tertiary text-light d-print-none">
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
                            <h2 class="mb-0 mt-2">LIST OF GUEST AS OF
                                {{ \Carbon\Carbon::parse($end_date)->format('F d, Y') }}
                            </h2>
                        </td>
                    </tr>
                </table>

                <div class="table-responsive mt-3">
                    <table class="table table-bordered" id="" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="text-center bg-theme-primary text-light">NO.</th>
                                <th class="text-center bg-theme-primary text-light">NAME OF GUEST</th>
                                <th class="text-center bg-theme-primary text-light">SEX</th>
                                <th class="text-center bg-theme-primary text-light">AGE</th>
                                <th class="text-center bg-theme-primary text-light">MEMBERS</th>
                                <th class="text-center bg-theme-primary text-light">ADDRESS</th>
                                <th class="text-center bg-theme-primary text-light">CONTACT NO.</th>
                                <th class="text-center bg-theme-primary text-light">CHECK-IN</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($entrances->isEmpty())
                                <tr>
                                    <td colspan="8" class="text-center">No data available for this date.</td>
                                </tr>
                            @else
                                @foreach ($entrances as $entrance)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">
                                            {{ $entrance->visitor?->first_name ?? '' }}
                                            {{ $entrance->visitor?->middle_name ?? '' }}
                                            {{ $entrance->visitor?->last_name ?? '' }}
                                        </td>
                                        <td class="text-center">{{ $entrance->visitor->gender }}</td>
                                        <td class="text-center">{{ $entrance->visitor->age }}</td>
                                        <td class="text-center px-0 pb-0">
                                            {{ $entrance->visitor->members ?? 0 }}
                                            @if (!empty($entrance->companions))
                                                <table class="table table-bordered border-none mt-2 mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-light bg-green-secondary text-center">No.</th>
                                                            <th class="text-light bg-green-secondary text-center">Name</th>
                                                            <th class="text-light bg-green-secondary text-center">Category
                                                            </th>
                                                            <th class="text-light bg-green-secondary text-center">Sex</th>
                                                            <th class="text-light bg-green-secondary text-center">Age</th>
                                                            <th class="text-light bg-green-secondary text-center">Address
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if ($entrance->companions->isNotEmpty())
                                                            @foreach ($entrance->companions as $index => $companion)
                                                                <tr>
                                                                    <td class="text-center">{{ $index + 1 }}</td>
                                                                    <td class="text-center">{{ $companion->name }}</td>
                                                                    <td class="text-center">
                                                                        @if ($companion->age <= 15)
                                                                            Child
                                                                        @elseif ($companion->isPWD)
                                                                            PWD
                                                                        @else
                                                                            Adult
                                                                        @endif
                                                                    </td>
                                                                    <td class="text-center">{{ $companion->gender }}</td>
                                                                    <td class="text-center">{{ $companion->age }}</td>
                                                                    <td class="text-center">{{ $companion->address }}</td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr>
                                                                <td colspan="6" class="text-center text-muted">No
                                                                    companions</td>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            @else
                                                <span class="text-muted">No companions</span>
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $entrance->visitor->address }}</td>
                                        <td class="text-center">{{ $entrance->visitor->contact_number }}</td>
                                        <td class="text-center">
                                            {{ \Carbon\Carbon::parse($entrance->visitor->created_at)->format('h:i A') }}
                                        </td>
                                    </tr>
                                    @php
                                        $totalVisitors = $entrances->sum(fn($e) => ($e->visitor->members ?? 0) + 1);
                                    @endphp
                                    <tr class="bg-light">
                                        <td colspan="4" class="text-center fw-bold">GRAND TOTAL</td>
                                        <td class="text-center fw-bold">{{ $totalVisitors }}</td>
                                        <td colspan="4"></td>
                                    </tr>
                                @endforeach
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
            });
        }

        function exportExcel() {
            let headers = [
                "No.",
                "Name of Guest",
                "Sex",
                "Age",
                "Members",
                "Companions (Name | Category | Sex | Age | Address)",
                "Address",
                "Contact No.",
                "Check-in"
            ];

            let data = [
                @if ($entrances->isEmpty())
                    ["No data available for this date."]
                @else
                    @foreach ($entrances as $index => $entrance)
                        [
                            "{{ $index + 1 }}",
                            "{{ $entrance->visitor?->first_name ?? '' }} {{ $entrance->visitor?->middle_name ?? '' }} {{ $entrance->visitor?->last_name ?? '' }}",
                            "{{ $entrance->visitor->gender }}",
                            "{{ $entrance->visitor->age }}",
                            "{{ $entrance->visitor->members ?? 0 }}",

                            `{{ $entrance->companions->map(function ($c) {
                                    return $c->name .
                                        ' | ' .
                                        ($c->age <= 15 ? 'Child' : ($c->isPWD ? 'PWD' : 'Adult')) .
                                        ' | ' .
                                        $c->gender .
                                        ' | ' .
                                        $c->age .
                                        ' | ' .
                                        $c->address;
                                })->implode('\n') }}`,

                            "{{ $entrance->visitor->address }}",
                            "{{ $entrance->visitor->contact_number }}",
                            "{{ \Carbon\Carbon::parse($entrance->visitor->created_at)->format('h:i A') }}"
                        ],
                    @endforeach
                @endif
            ];

            let worksheet = XLSX.utils.aoa_to_sheet([headers, ...data]);
            let workbook = XLSX.utils.book_new();

            XLSX.utils.book_append_sheet(workbook, worksheet, "Guest Report");

            XLSX.writeFile(
                workbook,
                "guest_report_{{ $start_date }}_to_{{ $end_date }}.xlsx"
            );
        }
    </script>
    <!-- Content Row -->
@endsection <!-- End the content section -->
