@extends('layouts.auth')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div class="d-flex">
            <i class="fa-solid fa-bed fa-2x text-dark me-2"></i>
            <div class="d-flex flex-column">
                <h1 class="h3 mb-0 text">AVAILED SERVICES</h1>
                <h6 class="mb-0">Guest | Accommodation Fees</h6>
            </div>
        </div>
        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAccommodationModal">Add Facilities
            Fee</a>
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
            <div class="d-flex gap-2">
                <a href="{{ url('accommodations') }}" class="btn btn-success d-flex align-items-center gap-2">
                    <i class="fa-solid fa-bed"></i>
                    Room Accommodation
                </a>
                <a href="{{ url('function-halls') }}"
                    class="btn bg-theme-primary text-light d-flex align-items-center gap-2">
                    <i class="fa-solid fa-building-columns"></i>
                    Function Hall
                </a>
            </div>
            <div class="table-responsive" style="overflow-x:auto;">
                <table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0"
                    style="min-width:1400px;">
                    <thead>
                        <tr>
                            <th class="bg-theme-primary text-light border-dark">NO.</th>
                            <th class="bg-theme-primary text-light border-dark">NAME OF GUEST</th>
                            <th class="bg-theme-primary text-light border-dark">ROOM CATEGORY</th>
                            <th class="bg-theme-primary text-light border-dark">NO. OF NIGHTS</th>
                            <th class="bg-theme-primary text-light border-dark">TOTAL FEE</th>
                            <th class="bg-theme-primary text-light border-dark">STATUS</th>
                            <th class="bg-theme-primary text-light border-dark">DATE CREATED</th>
                            <th class="bg-theme-primary text-light border-dark sticky-action">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($accommodations as $accommodation)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    {{ optional($accommodation->visitor)->first_name }}
                                    {{ optional($accommodation->visitor)->middle_name }}
                                    {{ optional($accommodation->visitor)->last_name }}
                                </td>
                                <td>
                                    @php
                                        $rooms = json_decode($accommodation->room, true);
                                        $fees = json_decode($accommodation->fee, true);
                                    @endphp
                                    <ul style="list-style-type: none; padding: 5px; margin: 0;">
                                        @foreach ($rooms as $index => $room)
                                            <li>{{ $room }} - ₱{{ number_format($fees[$index], 2) }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>
                                    @php
                                        $qtys = json_decode($accommodation->quantity, true);
                                    @endphp
                                    <ul style="list-style-type: none; padding: 5px; margin: 0;">
                                        @foreach ($qtys as $index => $qty)
                                            <li>{{ $qty }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>₱ {{ number_format($accommodation->total_payment, 2) }}</td>
                                <td>
                                    <span
                                        class="badge {{ $accommodation->status === 'Paid' ? 'bg-success' : 'bg-danger' }}">
                                        {{ $accommodation->status }}
                                    </span>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($accommodation->created_at)->format('F j, Y') }}</td>
                                <td class="sticky-action">
                                    <div class="d-flex align-items-center justify-c gap-2">
                                        <a href="#" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#editAccommodationModal" data-id="{{ $accommodation->id }}"
                                            data-visitor-id="{{ $accommodation->visitor_id }}"
                                            data-rooms="{{ $accommodation->room }}" data-fees="{{ $accommodation->fee }}"
                                            data-quantities="{{ $accommodation->quantity }}"
                                            data-service-types='accommodation'
                                            data-total-payment="{{ $accommodation->total_payment }}"
                                            data-accommodation-status="{{ $accommodation->status ?? '' }}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('accommodation.destroy', $accommodation->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to delete this accommodation?')">
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

    <!-- Add Accommodation Modal -->
    <div class="modal fade" id="addAccommodationModal" tabindex="-1" role="dialog"
        aria-labelledby="addAccommodationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" style="max-width: 1520px;">
            <form id="addAccommodationForm" action="{{ route('accommodation.store') }}" method="POST">
                @csrf
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
                        <div class="form-group mb-3">
                            <div class="col-4 d-flex align-items-center gap-3">
                                <label for="visitor_id">Name:</label>
                                <select name="visitor_id" class="form-control select2" id="visitor_name" required
                                    data-placeholder="Select a visitor">
                                    <option></option>
                                    @foreach ($visitors as $visitor)
                                        <option value="{{ $visitor->id }}">{{ $visitor->first_name }}
                                            {{ $visitor->middle_name }}
                                            {{ $visitor->last_name }} -
                                            {{ \Carbon\Carbon::parse($visitor->date_visit)->format('F j, Y') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Room Accommodation Section -->
                            <div class="col-md-6">
                                <div
                                    class="bg-theme-primary d-flex align-items-center gap-2 justify-content-center text-light p-2">
                                    <i class="fa fa-bed fa-2x"></i>
                                    <h3 class="m-0">ROOM ACCOMMODATION</h3>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered table table-bordered border-dark">
                                        <thead class="bg-success text-light">
                                            <tr>
                                                <th class="bg-success text-light" width="5%">SELECT</th>
                                                <th class="bg-success text-light">ROOM</th>
                                                <th class="bg-success text-light" width="20%">NO. OF NIGHTS</th>
                                                <th class="bg-success text-light" width="15%">FEE</th>
                                                <th class="bg-success text-light" width="15%">SUB-TOTAL</th>
                                            </tr>
                                        </thead>
                                        <tbody id="accommodation-table-body">
                                            @foreach ($accommodationFees as $index => $room)
                                                <tr data-type="accommodation">
                                                    <td class="text-center" style="padding: 5px;">
                                                        <input type="checkbox" name="accommodation_services[]"
                                                            value="{{ $room['service_name'] }}"
                                                            class="accommodation-checkbox form-check-input"
                                                            data-type="accommodation" data-fee="{{ $room['fee'] }}">
                                                    </td>
                                                    <td style="padding: 5px;">
                                                        <input type="hidden" name="accommodation_service_names[]"
                                                            value="{{ $room['service_name'] }}">
                                                        <input type="text" class="form-control"
                                                            value="{{ $room['service_name'] }}" readonly>
                                                    </td>
                                                    <td style="padding: 5px;">
                                                        <input type="number" name="accommodation_quantities[]"
                                                            class="form-control accommodation-quantity" min="0"
                                                            value="0" step="1">
                                                    </td>
                                                    <td style="padding: 5px;">
                                                        <input type="text" class="form-control accommodation-fee"
                                                            name="accommodation_fees[]"
                                                            value="{{ number_format($room['fee'], 2) }}" readonly>
                                                    </td>
                                                    <td style="padding: 5px;">
                                                        <input type="text" name="accommodation_subtotals[]"
                                                            class="form-control accommodation-subtotal" readonly
                                                            value="0.00">
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="form-group">
                                    <div class="d-flex align-items-center justify-content-end gap-3">
                                        <label>Payment Status:</label>
                                        <div class="col-3">
                                            <select name="accommodation_payment_status" class="form-control"
                                                id="accommodation_payment_status">
                                                <option value="">Select status</option>
                                                <option value="Paid">Paid</option>
                                                <option value="Unpaid">Unpaid</option>
                                            </select>
                                        </div>
                                        <label>Total Fee:</label>
                                        <div class="col-3">
                                            <div class="d-flex">
                                                <span class="input-group-text bg-theme-primary text-light">₱</span>
                                                <input type="text" name="accommodation_total" id="accommodation_total"
                                                    value="0.00" class="form-control" readonly required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Function Hall Section -->
                            <div class="col-md-6">
                                <div
                                    class="bg-theme-primary d-flex align-items-center gap-2 justify-content-center text-light p-2">
                                    <i class="fa fa-building-columns fa-2x"></i>
                                    <h3 class="m-0">FUNCTION HALL</h3>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered border-dark">
                                        <thead class="bg-success text-light">
                                            <tr>
                                                <th class="bg-success text-light" width="5%">SELECT</th>
                                                <th class="bg-success text-light">FUNCTION HALL</th>
                                                <th class="bg-success text-light" width="20%">QTY</th>
                                                <th class="bg-success text-light" width="15%">FEE</th>
                                                <th class="bg-success text-light" width="15%">SUB-TOTAL</th>
                                            </tr>
                                        </thead>
                                        <tbody id="functionhall-table-body">
                                            @foreach ($functionFees as $index => $hall)
                                                <tr data-type="functionhall">
                                                    <td class="text-center" style="padding: 5px;">
                                                        <input type="checkbox" name="functionhall_services[]"
                                                            value="{{ $hall['service_name'] }}"
                                                            class="functionhall-checkbox form-check-input"
                                                            data-type="functionhall" data-fee="{{ $hall['fee'] }}">
                                                    </td>
                                                    <td style="padding: 5px;">
                                                        <input type="hidden" name="functionhall_service_names[]"
                                                            value="{{ $hall['service_name'] }}">
                                                        <input type="text" class="form-control"
                                                            value="{{ $hall['service_name'] }}" readonly>
                                                    </td>
                                                    <td style="padding: 5px;">
                                                        <input type="number" name="functionhall_quantities[]"
                                                            class="form-control functionhall-quantity" min="0"
                                                            value="0" step="1">
                                                    </td>
                                                    <td style="padding: 5px;">
                                                        <input type="text" class="form-control functionhall-fee"
                                                            name="functionhall_fees[]"
                                                            value="{{ number_format($hall['fee'], 2) }}" readonly>
                                                    </td>
                                                    <td style="padding: 5px;">
                                                        <input type="text" name="functionhall_subtotals[]"
                                                            class="form-control functionhall-subtotal" readonly
                                                            value="0.00">
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="form-group">
                                    <div class="d-flex align-items-center justify-content-end gap-3">
                                        <label>Payment Status:</label>
                                        <div class="col-3">
                                            <select name="functionhall_payment_status" class="form-control"
                                                id="functionhall_payment_status">
                                                <option value="">Select status</option>
                                                <option value="Paid">Paid</option>
                                                <option value="Unpaid">Unpaid</option>
                                            </select>
                                        </div>
                                        <label>Total Fee:</label>
                                        <div class="col-3">
                                            <div class="d-flex">
                                                <span class="input-group-text bg-theme-primary text-light">₱</span>
                                                <input type="text" name="functionhall_total" id="functionhall_total"
                                                    value="0.00" class="form-control" readonly required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="grand_total" id="grand_total" value="0.00">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Save</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Accommodation Modal -->
    <div class="modal fade" id="editAccommodationModal" tabindex="-1" role="dialog"
        aria-labelledby="editAccommodationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form id="editAccommodationForm" action="{{ route('accommodation.update') }}" method="POST">
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
                        <input type="hidden" name="accommodation_id" id="edit_accommodation_id">
                        <div class="form-group mb-3">
                            <div class="col-8 d-flex align-items-center gap-3">
                                <label for="edit_visitor_id">Name:</label>
                                <select name="visitor_id" class="form-control select2" id="edit_visitor_id" required
                                    data-placeholder="Select a visitor">
                                    <option></option>
                                    @foreach ($visitors as $visitor)
                                        <option value="{{ $visitor->id }}">{{ $visitor->first_name }}
                                            {{ $visitor->middle_name }}
                                            {{ $visitor->last_name }} -
                                            {{ \Carbon\Carbon::parse($visitor->date_visit)->format('F j, Y') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <!-- Room Accommodation Section -->
                            <div class="">
                                <div
                                    class="bg-theme-primary d-flex align-items-center gap-2 justify-content-center text-light p-2">
                                    <i class="fa fa-bed fa-2x"></i>
                                    <h3 class="m-0">ROOM ACCOMMODATION</h3>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered border-dark">
                                        <thead class="bg-success text-light">
                                            <tr>
                                                <th class="bg-success text-light" width="5%">SELECT</th>
                                                <th class="bg-success text-light">ROOM</th>
                                                <th class="bg-success text-light" width="20%">NO. OF NIGHTS</th>
                                                <th class="bg-success text-light" width="15%">FEE</th>
                                                <th class="bg-success text-light" width="15%">SUB-TOTAL</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($accommodationFees as $index => $room)
                                                <tr data-type="accommodation">
                                                    <td style="padding: 5px;" class="text-center">
                                                        <input type="checkbox" name="edit_accommodation_services[]"
                                                            value="{{ $room['service_name'] }}"
                                                            class="edit-accommodation-checkbox form-check-input"
                                                            data-type="accommodation" data-fee="{{ $room['fee'] }}">
                                                    </td>
                                                    <td style="padding: 5px;">
                                                        <input type="hidden" name="edit_accommodation_service_names[]"
                                                            value="{{ $room['service_name'] }}">
                                                        <input type="text" class="form-control"
                                                            value="{{ $room['service_name'] }}" readonly>
                                                    </td>
                                                    <td style="padding: 5px;">
                                                        <input type="number" name="edit_accommodation_quantities[]"
                                                            class="form-control edit-accommodation-quantity"
                                                            min="0" value="0" step="1">
                                                    </td>
                                                    <td style="padding: 5px;">
                                                        <input type="text" class="form-control edit-accommodation-fee"
                                                            name="edit_accommodation_fees[]" value="{{ number_format($room['fee'], 2) }}" readonly>
                                                    </td>
                                                    <td style="padding: 5px;">
                                                        <input type="text" name="edit_accommodation_subtotals[]"
                                                            class="form-control edit-accommodation-subtotal" readonly
                                                            value="0.00">
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="form-group">
                                    <div class="d-flex align-items-center justify-content-end gap-3">
                                        <label>Payment Status:</label>
                                        <div class="col-3">
                                            <select name="accommodation_payment_status" class="form-control"
                                                id="edit_accommodation_payment_status">
                                                <option value="">Select status</option>
                                                <option value="Paid">Paid</option>
                                                <option value="Unpaid">Unpaid</option>
                                            </select>
                                        </div>
                                        <label>Total Fee:</label>
                                        <div class="col-3">
                                            <div class="d-flex">
                                                <span class="input-group-text bg-theme-primary text-light">₱</span>
                                                <input type="text" name="accommodation_total"
                                                    id="edit_accommodation_total" value="0.00" class="form-control"
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="grand_total" id="edit_grand_total" value="0.00">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Update</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Check if jQuery is loaded
        if (typeof jQuery === 'undefined') {
            console.error('jQuery is not loaded');
            return;
        }

        // Initialize Select2 for add form
        $('#addAccommodationModal').on('shown.bs.modal', function() {
            $('#visitor_name').select2({
                theme: 'bootstrap4',
                width: '100%',
                placeholder: "Select a visitor",
                allowClear: true,
                dropdownParent: $('#addAccommodationModal')
            });
            resetAddForm();
        });

        function resetAddForm() {
            // Reset accommodation section
            $('.accommodation-checkbox').prop('checked', false);
            $('.accommodation-quantity').val('0');
            $('.accommodation-subtotal').val('0.00');
            $('#accommodation_total').val('0.00');
            $('#accommodation_payment_status').val('');

            // Reset function hall section
            $('.functionhall-checkbox').prop('checked', false);
            $('.functionhall-quantity').val('0');
            $('.functionhall-subtotal').val('0.00');
            $('#functionhall_total').val('0.00');
            $('#functionhall_payment_status').val('');

            // Reset grand total
            $('#grand_total').val('0.00');
        }

        // Calculate accommodation subtotal
        $(document).on('input', '.accommodation-quantity', function() {
            const row = $(this).closest('tr');
            const checkbox = row.find('.accommodation-checkbox');
            const quantity = parseFloat($(this).val()) || 0;
            const feeText = row.find('.accommodation-fee').val();
            const fee = parseFloat(feeText.replace(/,/g, '')) || 0;
            const subtotal = quantity * fee;

            row.find('.accommodation-subtotal').val(subtotal.toFixed(2));

            if (quantity > 0) {
                checkbox.prop('checked', true);
            } else {
                checkbox.prop('checked', false);
            }

            updateAccommodationTotal();
            updateGrandTotal();
        });

        // Handle accommodation checkbox changes
        $(document).on('change', '.accommodation-checkbox', function() {
            const row = $(this).closest('tr');
            const quantityInput = row.find('.accommodation-quantity');

            if ($(this).is(':checked')) {
                if (parseFloat(quantityInput.val()) === 0) {
                    quantityInput.val('1').trigger('input');
                }
            } else {
                quantityInput.val('0').trigger('input');
            }
        });

        // Update accommodation total
        function updateAccommodationTotal() {
            let total = 0;
            $('.accommodation-checkbox:checked').each(function() {
                const row = $(this).closest('tr');
                const subtotal = parseFloat(row.find('.accommodation-subtotal').val()) || 0;
                total += subtotal;
            });
            $('#accommodation_total').val(total.toFixed(2));
        }

        // Calculate function hall subtotal
        $(document).on('input', '.functionhall-quantity', function() {
            const row = $(this).closest('tr');
            const checkbox = row.find('.functionhall-checkbox');
            const quantity = parseFloat($(this).val()) || 0;
            const feeText = row.find('.functionhall-fee').val();
            const fee = parseFloat(feeText.replace(/,/g, '')) || 0;
            const subtotal = quantity * fee;

            row.find('.functionhall-subtotal').val(subtotal.toFixed(2));

            if (quantity > 0) {
                checkbox.prop('checked', true);
            } else {
                checkbox.prop('checked', false);
            }

            updateFunctionHallTotal();
            updateGrandTotal();
        });

        // Handle function hall checkbox changes
        $(document).on('change', '.functionhall-checkbox', function() {
            const row = $(this).closest('tr');
            const quantityInput = row.find('.functionhall-quantity');

            if ($(this).is(':checked')) {
                if (parseFloat(quantityInput.val()) === 0) {
                    quantityInput.val('1').trigger('input');
                }
            } else {
                quantityInput.val('0').trigger('input');
            }
        });

        // Update function hall total
        function updateFunctionHallTotal() {
            let total = 0;
            $('.functionhall-checkbox:checked').each(function() {
                const row = $(this).closest('tr');
                const subtotal = parseFloat(row.find('.functionhall-subtotal').val()) || 0;
                total += subtotal;
            });
            $('#functionhall_total').val(total.toFixed(2));
        }

        // Update grand total
        function updateGrandTotal() {
            const accommodationTotal = parseFloat($('#accommodation_total').val()) || 0;
            const functionhallTotal = parseFloat($('#functionhall_total').val()) || 0;
            const grandTotal = accommodationTotal + functionhallTotal;
            $('#grand_total').val(grandTotal.toFixed(2));
        }

        // Validate add form
        $('#addAccommodationForm').on('submit', function(e) {
            const visitorId = $('#visitor_name').val();
            if (!visitorId) {
                e.preventDefault();
                alert('Please select a visitor.');
                return false;
            }

            const accommodationChecked = $(this).find('.accommodation-checkbox:checked').length;
            const functionhallChecked = $(this).find('.functionhall-checkbox:checked').length;

            // if (accommodationChecked === 0 && functionhallChecked === 0) {
            //     e.preventDefault();
            //     alert('Please select at least one service (Accommodation or Function Hall).');
            //     return false;
            // }

            // Validate accommodation quantities if checked
            let invalid = false;
            $('.accommodation-checkbox:checked').each(function() {
                const row = $(this).closest('tr');
                const qty = parseFloat(row.find('.accommodation-quantity').val());
                if (qty <= 0) {
                    invalid = true;
                    alert(
                        'Please enter valid quantity for all selected accommodation services.');
                    return false;
                }
            });

            // Validate function hall quantities if checked
            $('.functionhall-checkbox:checked').each(function() {
                const row = $(this).closest('tr');
                const qty = parseFloat(row.find('.functionhall-quantity').val());
                if (qty <= 0) {
                    invalid = true;
                    alert(
                        'Please enter valid quantity for all selected function hall services.');
                    return false;
                }
            });

            if (invalid) {
                e.preventDefault();
                return false;
            }

            // Validate payment status for selected sections
            const accommodationTotal = parseFloat($('#accommodation_total').val());
            const functionhallTotal = parseFloat($('#functionhall_total').val());

            // if (accommodationTotal > 0) {
            //     const accommodationStatus = $('#accommodation_payment_status').val();
            //     if (!accommodationStatus) {
            //         e.preventDefault();
            //         alert('Please select payment status for Accommodation section.');
            //         return false;
            //     }
            // }

            // if (functionhallTotal > 0) {
            //     const functionhallStatus = $('#functionhall_payment_status').val();
            //     if (!functionhallStatus) {
            //         e.preventDefault();
            //         alert('Please select payment status for Function Hall section.');
            //         return false;
            //     }
            // }

            const grandTotal = parseFloat($('#grand_total').val());
            if (grandTotal <= 0) {
                e.preventDefault();
                alert('Total payment must be greater than 0.');
                return false;
            }
        });

        // ==================== EDIT MODAL FUNCTIONS ====================

        // Initialize Select2 for edit modal
        $('#editAccommodationModal').on('shown.bs.modal', function() {
            $('#edit_visitor_id').select2({
                theme: 'bootstrap4',
                width: '100%',
                placeholder: "Select a visitor",
                allowClear: true,
                dropdownParent: $('#editAccommodationModal')
            });
        });

        // ==================== EDIT MODAL FUNCTIONS ====================

        // Initialize Select2 for edit modal
        $('#editAccommodationModal').on('shown.bs.modal', function() {
            $('#edit_visitor_id').select2({
                theme: 'bootstrap4',
                width: '100%',
                placeholder: "Select a visitor",
                allowClear: true,
                dropdownParent: $('#editAccommodationModal')
            });
        });

        // Populate edit modal
        $('#editAccommodationModal').on('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const modal = $(this);

            try {
                // Get data from button
                const accommodationId = button.getAttribute('data-id');
                const visitorId = button.getAttribute('data-visitor-id');
                const totalPayment = button.getAttribute('data-total-payment');
                const status = button.getAttribute('data-accommodation-status');

                // Parse JSON data
                let rooms = [];
                let fees = [];
                let quantities = [];

                try {
                    rooms = JSON.parse(button.getAttribute('data-rooms') || '[]');
                    fees = JSON.parse(button.getAttribute('data-fees') || '[]');
                    quantities = JSON.parse(button.getAttribute('data-quantities') || '[]');

                    console.log('Parsed data:', {
                        rooms,
                        fees,
                        quantities
                    });
                } catch (e) {
                    console.error('Error parsing JSON:', e);
                    rooms = [];
                    fees = [];
                    quantities = [];
                }

                // Set form values
                modal.find('#edit_accommodation_id').val(accommodationId);
                modal.find('#edit_visitor_id').val(visitorId).trigger('change');

                // Reset all checkboxes and inputs (only accommodation)
                modal.find('.edit-accommodation-checkbox').prop('checked', false);
                modal.find('.edit-accommodation-quantity').val('0');
                modal.find('.edit-accommodation-subtotal').val('0.00');

                // Populate selected items
                for (let i = 0; i < rooms.length; i++) {
                    const room = rooms[i];
                    const fee = fees[i] || 0;
                    const quantity = quantities[i] || 0;

                    // Calculate subtotal (fee * quantity)
                    const subtotal = fee * quantity;

                    console.log(`Item ${i}: ${room}, Fee: ${fee}, Qty: ${quantity}`);

                    // Find the checkbox with matching value
                    const checkbox = modal.find(`.edit-accommodation-checkbox[value="${room}"]`);
                    if (checkbox.length) {
                        checkbox.prop('checked', true);
                        const row = checkbox.closest('tr');
                        row.find('.edit-accommodation-quantity').val(quantity);
                        row.find('.edit-accommodation-subtotal').val(subtotal.toFixed(2));
                        console.log(`Checked: ${room}`);
                    } else {
                        console.log(`Checkbox not found for: ${room}`);
                    }
                }

                // Update totals after populating
                updateEditAccommodationTotal();
                updateEditGrandTotal();

                // Set payment status
                if (status && status !== '') {
                    modal.find('#edit_accommodation_payment_status').val(status);
                }

                // Set the total payment if needed
                if (totalPayment) {
                    modal.find('#edit_grand_total').val(totalPayment);
                }

            } catch (error) {
                console.error('Error initializing edit modal:', error);
                alert('Error loading accommodation data. Please try again.');
                $(this).modal('hide');
            }
        });

        // Calculate edit accommodation subtotal
        $(document).on('input', '.edit-accommodation-quantity', function() {
            const row = $(this).closest('tr');
            const checkbox = row.find('.edit-accommodation-checkbox');
            const quantity = parseFloat($(this).val()) || 0;
            const feeText = row.find('.edit-accommodation-fee').val();
            const fee = parseFloat(feeText.replace(/,/g, '')) || 0;
            const subtotal = quantity * fee;

            row.find('.edit-accommodation-subtotal').val(subtotal.toFixed(2));

            if (quantity > 0) {
                checkbox.prop('checked', true);
            } else {
                checkbox.prop('checked', false);
            }

            updateEditAccommodationTotal();
            updateEditGrandTotal();
        });

        // Handle edit accommodation checkbox changes
        $(document).on('change', '.edit-accommodation-checkbox', function() {
            const row = $(this).closest('tr');
            const quantityInput = row.find('.edit-accommodation-quantity');

            if ($(this).is(':checked')) {
                if (parseFloat(quantityInput.val()) === 0) {
                    quantityInput.val('1').trigger('input');
                }
            } else {
                quantityInput.val('0').trigger('input');
            }
        });

        // Update edit accommodation total
        function updateEditAccommodationTotal() {
            let total = 0;
            $('.edit-accommodation-checkbox:checked').each(function() {
                const row = $(this).closest('tr');
                const subtotal = parseFloat(row.find('.edit-accommodation-subtotal').val()) || 0;
                total += subtotal;
            });
            $('#edit_accommodation_total').val(total.toFixed(2));
        }

        // Update edit grand total
        function updateEditGrandTotal() {
            const accommodationTotal = parseFloat($('#edit_accommodation_total').val()) || 0;
            $('#edit_grand_total').val(accommodationTotal.toFixed(2));
        }

        // Validate edit form
        $('#editAccommodationForm').on('submit', function(e) {
            const visitorId = $('#edit_visitor_id').val();
            if (!visitorId) {
                e.preventDefault();
                alert('Please select a visitor.');
                return false;
            }

            const accommodationChecked = $(this).find('.edit-accommodation-checkbox:checked').length;

            // if (accommodationChecked === 0) {
            //     e.preventDefault();
            //     alert('Please select at least one room accommodation.');
            //     return false;
            // }

            let invalid = false;

            // Validate accommodation quantities
            $('.edit-accommodation-checkbox:checked').each(function() {
                const row = $(this).closest('tr');
                const qty = parseFloat(row.find('.edit-accommodation-quantity').val());
                if (qty <= 0) {
                    invalid = true;
                    alert('Please enter valid number of nights for all selected rooms.');
                    return false;
                }
            });

            if (invalid) {
                e.preventDefault();
                return false;
            }

            // Validate payment status
            const accommodationTotal = parseFloat($('#edit_accommodation_total').val());

            if (accommodationTotal > 0) {
                const accommodationStatus = $('#edit_accommodation_payment_status').val();
                if (!accommodationStatus) {
                    e.preventDefault();
                    alert('Please select payment status.');
                    return false;
                }
            }

            const grandTotal = parseFloat($('#edit_grand_total').val());
            if (grandTotal <= 0) {
                e.preventDefault();
                alert('Total payment must be greater than 0.');
                return false;
            }
        });
    });
</script>
