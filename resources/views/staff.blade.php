@extends('layouts.auth') <!-- Extend the main layout -->

@section('content')
    <!-- Start the content section -->
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div class="d-flex">
            <i class="fa fa-users fa-2x text-dark me-2"></i>
            <div class="d-flex flex-column">
                <h1 class="h3 mb-0 text">LIST & ATTENDANCE</h1>
                <h6 class="mb-0">Staff | Staffs</h6>
            </div>
        </div>
        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStaffModal">Add Staff</a>
    </div>

    <!-- Content Row -->
    @include('layouts.staff-navigation')
    <div class="card shadow mb-4">
        <div class="card-body">
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
                                    {{ $staff->date_resigned ? \Carbon\Carbon::parse($staff->date_resigned)->format('F j, Y') : 'N/A' }}
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
                                    <div class="d-flex align-items-center justify-c gap-1">
                                        <a href="#" class="btn btn-secondary btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#viewStaffModal" data-id="{{ $staff->id }}"
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
                                            <i class="fas fa-eye"></i>
                                        </a>

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
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('staff.destroy', $staff->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to delete this staff?')">
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
    <!-- Content Row -->

    <!-- Add Staff Modal -->
    <div class="modal fade" id="addStaffModal" tabindex="-1" role="dialog" aria-labelledby="addStaffModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-md" role="document" style="min-width: 690px;">
            <form action="{{ route('staff.store') }}" method="POST">
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
                        <div
                            class="bg-theme-primary d-flex align-items-center gap-2 justify-content-center text-light p-2 mb-3">
                            <i class="fa fa-book fa-2x"></i>
                            <h3 class="m-0">STAFF</h3>
                        </div>
                        <div class="text-center mb-3">
                            <i class="fa fa-user-circle text-secondary" style="font-size: 80px"></i>
                        </div>

                        <div class="form-group mb-3">
                            <div class="d-flex align-items-center gap-3">
                                <label for="">Name: </label>
                                <div class="col-4 first-name">
                                    <input type="text" name="first_name" class="form-control" placeholder="First Name"
                                        required>
                                </div>
                                <div class="col-3 middle-name">
                                    <input type="text" name="middle_name" placeholder="Middle Name"
                                        class="form-control">
                                </div>
                                <div class="col-3 last-name">
                                    <input type="text" name="last_name" class="form-control" placeholder="Last Name"
                                        required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <div class="d-flex align-items-center gap-3">
                                <label for="staff-id">Staff ID:</label>
                                <div class="col-6 staff-id">
                                    <input type="text" name="staff_id" class="form-control" required>
                                </div>
                                <label for="gender">Sex:</label>
                                <div class="gender col-3">
                                    <select name="gender" class="form-control" id="gender" required>
                                        <option value="">Select gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <div class="d-flex align-items-center gap-3">
                                <label for="address">Address:</label>
                                <div class="col-10 address">
                                    <textarea rows="1" name="address" class="form-control" required></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <div class="d-flex align-items-center gap-3">
                                <label for="contact_number">Contact:</label>
                                <div class="contact_number col-10">
                                    <input type="text" name="contact_number" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <div class="d-flex align-items-center gap-3">
                                <label for="email">Email:</label>
                                <div class="email col-10">
                                    <input type="email" name="email" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <div class="d-flex align-items-center gap-3">
                                <label for="birthdate">Birthdate</label>
                                <input type="date" name="birthdate" value="" class="form-control" required />
                                <label for="status">Status:</label>
                                <select name="status" class="form-control" id="" required>
                                    <option value="">Select Status</option>
                                    <option value="Hired">Hired</option>
                                    <option value="Resigned">Resigned</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <div class="d-flex align-items-center gap-3">
                                <label for="date_hired">Date Hired:</label>
                                <div class="form-group">
                                    <input type="date" name="date_hired" value="" class="form-control"
                                        required />
                                </div>
                                <div class="form-group col-6" id="add_date_resigned_wrapper">
                                    <div class="d-flex align-items-center gap-3">
                                        <label for="date_resigned" class="w-75">Date Resigned:</label>
                                        <input type="date" name="date_resigned" value=""
                                            class="form-control" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="d-flex gap-3 align-items-center col-6">
                                <label for="designation">Designation:</label>
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
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Save</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- View Staff Modal -->
    <div class="modal fade" id="viewStaffModal" tabindex="-1" role="dialog" aria-labelledby="viewStaffModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-md" role="document" style="min-width: 690px;">
            <input type="hidden" id="view_staff_id">

            <div class="modal-content">
                <div class="modal-header">
                    <div class="col-12">
                        <div class="text-end">
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="d-flex align-items-center gap-2 justify-content-center">
                            <img src="{{ asset('public/img/jbp-icon.jpg') }}" width="70">
                            <div class="d-flex flex-column">
                                <b class="modal-title mt-2">JPB Heritage Inland Resort</b>
                                <span>Progreso Street Illauod, Bugasong, Antique</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-body">
                    <div
                        class="bg-theme-primary d-flex align-items-center gap-2 justify-content-center text-light p-2 mb-3">
                        <i class="fa fa-eye fa-2x"></i>
                        <h3 class="m-0">VIEW STAFF</h3>
                    </div>

                    <div class="text-center mb-3">
                        <i class="fa fa-user-circle text-secondary" style="font-size: 80px"></i>
                    </div>

                    <!-- NAME -->
                    <div class="form-group mb-3">
                        <div class="d-flex align-items-center gap-3">
                            <label>Name:</label>
                            <div class="col-4">
                                <input readonly type="text" id="view_first_name" class="form-control">
                            </div>
                            <div class="col-3">
                                <input readonly type="text" id="view_middle_name" class="form-control">
                            </div>
                            <div class="col-3">
                                <input readonly type="text" id="view_last_name" class="form-control">
                            </div>
                        </div>
                    </div>

                    <!-- STAFF ID + GENDER -->
                    <div class="form-group mb-3">
                        <div class="d-flex align-items-center gap-3">
                            <label>Staff ID:</label>
                            <div class="col-6">
                                <input readonly type="text" id="view_staff_id_field" class="form-control">
                            </div>

                            <label>Sex:</label>
                            <div class="col-3">
                                <select disabled id="view_gender" class="form-control">
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- ADDRESS -->
                    <div class="form-group mb-3">
                        <div class="d-flex align-items-center gap-3">
                            <label>Address:</label>
                            <div class="col-10">
                                <textarea readonly id="view_address" class="form-control" rows="1"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- CONTACT -->
                    <div class="form-group mb-3">
                        <div class="d-flex align-items-center gap-3">
                            <label>Contact:</label>
                            <div class="col-10">
                                <input readonly type="text" id="view_contact_number" class="form-control">
                            </div>
                        </div>
                    </div>

                    <!-- EMAIL -->
                    <div class="form-group mb-3">
                        <div class="d-flex align-items-center gap-3">
                            <label>Email:</label>
                            <div class="col-10">
                                <input readonly type="email" id="view_email" class="form-control">
                            </div>
                        </div>
                    </div>

                    <!-- BIRTHDATE + STATUS -->
                    <div class="form-group mb-3">
                        <div class="d-flex align-items-center gap-3">
                            <label>Birthdate:</label>
                            <input readonly type="date" id="view_birthdate" class="form-control">
                            <label>Age</label>
                            <input readonly type="number" id="view_age" class="form-control">
                            <label>Status:</label>
                            <select disabled id="view_status" class="form-control">
                                <option value="Hired">Hired</option>
                                <option value="Resigned">Resigned</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <div class="d-flex align-items-center gap-3">
                            <label>Date Hired:</label>
                            <div class="form-group">
                                <input readonly type="date" id="view_date_hired" class="form-control">
                            </div>
                            <div class="col-6 d-flex align-items-center gap-2">
                                <label class="w-75">Date Resigned:</label>
                                <input readonly type="date" id="view_date_resigned" class="form-control">
                            </div>
                        </div>
                    </div>

                    <!-- DESIGNATION -->
                    <div class="form-group mb-3">
                        <div class="d-flex align-items-center gap-2 flex-nowrap">
                            <label class="mb-0">Service Duration:</label>
                            <input readonly type="text" id="view_service_duration" class="form-control w-auto"
                                style="min-width: 150px;">
                            <label class="mb-0">Designation:</label>
                            <select disabled id="view_designation" class="form-control w-auto" style="min-width: 180px;">
                                <option value="Front Desk">Front Desk</option>
                                <option value="Support Staff">Support Staff</option>
                                <option value="Maintenance">Maintenance</option>
                                <option value="Finance Staff">Finance Staff</option>
                                <option value="Event Coordinator">Event Coordinator</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Staff Modal -->
    <div class="modal fade" id="editStaffModal" tabindex="-1" role="dialog" aria-labelledby="editStaffModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-md" role="document" style="min-width: 690px;">
            <form action="{{ route('staff.update') }}" method="POST" id="editStaffForm">
                @csrf
                <input type="hidden" name="id" id="edit_staff_id">

                <div class="modal-content">
                    <div class="modal-header">
                        <div class="col-12">
                            <div class="text-end">
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="d-flex align-items-center gap-2 justify-content-center">
                                <img src="{{ asset('public/img/jbp-icon.jpg') }}" width="70">
                                <div class="d-flex flex-column">
                                    <b class="modal-title mt-2">JPB Heritage Inland Resort</b>
                                    <span>Progreso Street Illauod, Bugasong, Antique</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-body">
                        <div
                            class="bg-theme-primary d-flex align-items-center gap-2 justify-content-center text-light p-2 mb-3">
                            <i class="fa fa-edit fa-2x"></i>
                            <h3 class="m-0">EDIT STAFF</h3>
                        </div>

                        <div class="text-center mb-3">
                            <i class="fa fa-user-circle text-secondary" style="font-size: 80px"></i>
                        </div>

                        <!-- NAME -->
                        <div class="form-group mb-3">
                            <div class="d-flex align-items-center gap-3">
                                <label>Name:</label>
                                <div class="col-4">
                                    <input type="text" name="first_name" id="edit_first_name" class="form-control"
                                        required>
                                </div>
                                <div class="col-3">
                                    <input type="text" name="middle_name" id="edit_middle_name" class="form-control">
                                </div>
                                <div class="col-3">
                                    <input type="text" name="last_name" id="edit_last_name" class="form-control"
                                        required>
                                </div>
                            </div>
                        </div>

                        <!-- STAFF ID + GENDER -->
                        <div class="form-group mb-3">
                            <div class="d-flex align-items-center gap-3">
                                <label>Staff ID:</label>
                                <div class="col-6">
                                    <input type="text" name="staff_id" id="edit_staff_id_field" class="form-control"
                                        required>
                                </div>

                                <label>Sex:</label>
                                <div class="col-3">
                                    <select name="gender" id="edit_gender" class="form-control" required>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- ADDRESS -->
                        <div class="form-group mb-3">
                            <div class="d-flex align-items-center gap-3">
                                <label>Address:</label>
                                <div class="col-10">
                                    <textarea name="address" id="edit_address" class="form-control" rows="1" required></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- CONTACT -->
                        <div class="form-group mb-3">
                            <div class="d-flex align-items-center gap-3">
                                <label>Contact:</label>
                                <div class="col-10">
                                    <input type="text" name="contact_number" id="edit_contact_number"
                                        class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <!-- EMAIL -->
                        <div class="form-group mb-3">
                            <div class="d-flex align-items-center gap-3">
                                <label>Email:</label>
                                <div class="col-10">
                                    <input type="email" name="email" id="edit_email" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <!-- BIRTHDATE + STATUS -->
                        <div class="form-group mb-3">
                            <div class="d-flex align-items-center gap-3">
                                <label>Birthdate:</label>
                                <input type="date" name="birthdate" id="edit_birthdate" class="form-control"
                                    required>

                                <label>Status:</label>
                                <select name="status" id="edit_status" class="form-control" required>
                                    <option value="Hired">Hired</option>
                                    <option value="Resigned">Resigned</option>
                                </select>
                            </div>
                        </div>

                        <!-- DATES -->
                        <div class="form-group mb-3">
                            <div class="d-flex align-items-center gap-3">
                                <label for="date_hired">Date Hired:</label>
                                <div class="form-group">
                                    <input type="date" name="date_hired" id="edit_date_hired" value=""
                                        class="form-control" required />
                                </div>
                                <div class="form-group col-6" id="edit_date_resigned_wrapper">
                                    <div class="d-flex align-items-center gap-3">
                                        <label for="date_resigned" class="w-75">Date Resigned:</label>
                                        <input type="date" name="date_resigned" id="edit_date_resigned"
                                            value="" class="form-control" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- DESIGNATION -->
                        <div class="form-group">
                            <div class="d-flex align-items-center gap-3 col-6">
                                <label>Designation:</label>
                                <select name="designation" id="edit_designation" class="form-control" required>
                                    <option value="Front Desk">Front Desk</option>
                                    <option value="Support Staff">Support Staff</option>
                                    <option value="Maintenance">Maintenance</option>
                                    <option value="Finance Staff">Finance Staff</option>
                                    <option value="Event Coordinator">Event Coordinator</option>
                                </select>
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
@endsection <!-- End the content section -->

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const statusSelect = document.querySelector('select[name="status"]');
        const dateResignedGroup = document.getElementById('add_date_resigned_wrapper');

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
                // document.getElementById('view_date_resigned').value = data.date_resigned;
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
                const resignedInput = document.getElementById('view_date_resigned');

                if (data.date_resigned && data.date_resigned !== 'null') {
                    resignedInput.type = 'date';
                    resignedInput.value = data.date_resigned;
                } else {
                    resignedInput.type = 'text';
                    resignedInput.value = '';
                    resignedInput.placeholder = 'N/A';
                }

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
    });
</script>
