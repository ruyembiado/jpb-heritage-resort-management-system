@extends('layouts.auth') <!-- Extend the main layout -->
@section('content')
    <!-- Start the content section -->
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div class="d-flex">
            <i class="fa fa-calendar-days fa-2x text-dark me-2"></i>
            <div class="d-flex flex-column">
                <h1 class="h3 mb-0 text">LIST & ATTENDANCE</h1>
                <h6 class="mb-0">Staff | Attendance</h6>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    @include('layouts.staff-navigation')
    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('attendance.index') }}" class="mb-1">
                <div class="d-flex gap-2 align-items-center">
                    <label>Date:</label>
                    <div class="col-2">
                        <input type="date" name="date" class="form-control" onchange="this.form.submit()"
                            value="{{ request('date') ?? date('Y-m-d') }}">
                    </div>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th rowspan="2" style="background-color: #084D00 !important;"
                                class="bg-theme-primary text-light align-middle text-center">NO.</th>
                            <th rowspan="2" style="background-color: #084D00 !important;"
                                class="bg-theme-primary text-light align-middle text-center">STAFF ID</th>
                            <th rowspan="2" style="background-color: #084D00 !important;"
                                class="bg-theme-primary text-light align-middle text-center">NAME</th>
                            <th style="background-color: #084D00 !important;"
                                class="bg-theme-primary text-light align-middle text-center">TIME-IN</th>
                            <th style="background-color: #084D00 !important;"
                                class="bg-theme-primary text-light align-middle text-center">TIME-OUT</th>
                            <th rowspan="2" style="background-color: #084D00 !important;"
                                class="bg-theme-primary text-light align-middle text-center">ACTION</th>
                        </tr>
                        <tr>
                            <th style="background-color: #084D00 !important;"
                                class="bg-theme-primary text-light align-middle text-center">8:00 AM</th>
                            <th style="background-color: #084D00 !important;"
                                class="bg-theme-primary text-light align-middle text-center">5:00 PM</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($staffs as $staff)
                            @php
                                $attendance = $staff->attendanceToday;
                            @endphp
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">{{ $staff->staff_id }}</td>
                                <td class="text-center">
                                    {{ $staff->first_name . ' ' . $staff->middle_name . ' ' . $staff->last_name }}
                                </td>
                                <!-- TIME IN -->
                                <td class="text-center">
                                    <form method="POST" action="{{ route('time.in', $staff->id) }}">
                                        @csrf
                                        <input type="hidden" name="date" value="{{ $date }}">
                                        <div class="d-flex gap-1">
                                            <input type="time" name="time_in" onchange="this.form.submit()"
                                                class="form-control {{ optional($attendance)->time_in && \Carbon\Carbon::parse(optional($attendance)->time_in)->gt(\Carbon\Carbon::createFromTime(8, 0)) ? 'text-danger' : '' }}"
                                                value="{{ $attendance->time_in ?? '' }}">
                                        </div>
                                    </form>
                                </td>
                                <!-- TIME OUT -->
                                <td class="text-center">
                                    <form method="POST" action="{{ route('time.out', $staff->id) }}">
                                        @csrf
                                        <input type="hidden" name="date" value="{{ $date }}">
                                        <div class="d-flex gap-1">
                                            <input type="time" name="time_out" onchange="this.form.submit()"
                                                class="form-control {{ optional($attendance)->time_out &&
                                                \Carbon\Carbon::parse(optional($attendance)->time_out)->lt(\Carbon\Carbon::createFromTime(17, 0))
                                                    ? 'text-danger'
                                                    : '' }}"
                                                value="{{ $attendance->time_out ?? '' }}">
                                        </div>
                                    </form>
                                </td>
                                <td>
                                    <a href="#viewDTRModal-{{ $staff->id }}" class="btn btn-secondary btn-sm"
                                        data-bs-toggle="modal">
                                        View DTR
                                    </a>
                                    <div class="modal fade dtr-area" id="viewDTRModal-{{ $staff->id }}" tabindex="-1"
                                        role="dialog">
                                        <div class="modal-dialog modal-dialog-centered"
                                            style="max-width:1500px; margin:auto;">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="d-flex gap-3 bg-light p-3 rounded align-items-center"
                                                    id="print-section">

                                                    {{-- ================= CUT-OFF 1 CARD ================= --}}
                                                    <div style="width: 500px;" class="card staff-card px-1 py-2 shadow-sm mb-0">

                                                        {{-- HEADER --}}
                                                        <div class="col-12">
                                                            <div
                                                                class="p-3 d-flex align-items-center gap-2 justify-content-center">
                                                                <img src="{{ asset('public/img/jbp-icon.jpg') }}"
                                                                    width="40" alt="jbp-logo">
                                                                <div class="d-flex flex-column">
                                                                    <b class="modal-title mt-2 text-bold">JPB Heritage
                                                                        Inland Resort</b>
                                                                    <span style="font-size: 10px;">Progreso Street Illauod, Bugasong, Antique</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <hr>

                                                        <div class="d-flex align-items-center gap-2 justify-content-center">
                                                            <h3 style="font-size: 18px; font-weight: 700;" class="m-0">DAILY TIME RECORD (DTR)</h3>
                                                        </div>

                                                        {{-- STAFF INFO --}}
                                                        <div class="staff-details my-2 text-start d-flex flex-column p-2">
                                                            <span>Staff:
                                                                <u>{{ $staff->first_name }} {{ $staff->middle_name }}
                                                                    {{ $staff->last_name }}</u>
                                                            </span>
                                                            <span>Staff ID: <u>{{ $staff->staff_id }}</u></span>
                                                            <span>Period: <u>{{ $period1 }}</u></span>
                                                        </div>

                                                        {{-- TABLE --}}
                                                        <div class="table-responsive py-0 px-2">
                                                            <table class="table table-bordered" width="100%"
                                                                cellspacing="0">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="background-color: #084D00 !important;"
                                                                            class="bg-theme-primary text-light text-center">
                                                                            DAYS</th>
                                                                        <th style="background-color: #084D00 !important;"
                                                                            class="bg-theme-primary text-light text-center">
                                                                            TIME-IN</th>
                                                                        <th style="background-color: #084D00 !important;"
                                                                            class="bg-theme-primary text-light text-center">
                                                                            TIME-OUT</th>
                                                                        <th style="background-color: #084D00 !important;"
                                                                            class="bg-theme-primary text-light text-center">
                                                                            HOURS</th>
                                                                    </tr>
                                                                </thead>

                                                                <tbody>
                                                                    @foreach ($dates->filter(fn($d) => \Carbon\Carbon::parse($d)->lte($midMonth)) as $day)
                                                                        @php
                                                                            $attendance = $staff->attendancesMonth->firstWhere(
                                                                                'date',
                                                                                $day,
                                                                            );
                                                                        @endphp

                                                                        <tr>
                                                                            <td class="text-center">
                                                                                {{ \Carbon\Carbon::parse($day)->format('d') }}
                                                                            </td>

                                                                            {{-- TIME IN --}}
                                                                            <td class="text-center">
                                                                                {{ optional($attendance)->time_in ? \Carbon\Carbon::parse($attendance->time_in)->format('h:i A') : '-' }}
                                                                            </td>

                                                                            {{-- TIME OUT --}}
                                                                            <td class="text-center">
                                                                                {{ optional($attendance)->time_out ? \Carbon\Carbon::parse($attendance->time_out)->format('h:i A') : '-' }}
                                                                            </td>

                                                                            {{-- HOURS --}}
                                                                            <td class="text-center">
                                                                                @php
                                                                                    $hours = '-';

                                                                                    if (
                                                                                        $attendance &&
                                                                                        $attendance->time_in &&
                                                                                        $attendance->time_out
                                                                                    ) {
                                                                                        $workStart = Carbon\Carbon::createFromTime(
                                                                                            8,
                                                                                            0,
                                                                                        );
                                                                                        $lunchStart = Carbon\Carbon::createFromTime(
                                                                                            12,
                                                                                            0,
                                                                                        );
                                                                                        $lunchEnd = Carbon\Carbon::createFromTime(
                                                                                            13,
                                                                                            0,
                                                                                        );
                                                                                        $workEnd = Carbon\Carbon::createFromTime(
                                                                                            17,
                                                                                            0,
                                                                                        );

                                                                                        $in = Carbon\Carbon::parse(
                                                                                            $attendance->time_in,
                                                                                        );
                                                                                        $out = Carbon\Carbon::parse(
                                                                                            $attendance->time_out,
                                                                                        );

                                                                                        $total = 0;

                                                                                        // ---------------- MORNING BLOCK (8-12)
                                                                                        $morningIn = $in->lt($workStart)
                                                                                            ? $workStart
                                                                                            : $in;
                                                                                        $morningOut = $out->gt(
                                                                                            $lunchStart,
                                                                                        )
                                                                                            ? $lunchStart
                                                                                            : $out;

                                                                                        if (
                                                                                            $morningOut->gt($morningIn)
                                                                                        ) {
                                                                                            $total +=
                                                                                                $morningIn->diffInMinutes(
                                                                                                    $morningOut,
                                                                                                ) / 60;
                                                                                        }

                                                                                        // ---------------- AFTERNOON BLOCK (1-5)
                                                                                        $afternoonIn = $in->lt(
                                                                                            $lunchEnd,
                                                                                        )
                                                                                            ? $lunchEnd
                                                                                            : $in;
                                                                                        $afternoonOut = $out->gt(
                                                                                            $workEnd,
                                                                                        )
                                                                                            ? $workEnd
                                                                                            : $out;

                                                                                        if (
                                                                                            $afternoonOut->gt(
                                                                                                $afternoonIn,
                                                                                            )
                                                                                        ) {
                                                                                            $total +=
                                                                                                $afternoonIn->diffInMinutes(
                                                                                                    $afternoonOut,
                                                                                                ) / 60;
                                                                                        }

                                                                                        // cap to 8 hours
                                                                                        $hours = min($total, 8);
                                                                                    }
                                                                                @endphp

                                                                                {{ $hours !== '-' ? number_format($hours, 2) : '-' }}
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>

                                                    {{-- ================= CUT-OFF 2 CARD ================= --}}
                                                    <div style="width: 500px;" class="card staff-card px-1 py-2 shadow-sm mb-0">

                                                        {{-- HEADER --}}
                                                        <div class="col-12">
                                                            <div
                                                                class="p-3 d-flex align-items-center gap-2 justify-content-center">
                                                                <img src="{{ asset('public/img/jbp-icon.jpg') }}"
                                                                    width="40" alt="jbp-logo">
                                                                <div class="d-flex flex-column">
                                                                    <b class="modal-title mt-2 text-bold">JPB Heritage
                                                                        Inland Resort</b>
                                                                    <span style="font-size: 10px;">Progreso Street Illauod, Bugasong, Antique</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <hr>

                                                        <div
                                                            class="d-flex align-items-center gap-2 justify-content-center">
                                                            <h3 style="font-size: 18px; font-weight: 700;" class="m-0">DAILY TIME RECORD (DTR)</h3>
                                                        </div>

                                                        {{-- STAFF INFO --}}
                                                        <div class="staff-details my-2 text-start d-flex flex-column p-2">
                                                            <span>Staff:
                                                                <u>{{ $staff->first_name }} {{ $staff->middle_name }}
                                                                    {{ $staff->last_name }}</u>
                                                            </span>
                                                            <span>Staff ID: <u>{{ $staff->staff_id }}</u></span>
                                                            <span>Period: <u>{{ $period2 }}</u></span>
                                                        </div>

                                                        {{-- TABLE --}}
                                                        <div class="table-responsive py-0 px-2">
                                                            <table class="table table-bordered" width="100%"
                                                                cellspacing="0">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="background-color: #084D00 !important;"
                                                                            class="bg-theme-primary text-light text-center">
                                                                            DAYS</th>
                                                                        <th style="background-color: #084D00 !important;"
                                                                            class="bg-theme-primary text-light text-center">
                                                                            TIME-IN</th>
                                                                        <th style="background-color: #084D00 !important;"
                                                                            class="bg-theme-primary text-light text-center">
                                                                            TIME-OUT</th>
                                                                        <th style="background-color: #084D00 !important;"
                                                                            class="bg-theme-primary text-light text-center">
                                                                            HOURS</th>
                                                                    </tr>
                                                                </thead>

                                                                <tbody>
                                                                    @foreach ($dates->filter(fn($d) => \Carbon\Carbon::parse($d)->gt($midMonth)) as $day)
                                                                        @php
                                                                            $attendance = $staff->attendancesMonth->firstWhere(
                                                                                'date',
                                                                                $day,
                                                                            );
                                                                        @endphp

                                                                        <tr>
                                                                            <td class="text-center">
                                                                                {{ \Carbon\Carbon::parse($day)->format('d') }}
                                                                            </td>

                                                                            <td class="text-center">
                                                                                {{ optional($attendance)->time_in ? \Carbon\Carbon::parse($attendance->time_in)->format('h:i A') : '-' }}
                                                                            </td>

                                                                            <td class="text-center">
                                                                                {{ optional($attendance)->time_out ? \Carbon\Carbon::parse($attendance->time_out)->format('h:i A') : '-' }}
                                                                            </td>

                                                                            <td class="text-center">
                                                                                @php
                                                                                    $hours = '-';

                                                                                    if (
                                                                                        $attendance &&
                                                                                        $attendance->time_in &&
                                                                                        $attendance->time_out
                                                                                    ) {
                                                                                        $workStart = Carbon\Carbon::createFromTime(
                                                                                            8,
                                                                                            0,
                                                                                        );
                                                                                        $lunchStart = Carbon\Carbon::createFromTime(
                                                                                            12,
                                                                                            0,
                                                                                        );
                                                                                        $lunchEnd = Carbon\Carbon::createFromTime(
                                                                                            13,
                                                                                            0,
                                                                                        );
                                                                                        $workEnd = Carbon\Carbon::createFromTime(
                                                                                            17,
                                                                                            0,
                                                                                        );

                                                                                        $in = Carbon\Carbon::parse(
                                                                                            $attendance->time_in,
                                                                                        );
                                                                                        $out = Carbon\Carbon::parse(
                                                                                            $attendance->time_out,
                                                                                        );

                                                                                        $total = 0;

                                                                                        // ---------------- MORNING BLOCK (8-12)
                                                                                        $morningIn = $in->lt($workStart)
                                                                                            ? $workStart
                                                                                            : $in;
                                                                                        $morningOut = $out->gt(
                                                                                            $lunchStart,
                                                                                        )
                                                                                            ? $lunchStart
                                                                                            : $out;

                                                                                        if (
                                                                                            $morningOut->gt($morningIn)
                                                                                        ) {
                                                                                            $total +=
                                                                                                $morningIn->diffInMinutes(
                                                                                                    $morningOut,
                                                                                                ) / 60;
                                                                                        }

                                                                                        // ---------------- AFTERNOON BLOCK (1-5)
                                                                                        $afternoonIn = $in->lt(
                                                                                            $lunchEnd,
                                                                                        )
                                                                                            ? $lunchEnd
                                                                                            : $in;
                                                                                        $afternoonOut = $out->gt(
                                                                                            $workEnd,
                                                                                        )
                                                                                            ? $workEnd
                                                                                            : $out;

                                                                                        if (
                                                                                            $afternoonOut->gt(
                                                                                                $afternoonIn,
                                                                                            )
                                                                                        ) {
                                                                                            $total +=
                                                                                                $afternoonIn->diffInMinutes(
                                                                                                    $afternoonOut,
                                                                                                ) / 60;
                                                                                        }

                                                                                        // cap to 8 hours
                                                                                        $hours = min($total, 8);
                                                                                    }
                                                                                @endphp

                                                                                {{ $hours !== '-' ? number_format($hours, 2) : '-' }}
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>

                                                    <button id="print-buttons" onclick="printDTR()"
                                                        class="btn btn-light shadow-sm p-2 d-flex flex-column align-items-center">
                                                        <b>Print DTR</b>
                                                        <i style="font-size: 50px" class="fa fa-print text-success"></i>
                                                    </button>
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

    <script>
        function printDTR() {
            printJS({
                printable: 'print-section',
                type: 'html',
                targetStyles: ['*'],
                css: [
                    "{{ asset('public/css/styles.css') }}",
                    '{{ asset('public/css/bootstrap.min.css') }}'
                ],
                scanStyles: true,
                ignoreElements: ['print-buttons']
            });
        }
    </script>

    <!-- Content Row -->
@endsection <!-- End the content section -->
