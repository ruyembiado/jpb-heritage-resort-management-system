@extends('layouts.auth') <!-- Extend the main layout -->

@section('content')
    <!-- Start the content section -->
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text">Staffs</h1>
        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStaffModal">Add Staff</a>
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
                            <th>Staff ID</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Designation</th>
                            <th>Date Hired</th>
                            <th>Date Resigned</th>
                            {{-- <th>Service Duration</th> --}}
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($staffs as $staff)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $staff->staff_id }}</td>
                                <td>{{ $staff->first_name . ' ' . $staff->middle_name . ' ' . $staff->last_name }}
                                </td>
                                <td>
                                    <span class="badge {{ $staff->status == 'Hired' ? 'bg-success' : 'bg-danger' }}">
                                        {{ $staff->status }}
                                    </span>
                                </td>
                                <td>{{ $staff->designation }}</td>
                                <td>{{ \Carbon\Carbon::parse($staff->date_hired)->format('F j, Y') }}</td>
                                <td>
                                    {{ $staff->date_resigned ? \Carbon\Carbon::parse($staff->date_resigned)->format('F j, Y') : '' }}
                                </td>
                                {{-- <td>
                                    @php
                                        $hired = \Carbon\Carbon::parse($staff->date_hired);
                                        $resigned = \Carbon\Carbon::parse($staff->date_resigned);
                                        $diff = $hired->diff($resigned);
                                        if ($diff->y >= 1) {
                                            echo $diff->y . ' year' . ($diff->y > 1 ? 's' : '');
                                            echo ' ' . $diff->m . ' month' . ($diff->m > 1 ? 's' : '');
                                            echo ' ' . $diff->d . ' day' . ($diff->d > 1 ? 's' : '');
                                        } elseif ($diff->m >= 1) {
                                            echo $diff->m . ' month' . ($diff->m > 1 ? 's' : '');
                                            echo ' ' . $diff->d . ' day' . ($diff->d > 1 ? 's' : '');
                                        } else {
                                            echo $diff->d . ' day' . ($diff->d > 1 ? 's' : '');
                                        }
                                    @endphp
                                </td> --}}
                                <td>
                                    <div class="d-flex align-items-center justify-c gap-2">
                                        <a href="#" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#editStaffModal" data-id="{{ $staff->id }}"
                                            data-status="{{ $staff->status }}" data-date_hired="{{ $staff->date_hired }}"
                                            data-date_resigned="{{ $staff->date_resigned }}"
                                            data-staff_id="{{ $staff->staff_id }}"
                                            data-first_name="{{ $staff->first_name }}"
                                            data-middle_name="{{ $staff->middle_name }}"
                                            data-last_name="{{ $staff->last_name }}"
                                            data-contact_number="{{ $staff->contact_number }}"
                                            data-email="{{ $staff->email }}" data-gender="{{ $staff->gender }}"
                                            data-address="{{ $staff->address }}" data-birthdate="{{ $staff->birthdate }}"
                                            data-designation="{{ $staff->designation }}">
                                            Edit
                                        </a>

                                        <form action="{{ route('staff.destroy', $staff->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to delete this staff?')">
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

    <!-- Add Staff Modal -->
    <div class="modal fade" id="addStaffModal" tabindex="-1" role="dialog" aria-labelledby="addStaffModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form action="{{ route('staff.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addStaffModalLabel">Add New Staff</h5>
                    </div>

                    <div class="modal-body">
                        <div class="form-group mb-2">
                            <div class="d-flex align-items-start gap-3">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" class="form-control" id="" required>
                                        <option value="">Select Status</option>
                                        <option value="Hired">Hired</option>
                                        <option value="Resigned">Resigned</option>
                                    </select>
                                </div>

                                <div class="form-group col-3">
                                    <label for="date_hired">Date Hired</label>
                                    <input type="date" name="date_hired" value="" class="form-control" required />
                                </div>

                                <div class="form-group col-3">
                                    <label for="date_resigned">Date Resigned</label>
                                    <input type="date" name="date_resigned" value="" class="form-control" />
                                </div>

                                <div class="col-3 staff-id">
                                    <label for="staff-id">Staff ID</label>
                                    <input type="text" name="staff_id" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-2">
                            <div class="d-flex align-items-center gap-3">
                                <div class="col-4 first-name">
                                    <label for="first-name">First Name</label>
                                    <input type="text" name="first_name" class="form-control" required>
                                </div>
                                <div class="col-3 middle-name">
                                    <label for="middle-name">Middle Name</label>
                                    <input type="text" name="middle_name" class="form-control">
                                </div>
                                <div class="col-4 last-name">
                                    <label for="last-name">Last Name</label>
                                    <input type="text" name="last_name" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-2">
                            <div class="d-flex align-items-center gap-3">
                                <div class="contact_number col-3">
                                    <label for="contact_number">Contact No.</label>
                                    <input type="text" name="contact_number" class="form-control" required>
                                </div>

                                <div class="email col-5">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" class="form-control" required>
                                </div>

                                <div class="gender col-3">
                                    <label for="gender">Gender</label>
                                    <select name="gender" class="form-control" id="gender" required>
                                        <option value="">Select gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>


                            </div>
                        </div>

                        <div class="form-group mb-2">
                            <label for="address">Address</label>
                            <textarea name="address" class="form-control" required></textarea>
                        </div>

                        <div class="form-group mb-2">
                            <div class="d-flex align-items-center gap-3">
                                <div class="form-group col-3">
                                    <label for="birthdate">Birthdate</label>
                                    <input type="date" name="birthdate" value="" class="form-control"
                                        required />
                                </div>

                                <div class="form-group">
                                    <label for="designation">Designation</label>
                                    <select name="designation" class="form-control" id="" required>
                                        <option value="">Select designation</option>
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
                        <button type="submit" class="btn btn-primary">Add Staff</button>
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
                                <div class="col-5">
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
    });
</script>
