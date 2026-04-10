@extends('layouts.auth') <!-- Extend the main layout -->

@section('content')
    <!-- Start the content section -->
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div class="d-flex">
            <i class="fas fa-file-invoice fa-2x text-dark me-2"></i>
            <div class="d-flex flex-column">
                <h1 class="h3 mb-0 text">AVAILED SERVICES</h1>
                <h6 class="mb-0">Guest | Bills</h6>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    @include('layouts.services-navigation')
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <!-- Date Filter -->
                <form method="GET" action="" id="dateRangeForm">
                    <div class="d-flex justify-content-start gap-2 align-items-end mb-4">
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
                    <!-- A-Z Filter -->
                    <div class="d-flex flex-wrap gap-1 mb-3">
                        <a href="{{ request()->fullUrlWithQuery(['letter' => null]) }}"
                            class="btn btn-sm rounded-circle {{ request('letter') ? 'btn-dark' : 'btn-success' }}">
                            All
                        </a>
                        @foreach (range('A', 'Z') as $letter)
                            <a href="{{ request()->fullUrlWithQuery(['letter' => $letter]) }}"
                                class="btn btn-sm rounded-circle 
                                    {{ request('letter') == $letter ? 'btn-success' : 'btn-dark' }}"
                                style="width:32px;height:32px;line-height:22px;">
                                {{ $letter }}
                            </a>
                        @endforeach
                    </div>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0"
                    style="min-width:1800px;">
                    <thead>
                        <tr>
                            <th class="bg-theme-primary text-light">NO.</th>
                            <th class="bg-theme-primary text-light">NAME OF GUEST</th>
                            <th class="bg-theme-primary text-light">MEMBERS</th>
                            <th class="bg-theme-primary text-light">ENTRANCE FEE</th>
                            <th class="bg-theme-primary text-light">ACCOMMODATION</th>
                            <th class="bg-theme-primary text-light">FUNCTION HALL</th>
                            <th class="bg-theme-primary text-light">COTTAGE FEE</th>
                            <th class="bg-theme-primary text-light">FOODS</th>
                            <th class="bg-theme-primary text-light">DRINKS</th>
                            <th class="bg-theme-primary text-light">DATE CREATED</th>
                            <th class="bg-theme-primary text-light">TOTAL PAYMENT</th>
                            <th class="bg-theme-primary text-light">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($visitors as $visitor)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    {{ $visitor->first_name . ' ' . $visitor->middle_name . ' ' . $visitor->last_name }}
                                </td>
                                <td class="text-center">{{ $visitor->members }}</td>
                                <td>
                                    {{ $visitor->entrance ? '₱' . number_format($visitor->entrance->total_payment, 2) : 'N/A' }}
                                </td>
                                <td>
                                    {{ $visitor->accommodation ? '₱' . number_format($visitor->accommodation->total_payment, 2) : 'N/A' }}
                                </td>
                                <td>
                                    {{ $visitor->functionHall ? '₱' . number_format($visitor->functionHall->total_payment, 2) : 'N/A' }}
                                </td>
                                <td>
                                    {{ $visitor->cottage ? '₱' . number_format($visitor->cottage->total_payment, 2) : 'N/A' }}
                                </td>
                                <td>
                                    {{ $visitor->meal ? '₱' . number_format($visitor->meal->total_payment, 2) : 'N/A' }}
                                </td>
                                <td>
                                    {{ $visitor->beverage ? '₱' . number_format($visitor->beverage->total_payment, 2) : 'N/A' }}
                                </td>
                                <td>
                                    {{ $visitor->created_at->format('M d, Y') }}
                                </td>
                                @php
                                    $grand_total =
                                        ($visitor->entrance->total_payment ?? 0) +
                                        ($visitor->accommodation->total_payment ?? 0) +
                                        ($visitor->functionHall->total_payment ?? 0) +
                                        ($visitor->cottage->total_payment ?? 0) +
                                        ($visitor->meal->total_payment ?? 0) +
                                        ($visitor->beverage->total_payment ?? 0);
                                @endphp
                                <td>₱{{ number_format($grand_total, 2) }}</td>
                                <td>
                                    <a href="#" class="btn btn-secondary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#viewBillModal" data-visitor="{{ $visitor->id }}">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <!-- View Bill Modal -->
                                    <div class="modal fade" id="viewBillModal" tabindex="-1" role="dialog"
                                        aria-labelledby="viewBillModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-md" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <div class="col-12">
                                                        <div class="text-end">
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="d-flex align-items-center gap-2 justify-content-center">
                                                            <img src="{{ asset('public/img/jbp-icon.jpg') }}"
                                                                width="70" alt="jbp-logo">
                                                            <div class="d-flex flex-column">
                                                                <b class="modal-title mt-2 text-bold">JPB Heritage Inland
                                                                    Resort</b>
                                                                <span>Progreso Street Illauod, Bugasong, Antique</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div
                                                            class="bg-theme-primary d-flex align-items-center gap-2 justify-content-center text-light p-2">
                                                            <h3 class="m-0">BILL RECEIPT</h3>
                                                        </div>
                                                        <div class="visitor-name my-2 d-flex align-items-center gap-2">
                                                            <label class="col-3" for="visitorName">Visitor Name:</label>
                                                            <input type="text" class="form-control" id="visitorName"
                                                            value="{{ $visitor->first_name . ' ' . $visitor->middle_name . ' ' . $visitor->last_name }}" readonly>
                                                        </div>
                                                        <div class="table-responsive p-0">
                                                            <table class="table table-bordered border-none m-0">
                                                                <thead class="bg-success text-light">
                                                                    <tr>
                                                                        <th style="border-width: 0px"
                                                                            class="text-center bg-success text-light">
                                                                            AVAILED SERVICES</th>
                                                                        <th style="border-width: 0px"
                                                                            class="text-center bg-success text-light">AMOUNT
                                                                            FEE</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @if ($visitor->entrance)
                                                                        <tr>
                                                                            <td style="border-width: 0px">Entrance Fee</td>
                                                                            <td style="border-width: 0px"
                                                                                class="text-center">
                                                                                ₱{{ number_format($visitor->entrance->total_payment, 2) }}
                                                                            </td>
                                                                        </tr>
                                                                    @endif
                                                                    @if ($visitor->cottage)
                                                                        <tr>
                                                                            <td style="border-width: 0px">Cottage Fee</td>
                                                                            <td style="border-width: 0px"
                                                                                class="text-center">
                                                                                ₱{{ number_format($visitor->cottage->total_payment, 2) }}
                                                                            </td>
                                                                        </tr>
                                                                    @endif
                                                                    @if ($visitor->accommodation)
                                                                        <tr>
                                                                            <td style="border-width: 0px">Room Accommodation
                                                                            </td>
                                                                            <td style="border-width: 0px"
                                                                                class="text-center">
                                                                                ₱{{ number_format($visitor->accommodation->total_payment, 2) }}
                                                                            </td>
                                                                        </tr>
                                                                    @endif
                                                                    @if ($visitor->functionHall)
                                                                        <tr>
                                                                            <td style="border-width: 0px">Function Hall
                                                                            </td>
                                                                            <td style="border-width: 0px"
                                                                                class="text-center">
                                                                                ₱{{ number_format($visitor->functionHall->total_payment, 2) }}
                                                                            </td>
                                                                        </tr>
                                                                    @endif
                                                                    @if ($visitor->meal)
                                                                        <tr>
                                                                            <td style="border-width: 0px">Foods</td>
                                                                            <td style="border-width: 0px"
                                                                                class="text-center">
                                                                                ₱{{ number_format($visitor->meal->total_payment, 2) }}
                                                                            </td>
                                                                        </tr>
                                                                    @endif
                                                                    @if ($visitor->beverage)
                                                                        <tr>
                                                                            <td style="border-width: 0px">Drinks</td>
                                                                            <td style="border-width: 0px"
                                                                                class="text-center">
                                                                                ₱{{ number_format($visitor->beverage->total_payment, 2) }}
                                                                            </td>
                                                                        </tr>
                                                                    @endif
                                                                    <tr class="bg-dark text-light">
                                                                        <td style="border-width: 0px"></td>
                                                                        <td style="border-width: 0px"
                                                                            class="fw-semibold text-center">
                                                                            ₱{{ number_format($grand_total, 2) }}</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Content Row -->
@endsection <!-- End the content section -->
