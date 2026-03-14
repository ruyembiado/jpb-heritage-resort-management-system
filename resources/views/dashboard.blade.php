@extends('layouts.auth') <!-- Extend the main layout -->

@section('content')
    <!-- Start the content section -->
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text">Dashboard</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-0">
            <a href="#" data-bs-toggle="modal" data-bs-target="#guestsModal">
                <div class="card shadow py-2 bg-primary">
                    <div class="card-body">
                        <div class="row align-items-center justify-content-between flex-column gap-3">
                            <div class="d-flex flex-column text-center">
                                <b class="text-xs font-weight-bold text-light text-uppercase">
                                    Total Guest
                                </b>
                                <span class="text-center text-light">({{ date('Y') }})</span>
                            </div>
                            <div class="d-flex justify-content-center align-items-center gap-2">
                                <i class="fa fa-users fa-2x text-light"></i>
                                <div class="h3 mb-0 font-weight-bold text-light">{{ $visitorsThisYear }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-xl-3 col-md-6 mb-0">
            <div class="card shadow py-2 bg-brown">
                <div class="card-body">
                    <div class="row align-items-center justify-content-between flex-column gap-3">
                        <div class="d-flex flex-column text-center">
                            <b class="text-xs font-weight-bold text-light text-uppercase">
                                Total Bill
                            </b>
                            <span class="text-center text-light">({{ date('Y') }})</span>
                        </div>
                        <div class="d-flex justify-content-center align-items-center gap-2">
                            <i class="fa fa-peso-sign fa-2x text-light"></i>
                            <div class="h3 mb-0 font-weight-bold text-light">{{ $visitorsThisYear }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-0">
            <a href="#" data-bs-toggle="modal" data-bs-target="#incompleteBill">
                <div class="card shadow py-2 bg-danger">
                    <div class="card-body">
                        <div class="row align-items-center justify-content-between flex-column gap-3">
                            <div class="d-flex flex-column text-center">
                                <b class="text-xs font-weight-bold text-light text-uppercase">
                                    Unpaid Bills
                                </b>
                                <span class="text-center text-light">(Incomplete)</span>
                            </div>
                            <div class="d-flex justify-content-center align-items-center gap-2">
                                <i class="fa fa-times-circle fa-2x text-light"></i>
                                <div class="h3 mb-0 font-weight-bold text-light">{{ $visitorsThisYear }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-xl-3 col-md-6 mb-0">
            <div class="card shadow py-2 bg-success">
                <div class="card-body">
                    <div class="row align-items-center justify-content-between flex-column gap-3">
                        <div class="d-flex flex-column text-center">
                            <b class="text-xs font-weight-bold text-light text-uppercase">
                                Paid Bills
                            </b>
                            <span class="text-center text-light">(Complete)</span>
                        </div>
                        <div class="d-flex justify-content-center align-items-center gap-2">
                            <i class="fa fa-check-circle fa-2x text-light"></i>
                            <div class="h3 mb-0 font-weight-bold text-light">{{ $visitorsThisYear }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Guests Statistics Modal -->
        <div class="modal fade" id="guestsModal" tabindex="-1">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Guest Statistics</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body px-3 py-0">
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card mb-0 py-2">
                                    <div class="card-body">
                                        <div
                                            class="d-flex flex-column justify-content-between p-3 border border-2 rounded border-primary">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase">
                                                <i class="fa fa-calendar fa-2x text-primary"></i>
                                                <b class="ms-2 pb-2">DAY</b>
                                            </div>
                                            <div class="h1 mb-0 font-weight-bold text-center text-primary">
                                                {{ $visitorsToday }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="card mb-0 py-2">
                                    <div class="card-body">
                                        <div
                                            class="d-flex flex-column justify-content-between p-3 border border-2 rounded border-success">
                                            <div class="text-xs font-weight-bold text-success text-uppercase">
                                                <i class="fa fa-calendar fa-2x text-success"></i>
                                                <b class="ms-2 pb-2">WEEK</b>
                                            </div>
                                            <div class="h1 mb-0 font-weight-bold text-center text-success">
                                                {{ $visitorsThisWeek }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="card mb-0 py-2">
                                    <div class="card-body">
                                        <div
                                            class="d-flex flex-column justify-content-between p-3 border border-2 rounded border-brown">
                                            <div class="text-xs font-weight-bold text-brown text-uppercase">
                                                <i class="fa fa-calendar fa-2x text-brown"></i>
                                                <b class="ms-2 pb-2">MONTH</b>
                                            </div>
                                            <div class="h1 mb-0 font-weight-bold text-center text-brown">
                                                {{ $visitorsThisMonth }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="card mb-0 py-2">
                                    <div class="card-body">
                                        <div
                                            class="d-flex flex-column justify-content-between p-3 border border-2 rounded border-danger">
                                            <div class="text-xs font-weight-bold text-danger text-uppercase">
                                                <i class="fa fa-calendar fa-2x text-danger"></i>
                                                <b class="ms-2 pb-2">YEAR</b>
                                            </div>
                                            <div class="h1 mb-0 font-weight-bold text-center text-danger">
                                                {{ $visitorsThisYear }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="incompleteBill" class="modal fade" tabindex="-1">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Incomplete Bills</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card mb-0">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered border-dark" id="" width="100%">
                                        <thead>
                                            <tr>
                                                <th rowspan="3"
                                                    class="align-middle bg-theme-primary text-light text-uppercase">No.
                                                </th>
                                                <th rowspan="3"
                                                    class="align-middle bg-theme-primary text-light text-uppercase">Name of
                                                    Guest</th>
                                                <th rowspan="3"
                                                    class="align-middle bg-theme-primary text-light text-uppercase">Members
                                                </th>
                                                <th colspan="10"
                                                    class="text-center bg-theme-primary text-light text-uppercase">Availed
                                                    Services</th>
                                                <th rowspan="3"
                                                    class="align-middle bg-theme-primary text-light text-uppercase">Total
                                                    Fee</th>
                                            </tr>
                                            <tr>
                                                <th class="bg-theme-primary text-light text-uppercase" colspan="2">
                                                    Entrance Fee</th>
                                                <th class="bg-theme-primary text-light text-uppercase" colspan="2">Room
                                                    Accommodation</th>
                                                <th class="bg-theme-primary text-light text-uppercase" colspan="2">
                                                    Cottage Fee</th>
                                                <th class="bg-theme-primary text-light text-uppercase" colspan="2">
                                                    Foods</th>
                                                <th class="bg-theme-primary text-light text-uppercase" colspan="2">
                                                    Drinks</th>
                                            </tr>
                                            <tr>
                                                <th class="bg-success text-light">Fee</th>
                                                <th class="bg-success text-light">Status</th>
                                                <th class="bg-success text-light">Fee</th>
                                                <th class="bg-success text-light">Status</th>
                                                <th class="bg-success text-light">Fee</th>
                                                <th class="bg-success text-light">Status</th>
                                                <th class="bg-success text-light">Fee</th>
                                                <th class="bg-success text-light">Status</th>
                                                <th class="bg-success text-light">Fee</th>
                                                <th class="bg-success text-light">Status</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($visitors as $visitor)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>
                                                        {{ $visitor->first_name . ' ' . $visitor->middle_name . ' ' . $visitor->last_name }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ $visitor->members }}
                                                    </td>

                                                    <!-- Entrance -->
                                                    <td>
                                                        {{ $visitor->entrance ? '₱' . number_format($visitor->entrance->total_payment, 2) : 'N/A' }}
                                                    </td>
                                                    <td>
                                                        @if (isset($visitor->entrance->status))
                                                            <span
                                                                class="badge {{ $visitor->entrance->status === 'Paid' ? 'bg-success' : 'bg-danger' }}">
                                                                {{ $visitor->entrance->status }}
                                                            </span>
                                                        @else
                                                            <span class="badge bg-secondary">N/A</span>
                                                        @endif
                                                    </td>

                                                    <!-- Accommodation -->
                                                    <td>
                                                        {{ $visitor->accommodation ? '₱' . number_format($visitor->accommodation->total_payment, 2) : 'N/A' }}
                                                    </td>
                                                    <td>
                                                        @if (isset($visitor->accommodation->status))
                                                            <span
                                                                class="badge {{ $visitor->accommodation->status === 'Paid' ? 'bg-success' : 'bg-danger' }}">
                                                                {{ $visitor->accommodation->status }}
                                                            </span>
                                                        @else
                                                            <span class="badge bg-secondary">N/A</span>
                                                        @endif
                                                    </td>

                                                    <!-- Cottage -->
                                                    <td>
                                                        {{ $visitor->cottage ? '₱' . number_format($visitor->cottage->total_payment, 2) : 'N/A' }}
                                                    </td>
                                                    <td>
                                                        @if (isset($visitor->cottage->status))
                                                            <span
                                                                class="badge {{ $visitor->cottage->status === 'Paid' ? 'bg-success' : 'bg-danger' }}">
                                                                {{ $visitor->cottage->status }}
                                                            </span>
                                                        @else
                                                            <span class="badge bg-secondary">N/A</span>
                                                        @endif
                                                    </td>

                                                    <!-- Meals -->
                                                    <td>
                                                        {{ $visitor->meal ? '₱' . number_format($visitor->meal->total_payment, 2) : 'N/A' }}
                                                    </td>
                                                    <td>
                                                        @if (isset($visitor->meal->status))
                                                            <span
                                                                class="badge {{ $visitor->meal->status === 'Paid' ? 'bg-success' : 'bg-danger' }}">
                                                                {{ $visitor->meal->status }}
                                                            </span>
                                                        @else
                                                            <span class="badge bg-secondary">N/A</span>
                                                        @endif
                                                    </td>

                                                    <!-- Beverages -->
                                                    <td>
                                                        {{ $visitor->beverage ? '₱' . number_format($visitor->beverage->total_payment, 2) : 'N/A' }}
                                                    </td>
                                                    <td>
                                                        @if (isset($visitor->beverage->status))
                                                            <span
                                                                class="badge {{ $visitor->beverage->status === 'Paid' ? 'bg-success' : 'bg-danger' }}">
                                                                {{ $visitor->beverage->status }}
                                                            </span>
                                                        @else
                                                            <span class="badge bg-secondary">N/A</span>
                                                        @endif
                                                    </td>

                                                    @php
                                                        $grand_total =
                                                            ($visitor->entrance->total_payment ?? 0) +
                                                            ($visitor->accommodation->total_payment ?? 0) +
                                                            ($visitor->cottage->total_payment ?? 0) +
                                                            ($visitor->meal->total_payment ?? 0) +
                                                            ($visitor->beverage->total_payment ?? 0);
                                                    @endphp
                                                    <td>
                                                        ₱{{ number_format($grand_total, 2) }}
                                                    </td>
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
