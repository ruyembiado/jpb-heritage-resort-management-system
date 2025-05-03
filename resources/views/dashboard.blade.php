@extends('layouts.auth') <!-- Extend the main layout -->

@section('content')
    <!-- Start the content section -->
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text">Dashboard</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <div class="d-flex h-100 flex-column justify-content-between">
                        <div class="row align-items-center justify-content-between">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                                    Visitors | Today</div>
                                <div class="h3 mb-0 font-weight-bold text-primary">{{ $visitorsToday }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fa fa-users fa-2x text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <div class="d-flex h-100 flex-column justify-content-between">
                        <div class="row align-items-center justify-content-between">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                                    Visitors | This Week</div>
                                <div class="h3 mb-0 font-weight-bold text-primary">{{ $visitorsThisWeek }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fa fa-users fa-2x text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <div class="d-flex h-100 flex-column justify-content-between">
                        <div class="row align-items-center justify-content-between">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                                    Visitors | This Month</div>
                                <div class="h3 mb-0 font-weight-bold text-primary">{{ $visitorsThisMonth }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fa fa-users fa-2x text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <div class="d-flex h-100 flex-column justify-content-between">
                        <div class="row align-items-center justify-content-between">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                                    Visitors | This Year</div>
                                <div class="h3 mb-0 font-weight-bold text-primary">{{ $visitorsThisYear }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fa fa-users fa-2x text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 mb-4">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <div class="d-flex h-100 flex-column justify-content-between">
                        <div class="row align-items-center justify-content-between">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                                    Visitors | This Month</div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Name</th>
                                            <th>Gender</th>
                                            <th>Age</th>
                                            <th class="text-start">Members</th>
                                            <th class="text-start">Contact No.</th>
                                            <th>Address</th>
                                            <th>Date</th>
                                            {{-- <th>Date Created</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($visitors as $visitor)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $visitor->first_name . ' ' . $visitor->middle_name . ' ' . $visitor->last_name }}
                                                </td>
                                                <td class="text-start">{{ $visitor->gender }}</td>
                                                <td class="text-start">{{ $visitor->age }}</td>
                                                <td class="text-start">{{ $visitor->members }}</td>
                                                <td class="text-start">{{ $visitor->contact_number }}</td>
                                                <td>{{ $visitor->address }}</td>
                                                <td>{{ \Carbon\Carbon::parse($visitor->date_visit)->format('F j, Y') }}
                                                </td>
                                                {{-- <td>{{ \Carbon\Carbon::parse($visitor->created_at)->format('F j, Y \a\t h:i A') }}</td> --}}
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card shadow h-100 py-2">
                <div class="card-body">
                    <div class="d-flex h-100 flex-column justify-content-between">
                        <div class="row align-items-center justify-content-between">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                                    Monthly Visitors Data Chart</div>
                            </div>
                            <canvas id="visitorsChart" height="100"></canvas>
                            <div class="text-center mt-3">
                                <p>Year {{ now()->year }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Content Row -->
@endsection <!-- End the content section -->

<script src="{{ asset('public/js/chart.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('visitorsChart')?.getContext('2d');
        if (!ctx) return;

        const visitorsChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($months) !!},
                datasets: [{
                    label: 'Total Visitors',
                    data: {!! json_encode($visitorsPerMonth) !!},
                    backgroundColor: '#4e73df',
                    borderRadius: 4,
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
