@extends('layouts.auth') <!-- Extend the main layout -->

@section('content')
    <!-- Start the content section -->
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div class="d-flex">
            <i class="fa fa-file fa-2x text-dark me-2"></i>
            <div class="d-flex flex-column">
                <h1 class="h3 mb-0 text">LIST OF GUEST</h1>
                <h6 class="mb-0">Report | Guest Report</h6>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <!-- Date Filter -->
                <form method="GET" action="" id="dateRangeForm">
                    <div class="d-flex justify-content-center gap-2 align-items-center">
                        <div class="d-flex align-items-center">
                            <label class="mb-0 me-0 p-1 bg-theme-primary text-light">From:</label>
                            <input type="date" name="start_date" value="{{ request('start_date') }}"
                                class="form-control form-control-sm rounded-0"
                                onchange="document.getElementById('dateRangeForm').submit();">
                        </div>

                        <div class="d-flex align-items-center">
                            <label class="mb-0 me-0 p-1 bg-theme-primary text-light">To:</label>
                            <input type="date" name="end_date" value="{{ request('end_date') }}"
                                class="form-control form-control-sm rounded-0"
                                onchange="document.getElementById('dateRangeForm').submit();">
                        </div>
                    </div>
                </form>
                <div class="print-buttons">
                    <button onclick="printReport()" class="btn btn-sm btn-success d-print-none bg-theme-primary">
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
                            <h2 class="mb-0 mt-2">LIST OF GUEST AS OF {{ \Carbon\Carbon::parse($end_date)->format('F d, Y') }}
                            </h2>
                        </td>
                    </tr>
                </table>

                <div class="table-responsive mt-3">
                    <table class="table table-bordered" id="" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="text-dark text-center">NO.</th>
                                <th class="text-dark text-center">NAME OF GUEST</th>
                                <th class="text-dark text-center">SEX</th>
                                <th class="text-dark text-center">AGE</th>
                                <th class="text-dark text-center">MEMBERS</th>
                                <th class="text-dark text-center">ADDRESS</th>
                                <th class="text-dark text-center">CONTACT NO.</th>
                                <th class="text-dark text-center">CHECK-IN</th>
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
                                                            <th class="text-dark text-center">No.</th>
                                                            <th class="text-dark text-center">Name</th>
                                                            <th class="text-dark text-center">Category</th>
                                                            <th class="text-dark text-center">Sex</th>
                                                            <th class="text-dark text-center">Age</th>
                                                            <th class="text-dark text-center">Address</th>
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
                                        <td class="text-center">{{ \Carbon\Carbon::parse($entrance->visitor->created_at)->format('h:i A') }}
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
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
    </script>
    <!-- Content Row -->
@endsection <!-- End the content section -->
