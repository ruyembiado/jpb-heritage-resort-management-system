@extends('layouts.auth') <!-- Extend the main layout -->

@section('content')
    <!-- Start the content section -->
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text">Visitor's Log Book</h1>
        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addVisitorModal">Add Visitor</a>
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
                            <th>Age</th>
                            <th>Address</th>
                            <th>Contact No.</th>
                            <th>Date Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Content Row -->

    <!-- Add Visitor Modal -->
    <div class="modal fade" id="addVisitorModal" tabindex="-1" role="dialog" aria-labelledby="addVisitorModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form action="" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addVisitorModalLabel">Add New Visitor</h5>
                    </div>

                    <div class="modal-body">
                        <!-- Visitor Name -->

                        <div class="form-group mb-2 col-3">
                            <label for="date">Date</label>
                            <input type="date" name="date" value="{{ now()->toDateString() }}" class="form-control" required />
                        </div>

                        <div class="form-group mb-2">
                            <div class="d-flex align-items-center gap-3">
                                <div class="col-4 first-name">
                                    <label for="first-name">Name</label>
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
                                <div class="contact-no col-3">
                                    <label for="contact-no">Contact No.</label>
                                    <input type="text" name="contact_no" class="form-control" required>
                                </div>

                                <div class="gender col-3">
                                    <label for="gender">Gender</label>
                                    <select name="gender" class="form-control" id="gender" required>
                                        <option value="">Select gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>

                                <div class="age col-2">
                                    <label for="age">Age</label>
                                    <input type="number" name="age" class="form-control" required>
                                </div>

                                <div class="members col-2">
                                    <label for="members">Members</label>
                                    <input type="number" name="contact_no" min="1" value="1"
                                        class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-2">
                            <label for="address">Address</label>
                            <textarea name="address" class="form-control" required></textarea>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Visitor</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection <!-- End the content section -->
