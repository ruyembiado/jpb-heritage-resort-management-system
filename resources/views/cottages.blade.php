@extends('layouts.auth')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text">Cottage Rental</h1>
        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCottageModal">Add
            Cottage Rental</a>
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
                            <th>Cottage</th>
                            <th>Total Payment</th>
                            <th>Date Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cottages as $cottage)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $cottage->visitor->first_name }} {{ $cottage->visitor->middle_name }}
                                    {{ $cottage->visitor->last_name }}</td>
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
                                                    ×{{ $quantities[$index] }} =
                                                    ₱{{ number_format($fees[$index] * $quantities[$index], 2) }}
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </td>
                                <td>₱ {{ number_format($cottage->total_payment, 2) }}</td>
                                <td>{{ \Carbon\Carbon::parse($cottage->created_at)->format('F j, Y') }}</td>
                                <td>
                                    <div class="d-flex align-items-center justify-c gap-2">
                                        <a href="#" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#editCottageModal" data-id="{{ $cottage->id }}"
                                            data-visitor-id="{{ $cottage->visitor_id }}"
                                            data-cottage-area="{{ $cottage->cottage_area }}"
                                            data-cottage-type="{{ $cottage->cottage_type }}"
                                            data-quantity="{{ $cottage->quantity }}"
                                            data-total-payment="{{ $cottage->total_payment }}">
                                            Edit
                                        </a>
                                        <form action="{{ route('cottage.destroy', $cottage->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to delete this cottage rental?')">
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

    <!-- Add Cottage Rental Modal -->
    <div class="modal fade" id="addCottageModal" tabindex="-1" role="dialog" aria-labelledby="addCottageModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form action="{{ route('cottage.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCottageModalLabel">Add Cottage Rental</h5>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex gap-2 form-group mb-3">
                            <div class="form-group col-8">
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
                            <div class="form-group col-3">
                                <label for="members">Cottage Area</label>
                                <div class="">
                                    <input type="text" name="cottage_area" id="cottage_area" class="form-control"
                                        required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-2">
                            <table style="width: 100%; border-collapse: collapse;">
                                <thead>
                                    <tr class="bg-secondary text-light">
                                        <th style="padding: 10px;">COTTAGE</th>
                                        <th style="padding: 10px;">QUANTITY</th>
                                        <th style="padding: 10px;">FEE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $cottages = [
                                            [
                                                'name' => 'Good for Family',
                                                'price' => '350.00',
                                            ],
                                            [
                                                'name' => 'Good for Friends',
                                                'price' => '350.00',
                                            ],
                                        ];
                                    @endphp

                                    @foreach ($cottages as $index => $cottage)
                                        <tr>
                                            <td width="" style="padding: 5px;">
                                                <input class="form-control" name="cottage_type[]" type="text"
                                                    value="{{ $cottage['name'] }}" readonly>
                                            </td>
                                            <td width="10%" style="">
                                                <input class="form-control" id="edit_cottage_quantity" name="quantity[]"
                                                    type="number" value="0" min="0">
                                            </td>
                                            <td width="15%" style="padding: 5px;">
                                                <input class="form-control room-fee" type="text" name="fees[]"
                                                    min="0" value="{{ $cottage['price'] }}" readonly>
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
                        <button type="submit" class="btn btn-primary">Add Cottage Rental</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Cottage Rental Modal -->
    <div class="modal fade" id="editCottageModal" tabindex="-1" role="dialog" aria-labelledby="editCottageModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form action="{{ route('cottage.update') }}" method="POST">
                <input type="hidden" name="cottage_id" id="edit_cottage_id">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editCottageModalLabel">Edit Cottage Rental</h5>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex gap-1 form-group mb-3">
                            <div class="form-group col-8">
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
                            <div class="form-group col-3">
                                <label for="members">Cottage Area</label>
                                <div class="">
                                    <input type="text" id="edit_cottage_area" name="edit_cottage_area"
                                        class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-2">
                            <table style="width: 100%; border-collapse: collapse;">
                                <thead>
                                    <tr class="bg-secondary text-light">
                                        <th style="padding: 10px;">COTTAGE</th>
                                        <th style="padding: 10px;">QUANTITY</th>
                                        <th style="padding: 10px;">FEE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $cottages = [
                                            [
                                                'name' => 'Good for Family',
                                                'price' => '350.00',
                                            ],
                                            [
                                                'name' => 'Good for Friends',
                                                'price' => '350.00',
                                            ],
                                        ];
                                    @endphp

                                    @foreach ($cottages as $index => $cottage)
                                        <tr>
                                            <td width="" style="padding: 5px;">
                                                <input class="form-control" name="edit_cottage_types[]" type="text"
                                                    value="{{ $cottage['name'] }}" readonly>
                                            </td>
                                            <td width="10%" style="">
                                                <input class="form-control" id="edit_cottage_quantity" name="quantity[]"
                                                    type="number" value="" min="0">
                                            <td width="15%" style="padding: 5px;">
                                                <input class="form-control edit-cottage-fee" type="text"
                                                    name="cottage_fees[]" min="0" value="{{ $cottage['price'] }}"
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
                        <button type="submit" class="btn btn-primary">Update Cottage Rental</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Select2 for Add form
        $('#addCottageModal').on('shown.bs.modal', function() {
            $('#visitor_name').select2({
                theme: 'bootstrap4',
                width: '100%',
                placeholder: "Select a visitor",
                allowClear: true,
                dropdownParent: $('#addCottageModal')
            });

            // Reset Add form
            $('#total_payment').val('0.00');
            $('input[name="quantity[]"]').val('0');
        });

        // Calculate total payment in Add form
        $(document).on('input', '#addCottageModal input[name="quantity[]"]', function() {
            updateTotalPayment('#addCottageModal', '.room-fee');
        });

        // Calculate total payment in Edit form
        $(document).on('input', '#editCottageModal input[name="quantity[]"]', function() {
            updateTotalPayment('#editCottageModal', '.edit-cottage-fee');
        });

        // Function to update total payment
        function updateTotalPayment(modalId, feeSelector) {
            let total = 0;
            const modal = $(modalId);

            modal.find('tbody tr').each(function() {
                const quantity = parseInt($(this).find('input[name="quantity[]"]').val()) || 0;
                const fee = parseFloat($(this).find(feeSelector).val()) || 0;
                total += quantity * fee;
            });

            modal.find('input[name="total_payment"]').val(total.toFixed(2));
        }

        $(document).on('click', '[data-bs-target="#editCottageModal"]', function() {
            const button = $(this);

            let quantitiesRaw = button.data('quantity');
            let quantities = [];

            if (typeof quantitiesRaw === 'string') {
                try {
                    quantities = JSON.parse(quantitiesRaw);
                } catch (e) {
                    console.warn('Invalid quantity format:', quantitiesRaw);
                }
            } else if (Array.isArray(quantitiesRaw)) {
                quantities = quantitiesRaw;
            } else {
                console.warn('Quantity data is neither a string nor an array:', quantitiesRaw);
            }


            if (Array.isArray(quantities)) {
                quantities.forEach((item, index) => {
                    console.log(`Item ${index}:`, item);
                });
            } else {
                console.warn('quantities is not an array:', quantities);
            }


            console.log(quantities);
            if (Array.isArray(quantities)) {
                quantities.forEach((item, index) => {
                    console.log(`Item ${index}:`, item);
                });
            } else {
                console.warn('quantities is not an array:', quantities);
            }

            // Set form values
            $('#edit_cottage_id').val(button.data('id'));
            $('#edit_visitor_id').val(button.data('visitor-id'));
            $('#edit_cottage_area').val(button.data('cottage-area'));

            const modalHandler = function() {
                let calculatedTotal = 0;

                // Use the parsed array here!
                $('#editCottageModal tbody tr').each(function(index) {
                    const row = $(this);
                    const cottageType = row.find('input[name="edit_cottage_types[]"]')
                        .val();
                    const qty = Number(quantities[index]) || 0;
                    const quantityInput = row.find('input[name="quantity[]"]');
                    const feeInput = row.find('input[name="cottage_fees[]"]');
                    const fee = parseFloat(feeInput.val()) || 0;

                    console.log(`Cottage: ${cottageType}, qty=${qty}, fee=${fee}`);
                    quantityInput.val(qty).trigger('change');
                    calculatedTotal += qty * fee;
                });

                $('#edit_total_payment').val(calculatedTotal.toFixed(2));
                $('#editCottageModal').off('shown.bs.modal', modalHandler); // clean up
            };

            $('#editCottageModal').on('shown.bs.modal', modalHandler);
        });

    });
</script>
