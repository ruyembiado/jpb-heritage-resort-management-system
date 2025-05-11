@extends('layouts.auth') <!-- Extend the main layout -->

@section('content')
    <!-- Start the content section -->
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text">Entrances</h1>
        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEntranceModal">Add Entrance Fee</a>
    </div>

    <!-- Content Row -->
    <div class="card shadow mb-4">
        <div class="card-body">
            {{-- <form method="GET" action="" class="" id="dateRangeForm">
                <div class="d-flex justify-content-start gap-2 align-items-end mb-4">
                    <div class="d-flex flex-column align-items-start" style="width: auto;">
                        <label for="date" class="mb-0">Start Date:</label>
                        <input type="date" name="start_date" value="{{ $start_date }}"
                            class="form-control form-control-sm" style="width: auto;" id="start_date" />
                    </div>
                    <div class="d-flex flex-column align-items-start" style="width: auto;">
                        <label for="date" class="mb-0">End Date:</label>
                        <input type="date" name="end_date" value="{{ $end_date }}"
                            class="form-control form-control-sm" style="width: auto;" id="end_date" />
                    </div>

                    <a href="{{ url()->current() }}" class="btn btn-sm btn-danger">
                        <i class="fas fa-times"></i> Clear
                    </a>
                </div>
            </form> --}}

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Total Payment</th>
                            <th>Date Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($entrances as $entrance)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $entrance->visitor->first_name }} {{ $entrance->visitor->middle_name }}
                                    {{ $entrance->visitor->last_name }}</td>
                                @php
                                    $categories = json_decode($entrance->category, true);
                                    $members = json_decode($entrance->members, true);
                                    $ages = json_decode($entrance->age, true);
                                    $fees = json_decode($entrance->fee, true);
                                @endphp
                                <td style="padding: 10px;">
                                    <table style="width: 100%; border-collapse: collapse;">
                                        <thead>
                                            <tr>
                                                <th style="padding: 5px;">Category</th>
                                                <th style="padding: 5px;">No. of Members</th>
                                                <th style="padding: 5px;">Age</th>
                                                <th style="padding: 5px;">Sub-total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($categories as $index => $cat)
                                                @if (!empty($members[$index]))
                                                    <tr>
                                                        <td style="padding: 8px;">{{ $cat }}</td>
                                                        <td style="padding: 8px;">{{ $members[$index] }}</td>
                                                        <td style="padding: 8px;">{{ $ages[$index] ?? 'N/A' }}</td>
                                                        <td style="padding: 8px;">
                                                            ₱{{ number_format((float) ($members[$index] ?? 0) * (float) ($fees[$index] ?? 0), 2) }}
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </td>
                                <td>₱ {{ number_format($entrance->total_payment, 2) }}</td>
                                <td>{{ \Carbon\Carbon::parse($entrance->created_at)->format('F j, Y') }}</td>
                                <td>
                                    <div class="d-flex align-items-center justify-c gap-2">
                                        <a href="#" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#editEntranceModal" data-id="{{ $entrance->id }}"
                                            data-visitor-id="{{ $entrance->visitor_id }}"
                                            data-total-members="{{ $entrance->members }}"
                                            data-total-payment="{{ $entrance->total_payment }}">
                                            Edit
                                        </a>
                                        <form action="{{ route('entrance.destroy', $entrance->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to delete this visitor?')">
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
    <!-- Content Row -->

    <!-- Add Entrance Fee Modal -->
    <div class="modal fade" id="addEntranceModal" tabindex="-1" role="dialog" aria-labelledby="addEntranceModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form action="{{ route('entrance.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addEntranceModalLabel">Add Entrance Fee</h5>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <div class="d-flex align-items-start gap-1">
                                <div class="form-group col-6">
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
                                <div class="form-group">
                                    <small id="remaining_members_note" class="text-muted"></small>
                                </div>
                                <div class="form-group">
                                    <label for="members">Total Members</label>
                                    <div class="col-4">
                                        <input readonly type="number" id="total_members" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-2">
                            <table style="width: 100%; border-collapse: collapse;">
                                <thead>
                                    <tr class="bg-secondary text-light">
                                        <th style="padding: 10px;">CATEGORY</th>
                                        <th style="padding: 10px;">NO. OF MEMBERS</th>
                                        <th style="padding: 10px;">AGE</th>
                                        <th style="padding: 10px;">FEE</th>
                                        <th style="padding: 10px;">SUB-TOTAL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $categories = [
                                            [
                                                'name' => 'Adult',
                                                'age' => '18-59',
                                                'checked' => false,
                                                'price' => '150.00',
                                            ],
                                            [
                                                'name' => 'Senior Citizen',
                                                'age' => '60+',
                                                'checked' => false,
                                                'price' => '100.00',
                                            ],
                                            [
                                                'name' => 'Children (Below 10 yo)',
                                                'age' => '',
                                                'checked' => false,
                                                'price' => '100.00',
                                            ],
                                            [
                                                'name' => 'Infant  (Below 2 Feet)',
                                                'age' => '',
                                                'checked' => false,
                                                'price' => '0.00',
                                            ],
                                        ];
                                    @endphp

                                    @foreach ($categories as $index => $category)
                                        <tr>
                                            <td width="30%" style="padding: 5px;">
                                                <div class="d-flex align-items-center gap-1">
                                                    <input type="hidden" name="category[]" value="{{ $category['name'] }}"
                                                        {{ $category['checked'] ? 'checked' : '' }}>
                                                    <span>{{ $category['name'] }}</span>
                                                </div>
                                            </td>
                                            <td width="25%" style="padding: 5px;">
                                                <input class="form-control" type="number" name="members[]" min="0"
                                                    value="">
                                            </td>
                                            <td style="padding: 5px;">
                                                <input class="form-control" type="text" name="age[]"
                                                    value="{{ $category['age'] }}" readonly>
                                            </td>
                                            <td style="padding: 5px;">
                                                <input class="form-control" type="text" name="fee[]" min="0"
                                                    value="{{ $category['price'] }}" readonly>
                                            </td>
                                            <td>
                                                <input type="text" readonly id="sub-total" class="form-control"
                                                    value="" readonly>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex align-items-center justify-content-end">
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
                        <button type="submit" class="btn btn-primary">Add Entrance Fee</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Entrance Fee Modal -->
    <div class="modal fade" id="editEntranceModal" tabindex="-1" role="dialog"
        aria-labelledby="editEntranceModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form action="{{ route('entrance.update') }}" method="POST">
                <input type="hidden" name="id" id="edit_entrance_id">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editEntranceModalLabel">Edit Entrance Fee</h5>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <div class="d-flex align-items-start gap-1">
                                <div class="form-group col-6">
                                    <label for="visitor_id">Name</label>
                                    <select disabled name="visitor_id" class="form-control select2" id="edit_visitor_id" required
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
                                <div class="form-group">
                                    <small id="remaining_members_note" class="text-muted"></small>
                                </div>
                                <div class="form-group">
                                    <label for="members">Total Members</label>
                                    <div class="col-4">
                                        <input readonly type="number" id="edit_total_members" class="form-control"
                                            required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-2">
                            <table style="width: 100%; border-collapse: collapse;">
                                <thead>
                                    <tr class="bg-secondary text-light">
                                        <th style="padding: 10px;">CATEGORY</th>
                                        <th style="padding: 10px;">NO. OF MEMBERS</th>
                                        <th style="padding: 10px;">AGE</th>
                                        <th style="padding: 10px;">FEE</th>
                                        <th style="padding: 10px;">SUB-TOTAL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $categories = [
                                            [
                                                'name' => 'Adult',
                                                'age' => '18-59',
                                                'checked' => false,
                                                'price' => '150.00',
                                            ],
                                            [
                                                'name' => 'Senior Citizen',
                                                'age' => '60+',
                                                'checked' => false,
                                                'price' => '100.00',
                                            ],
                                            [
                                                'name' => 'Children (Below 10 yo)',
                                                'age' => '',
                                                'checked' => false,
                                                'price' => '100.00',
                                            ],
                                            [
                                                'name' => 'Infant  (Below 2 Feet)',
                                                'age' => '',
                                                'checked' => false,
                                                'price' => '0.00',
                                            ],
                                        ];
                                    @endphp

                                    @foreach ($categories as $index => $category)
                                        <tr>
                                            <td width="30%" style="padding: 5px;">
                                                <div class="d-flex align-items-center gap-1">
                                                    <input type="hidden" name="category[]"
                                                        value="{{ $category['name'] }}"
                                                        {{ $category['checked'] ? 'checked' : '' }}>
                                                    <span>{{ $category['name'] }}</span>
                                                </div>
                                            </td>
                                            <td width="25%" style="padding: 5px;">
                                                <input class="form-control" type="number" name="members[]"
                                                    min="0" value="" required>
                                            </td>
                                            <td style="padding: 5px;">
                                                <input class="form-control" type="text" name="age[]"
                                                    value="{{ $category['age'] }}" readonly>
                                            </td>
                                            <td style="padding: 5px;">
                                                <input class="form-control" type="text" id="" name="fee[]" min="0"
                                                    value="{{ $category['price'] }}" readonly>
                                            </td>
                                            <td>
                                                <input type="text" readonly id="sub-total" class="form-control"
                                                    value="" readonly>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex align-items-center justify-content-end">
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
                        <button type="submit" class="btn btn-primary">Update Entrance Fee</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection <!-- End the content section -->
{{-- ADD FORM SCRIPT --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Select2 for visitor_name for add form
        $('#addEntranceModal').on('shown.bs.modal', function() {
            $('#visitor_name').select2({
                theme: 'bootstrap4',
                width: '100%',
                placeholder: "Select a visitor",
                allowClear: true,
                dropdownParent: $('#addEntranceModal')
            });
        });

        // Get total members based on selected visitor
        $('#visitor_name').on('change', function() {
            var visitor_id = $(this).val();
            if (visitor_id) {
                var baseUrl = window.location.origin;
                var pathParts = window.location.pathname.split('/');
                var folderName = pathParts[1];
                var url = window.location.origin + '/' + folderName + '/get-visitor-members/' +
                    visitor_id;

                $.ajax({
                    url: url,
                    method: 'GET',
                    success: function(response) {
                        $('#total_members').val(response.members).trigger('input');
                    }
                });
            } else {
                $('#total_members').val('');
            }
        });

        let totalMembers = 0;

        // When total_members changes (manual or from AJAX)
        $('#total_members').on('input', function() {
            totalMembers = parseInt($(this).val()) || 0;
            resetMemberInputs();
        });

        // When any members[] input changes
        $(document).on('input', '#addEntranceModal input[name="members[]"]', function() {
            updateMemberInputLimitsAddForm();
            updateSubtotalsAndTotalAddForm();
        });

        function resetMemberInputs() {
            $('#addEntranceModal input[name="members[]"]').each(function() {
                $(this).val('');
                $(this).attr('max', totalMembers);
                $(this).prop('readonly', false);
            });
        }

        function updateMemberInputLimitsAddForm() {
            let used = 0;

            // First, calculate the total used
            $('#addEntranceModal input[name="members[]"]').each(function() {
                used += parseInt($(this).val()) || 0;
            });

            if (used > totalMembers) {
                // Reset all to 0 if over limit
                $('#addEntranceModal input[name="members[]"]').each(function() {
                    $(this).val(0);
                    $(this).attr('max', totalMembers);
                    $(this).prop('readonly', totalMembers === 0);
                });

                // Optional: show feedback
                alert('Total members exceeded. All inputs have been reset to 0.');
                return;
            }

            // Otherwise, set max per input dynamically
            let remaining = totalMembers - used;

            $('#addEntranceModal input[name="members[]"]').each(function() {
                let currentVal = parseInt($(this).val()) || 0;
                let max = currentVal + remaining;
                $(this).attr('max', max);
                $(this).prop('readonly', totalMembers === 0);
            });

            // Lock further increments if full
            if (remaining <= 0) {
                $('#addEntranceModal input[name="members[]"]').each(function() {
                    let val = parseInt($(this).val()) || 0;
                    $(this).attr('max', val); // lock to current value
                });
            }
        }

        function updateSubtotalsAndTotalAddForm() {
            let totalPayment = 0;

            $('#addEntranceModal tbody tr').each(function() {
                const memberInput = $(this).find('input[name="members[]"]');
                const feeInput = $(this).find('input[name="fee[]"]');
                const subtotalInput = $(this).find('input[id="sub-total"]');

                const members = parseInt(memberInput.val()) || 0;
                const fee = parseFloat(feeInput.val()) || 0;
                const subtotal = members * fee;

                subtotalInput.val(subtotal.toFixed(2));
                totalPayment += subtotal;
            });

            $('#total_payment').val(totalPayment.toFixed(2));
        }
    });
</script>

{{-- EDIT FORM SCRIPT --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editModal = document.getElementById('editEntranceModal');
        let editTotalMembers = 0; // Track total members for edit form

        if (editModal) {
            editModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;

                const totalMembersArray = JSON.parse(button.getAttribute('data-total-members') || '[]');
                const visitorId = button.getAttribute('data-visitor-id');
                const entranceId = button.getAttribute('data-id');
                const totalPayment = button.getAttribute('data-total-payment');

                document.getElementById('edit_entrance_id').value = entranceId;
                $('#edit_visitor_id').val(visitorId).trigger('change');

                // Target all members inputs
                const memberInputs = document.querySelectorAll('#editEntranceModal input[name="members[]"]');
                const feeInputs = document.querySelectorAll('#editEntranceModal input[name="fee[]"]');
                const subTotalInputs = document.querySelectorAll('#editEntranceModal input[id="sub-total"]');

                editTotalMembers = 0;
                let totalPaymentCalculated = 0;

                memberInputs.forEach((input, index) => {
                    const memberCount = parseInt(totalMembersArray[index]) || 0;
                    const fee = parseFloat(feeInputs[index].value) || 0;
                    const subTotal = memberCount * fee;

                    input.value = memberCount;
                    subTotalInputs[index].value = subTotal.toFixed(2);

                    editTotalMembers += memberCount;
                    totalPaymentCalculated += subTotal;
                });

                // Update total members and payment
                document.getElementById('edit_total_members').value = editTotalMembers;
                document.getElementById('edit_total_payment').value = totalPaymentCalculated.toFixed(2);
            });
        }

        // Initialize Select2 for visitor_name for edit form
        $('#editEntranceModal').on('shown.bs.modal', function() {
            $('#edit_visitor_id').select2({
                theme: 'bootstrap4',
                width: '100%',
                placeholder: "Select a visitor",
                allowClear: true,
                dropdownParent: $('#editEntranceModal')
            });
        });

        // Get total members based on selected visitor for edit form
        $('#edit_visitor_id').on('change', function() {
            var visitor_id = $(this).val();
            if (visitor_id) {
                var baseUrl = window.location.origin;
                var pathParts = window.location.pathname.split('/');
                var folderName = pathParts[1];
                var url = window.location.origin + '/' + folderName + '/get-visitor-members/' + visitor_id;

                $.ajax({
                    url: url,
                    method: 'GET',
                    success: function(response) {
                        editTotalMembers = parseInt(response.members) || 0;
                        $('#edit_total_members').val(editTotalMembers);
                        resetEditMemberInputs();
                    }
                });
            } else {
                editTotalMembers = 0;
                $('#edit_total_members').val('');
                resetEditMemberInputs();
            }
        });

        // When any members[] input changes in edit form
        $(document).on('input', '#editEntranceModal input[name="members[]"]', function() {
            updateMemberInputLimitsEditForm();
            updateEditSubtotalsAndTotal();
        });

        function resetEditMemberInputs() {
            $('#editEntranceModal input[name="members[]"]').each(function() {
                $(this).val('');
                $(this).attr('max', editTotalMembers);
                $(this).prop('readonly', false);
            });
        }

        function updateEditSubtotalsAndTotal() {
            let totalPayment = 0;
            let currentTotalMembers = 0;
            
            $('#editEntranceModal tbody tr').each(function() {
                const memberInput = $(this).find('input[name="members[]"]');
                const feeInput = $(this).find('input[name="fee[]"]');
                const subtotalInput = $(this).find('input[id="sub-total"]');
                
                const members = parseInt(memberInput.val()) || 0;
                const fee = parseFloat(feeInput.val()) || 0;
                const subtotal = members * fee;
                
                subtotalInput.val(subtotal.toFixed(2));
                totalPayment += subtotal;
                currentTotalMembers += members;
            });
            
            $('#edit_total_payment').val(totalPayment.toFixed(2));
            // Don't update editTotalMembers here - it should only come from visitor data
        }

        function updateMemberInputLimitsEditForm() {
            let used = 0;

            // First, calculate the total used
            $('#editEntranceModal input[name="members[]"]').each(function() {
                used += parseInt($(this).val()) || 0;
            });

            if (used > editTotalMembers) {
                // Reset all to 0 if over limit
                $('#editEntranceModal input[name="members[]"]').each(function() {
                    $(this).val(0);
                });
                
                // Recalculate totals
                updateEditSubtotalsAndTotal();
                
                // Optional: show feedback
                alert('Total members exceeded. All inputs have been reset to 0.');
                return;
            }

            // Otherwise, set max per input dynamically
            let remaining = editTotalMembers - used;

            $('#editEntranceModal input[name="members[]"]').each(function() {
                let currentVal = parseInt($(this).val()) || 0;
                let max = currentVal + remaining;
                $(this).attr('max', max);
            });

            // Lock further increments if full
            if (remaining <= 0) {
                $('#editEntranceModal input[name="members[]"]').each(function() {
                    let val = parseInt($(this).val()) || 0;
                    $(this).attr('max', val); // lock to current value
                });
            }
        }
    });
</script>
