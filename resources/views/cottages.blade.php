@extends('layouts.auth')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div class="d-flex">
            <i class="fas fa-home fa-2x text-dark me-2"></i>
            <div class="d-flex flex-column">
                <h1 class="h3 mb-0 text">AVAILED SERVICES</h1>
                <h6 class="mb-0">Guest | Cottage Fees</h6>
            </div>
        </div>
        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCottageModal">Add Cottage Fee</a>
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

            <div class="table-responsive" style="overflow-x:auto;">
                <table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0"
                    style="min-width:1000px;">
                    <thead>
                        <tr>
                            <th class="bg-theme-primary text-light border-dark">NO.</th>
                            <th class="bg-theme-primary text-light border-dark">NAME OF GUEST</th>
                            {{-- <th class="bg-theme-primary text-light border-dark text-center">MEMBERS</th> --}}
                            <th class="bg-theme-primary text-light border-dark">COTTAGE CATEGORY</th>
                            <th class="bg-theme-primary text-light border-dark">TOTAL FEE</th>
                            <th class="bg-theme-primary text-light border-dark">STATUS</th>
                            <th class="bg-theme-primary text-light border-dark">DATE CREATED</th>
                            <th class="bg-theme-primary text-light border-dark sticky-action">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cottages as $cottage)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    {{ optional($cottage->visitor)->first_name }}
                                    {{ optional($cottage->visitor)->middle_name }}
                                    {{ optional($cottage->visitor)->last_name }}
                                </td>
                                {{-- <td class="text-center">{{ $cottage->visitor->members }}</td> --}}
                                <td>
                                    @php
                                        $cottage_types = json_decode($cottage->cottage_type, true);
                                        $quantities = json_decode($cottage->quantity, true);
                                        $fees = json_decode($cottage->fee, true);
                                    @endphp
                                    <ul style="list-style-type: none; padding: 5px; margin: 0;">
                                        @foreach ($cottage_types as $index => $cottage_type)
                                            @if ($quantities[$index] > 0)
                                                <li>{{ $cottage_type }} -
                                                    ₱{{ number_format($fees[$index], 2) }}
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </td>
                                <td>₱ {{ number_format($cottage->total_payment, 2) }}</td>
                                <td>
                                    <span class="badge {{ $cottage->status === 'Paid' ? 'bg-success' : 'bg-danger' }}">
                                        {{ $cottage->status }}
                                    </span>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($cottage->created_at)->format('F j, Y') }}</td>
                                <td>
                                    <div class="d-flex align-items-center justify-c gap-2">
                                        <a href="#" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#editCottageModal" data-id="{{ $cottage->id }}"
                                            data-visitor-id="{{ $cottage->visitor_id }}"
                                            data-cottage-area="{{ $cottage->cottage_area }}"
                                            data-cottage-type='{{ $cottage->cottage_type }}'
                                            data-quantity='{{ $cottage->quantity }}' data-fee='{{ $cottage->fee }}'
                                            data-total-payment="{{ $cottage->total_payment }}"
                                            data-status="{{ $cottage->status }}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('cottage.destroy', $cottage->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to delete this cottage rental?')">
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

    {{-- Add Cottage Modal --}}
    <div class="modal fade" id="addCottageModal" tabindex="-1" role="dialog" aria-labelledby="addCottageModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form action="{{ route('cottage.store') }}" method="POST" id="cottageAddForm">
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
                        <div class="d-flex gap-2 form-group mb-3">
                            <div class="form-group col-8 d-flex align-items-center gap-3">
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
                            <input type="hidden" name="cottage_area" id="cottage_area" class="form-control" required
                                value="Cottage Fee">
                        </div>
                        <div
                            class="bg-theme-primary d-flex align-items-center gap-2 justify-content-center text-light p-2">
                            <i class="fa fa-book fa-2x"></i>
                            <h3 class="m-0">COTTAGE FEE</h3>
                        </div>
                        <table class="table table-bordered border-dark" width="100%" cellspacing="0">
                            <thead>
                                <tr class="bg-secondary text-light">
                                    <th class="bg-success text-light text-center" style="padding: 10px;">SELECT</th>
                                    <th class="bg-success text-light" style="padding: 10px;">COTTAGE</th>
                                    <th class="bg-success text-light" style="padding: 10px;">FEE</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cottageFees as $index => $cottage)
                                    <tr>
                                        <td width="10%" style="" class="text-center">
                                            <input class="form-check-input cottage-checkbox" name="quantity[]"
                                                type="checkbox" value="1">
                                            <input type="hidden" name="cottage_type[]"
                                                value="{{ $cottage['service_name'] }}">
                                            <input type="hidden" name="fees[]" value="{{ $cottage['fee'] }}">
                                        </td>
                                        <td width="" style="padding: 5px;">
                                            <input class="form-control" type="text"
                                                value="{{ $cottage['service_name'] }}" readonly>
                                        </td>
                                        <td width="15%" style="padding: 5px;">
                                            <input class="form-control cottage-fee" type="text"
                                                value="{{ number_format($cottage['fee'], 2) }}" readonly>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="form-group mb-2">
                            <div class="d-flex align-items-center gap-3">
                                <label>Payment Status:</label>
                                <div class="col-2">
                                    <select name="payment_status" class="form-control" required>
                                        <option value="">Select status</option>
                                        <option value="Paid">Paid</option>
                                        <option value="Unpaid">Unpaid</option>
                                    </select>
                                </div>
                                <label>Total Fee:</label>
                                <div class="col-3">
                                    <div class="d-flex">
                                        <span class="input-group-text bg-theme-primary text-light">₱</span>
                                        <input type="text" name="total_payment" id="total_payment" value="0.00"
                                            class="form-control" readonly required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Save</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Edit Cottage Modal (Same style as Add Modal) --}}
    <div class="modal fade" id="editCottageModal" tabindex="-1" role="dialog" aria-labelledby="editCottageModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form action="{{ route('cottage.update') }}" method="POST" id="cottageEditForm">
                @csrf
                @method('PUT')
                <input type="hidden" name="cottage_id" id="edit_cottage_id">
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
                        <div class="d-flex gap-2 form-group mb-3">
                            <div class="form-group col-8 d-flex align-items-center gap-3">
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
                            <input type="hidden" name="cottage_area" id="edit_cottage_area" class="form-control"
                                required value="Cottage Fee">
                        </div>
                        <div
                            class="bg-theme-primary d-flex align-items-center gap-2 justify-content-center text-light p-2">
                            <i class="fa fa-book fa-2x"></i>
                            <h3 class="m-0">COTTAGE FEE</h3>
                        </div>
                        <table class="table table-bordered border-dark" width="100%" cellspacing="0">
                            <thead>
                                <tr class="bg-secondary text-light">
                                    <th class="bg-success text-light text-center" style="padding: 10px;">SELECT</th>
                                    <th class="bg-success text-light" style="padding: 10px;">COTTAGE</th>
                                    <th class="bg-success text-light" style="padding: 10px;">FEE</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cottageFees as $index => $cottage)
                                    <tr>
                                        <td width="10%" style="" class="text-center">
                                            <input class="form-check-input edit-cottage-checkbox" name="quantity[]"
                                                type="checkbox" value="1">
                                            <input type="hidden" name="cottage_type[]"
                                                value="{{ $cottage['service_name'] }}">
                                            <input type="hidden" name="fees[]" value="{{ $cottage['fee'] }}">
                                        </td>
                                        <td width="" style="padding: 5px;">
                                            <input class="form-control" type="text"
                                                value="{{ $cottage['service_name'] }}" readonly>
                                            <input type="hidden" name="edit_cottage_types[]"
                                                value="{{ $cottage['service_name'] }}">
                                        </td>
                                        <td width="15%" style="padding: 5px;">
                                            <input class="form-control edit-cottage-fee" type="text"
                                                value="{{ number_format($cottage['fee'], 2) }}" readonly>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="form-group mb-2">
                            <div class="d-flex align-items-center gap-3">
                                <label>Payment Status:</label>
                                <div class="col-2">
                                    <select name="payment_status" id="edit_payment_status" class="form-control" required>
                                        <option value="">Select status</option>
                                        <option value="Paid">Paid</option>
                                        <option value="Unpaid">Unpaid</option>
                                    </select>
                                </div>
                                <label>Total Fee:</label>
                                <div class="col-3">
                                    <div class="d-flex">
                                        <span class="input-group-text bg-theme-primary text-light">₱</span>
                                        <input type="text" name="total_payment" id="edit_total_payment"
                                            value="0.00" class="form-control" readonly required>
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
@endsection

<script>
    // Wait for the DOM to be fully loaded and jQuery to be available
    document.addEventListener('DOMContentLoaded', function() {
        // Check if jQuery is loaded
        if (typeof jQuery === 'undefined') {
            console.error('jQuery is not loaded');
            return;
        }

        // Use jQuery safely
        $(document).ready(function() {
            // Initialize Select2 for Add modal
            $('#addCottageModal').on('shown.bs.modal', function() {
                $('#visitor_name').select2({
                    theme: 'bootstrap4',
                    width: '100%',
                    placeholder: "Select a visitor",
                    allowClear: true,
                    dropdownParent: $('#addCottageModal')
                });

                // Reset Add form
                resetAddForm();
            });

            // Initialize Select2 for Edit modal
            $('#editCottageModal').on('shown.bs.modal', function() {
                $('#edit_visitor_id').select2({
                    theme: 'bootstrap4',
                    width: '100%',
                    placeholder: "Select a visitor",
                    allowClear: true,
                    dropdownParent: $('#editCottageModal')
                });
            });

            // Calculate total for Add form (checkbox style)
            $(document).on('change', '#addCottageModal .cottage-checkbox', function() {
                let total = 0;
                $('#addCottageModal tbody tr').each(function() {
                    const checkbox = $(this).find('.cottage-checkbox');
                    const feeText = $(this).find('.cottage-fee').val();
                    const fee = parseFloat(feeText.replace(/[^0-9.-]/g, '')) || 0;

                    if (checkbox.is(':checked')) {
                        total += fee;
                    }
                });
                $('#total_payment').val(total.toFixed(2));
            });

            // Calculate total for Edit form (checkbox style)
            $(document).on('change', '#editCottageModal .edit-cottage-checkbox', function() {
                let total = 0;
                $('#editCottageModal tbody tr').each(function() {
                    const checkbox = $(this).find('.edit-cottage-checkbox');
                    const feeText = $(this).find('.edit-cottage-fee').val();
                    const fee = parseFloat(feeText.replace(/[^0-9.-]/g, '')) || 0;

                    if (checkbox.is(':checked')) {
                        total += fee;
                    }
                });
                $('#edit_total_payment').val(total.toFixed(2));
            });

            // Reset Add form
            function resetAddForm() {
                $('#addCottageModal .cottage-checkbox').prop('checked', false);
                $('#total_payment').val('0.00');
                $('select[name="payment_status"]').val('');
                $('#visitor_name').val(null).trigger('change');
            }

            // Handle Edit modal data population
            $(document).on('click', '[data-bs-target="#editCottageModal"]', function() {
                const button = $(this);
                const cottageId = button.data('id');
                const visitorId = button.data('visitor-id');
                const totalPayment = button.data('total-payment');
                const status = button.data('status');

                console.log('=== Edit Modal Data ===');
                console.log('Cottage ID:', cottageId);

                // Get raw data attributes
                let rawCottageType = button.data('cottage-type');
                let rawQuantity = button.data('quantity');

                console.log('Raw Cottage Type:', rawCottageType);
                console.log('Raw Quantity:', rawQuantity);

                // Parse the stored cottage types and quantities
                let cottageTypes = [];
                let quantities = [];

                try {
                    if (rawCottageType) {
                        // If it's a string, parse it
                        if (typeof rawCottageType === 'string') {
                            cottageTypes = JSON.parse(rawCottageType);
                        } else {
                            cottageTypes = rawCottageType;
                        }
                        console.log('Parsed Cottage Types:', cottageTypes);
                    }

                    if (rawQuantity) {
                        if (typeof rawQuantity === 'string') {
                            quantities = JSON.parse(rawQuantity);
                        } else {
                            quantities = rawQuantity;
                        }
                        console.log('Parsed Quantities:', quantities);
                    }
                } catch (e) {
                    console.error('Error parsing JSON:', e);
                    console.error('Raw data:', rawCottageType, rawQuantity);
                }

                // Set basic form values
                $('#edit_cottage_id').val(cottageId);
                $('#edit_visitor_id').val(visitorId).trigger('change');
                $('#edit_total_payment').val(totalPayment);
                $('#edit_payment_status').val(status);

                // First, uncheck all checkboxes
                $('#editCottageModal .edit-cottage-checkbox').prop('checked', false);

                // Check the appropriate checkboxes
                if (cottageTypes && Array.isArray(cottageTypes) && cottageTypes.length > 0) {
                    $('#editCottageModal tbody tr').each(function(index) {
                        const row = $(this);
                        const cottageName = row.find('input[type="text"]').val().trim();
                        const checkbox = row.find('.edit-cottage-checkbox');

                        // Find if this cottage type exists in the stored data
                        const cottageIndex = cottageTypes.findIndex(type => type
                        .trim() === cottageName);

                        if (cottageIndex !== -1 && quantities[cottageIndex] &&
                            quantities[cottageIndex] > 0) {
                            checkbox.prop('checked', true);
                            console.log('✓ Checked:', cottageName);
                        } else {
                            console.log('✗ Not checked:', cottageName);
                        }
                    });
                }

                // Trigger change to recalculate total
                $('#editCottageModal .edit-cottage-checkbox').trigger('change');
                console.log('=== End Edit Modal Data ===');
            });

            // Form validation for Add form
            $('#cottageAddForm').on('submit', function(e) {
                const visitorId = $('#visitor_name').val();
                const paymentStatus = $('select[name="payment_status"]').val();
                const totalPayment = parseFloat($('#total_payment').val());

                if (!visitorId) {
                    e.preventDefault();
                    alert('Please select a visitor');
                    return false;
                }

                if (!paymentStatus) {
                    e.preventDefault();
                    alert('Please select payment status');
                    return false;
                }

                if (totalPayment === 0) {
                    e.preventDefault();
                    alert('Please select at least one cottage');
                    return false;
                }

                // Set quantity values for checkboxes
                $('#addCottageModal tbody tr').each(function() {
                    const checkbox = $(this).find('.cottage-checkbox');
                    if (checkbox.is(':checked')) {
                        checkbox.val(1);
                    } else {
                        checkbox.val(0);
                    }
                });

                return true;
            });

            // Form validation for Edit form
            $('#cottageEditForm').on('submit', function(e) {
                const visitorId = $('#edit_visitor_id').val();
                const paymentStatus = $('#edit_payment_status').val();
                const totalPayment = parseFloat($('#edit_total_payment').val());

                if (!visitorId) {
                    e.preventDefault();
                    alert('Please select a visitor');
                    return false;
                }

                if (!paymentStatus) {
                    e.preventDefault();
                    alert('Please select payment status');
                    return false;
                }

                if (totalPayment === 0) {
                    e.preventDefault();
                    alert('Please select at least one cottage');
                    return false;
                }

                // Set quantity values for checkboxes in edit form
                $('#editCottageModal tbody tr').each(function() {
                    const checkbox = $(this).find('.edit-cottage-checkbox');
                    if (checkbox.is(':checked')) {
                        checkbox.val(1);
                    } else {
                        checkbox.val(0);
                    }
                });

                return true;
            });
        });
    });
</script>
