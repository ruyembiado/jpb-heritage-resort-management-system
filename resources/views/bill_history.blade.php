@extends('layouts.auth') <!-- Extend the main layout -->

@section('content')
    <!-- Start the content section -->
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div class="d-flex">
            <i class="fa fa-money-bill fa-2x text-dark me-2"></i>
            <div class="d-flex flex-column">
                <h1 class="h3 mb-0 text">AVAILED SERVICES</h1>
                <h6 class="mb-0">Guest | Bill History</h6>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row justify-content-center">
        <div class="card col-6 shadow mb-4 text-center">
            <div class="card-body">
                <div id="calendar"></div>
                <button class="btn btn-primary mt-3 d-none" data-bs-toggle="modal" data-bs-target="#viewBillModal">
                    View Bill
                </button>
            </div>
        </div>
    </div>

    <div class="modal fade" id="viewBillModal" tabindex="-1" role="dialog" aria-labelledby="viewBillModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width:1500px; margin:auto;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="d-flex gap-3 bg-light p-3 rounded overflow-auto" style="white-space: nowrap;">
                    @foreach ($visitors as $visitor)
                        <div class="card visitor-card col-4 px-1 py-2 shadow-sm mb-0"
                            data-date="{{ \Carbon\Carbon::parse($visitor->created_at)->format('Y-m-d') }}">
                            <div class="col-12">
                                <div class="d-flex align-items-center gap-2 justify-content-center">
                                    <img src="{{ asset('public/img/jbp-icon.jpg') }}" width="70" alt="jbp-logo">
                                    <div class="d-flex flex-column">
                                        <b class="modal-title mt-2 text-bold">JPB Heritage Inland
                                            Resort</b>
                                        <span>Progreso Street Illauod, Bugasong, Antique</span>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div
                                class="bg-theme-primary d-flex align-items-center gap-2 justify-content-center text-light p-2">
                                <h3 class="m-0">BILL RECEIPT</h3>
                            </div>
                            <div class="visitor-name my-2 d-flex align-items-center gap-2">
                                <label class="col-4" for="visitorName">Visitor Name:</label>
                                <input type="text" class="form-control" id="visitorName"
                                    value="{{ $visitor->first_name . ' ' . $visitor->middle_name . ' ' . $visitor->last_name }}"
                                    readonly>
                            </div>
                            <div class="table-responsive p-0">
                                <table class="table table-bordered border-none m-0">
                                    <thead class="bg-success text-light">
                                        <tr>
                                            <th style="border-width: 0px" class="text-center bg-success text-light">
                                                AVAILED SERVICES</th>
                                            <th style="border-width: 0px" class="text-center bg-success text-light">AMOUNT
                                                FEE</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($visitor->entrance)
                                            <tr>
                                                <td style="border-width: 0px">Entrance Fee</td>
                                                <td style="border-width: 0px" class="text-center">
                                                    ₱{{ number_format($visitor->entrance->total_payment, 2) }}
                                                </td>
                                            </tr>
                                        @endif
                                        @if ($visitor->cottage)
                                            <tr>
                                                <td style="border-width: 0px">Cottage Fee</td>
                                                <td style="border-width: 0px" class="text-center">
                                                    ₱{{ number_format($visitor->cottage->total_payment, 2) }}
                                                </td>
                                            </tr>
                                        @endif
                                        @if ($visitor->accommodation)
                                            <tr>
                                                <td style="border-width: 0px">Room Accommodation
                                                </td>
                                                <td style="border-width: 0px" class="text-center">
                                                    ₱{{ number_format($visitor->accommodation->total_payment, 2) }}
                                                </td>
                                            </tr>
                                        @endif
                                        @if ($visitor->functionHall)
                                            <tr>
                                                <td style="border-width: 0px">Function Hall
                                                </td>
                                                <td style="border-width: 0px" class="text-center">
                                                    ₱{{ number_format($visitor->functionHall->total_payment, 2) }}
                                                </td>
                                            </tr>
                                        @endif
                                        @if ($visitor->meal)
                                            <tr>
                                                <td style="border-width: 0px">Foods</td>
                                                <td style="border-width: 0px" class="text-center">
                                                    ₱{{ number_format($visitor->meal->total_payment, 2) }}
                                                </td>
                                            </tr>
                                        @endif
                                        @if ($visitor->beverage)
                                            <tr>
                                                <td style="border-width: 0px">Drinks</td>
                                                <td style="border-width: 0px" class="text-center">
                                                    ₱{{ number_format($visitor->beverage->total_payment, 2) }}
                                                </td>
                                            </tr>
                                        @endif
                                        @php
                                            $grand_total =
                                                ($visitor->entrance->total_payment ?? 0) +
                                                ($visitor->accommodation->total_payment ?? 0) +
                                                ($visitor->functionHall->total_payment ?? 0) +
                                                ($visitor->cottage->total_payment ?? 0) +
                                                ($visitor->meal->total_payment ?? 0) +
                                                ($visitor->beverage->total_payment ?? 0);
                                        @endphp
                                        <tr class="bg-dark text-light">
                                            <td style="border-width: 0px"></td>
                                            <td style="border-width: 0px" class="fw-semibold text-center">
                                                ₱{{ number_format($grand_total, 2) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
@endsection <!-- End the content section -->

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const visitors = @json($visitors);

        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },

            events: visitors.map(v => ({
                allDay: true
            })),

            dateClick: function(info) {
                let selectedDate = info.dateStr;
                document.querySelectorAll('.visitor-card').forEach(card => {
                    if (card.dataset.date === selectedDate) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });

                var modal = new bootstrap.Modal(document.getElementById('viewBillModal'));
                modal.show();
            }
        });
        calendar.render();
    });
</script>
