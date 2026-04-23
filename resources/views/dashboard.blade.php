@extends('layouts.auth') <!-- Extend the main layout -->

@section('content')
    <!-- Start the content section -->
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-start gap-2 mb-4">
        <i class="fas fa-dashboard fa-2x text-dark"></i>
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
                            <div class="h3 mb-0 font-weight-bold text-light">₱{{ number_format($totalBills, 2) }}</div>
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
                                <div class="h3 mb-0 font-weight-bold text-light">{{ $unpaidBills }}</div>
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
                            <div class="h3 mb-0 font-weight-bold text-light">{{ $paidBills }}</div>
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
            <div class="modal-dialog modal-dialog-centered" style="max-width: 1520px;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Incomplete Bills</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-0">
                        <div class="card mb-0">
                            <div class="card-body p-1">
                                <div class="table-responsive">
                                    <table class="table table-bordered border-dark m-0" width="100%">
                                        <thead>
                                            <tr>
                                                <th rowspan="3"
                                                    class="align-middle bg-theme-primary text-light text-uppercase"
                                                    style="vertical-align: middle;">No.</th>
                                                <th rowspan="3"
                                                    class="align-middle bg-theme-primary text-light text-uppercase"
                                                    style="vertical-align: middle;">Name of Guest</th>
                                                <th rowspan="3"
                                                    class="align-middle bg-theme-primary text-light text-uppercase"
                                                    style="vertical-align: middle;">Members</th>
                                                <th colspan="14"
                                                    class="text-center bg-theme-primary text-light text-uppercase">Availed
                                                    Services</th>
                                                <th rowspan="3"
                                                    class="align-middle bg-theme-primary text-light text-uppercase"
                                                    style="vertical-align: middle;">Total Fee</th>
                                            </tr>
                                            <tr>
                                                <th class="bg-theme-primary text-light text-uppercase" colspan="2">
                                                    Entrance Fee</th>
                                                <th class="bg-theme-primary text-light text-uppercase" colspan="2">Room
                                                    Accommodation</th>
                                                <th class="bg-theme-primary text-light text-uppercase" colspan="2">
                                                    Function Hall</th>
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
                                                <th class="bg-success text-light">Fee</th>
                                                <th class="bg-success text-light">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($visitorsWithUnpaidBills->isNotEmpty())
                                                @foreach ($visitorsWithUnpaidBills as $visitor)
                                                    <tr>
                                                        <td class="text-center">{{ $loop->iteration }}</td>
                                                        <td>
                                                            {{ $visitor->first_name }}
                                                            {{ $visitor->middle_name ? $visitor->middle_name . ' ' : '' }}
                                                            {{ $visitor->last_name }}
                                                        </td>
                                                        <td class="text-center">{{ $visitor->members ?? 'N/A' }}</td>

                                                        <!-- Entrance Fee -->
                                                        <td class="text-end">
                                                            {{ $visitor->entrance ? '₱' . number_format($visitor->entrance->total_payment, 2) : '₱0.00' }}
                                                        </td>
                                                        <td class="text-center">
                                                            @if (isset($visitor->entrance->status))
                                                                <span
                                                                    class="badge {{ $visitor->entrance->status === 'Paid' ? 'bg-success' : 'bg-danger' }}">
                                                                    {{ $visitor->entrance->status }}
                                                                </span>
                                                            @else
                                                                <span class="badge bg-secondary">N/A</span>
                                                            @endif
                                                        </td>

                                                        <!-- Room Accommodation -->
                                                        <td class="text-end">
                                                            {{ $visitor->accommodation ? '₱' . number_format($visitor->accommodation->total_payment, 2) : '₱0.00' }}
                                                        </td>
                                                        <td class="text-center">
                                                            @if (isset($visitor->accommodation->status))
                                                                <span
                                                                    class="badge {{ $visitor->accommodation->status === 'Paid' ? 'bg-success' : 'bg-danger' }}">
                                                                    {{ $visitor->accommodation->status }}
                                                                </span>
                                                            @else
                                                                <span class="badge bg-secondary">N/A</span>
                                                            @endif
                                                        </td>

                                                        <!-- Function Hall -->
                                                        <td class="text-end">
                                                            {{ $visitor->functionHall ? '₱' . number_format($visitor->functionHall->total_payment, 2) : '₱0.00' }}
                                                        </td>
                                                        <td class="text-center">
                                                            @if (isset($visitor->functionHall->status))
                                                                <span
                                                                    class="badge {{ $visitor->functionHall->status === 'Paid' ? 'bg-success' : 'bg-danger' }}">
                                                                    {{ $visitor->functionHall->status }}
                                                                </span>
                                                            @else
                                                                <span class="badge bg-secondary">N/A</span>
                                                            @endif
                                                        </td>

                                                        <!-- Cottage Fee -->
                                                        <td class="text-end">
                                                            {{ $visitor->cottage ? '₱' . number_format($visitor->cottage->total_payment, 2) : '₱0.00' }}
                                                        </td>
                                                        <td class="text-center">
                                                            @if (isset($visitor->cottage->status))
                                                                <span
                                                                    class="badge {{ $visitor->cottage->status === 'Paid' ? 'bg-success' : 'bg-danger' }}">
                                                                    {{ $visitor->cottage->status }}
                                                                </span>
                                                            @else
                                                                <span class="badge bg-secondary">N/A</span>
                                                            @endif
                                                        </td>

                                                        <!-- Foods -->
                                                        <td class="text-end">
                                                            {{ $visitor->meal ? '₱' . number_format($visitor->meal->total_payment, 2) : '₱0.00' }}
                                                        </td>
                                                        <td class="text-center">
                                                            @if (isset($visitor->meal->status))
                                                                <span
                                                                    class="badge {{ $visitor->meal->status === 'Paid' ? 'bg-success' : 'bg-danger' }}">
                                                                    {{ $visitor->meal->status }}
                                                                </span>
                                                            @else
                                                                <span class="badge bg-secondary">N/A</span>
                                                            @endif
                                                        </td>

                                                        <!-- Drinks -->
                                                        <td class="text-end">
                                                            {{ $visitor->beverage ? '₱' . number_format($visitor->beverage->total_payment, 2) : '₱0.00' }}
                                                        </td>
                                                        <td class="text-center">
                                                            @if (isset($visitor->beverage->status))
                                                                <span
                                                                    class="badge {{ $visitor->beverage->status === 'Paid' ? 'bg-success' : 'bg-danger' }}">
                                                                    {{ $visitor->beverage->status }}
                                                                </span>
                                                            @else
                                                                <span class="badge bg-secondary">N/A</span>
                                                            @endif
                                                        </td>
                                                      
                                                        <!-- Grand Total -->
                                                        @php
                                                            $grand_total =
                                                                ($visitor->entrance->total_payment ?? 0) +
                                                                ($visitor->accommodation->total_payment ?? 0) +
                                                                ($visitor->functionHall->total_payment ?? 0) +
                                                                ($visitor->cottage->total_payment ?? 0) +
                                                                ($visitor->meal->total_payment ?? 0) +
                                                                ($visitor->beverage->total_payment ?? 0);
                                                        @endphp
                                                        <td class="text-end fw-bold">₱{{ number_format($grand_total, 2) }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="20" class="text-center text-muted py-4">No visitors
                                                        with unpaid bills.</td>
                                                </tr>
                                            @endif
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
            <div class="card shadow mb-0">
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

                    <div class="table-responsive" style="overflow-x:auto;">
                        <table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0"
                            style="min-width:2000px;">
                            <thead>
                                <tr>
                                    <th class="bg-theme-primary text-light border-dark">NO.</th>
                                    <th class="bg-theme-primary text-light border-dark">NAME OF GUEST</th>
                                    <th class="bg-theme-primary text-light border-dark">SEX</th>
                                    <th class="bg-theme-primary text-light border-dark">AGE</th>
                                    <th class="bg-theme-primary text-light border-dark">MEMBERS</th>
                                    <th class="bg-theme-primary text-light border-dark">TOTAL FEE</th>
                                    <th class="bg-theme-primary text-light border-dark">STATUS</th>
                                    <th class="bg-theme-primary text-light border-dark">CONTACT NO.</th>
                                    <th class="bg-theme-primary text-light border-dark">ADDRESS</th>
                                    <th class="bg-theme-primary text-light border-dark">CHECK-IN</th>
                                    <th class="bg-theme-primary text-light border-dark">DATE CREATED</th>
                                    <th class="bg-theme-primary text-light border-dark sticky-action">ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($entrances as $entrance)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            {{ $entrance->visitor?->first_name ?? '' }}
                                            {{ $entrance->visitor?->middle_name ?? '' }}
                                            {{ $entrance->visitor?->last_name ?? '' }}
                                        </td>
                                        <td>{{ $entrance->visitor->gender }}</td>
                                        <td>{{ $entrance->visitor->age }}</td>
                                        <td class="text-center px-0 pb-0">
                                            {{ $entrance->visitor->members ?? 0 }}
                                            @if (!empty($entrance->companions))
                                                <table class="table table-bordered mt-2 mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th class="bg-success text-light">No.</th>
                                                            <th class="bg-success text-light">Name</th>
                                                            <th class="bg-success text-light">Category</th>
                                                            <th class="bg-success text-light">Sex</th>
                                                            <th class="bg-success text-light">Age</th>
                                                            <th class="bg-success text-light">Address</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if ($entrance->companions->isNotEmpty())
                                                            @foreach ($entrance->companions as $index => $companion)
                                                                <tr>
                                                                    <td>{{ $index + 1 }}</td>
                                                                    <td>{{ $companion->name }}</td>
                                                                    <td>
                                                                        @if ($companion->age <= 15)
                                                                            Child
                                                                        @elseif ($companion->isPWD)
                                                                            PWD
                                                                        @else
                                                                            Adult
                                                                        @endif
                                                                    </td>
                                                                    <td>{{ $companion->gender }}</td>
                                                                    <td>{{ $companion->age }}</td>
                                                                    <td>{{ $companion->address }}</td>
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
                                        <td>₱ {{ number_format($entrance->total_payment, 2) }}</td>
                                        <td>
                                            @if ($entrance->status === 'Paid')
                                                <span class="badge bg-success">Paid</span>
                                            @else
                                                <span class="badge bg-danger">Unpaid</span>
                                            @endif
                                        </td>
                                        <td>{{ $entrance->visitor->contact_number }}</td>
                                        <td>{{ $entrance->visitor->address }}</td>
                                        <td>{{ \Carbon\Carbon::parse($entrance->visitor->created_at)->format('h:i A') }}
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($entrance->created_at)->format('M d, Y') }}</td>
                                        <td class="sticky-action">
                                            <div class="d-flex align-items-center gap-1">
                                                <button class="btn btn-warning btn-sm editEntranceBtn"
                                                    data-id="{{ $entrance->id }}"
                                                    data-first_name="{{ $entrance->visitor->first_name }}"
                                                    data-middle_name="{{ $entrance->visitor->middle_name }}"
                                                    data-last_name="{{ $entrance->visitor->last_name }}"
                                                    data-age="{{ $entrance->visitor->age }}"
                                                    data-gender="{{ $entrance->visitor->gender }}"
                                                    data-contact="{{ $entrance->visitor->contact_number }}"
                                                    data-address="{{ $entrance->visitor->address }}"
                                                    data-pwd="{{ $entrance->visitor->isPWD ?? 0 }}"
                                                    data-fee="{{ $entrance->total_payment }}"
                                                    data-status="{{ $entrance->status }}"
                                                    data-companions="{{ json_encode($entrance->companions) }}"
                                                    data-members="{{ $entrance->visitor->members ?? 0 }}"
                                                    data-bs-toggle="modal" data-bs-target="#editEntranceModal">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <form action="{{ route('visitor.destroy', $entrance->visitor_id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this visitor record?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
                            <div class="col-auto">
                                <form method="GET" action="{{ route('dashboard') }}">
                                    <select name="year" class="form-select" onchange="this.form.submit()">
                                        @for ($year = 2025; $year <= now()->year; $year++)
                                            <option value="{{ $year }}"
                                                {{ $selectedYear == $year ? 'selected' : '' }}>
                                                {{ $year }}
                                            </option>
                                        @endfor
                                    </select>
                                </form>
                            </div>
                            <canvas id="visitorsChart" height="100"></canvas>
                            <div class="text-center mt-3">
                                <p>Year {{ $selectedYear }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Entrance Modal -->
    <div class="modal fade" id="editEntranceModal" tabindex="-1" role="dialog"
        aria-labelledby="editEntranceModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <form action="{{ route('entrance.update') }}" method="POST" id="entranceEditForm">
                <input type="hidden" name="entrance_id" id="edit_entrance_id">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="col-12">
                            <div class="text-end">
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="d-flex align-items-center gap-2 justify-content-center">
                                <img src="{{ asset('public/img/jbp-icon.jpg') }}" width="70" alt="jbp-logo">
                                <div class="d-flex flex-column">
                                    <b class="modal-title mt-2 text-bold">JPB Heritage Inland Resort</b>
                                    <span>Progreso Street Illauod, Bugasong, Antique</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="edit_date_visit" value="{{ now()->toDateString() }}"
                            class="form-control" required />
                        <div
                            class="bg-theme-primary d-flex align-items-center gap-2 justify-content-center text-light p-2 mb-3">
                            <i class="fa fa-book fa-2x"></i>
                            <h3 class="m-0">ENTRANCE FEE</h3>
                        </div>
                        <b>GUEST INFORMATION</b>
                        <div class="form-group mb-2">
                            <div class="d-flex align-items-center gap-3">
                                <label style="min-width: 120px;">Complete Name:</label>
                                <div class="col-3">
                                    <input type="text" name="edit_guest_first_name" class="form-control"
                                        placeholder="First Name" required>
                                </div>
                                <div class="col-3">
                                    <input type="text" name="edit_guest_middle_name" class="form-control"
                                        placeholder="Middle Name">
                                </div>
                                <div class="col-3">
                                    <input type="text" name="edit_guest_last_name" class="form-control"
                                        placeholder="Last Name" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-2">
                            <div class="d-flex align-items-center gap-3">
                                <label style="min-width: 120px;">Contact Number:</label>
                                <div class="col-3">
                                    <input type="text" name="edit_guest_contact_number" class="form-control" required>
                                </div>
                                <label>Age:</label>
                                <div class="col-2">
                                    <input type="number" name="edit_guest_age" id="edit_guest_age" class="form-control"
                                        required onchange="calculateEditGuestFee()">
                                </div>
                                <label>Sex:</label>
                                <div class="col-2">
                                    <select name="edit_guest_gender" class="form-control" required>
                                        <option value="">Select sex</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-2">
                            <div class="d-flex align-items-center gap-3">
                                <label style="min-width: 120px;">Address:</label>
                                <div class="col-5">
                                    <input type="text" name="edit_guest_address" class="form-control" required>
                                </div>
                                <label style="min-width: 50px;">is PWD?</label>
                                <div class="col-1">
                                    <input type="checkbox" name="edit_guest_is_pwd" id="edit_guest_is_pwd"
                                        value="1" class="form-check-input" onchange="calculateEditGuestFee()">
                                </div>
                                <label>Guest Fee:</label>
                                <div class="col-2">
                                    <div class="d-flex">
                                        <span class="input-group-text bg-theme-primary text-light">₱</span>
                                        <input type="number" readonly name="edit_guest_fee" id="edit_guest_fee"
                                            min="0" value="0" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <b>ADD COMPANIONS</b>
                        <div class="form-group mb-2">
                            <div class="d-flex align-items-center gap-3">
                                <label>No. of Companions:</label>
                                <div class="col-1">
                                    <input type="number" id="edit_companionsCount" name="edit_guest_members"
                                        min="0" value="0" class="form-control">
                                </div>
                            </div>
                        </div>

                        <table class="table table-bordered border-dark" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="bg-success text-light">No.</th>
                                    <th class="bg-success text-light">Name</th>
                                    <th class="bg-success text-light">Sex</th>
                                    <th class="bg-success text-light">Age</th>
                                    <th class="bg-success text-light">is PWD?</th>
                                    <th class="bg-success text-light">Address</th>
                                    <th class="bg-success text-light">Fee</th>
                                    <th class="bg-success text-light">Action</th>
                                </tr>
                            </thead>
                            <tbody id="edit_companionsTableBody"></tbody>
                        </table>

                        <div class="form-group mb-2">
                            <div class="d-flex align-items-center gap-3">
                                <label>Payment Status:</label>
                                <div class="col-2">
                                    <select name="edit_payment_status" class="form-control" required>
                                        <option value="">Select status</option>
                                        <option value="Paid">Paid</option>
                                        <option value="Unpaid">Unpaid</option>
                                    </select>
                                </div>
                                <label>Total Fee:</label>
                                <div class="col-3">
                                    <div class="d-flex">
                                        <span class="input-group-text bg-theme-primary text-light">₱</span>
                                        <input type="text" name="edit_total_fee" id="edit_total_fee" value="0.00"
                                            class="form-control" readonly required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Update</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Content Row -->
@endsection <!-- End the content section -->

<script src="{{ asset('public/js/chart.js') }}"></script>
<script>
    const entranceFees = @json($entranceFees);

    /* ---------------------------------
       BUILD FEE MAP
    ----------------------------------*/
    let feeMap = {};

    entranceFees.forEach(fee => {
        if (fee.service_name === "Adult") {
            feeMap['adult'] = parseFloat(fee.fee);
        } else if (fee.service_name === "PWD") {
            feeMap['pwd'] = parseFloat(fee.fee);
        } else if (fee.service_name === "Child") {
            feeMap['child'] = parseFloat(fee.fee);
        }
    });

    /* ---------------------------------
       GET FEE BASED ON AGE + PWD
    ----------------------------------*/
    function getFee(age, isPwd) {
        if (isPwd) return feeMap['pwd'] ?? 0;
        if (age <= 15) return feeMap['child'] ?? 0;
        return feeMap['adult'] ?? 0;
    }

    /* ---------------------------------
       GET CATEGORY
    ----------------------------------*/
    function getCategory(age, isPwd) {
        if (isPwd) return "PWD";
        if (age <= 15) return "Child";
        return "Adult";
    }

    /* ---------------------------------
       GUEST FEE (ADD MODAL)
    ----------------------------------*/
    window.calculateGuestFee = function() {
        let age = parseInt(document.getElementById('guest_age').value) || 0;
        let isPwd = document.getElementById('guest_is_pwd').checked;
        let fee = getFee(age, isPwd);
        document.getElementById('guest_fee').value = fee.toFixed(2);
        calculateTotal();
    }

    /* ---------------------------------
       GUEST FEE (EDIT MODAL)
    ----------------------------------*/
    window.calculateEditGuestFee = function() {
        let age = parseInt(document.getElementById('edit_guest_age').value) || 0;
        let isPwd = document.getElementById('edit_guest_is_pwd').checked;
        let fee = getFee(age, isPwd);
        document.getElementById('edit_guest_fee').value = fee.toFixed(2);
        calculateEditTotal();
    }

    /* ---------------------------------
       COMPANION FEE (ADD MODAL)
    ----------------------------------*/
    window.calculateCompanionFee = function(element) {
        const row = element.closest("tr");
        const ageInput = row.querySelector(".companion-age");
        const pwdCheckbox = row.querySelector(".companion-pwd");
        const feeInput = row.querySelector(".companion-fee");
        let age = parseInt(ageInput.value) || 0;
        let isPwd = pwdCheckbox.checked;
        let fee = getFee(age, isPwd);
        feeInput.value = fee.toFixed(2);
        calculateTotal();
    }

    /* ---------------------------------
       COMPANION FEE (EDIT MODAL)
    ----------------------------------*/
    window.calculateEditCompanionFee = function(element) {
        const row = element.closest("tr");
        const ageInput = row.querySelector(".edit-companion-age");
        const pwdCheckbox = row.querySelector(".edit-companion-pwd");
        const feeInput = row.querySelector(".edit-companion-fee");
        let age = parseInt(ageInput.value) || 0;
        let isPwd = pwdCheckbox.checked;
        let fee = getFee(age, isPwd);
        feeInput.value = fee.toFixed(2);
        calculateEditTotal();
    }

    /* ---------------------------------
       TOTAL CALCULATION (ADD MODAL)
    ----------------------------------*/
    function calculateTotal() {
        let total = 0;
        let guestFee = parseFloat(document.getElementById('guest_fee').value) || 0;
        total += guestFee;
        document.querySelectorAll("#add_companionsTableBody .companion-fee").forEach(function(input) {
            total += parseFloat(input.value) || 0;
        });
        document.getElementById("total_fee").value = total.toFixed(2);
    }

    /* ---------------------------------
       TOTAL CALCULATION (EDIT MODAL)
    ----------------------------------*/
    function calculateEditTotal() {
        let total = 0;
        let guestFee = parseFloat(document.getElementById('edit_guest_fee').value) || 0;
        total += guestFee;
        document.querySelectorAll("#edit_companionsTableBody .edit-companion-fee").forEach(function(input) {
            total += parseFloat(input.value) || 0;
        });
        document.getElementById("edit_total_fee").value = total.toFixed(2);
    }

    document.addEventListener("DOMContentLoaded", function() {
        // ========== ADD MODAL FUNCTIONALITY ==========
        const addCompanionsCount = document.getElementById("add_companionsCount");
        const addTableBody = document.getElementById("add_companionsTableBody");

        function createAddRow(index) {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${index + 1}</td>
                <td>
                    <input type="text" name="companion_name[${index}]" class="form-control" required>
                </td>
                <td>
                    <select name="companion_gender[${index}]" class="form-control" required>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </td>
                <td width="10%">
                    <input type="number" name="companion_age[${index}]" class="form-control companion-age" min="0" max="110" required oninput="calculateCompanionFee(this)">
                </td>
                <td class="text-center">
                    <input type="checkbox" name="companion_is_pwd[${index}]" value="1" class="form-check-input companion-pwd" onchange="calculateCompanionFee(this)">
                </td>
                <td>
                    <input type="text" name="companion_address[${index}]" class="form-control" required>
                </td>
                <td width="12%">
                    <input type="number" name="companion_fee[${index}]" class="form-control companion-fee" readonly step="0.01" min="0">
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm remove-member">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;
            return row;
        }

        if (addCompanionsCount) {
            addCompanionsCount.addEventListener("input", function() {
                let members = parseInt(this.value) || 0;
                let currentRows = addTableBody.querySelectorAll("tr").length;

                if (members > currentRows) {
                    for (let i = currentRows; i < members; i++) {
                        addTableBody.appendChild(createAddRow(i));
                    }
                } else if (members < currentRows) {
                    for (let i = currentRows; i > members; i--) {
                        addTableBody.removeChild(addTableBody.lastElementChild);
                    }
                }
                updateRowNumbers(addTableBody);
                calculateTotal();
            });
        }

        // ========== EDIT MODAL FUNCTIONALITY ==========
        const editCompanionsCount = document.getElementById("edit_companionsCount");
        const editTableBody = document.getElementById("edit_companionsTableBody");

        function createEditRow(index, companionData = null) {
            const row = document.createElement("tr");
            const name = companionData ? companionData.name : '';
            const gender = companionData ? companionData.gender : 'Male';
            const age = companionData ? companionData.age : '';
            const isPwd = companionData ? (companionData.isPWD == 1) : false;
            const address = companionData ? companionData.address : '';
            const fee = companionData ? getFee(companionData.age, companionData.isPWD).toFixed(2) : '0.00';

            row.innerHTML = `
                <td>${index + 1}</td>
                <td>
                    <input type="text" name="edit_companion_name[${index}]" class="form-control" value="${name.replace(/"/g, '&quot;')}" required>
                </td>
                <td>
                    <select name="edit_companion_gender[${index}]" class="form-control" required>
                        <option value="Male" ${gender === 'Male' ? 'selected' : ''}>Male</option>
                        <option value="Female" ${gender === 'Female' ? 'selected' : ''}>Female</option>
                    </select>
                </td>
                <td width="10%">
                    <input type="number" name="edit_companion_age[${index}]" class="form-control edit-companion-age" value="${age}" min="0" max="110" required oninput="calculateEditCompanionFee(this)">
                </td>
                <td class="text-center">
                    <input type="checkbox" name="edit_companion_is_pwd[${index}]" value="1" class="form-check-input edit-companion-pwd" ${isPwd ? 'checked' : ''} onchange="calculateEditCompanionFee(this)">
                </td>
                <td>
                    <input type="text" name="edit_companion_address[${index}]" class="form-control" value="${address.replace(/"/g, '&quot;')}" required>
                </td>
                <td width="12%">
                    <input type="number" name="edit_companion_fee[${index}]" class="form-control edit-companion-fee" value="${fee}" readonly step="0.01" min="0">
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm remove-edit-member">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;
            return row;
        }

        if (editCompanionsCount) {
            editCompanionsCount.addEventListener("input", function() {
                let members = parseInt(this.value) || 0;
                let currentRows = editTableBody.querySelectorAll("tr").length;

                if (members > currentRows) {
                    for (let i = currentRows; i < members; i++) {
                        editTableBody.appendChild(createEditRow(i));
                    }
                } else if (members < currentRows) {
                    for (let i = currentRows; i > members; i--) {
                        editTableBody.removeChild(editTableBody.lastElementChild);
                    }
                }
                updateRowNumbers(editTableBody);
                calculateEditTotal();
            });
        }

        // Helper function to update row numbers
        function updateRowNumbers(tableBody) {
            const rows = tableBody.querySelectorAll("tr");
            rows.forEach((row, index) => {
                row.children[0].innerText = index + 1;
            });
        }

        // Remove member handlers
        if (addTableBody) {
            addTableBody.addEventListener("click", function(e) {
                if (e.target.closest(".remove-member")) {
                    e.target.closest("tr").remove();
                    if (addCompanionsCount) {
                        addCompanionsCount.value = addTableBody.querySelectorAll("tr").length;
                    }
                    updateRowNumbers(addTableBody);
                    calculateTotal();
                }
            });
        }

        if (editTableBody) {
            editTableBody.addEventListener("click", function(e) {
                if (e.target.closest(".remove-edit-member")) {
                    e.target.closest("tr").remove();
                    if (editCompanionsCount) {
                        editCompanionsCount.value = editTableBody.querySelectorAll("tr").length;
                    }
                    updateRowNumbers(editTableBody);
                    calculateEditTotal();
                }
            });
        }

        // ========== EDIT BUTTON CLICK HANDLER ==========
        document.querySelectorAll(".editEntranceBtn").forEach(button => {
            button.addEventListener("click", function() {
                // Basic information
                document.getElementById("edit_entrance_id").value = this.dataset.id;
                document.querySelector("[name='edit_guest_first_name']").value = this.dataset
                    .first_name || '';
                document.querySelector("[name='edit_guest_middle_name']").value = this.dataset
                    .middle_name || '';
                document.querySelector("[name='edit_guest_last_name']").value = this.dataset
                    .last_name || '';
                document.querySelector("[name='edit_guest_contact_number']").value = this
                    .dataset.contact || '';
                document.querySelector("[name='edit_guest_age']").value = this.dataset.age ||
                    '';
                document.querySelector("[name='edit_guest_gender']").value = this.dataset
                    .gender || '';
                document.querySelector("[name='edit_guest_address']").value = this.dataset
                    .address || '';
                document.querySelector("[name='edit_payment_status']").value = this.dataset
                    .status ||
                    '';

                // PWD checkbox
                const pwdCheckbox = document.getElementById("edit_guest_is_pwd");
                if (this.dataset.pwd == 1) {
                    pwdCheckbox.checked = true;
                } else {
                    pwdCheckbox.checked = false;
                }

                // Calculate guest fee
                calculateEditGuestFee();

                // Handle companions
                try {
                    const companions = JSON.parse(this.dataset.companions || '[]');
                    const membersCount = parseInt(this.dataset.members) || companions.length;

                    // Set companions count
                    if (editCompanionsCount) {
                        editCompanionsCount.value = membersCount;
                    }

                    // Clear and populate companions table
                    if (editTableBody) {
                        editTableBody.innerHTML = '';

                        if (companions.length > 0) {
                            companions.forEach((companion, index) => {
                                editTableBody.appendChild(createEditRow(index,
                                    companion));
                            });
                        } else {
                            // Create empty rows based on members count
                            for (let i = 0; i < membersCount; i++) {
                                editTableBody.appendChild(createEditRow(i));
                            }
                        }
                    }
                } catch (e) {
                    console.error('Error parsing companions data:', e);
                }

                // Calculate total fee
                calculateEditTotal();
            });
        });

        // ========== MODAL RESET HANDLERS ==========
        $('#addEntranceModal').on('hidden.bs.modal', function() {
            document.getElementById("entranceAddForm").reset();
            if (addTableBody) addTableBody.innerHTML = "";
            if (addCompanionsCount) addCompanionsCount.value = 0;
            document.getElementById("guest_fee").value = "0";
            document.getElementById("total_fee").value = "0";
        });

        $('#editEntranceModal').on('hidden.bs.modal', function() {
            document.getElementById("entranceEditForm").reset();
            if (editTableBody) editTableBody.innerHTML = "";
            if (editCompanionsCount) editCompanionsCount.value = 0;
            document.getElementById("edit_guest_fee").value = "0";
            document.getElementById("edit_total_fee").value = "0";
        });
    });
</script>
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
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    });
</script>
