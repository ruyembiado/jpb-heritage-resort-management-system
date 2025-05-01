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
                                    Orders | Today</div>
                                <div class="h3 mb-0 font-weight-bold">1</div>
                            </div>
                            <div class="col-auto">
                                <i class="fa fa-pen-to-square fa-2x text-dark"></i>
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
                                    Orders | This Week</div>
                                <div class="h3 mb-0 font-weight-bold">1</div>
                            </div>
                            <div class="col-auto">
                                <i class="fa fa-pen-to-square fa-2x text-dark"></i>
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
                                    Orders | This Month</div>
                                <div class="h3 mb-0 font-weight-bold">1</div>
                            </div>
                            <div class="col-auto">
                                <i class="fa fa-pen-to-square fa-2x text-dark"></i>
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
                                    Orders | This Year</div>
                                <div class="h3 mb-0 font-weight-bold">1</div>
                            </div>
                            <div class="col-auto">
                                <i class="fa fa-pen-to-square fa-2x text-dark"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- @if (auth()->user()->user_type == 'admin')
            <div class="col-12 mb-4">
                <div class="card shadow h-100 py-2">
                    <div class="card-body">
                        <div class="d-flex h-100 flex-column justify-content-between">
                            <div class="row align-items-center justify-content-between">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                                        Request Orders | This Month</div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Order Number</th>
                                                <th>Name</th>
                                                <th>Status</th>
                                                <th>Total Amount</th>
                                                <th>Date of Request</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orders as $key => $order)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $order->order_number }}</td>
                                                    <td>{{ $order->user->name ?? 'N/A' }}</td> <!-- Display user name -->
                                                    <td>
                                                        <span
                                                            class="badge 
                                                        @if ($order->status == 'Pending') bg-warning
                                                        @elseif($order->status == 'Done') bg-success
                                                        @elseif($order->status == 'Accepted') bg-info
                                                        @elseif($order->status == 'Cancelled') bg-danger @endif">
                                                            {{ $order->status }}
                                                        </span>
                                                    </td>
                                                    <td>₱{{ number_format($order->total_amount, 2) }}</td>
                                                    <td>{{ $order->created_at->format('Y-m-d H:i A') }}</td>
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
                                        Monthly Orders Data Chart</div>
                                </div>
                                <canvas id="ordersChart" height="100"></canvas>
                                <div class="text-center mt-3">
                                    <p>Year {{ now()->year }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif --}}
    </div>
    <!-- Content Row -->
@endsection <!-- End the content section -->

<script src="{{ asset('public/js/chart.js') }}"></script>
{{-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('ordersChart')?.getContext('2d');
        if (!ctx) return;

        const ordersChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($months) !!},
                datasets: [{
                    label: 'Total Orders',
                    data: {!! json_encode($ordersPerMonth) !!},
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
</script> --}}
