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
                            <div class="d-flex align-items-start gap-3">
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

    <!-- View Staff Modal -->
    <div class="modal fade" id="viewStaffModal" tabindex="-1" role="dialog" aria-labelledby="viewStaffModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form action="{{ route('staff.update') }}" method="POST" id="viewStaffForm">
                @csrf
                <input type="hidden" name="id" id="view_staff_id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewStaffModalLabel">View Staff</h5>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-2">
                            <div class="d-flex align-items-start gap-3">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select style="background-color: #ffff" disabled name="status" class="form-control"
                                        id="view_status" required>
                                        <option value="Hired">Hired</option>
                                        <option value="Resigned">Resigned</option>
                                    </select>
                                </div>

                                <div class="form-group col-3">
                                    <label>Date Hired</label>
                                    <input readonly type="date" name="date_hired" class="form-control"
                                        id="view_date_hired" required />
                                </div>

                                <div class="form-group col-3 d-block" id="view_date_resigned_wrapper">
                                    <label>Date Resigned</label>
                                    <input readonly type="date" name="date_resigned" class="form-control"
                                        id="view_date_resigned" />
                                </div>

                                <div class="col-3">
                                    <label>Staff ID</label>
                                    <input readonly type="text" name="staff_id" class="form-control"
                                        id="view_staff_id_field" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-2">
                            <div class="d-flex align-items-center gap-3">
                                <div class="col-4">
                                    <label>First Name</label>
                                    <input readonly type="text" name="first_name" class="form-control"
                                        id="view_first_name" required>
                                </div>
                                <div class="col-3">
                                    <label>Middle Name</label>
                                    <input readonly type="text" name="middle_name" class="form-control"
                                        id="view_middle_name">
                                </div>
                                <div class="col-4">
                                    <label>Last Name</label>
                                    <input readonly type="text" name="last_name" class="form-control"
                                        id="view_last_name" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-2">
                            <div class="d-flex align-items-center gap-3">
                                <div class="col-3">
                                    <label>Contact No.</label>
                                    <input readonly type="text" name="contact_number" class="form-control"
                                        id="view_contact_number" required>
                                </div>
                                <div class="col-5">
                                    <label>Email</label>
                                    <input readonly type="email" name="email" class="form-control" id="view_email"
                                        required>
                                </div>
                                <div class="col-2">
                                    <label>Gender</label>
                                    <select style="background-color: #ffff;" disabled name="gender" class="form-control"
                                        id="view_gender" required>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                                <div class="col-1">
                                    <label>Age</label>
                                    <input readonly type="number" name="age" class="form-control" id="view_age"
                                        required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-2">
                            <label>Address</label>
                            <textarea readonly name="address" class="form-control" id="view_address" required></textarea>
                        </div>

                        <div class="form-group mb-2">
                            <div class="d-flex align-items-center gap-3">
                                <div class="col-3">
                                    <label>Birthdate</label>
                                    <input readonly type="date" name="birthdate" class="form-control"
                                        id="view_birthdate" required>
                                </div>
                                <div class="col-3">
                                    <label>Designation</label>
                                    <select style="background-color: #ffff;" disabled name="designation"
                                        class="form-control" id="view_designation" required>
                                        <option value="Front Desk">Front Desk</option>
                                        <option value="Support Staff">Support Staff</option>
                                        <option value="Maintenance">Maintenance</option>
                                        <option value="Finance Staff">Finance Staff</option>
                                        <option value="Event Coordinator">Event Coordinator</option>
                                    </select>
                                </div>
                                <div class="col-4">
                                    <label>Service Duration</label>
                                    <input readonly type="text" name="service_duration" class="form-control"
                                        id="view_service_duration" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Staff Modal -->
    <div class="modal fade" id="editStaffModal" tabindex="-1" role="dialog" aria-labelledby="editStaffModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form action="{{ route('staff.update') }}" method="POST" id="editStaffForm">
                @csrf
                <input type="hidden" name="id" id="edit_staff_id">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editStaffModalLabel">Edit Staff</h5>
                    </div>
                    <div class="modal-body">
                        <!-- Include the same fields as Add Modal but with different IDs prefixed by 'edit_' -->
                        <div class="form-group mb-2">
                            <div class="d-flex align-items-start gap-3">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control" id="edit_status" required>
                                        <option value="Hired">Hired</option>
                                        <option value="Resigned">Resigned</option>
                                    </select>
                                </div>

                                <div class="form-group col-3">
                                    <label>Date Hired</label>
                                    <input type="date" name="date_hired" class="form-control" id="edit_date_hired"
                                        required />
                                </div>

                                <div class="form-group col-3" id="edit_date_resigned_wrapper">
                                    <label>Date Resigned</label>
                                    <input type="date" name="date_resigned" class="form-control"
                                        id="edit_date_resigned" />
                                </div>

                                <div class="col-3">
                                    <label>Staff ID</label>
                                    <input type="text" name="staff_id" class="form-control" id="edit_staff_id_field"
                                        required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-2">
                            <div class="d-flex align-items-center gap-3">
                                <div class="col-4">
                                    <label>First Name</label>
                                    <input type="text" name="first_name" class="form-control" id="edit_first_name"
                                        required>
                                </div>
                                <div class="col-3">
                                    <label>Middle Name</label>
                                    <input type="text" name="middle_name" class="form-control" id="edit_middle_name">
                                </div>
                                <div class="col-4">
                                    <label>Last Name</label>
                                    <input type="text" name="last_name" class="form-control" id="edit_last_name"
                                        required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-2">
                            <div class="d-flex align-items-center gap-3">
                                <div class="col-3">
                                    <label>Contact No.</label>
                                    <input type="text" name="contact_number" class="form-control"
                                        id="edit_contact_number" required>
                                </div>
                                <div class="col-5">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control" id="edit_email" required>
                                </div>
                                <div class="col-3">
                                    <label>Gender</label>
                                    <select name="gender" class="form-control" id="edit_gender" required>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-2">
                            <label>Address</label>
                            <textarea name="address" class="form-control" id="edit_address" required></textarea>
                        </div>

                        <div class="form-group mb-2">
                            <div class="d-flex align-items-center gap-3">
                                <div class="col-3">
                                    <label>Birthdate</label>
                                    <input type="date" name="birthdate" class="form-control" id="edit_birthdate"
                                        required>
                                </div>
                                <div class="col-3">
                                    <label>Designation</label>
                                    <select name="designation" class="form-control" id="edit_designation" required>
                                        <option value="Front Desk">Front Desk</option>
                                        <option value="Support Staff">Support Staff</option>
                                        <option value="Maintenance">Maintenance</option>
                                        <option value="Finance Staff">Finance Staff</option>
                                        <option value="Event Coordinator">Event Coordinator</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Staff</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection <!-- End the content section -->

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const statusSelect = document.querySelector('select[name="status"]');
        const dateResignedGroup = document.querySelector('input[name="date_resigned"]').closest('.form-group');

        // Initially hide "Date Resigned" if status is not "Resigned"
        if (statusSelect && statusSelect.value !== 'Resigned') {
            dateResignedGroup.style.display = 'none';
        }

        statusSelect?.addEventListener('change', function() {
            if (this.value === 'Resigned') {
                dateResignedGroup.style.display = 'block';
                document.querySelector('input[name="date_resigned"]').setAttribute('required',
                    'required');
            } else {
                dateResignedGroup.style.display = 'none';
                const dateResignedInput = document.querySelector('input[name="date_resigned"]');
                dateResignedInput.removeAttribute('required');
                dateResignedInput.value = '';
            }
        });

        // View Modal Handler
        const viewModal = document.getElementById('viewStaffModal');
        if (viewModal) {
            viewModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;

                const data = {
                    id: button.getAttribute('data-id'),
                    status: button.getAttribute('data-status'),
                    date_hired: button.getAttribute('data-date_hired'),
                    date_resigned: button.getAttribute('data-date_resigned'),
                    staff_id: button.getAttribute('data-staff_id'),
                    first_name: button.getAttribute('data-first_name'),
                    middle_name: button.getAttribute('data-middle_name'),
                    last_name: button.getAttribute('data-last_name'),
                    contact_number: button.getAttribute('data-contact_number'),
                    email: button.getAttribute('data-email'),
                    gender: button.getAttribute('data-gender'),
                    address: button.getAttribute('data-address'),
                    birthdate: button.getAttribute('data-birthdate'),
                    designation: button.getAttribute('data-designation'),
                };

                // set age
                const birthdate = new Date(data.birthdate);
                const today = new Date();
                let age = today.getFullYear() - birthdate.getFullYear();
                const monthDiff = today.getMonth() - birthdate.getMonth();
                if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthdate.getDate())) {
                    age--;
                }
                document.getElementById('view_age').value = age;

                function getDateDifference(dateHired, dateResigned) {
                    const start = new Date(dateHired);
                    const end = new Date(dateResigned);

                    if (isNaN(start) || isNaN(end)) {
                        return 'N/A';
                    }

                    let years = end.getFullYear() - start.getFullYear();
                    let months = end.getMonth() - start.getMonth();
                    let days = end.getDate() - start.getDate();

                    if (days < 0) {
                        months--;
                        const prevMonth = new Date(end.getFullYear(), end.getMonth(), 0);
                        days += prevMonth.getDate();
                    }

                    if (months < 0) {
                        years--;
                        months += 12;
                    }

                    let result = '';
                    if (years >= 1) {
                        result += `${years} year${years > 1 ? 's' : ''} `;
                        result += `${months} month${months > 1 ? 's' : ''} `;
                        result += `${days} day${days > 1 ? 's' : ''}`;
                    } else if (months >= 1) {
                        result += `${months} month${months > 1 ? 's' : ''} `;
                        result += `${days} day${days > 1 ? 's' : ''}`;
                    } else {
                        result += `${days} day${days > 1 ? 's' : ''}`;
                    }

                    return result.trim();
                }
                const serviceDuration = getDateDifference(data.date_hired, data.date_resigned);
                document.getElementById('view_service_duration').value = serviceDuration;

                // Populate form fields
                document.getElementById('view_staff_id').value = data.id;
                document.getElementById('view_status').value = data.status;
                document.getElementById('view_date_hired').value = data.date_hired;
                document.getElementById('view_date_resigned').value = data.date_resigned;
                document.getElementById('view_staff_id_field').value = data.staff_id;
                document.getElementById('view_first_name').value = data.first_name;
                document.getElementById('view_middle_name').value = data.middle_name;
                document.getElementById('view_last_name').value = data.last_name;
                document.getElementById('view_contact_number').value = data.contact_number;
                document.getElementById('view_email').value = data.email;
                document.getElementById('view_gender').value = data.gender;
                document.getElementById('view_address').value = data.address;
                document.getElementById('view_birthdate').value = data.birthdate;
                document.getElementById('view_designation').value = data.designation;

            });
        }

        // Edit Modal Handler
        const editModal = document.getElementById('editStaffModal');
        if (editModal) {
            editModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;

                const data = {
                    id: button.getAttribute('data-id'),
                    status: button.getAttribute('data-status'),
                    date_hired: button.getAttribute('data-date_hired'),
                    date_resigned: button.getAttribute('data-date_resigned'),
                    staff_id: button.getAttribute('data-staff_id'),
                    first_name: button.getAttribute('data-first_name'),
                    middle_name: button.getAttribute('data-middle_name'),
                    last_name: button.getAttribute('data-last_name'),
                    contact_number: button.getAttribute('data-contact_number'),
                    email: button.getAttribute('data-email'),
                    gender: button.getAttribute('data-gender'),
                    address: button.getAttribute('data-address'),
                    birthdate: button.getAttribute('data-birthdate'),
                    designation: button.getAttribute('data-designation'),
                };

                // Populate form fields
                document.getElementById('edit_staff_id').value = data.id;
                document.getElementById('edit_status').value = data.status;
                document.getElementById('edit_date_hired').value = data.date_hired;
                document.getElementById('edit_date_resigned').value = data.date_resigned;
                document.getElementById('edit_staff_id_field').value = data.staff_id;
                document.getElementById('edit_first_name').value = data.first_name;
                document.getElementById('edit_middle_name').value = data.middle_name;
                document.getElementById('edit_last_name').value = data.last_name;
                document.getElementById('edit_contact_number').value = data.contact_number;
                document.getElementById('edit_email').value = data.email;
                document.getElementById('edit_gender').value = data.gender;
                document.getElementById('edit_address').value = data.address;
                document.getElementById('edit_birthdate').value = data.birthdate;
                document.getElementById('edit_designation').value = data.designation;

            });
        }

        function toggleEditDateResigned(status) {
            const resignedField = document.getElementById('edit_date_resigned_wrapper');
            if (status === 'Resigned') {
                resignedField.style.display = 'block';
            } else {
                resignedField.style.display = 'none';
                document.getElementById('edit_date_resigned').value = ''; // Clear value when hidden
            }
        }

        // Handle status change in edit modal
        document.getElementById('edit_status').addEventListener('change', function() {
            toggleEditDateResigned(this.value);
        });

        // Initialize on modal show (to apply logic based on existing data)
        document.getElementById('editStaffModal').addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const status = button.getAttribute('data-status');
            const dateResigned = button.getAttribute('data-date_resigned');

            document.getElementById('edit_status').value = status;
            document.getElementById('edit_date_resigned').value = dateResigned;

            toggleEditDateResigned(status);
        });

        // Initialize Select2 for visitor_name
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
        $(document).on('input', 'input[name="members[]"]', function() {
            updateMemberInputLimits();
        });

        function resetMemberInputs() {
            $('input[name="members[]"]').each(function() {
                $(this).val('');
                $(this).attr('max', totalMembers);
                $(this).prop('readonly', false);
            });
        }

        function updateMemberInputLimits() {
            let used = 0;

            // First, calculate the total used
            $('input[name="members[]"]').each(function() {
                used += parseInt($(this).val()) || 0;
            });

            if (used > totalMembers) {
                // Reset all to 0 if over limit
                $('input[name="members[]"]').each(function() {
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

            $('input[name="members[]"]').each(function() {
                let currentVal = parseInt($(this).val()) || 0;
                let max = currentVal + remaining;
                $(this).attr('max', max);
                $(this).prop('readonly', totalMembers === 0);
            });

            // Lock further increments if full
            if (remaining <= 0) {
                $('input[name="members[]"]').each(function() {
                    let val = parseInt($(this).val()) || 0;
                    $(this).attr('max', val); // lock to current value
                });
            }
        }

        const rows = document.querySelectorAll('tbody tr');
        const totalInput = document.getElementById('total_payment');

        rows.forEach((row, idx) => {
            const memberInput = row.querySelector('input[name="members[]"]');
            const feeInput = row.querySelector('input[name="fee[]"]');
            const subtotalInput = row.querySelector('input[id="sub-total"]');

            const updateSubtotal = () => {
                const members = parseInt(memberInput.value) || 0;
                const fee = parseFloat(feeInput.value) || 0;
                const subtotal = members * fee;
                subtotalInput.value = subtotal.toFixed(2);

                updateTotal(); // Update total after each change
            };

            const updateTotal = () => {
                let total = 0;
                document.querySelectorAll('input[id="sub-total"]').forEach(st => {
                    total += parseFloat(st.value) || 0;
                });
                totalInput.value = total.toFixed(2);
            };

            if (memberInput && feeInput && subtotalInput) {
                updateSubtotal();

                memberInput.addEventListener('keydown', function(e) {
                    if (e.key === "ArrowUp" || e.key === "ArrowDown") {
                        setTimeout(updateSubtotal, 100);
                    }
                });

                // Also trigger on input
                memberInput.addEventListener('input', updateSubtotal);
                feeInput.addEventListener('input',
                    updateSubtotal); // Optional: if fee input is editable
            }

        });
    });
</script>
