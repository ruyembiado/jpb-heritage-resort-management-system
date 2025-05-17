@extends('layouts.auth') <!-- Extend the main layout -->

@section('content')
    <!-- Start the content section -->
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0">Reports</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <div class="d-flex h-100 flex-column justify-content-center">
                        <div class="row align-items-center justify-content-between">
                            <div class="col mr-2 text-center">
                                <div class="col-auto">
                                    <i class="fa fa-book fa-5x text-dark"></i>
                                </div>
                                <div class="text-dark text-uppercase mb-1 mt-3">
                                    <strong>Daily Report</strong>
                                </div>
                                <a class="btn btn-sm btn-primary mt-2" href="{{ route('daily.report') }}">View Report</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <div class="d-flex h-100 flex-column justify-content-center">
                        <div class="row align-items-center justify-content-between">
                            <div class="col mr-2 text-center">
                                <div class="col-auto">
                                    <i class="fa fa-book fa-5x text-dark"></i>
                                </div>
                                <div class="text-dark text-uppercase mb-1 mt-3">
                                    <strong>Weekly Report</strong>
                                </div>

                                @php
                                    $currentYear = now()->year;
                                    $currentMonth = now()->month;
                                    // Get the start of the current month
                                    $startOfMonth = now()->startOfMonth();
                                    // Get the current date's ISO week number relative to the start of the month
                                    $currentWeek = now()->diffInWeeks($startOfMonth) + 1; // Add 1 to ensure the week starts at 1
                                @endphp

                                <a class="btn btn-sm btn-primary mt-2"
                                    href="{{ route('weekly.report', ['year' => $currentYear, 'month' => $currentMonth, 'week' => $currentWeek]) }}">
                                    View Report
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <div class="d-flex h-100 flex-column justify-content-center">
                        <div class="row align-items-center justify-content-between">
                            <div class="col mr-2 text-center">
                                <div class="col-auto">
                                    <i class="fa fa-book fa-5x text-dark"></i>
                                </div>
                                <div class="text-dark text-uppercase mb-1 mt-3">
                                    <strong>Monthly Report</strong>
                                </div>
                                <a class="btn btn-sm btn-primary mt-2"
                                    href="{{ route('monthly.report', ['year' => now()->year, 'month' => now()->month]) }}">
                                    View Report
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <div class="d-flex h-100 flex-column justify-content-center">
                        <div class="row align-items-center justify-content-between">
                            <div class="col mr-2 text-center">
                                <div class="col-auto">
                                    <i class="fa fa-book fa-5x text-dark"></i>
                                </div>
                                <div class="text-dark text-uppercase mb-1 mt-3">
                                    <strong>Yearly Report</strong>
                                </div>
                                <a class="btn btn-sm btn-primary mt-2"
                                    href="{{ route('yearly.report', ['year' => now()->year]) }}">View Report</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Content Row -->
@endsection <!-- End the content section -->
