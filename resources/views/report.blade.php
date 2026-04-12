@extends('layouts.auth') <!-- Extend the main layout -->

@section('content')
    <!-- Start the content section -->
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div class="d-flex">
            <i class="fa fa-money-bill fa-2x text-dark me-2"></i>
            <div class="d-flex flex-column">
                <h1 class="h3 mb-0 text">BILL INCOME</h1>
                <h6 class="mb-0">Report | Bill Income</h6>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="card col-5 m-auto shadow mb-4 px-0">
            <div class="card-body">
                <div class="d-flex align-items-center gap-2 justify-content-center">
                    <img src="http://localhost/jpb-heritage/public/img/jbp-icon.jpg" width="70" alt="jbp-logo">
                    <div class="d-flex flex-column">
                        <b class="modal-title mt-2 text-bold">JPB Heritage Inland
                            Resort</b>
                        <span>Progreso Street Illauod, Bugasong, Antique</span>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <form action="{{ route('reportType') }}">
                        <div class="form-group mb-2">
                            <div class="d-flex flex-column align-items-start gap-3">
                                <label>Periodic Report Type:</label>
                                <div class="col-12">
                                    <select name="report_type" class="form-control" id="report_type">
                                        <option value="daily">Daily</option>
                                        <option value="weekly">Weekly</option>
                                        <option value="monthly">Monthly</option>
                                        <option value="yearly">Yearly</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-success bg-theme-primary w-100">View Report</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    {{-- <div class="row">
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
                                <a class="btn btn-sm btn-secondary mt-2" href="{{ route('daily.report') }}">View
                                    Report</a>
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

                                <a class="btn btn-sm btn-secondary mt-2"
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
                                <a class="btn btn-sm btn-secondary mt-2"
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
                                <a class="btn btn-sm btn-secondary mt-2"
                                    href="{{ route('yearly.report', ['year' => now()->year]) }}">View Report</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- Content Row -->
@endsection <!-- End the content section -->
