@extends('layouts.auth')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text">Accommodations</h1>
        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAccommodationModal">Add
            Accommodation</a>
    </div>

    <!-- Content Row -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Name</th>
                            <th>Rooms</th>
                            <th>Total Payment</th>
                            <th>Date Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($accommodations as $accommodation)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $accommodation->visitor->first_name }} {{ $accommodation->visitor->middle_name }}
                                    {{ $accommodation->visitor->last_name }}</td>
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
                                <td>₱ {{ number_format($accommodation->total_payment, 2) }}</td>
                                <td>{{ \Carbon\Carbon::parse($accommodation->created_at)->format('F j, Y') }}</td>
                                <td>
                                    <div class="d-flex align-items-center justify-c gap-2">
                                        <a href="#" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#editAccommodationModal" data-id="{{ $accommodation->id }}"
                                            data-visitor-id="{{ $accommodation->visitor_id }}"
                                            data-rooms="{{ $accommodation->room }}"
                                            data-fees="{{ $accommodation->fee }}"
                                            data-total-payment="{{ $accommodation->total_payment }}">
                                            Edit
                                        </a>
                                        <form action="{{ route('accommodation.destroy', $accommodation->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to delete this accommodation?')">
                                                Delete
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
        <div class="modal-dialog modal-lg" role="document">
            <form action="{{ route('accommodation.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addAccommodationModalLabel">Add Accommodation</h5>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <div class="form-group">
                                <label for="visitor_id">Name</label>
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

                        <div class="form-group mb-2">
                            <table style="width: 100%; border-collapse: collapse;">
                                <thead>
                                    <tr class="bg-secondary text-light">
                                        <th style="padding: 10px;">SELECT</th>
                                        <th style="padding: 10px;">ROOM</th>
                                        <th style="padding: 10px;">FEE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $rooms = [
                                            [
                                                'name' => 'ROOM 1 (Good for 5 Persons)',
                                                'price' => '2000.00',
                                            ],
                                            [
                                                'name' => 'ROOM 2 (Good for 3 Persons)',
                                                'price' => '1500.00',
                                            ],
                                            [
                                                'name' => 'ROOM 3 (Good for 10 Persons)',
                                                'price' => '4000.00',
                                            ],
                                            [
                                                'name' => 'ROOM 4 (Good for 2 Persons)',
                                                'price' => '1000.00',
                                            ],
                                        ];
                                    @endphp

                                    @foreach ($rooms as $index => $room)
                                        <tr>
                                            <td width="5%" style="padding: 5px; text-align: center;">
                                                <input type="checkbox" name="checked[]" value="{{ $room['name'] }}"
                                                    class="room-checkbox">
                                            </td>
                                            <td width="" style="padding: 5px;">
                                                <input class="form-control" name="rooms[]" type="text" value="{{ $room['name'] }}"
                                                    readonly>
                                            </td>
                                            <td width="15%" style="padding: 5px;">
                                                <input class="form-control room-fee" type="text" name="fees[]"
                                                    min="0" value="{{ $room['price'] }}" readonly>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex align-items-center justify-content-end mt-3">
                                <div class="col-2">
                                    <label for="total_payment">Total Payment</label>
                                    <div class="d-flex align-items-center gap-1">
                                        <span>₱ </span>
                                        <span><input type="text" name="total_payment" id="total_payment"
                                                class="form-control" readonly></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Accommodation</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Accommodation Modal -->
    <div class="modal fade" id="editAccommodationModal" tabindex="-1" role="dialog"
        aria-labelledby="editAccommodationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form action="{{ route('accommodation.update') }}" method="POST">
                <input type="hidden" name="accommodation_id" id="edit_accommodation_id">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editAccommodationModalLabel">Edit Accommodation</h5>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <div class="form-group">
                                <label for="visitor_id">Name</label>
                                <select disabled name="visitor_id" class="form-control" id="edit_visitor_id">
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

                        <div class="form-group mb-2">
                            <table style="width: 100%; border-collapse: collapse;">
                                <thead>
                                    <tr class="bg-secondary text-light">
                                        <th style="padding: 10px;">SELECT</th>
                                        <th style="padding: 10px;">ROOM</th>
                                        <th style="padding: 10px;">FEE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $rooms = [
                                            [
                                                'name' => 'ROOM 1 (Good for 5 Persons)',
                                                'price' => '2000.00',
                                            ],
                                            [
                                                'name' => 'ROOM 2 (Good for 3 Persons)',
                                                'price' => '1500.00',
                                            ],
                                            [
                                                'name' => 'ROOM 3 (Good for 10 Persons)',
                                                'price' => '4000.00',
                                            ],
                                            [
                                                'name' => 'ROOM 4 (Good for 2 Persons)',
                                                'price' => '1000.00',
                                            ],
                                        ];
                                    @endphp

                                    @foreach ($rooms as $index => $room)
                                        <tr>
                                            <td width="5%" style="padding: 5px; text-align: center;">
                                                <input type="checkbox" name="checked[]" value="{{ $room['name'] }}"
                                                    class="edit-room-checkbox">
                                            </td>
                                            <td width="" style="padding: 5px;">
                                                <input class="form-control" name="edit_rooms[]" type="text" value="{{ $room['name'] }}"
                                                    readonly>
                                            </td>
                                            <td width="15%" style="padding: 5px;">
                                                <input class="form-control edit-room-fee" type="text"
                                                    name="edit_fees[]" min="0" value="{{ $room['price'] }}"
                                                    readonly>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex align-items-center justify-content-end mt-3">
                                <div class="col-2">
                                    <label for="total_payment">Total Payment</label>
                                    <div class="d-flex align-items-center gap-1">
                                        <span>₱ </span>
                                        <span><input type="text" name="total_payment" id="edit_total_payment"
                                                class="form-control" readonly></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Accommodation</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Select2 for visitor_name for add form
        $('#addAccommodationModal').on('shown.bs.modal', function() {
            $('#visitor_name').select2({
                theme: 'bootstrap4',
                width: '100%',
                placeholder: "Select a visitor",
                allowClear: true,
                dropdownParent: $('#addAccommodationModal')
            });

            // Reset form when modal is shown
            $('#total_payment').val('0.00');
            $('.room-checkbox').prop('checked', false);
        });

        // Calculate total payment when rooms are selected in add form
        $(document).on('change', '.room-checkbox, .edit-room-checkbox', updateTotalPayment);

        // Function to update total payment for both add and edit forms
        function updateTotalPayment() {
            let total = 0;

            // Calculate for add form
            $('#addAccommodationModal .room-checkbox:checked').each(function() {
                const fee = parseFloat($(this).closest('tr').find('.room-fee').val()) || 0;
                total += fee;
            });

            $('#total_payment').val(total.toFixed(2));

            // Calculate for edit form
            let editTotal = 0;
            $('#editAccommodationModal .edit-room-checkbox:checked').each(function() {
                const fee = parseFloat($(this).closest('tr').find('.edit-room-fee').val()) || 0;
                editTotal += fee;
            });

            $('#edit_total_payment').val(editTotal.toFixed(2));
        }

        // Edit modal functionality with error handling
        $('#editAccommodationModal').on('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const modal = $(this);

            try {
                // Get basic data
                const accommodationId = button.getAttribute('data-id');
                const visitorId = button.getAttribute('data-visitor-id');
                const totalPayment = button.getAttribute('data-total-payment');

                // Safely parse JSON data with fallback to empty arrays
                let rooms = [];
                let fees = [];

                try {
                    rooms = JSON.parse(button.getAttribute('data-rooms') || '[]');
                    fees = JSON.parse(button.getAttribute('data-fees') || '[]');
                } catch (e) {
                    console.error('Error parsing JSON:', e);
                    rooms = [];
                    fees = [];
                }

                // Set form values
                modal.find('#edit_accommodation_id').val(accommodationId);
                modal.find('#edit_visitor_id').val(visitorId).trigger('change');
                modal.find('#edit_total_payment').val(totalPayment);

                // Reset all checkboxes
                modal.find('.edit-room-checkbox').prop('checked', false);

                // Check the rooms that were previously selected
                rooms.forEach((room) => {
                    modal.find('.edit-room-checkbox[value="' + room + '"]').prop('checked',
                        true);
                });

                // Update the total payment display
                updateTotalPayment();

            } catch (error) {
                console.error('Error initializing edit modal:', error);
                alert('Error loading accommodation data. Please try again.');
                $(this).modal('hide');
            }
        });

        // Form submission validation
        $('#submit-accommodation, #submit-edit-accommodation').on('click', function(e) {
            const form = $(this).closest('form');
            const checkedBoxes = form.find('.room-checkbox:checked, .edit-room-checkbox:checked');

            if (checkedBoxes.length === 0) {
                e.preventDefault();
                alert('Please select at least one room.');
                return false;
            }
        });
    });
</script>