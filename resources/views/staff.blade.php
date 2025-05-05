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
                            <th class="text-start">Contact No.</th>
                            <th>Designation</th>
                            <th>Date Hired</th>
                            <th>Date Resigned</th>
                            <th>Service Duration</th>
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
                                <td class="text-start">{{ $staff->contact_number }}</td>
                                <td>{{ $staff->designation }}</td>
                                <td>{{ \Carbon\Carbon::parse($staff->date_hired)->format('F j, Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($staff->date_resigned)->format('F j, Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($staff->date_hired)->diffInDays($staff->date_resigned) }} days
                                </td>
                                <td class="d-flex gap-2">
                                    <a href="#" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#editVisitorModal" data-id="{{ $staff->id }}">
                                        Edit
                                    </a>
                                    <form action="" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Are you sure you want to delete this staff?')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Content Row -->

    <!-- Add Visitor Modal -->
    <div class="modal fade" id="addStaffModal" tabindex="-1" role="dialog" aria-labelledby="addStaffModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form action="" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addStaffModalLabel">Add New Staff</h5>
                    </div>

                    <div class="modal-body">
                        <div class="form-group mb-2">
                            <div class="d-flex align-items-start gap-3">
                                <div class="form-group col-3">
                                    <label for="date_hired">Date Hired</label>
                                    <input type="date" name="date_hired" value="" class="form-control" required />
                                </div>

                                <div class="form-group col-3">
                                    <label for="date_resigned">Date Resigned</label>
                                    <input type="date" name="date_resigned" value="" class="form-control" />
                                </div>

                                <div class="col-4 staff-id">
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
                                        <option value="Manager">Front Desk</option>
                                        <option value="Staff">Support Staff</option>
                                        <option value="Intern">Maintenance</option>
                                        <option value="Intern">Finance Staff</option>
                                        <option value="Intern">Event Coordinator</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="designation">Status</label>
                                    <select name="designation" class="form-control" id="" required>
                                        <option value="">Select Status</option>
                                        <option value="Manager">Hired</option>
                                        <option value="Staff">Resigned</option>
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

    <!-- Edit Visitor Modal -->
    <div class="modal fade" id="editVisitorModal" tabindex="-1" role="dialog" aria-labelledby="editVisitorModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form action="{{ route('visitor.update') }}" id="editVisitorForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editVisitorModalLabel">Edit Visitor</h5>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="visitor_id" id="visitor_id">

                        <div class="form-group mb-2 col-3">
                            <label for="date_visit">Date Visit</label>
                            <input type="date" name="date_visit" id="edit_date_visit" class="form-control" required>
                        </div>

                        <div class="form-group mb-2">
                            <div class="d-flex align-items-center gap-3">
                                <div class="col-4 first-name">
                                    <label for="first_name">First Name</label>
                                    <input type="text" name="first_name" id="edit_first_name" class="form-control"
                                        required>
                                </div>
                                <div class="col-3 middle-name">
                                    <label for="middle_name">Middle Name</label>
                                    <input type="text" name="middle_name" id="edit_middle_name" class="form-control">
                                </div>
                                <div class="col-4 last-name">
                                    <label for="last_name">Last Name</label>
                                    <input type="text" name="last_name" id="edit_last_name" class="form-control"
                                        required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-2">
                            <div class="d-flex align-items-center gap-3">
                                <div class="contact_number col-3">
                                    <label for="contact_number">Contact No.</label>
                                    <input type="text" name="contact_number" id="edit_contact_number"
                                        class="form-control" required>
                                </div>

                                <div class="gender col-3">
                                    <label for="gender">Gender</label>
                                    <select name="gender" id="edit_gender" class="form-control" required>
                                        <option value="">Select gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>

                                <div class="age col-2">
                                    <label for="age">Age</label>
                                    <input type="number" name="age" id="edit_age" class="form-control" required>
                                </div>

                                <div class="members col-2">
                                    <label for="members">Members</label>
                                    <input type="number" name="members" id="edit_members" class="form-control"
                                        required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-2">
                            <label for="address">Address</label>
                            <textarea name="address" id="edit_address" class="form-control" required></textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Visitor</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection <!-- End the content section -->

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Edit Visitor Modal Populating
        const modal = document.getElementById('editVisitorModal');
        modal.addEventListener('show.bs.modal', function(e) {
            var button = e.relatedTarget; // Button that triggered the modal

            // Fetch data-* attributes
            var id = button.getAttribute('data-id');
            var first_name = button.getAttribute('data-first_name');
            var middle_name = button.getAttribute('data-middle_name');
            var last_name = button.getAttribute('data-last_name');
            var contact_number = button.getAttribute('data-contact_number');
            var gender = button.getAttribute('data-gender');
            var age = button.getAttribute('data-age');
            var members = button.getAttribute('data-members');
            var address = button.getAttribute('data-address');
            var date_visit = button.getAttribute('data-date_visit');

            // Log the data to the console for debugging
            console.log("Edit Modal Data:", {
                id,
                first_name,
                middle_name,
                last_name,
                contact_number,
                gender,
                age,
                members,
                address,
                date_visit
            });

            // Set the values of the modal fields
            document.getElementById('visitor_id').value = id;
            document.getElementById('edit_first_name').value = first_name;
            document.getElementById('edit_middle_name').value = middle_name;
            document.getElementById('edit_last_name').value = last_name;
            document.getElementById('edit_contact_number').value = contact_number;
            document.getElementById('edit_gender').value = gender;
            document.getElementById('edit_age').value = age;
            document.getElementById('edit_members').value = members;
            document.getElementById('edit_address').value = address;
            document.getElementById('edit_date_visit').value = date_visit;
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add event listeners for input changes
        document.getElementById('start_date').addEventListener('change', validateAndSubmit);
        document.getElementById('end_date').addEventListener('change', validateAndSubmit);

        function validateAndSubmit() {
            var startDate = document.getElementById('start_date').value;
            var endDate = document.getElementById('end_date').value;

            // Check if both dates are filled out
            if (startDate && endDate) {
                document.getElementById('dateRangeForm').submit(); // Submit the form if both dates are provided
            }
        }
    });
</script>
