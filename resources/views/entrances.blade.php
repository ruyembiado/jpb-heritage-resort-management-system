@extends('layouts.auth') <!-- Extend the main layout -->

@section('content')
    <!-- Start the content section -->
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div class="d-flex">
            <i class="fas fa-money-bill fa-2x text-dark me-2"></i>
            <div class="d-flex flex-column">
                <h1 class="h3 mb-0 text">AVAILED SERVICES</h1>
                <h6 class="mb-0">Guest | Entrance Fees</h6>
            </div>
        </div>
        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEntranceModal">Add Entrance Fee</a>
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
                    style="min-width:2000px;">
                    <thead>
                        <tr>
                            <th class="bg-theme-primary text-light border-dark">NO.</th>
                            <th class="bg-theme-primary text-light border-dark">NAME OF GUEST</th>
                            <th class="bg-theme-primary text-light border-dark">SEX</th>
                            <th class="bg-theme-primary text-light border-dark">AGE</th>
                            <th class="bg-theme-primary text-light border-dark">MEMBERS</th>
                            <th class="bg-theme-primary text-light border-dark">TOTAL FEE</th>
                            <th class="bg-theme-primary text-light border-dark">STATUS</th>
                            <th class="bg-theme-primary text-light border-dark">CONTACT NO.</th>
                            <th class="bg-theme-primary text-light border-dark">ADDRESS</th>
                            <th class="bg-theme-primary text-light border-dark">CHECK-IN</th>
                            <th class="bg-theme-primary text-light border-dark">DATE CREATED</th>
                            <th class="bg-theme-primary text-light border-dark sticky-action">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($entrances as $entrance)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    {{ $entrance->visitor?->first_name ?? '' }}
                                    {{ $entrance->visitor?->middle_name ?? '' }}
                                    {{ $entrance->visitor?->last_name ?? '' }}
                                </td>
                                <td>{{ $entrance->visitor->gender }}</td>
                                <td>{{ $entrance->visitor->age }}</td>
                                <td class="text-center px-0 pb-0">
                                    {{ $entrance->visitor->members ?? 0 }}
                                    @if (!empty($entrance->companions))
                                        <table class="table table-bordered mt-2 mb-0">
                                            <thead>
                                                <tr>
                                                    <th class="bg-success text-light">No.</th>
                                                    <th class="bg-success text-light">Name</th>
                                                    <th class="bg-success text-light">Category</th>
                                                    <th class="bg-success text-light">Sex</th>
                                                    <th class="bg-success text-light">Age</th>
                                                    <th class="bg-success text-light">Address</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($entrance->companions as $index => $companion)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $companion->name }}</td>
                                                        <td>
                                                            @if ($companion->age <= 15)
                                                                Child
                                                            @elseif ($companion->isPWD)
                                                                PWD
                                                            @else
                                                                Adult
                                                            @endif
                                                        </td>
                                                        <td>{{ $companion->gender }}</td>
                                                        <td>{{ $companion->age }}</td>
                                                        <td>{{ $companion->address }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @else
                                        <span class="text-muted">No companions</span>
                                    @endif
                                </td>
                                <td>₱ {{ number_format($entrance->total_payment, 2) }}</td>
                                <td>
                                    @if ($entrance->status === 'Paid')
                                        <span class="badge bg-success">Paid</span>
                                    @else
                                        <span class="badge bg-danger">Unpaid</span>
                                    @endif
                                </td>
                                <td>{{ $entrance->visitor->contact_number }}</td>
                                <td>{{ $entrance->visitor->address }}</td>
                                <td>{{ \Carbon\Carbon::parse($entrance->visitor->created_at)->format('h:i A') }}</td>
                                <td>{{ \Carbon\Carbon::parse($entrance->created_at)->format('M d, Y') }}</td>
                                <td class="sticky-action">
                                    <div class="d-flex align-items-center gap-1">
                                        <button class="btn btn-warning btn-sm editEntranceBtn"
                                            data-id="{{ $entrance->id }}"
                                            data-first_name="{{ $entrance->visitor->first_name }}"
                                            data-middle_name="{{ $entrance->visitor->middle_name }}"
                                            data-last_name="{{ $entrance->visitor->last_name }}"
                                            data-age="{{ $entrance->visitor->age }}"
                                            data-gender="{{ $entrance->visitor->gender }}"
                                            data-contact="{{ $entrance->visitor->contact_number }}"
                                            data-address="{{ $entrance->visitor->address }}"
                                            data-pwd="{{ $entrance->visitor->isPWD ?? 0 }}"
                                            data-fee="{{ $entrance->total_payment }}"
                                            data-status="{{ $entrance->status }}"
                                            data-companions="{{ json_encode($entrance->companions) }}"
                                            data-members="{{ $entrance->visitor->members ?? 0 }}" data-bs-toggle="modal"
                                            data-bs-target="#editEntranceModal">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('visitor.destroy', $entrance->visitor_id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this visitor record?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
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

    <!-- Add Entrance Modal -->
    <div class="modal fade" id="addEntranceModal" tabindex="-1" role="dialog" aria-labelledby="addEntranceModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <form action="{{ route('entrance.store') }}" method="POST" id="entranceAddForm">
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
                        <input type="hidden" name="date_visit" value="{{ now()->toDateString() }}"
                            class="form-control" required />
                        <div
                            class="bg-theme-primary d-flex align-items-center gap-2 justify-content-center text-light p-2 mb-3">
                            <i class="fa fa-book fa-2x"></i>
                            <h3 class="m-0">ENTRANCE FEE</h3>
                        </div>
                        <b>GUEST INFORMATION</b>
                        <div class="form-group mb-2">
                            <div class="d-flex align-items-center gap-3">
                                <label style="min-width: 120px;">Complete Name:</label>
                                <div class="col-3">
                                    <input type="text" name="guest_first_name" class="form-control"
                                        placeholder="First Name" required>
                                </div>
                                <div class="col-3">
                                    <input type="text" name="guest_middle_name" class="form-control"
                                        placeholder="Middle Name">
                                </div>
                                <div class="col-3">
                                    <input type="text" name="guest_last_name" class="form-control"
                                        placeholder="Last Name" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-2">
                            <div class="d-flex align-items-center gap-3">
                                <label style="min-width: 120px;">Contact Number:</label>
                                <div class="col-3">
                                    <input type="text" name="guest_contact_number" class="form-control" required>
                                </div>
                                <label>Age:</label>
                                <div class="col-2">
                                    <input type="number" name="guest_age" id="guest_age" class="form-control" required
                                        onchange="calculateGuestFee()">
                                </div>
                                <label>Sex:</label>
                                <div class="col-2">
                                    <select name="guest_gender" class="form-control" required>
                                        <option value="">Select sex</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-2">
                            <div class="d-flex align-items-center gap-3">
                                <label style="min-width: 120px;">Address:</label>
                                <div class="col-5">
                                    <input type="text" name="guest_address" class="form-control" required>
                                </div>
                                <label style="min-width: 50px;">is PWD?</label>
                                <div class="col-1">
                                    <input type="checkbox" name="guest_is_pwd" id="guest_is_pwd" value="1"
                                        class="form-check-input" onchange="calculateGuestFee()">
                                </div>
                                <label>Guest Fee:</label>
                                <div class="col-2">
                                    <div class="d-flex">
                                        <span class="input-group-text bg-theme-primary text-light">₱</span>
                                        <input type="number" readonly name="guest_fee" id="guest_fee" min="0"
                                            value="0" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <b>ADD COMPANIONS</b>
                        <div class="form-group mb-2">
                            <div class="d-flex align-items-center gap-3">
                                <label>No. of Companions:</label>
                                <div class="col-1">
                                    <input type="number" id="add_companionsCount" name="guest_members" min="0"
                                        value="0" class="form-control">
                                </div>
                            </div>
                        </div>

                        <table class="table table-bordered border-dark" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="bg-success text-light">No.</th>
                                    <th class="bg-success text-light">Name</th>
                                    <th class="bg-success text-light">Sex</th>
                                    <th class="bg-success text-light">Age</th>
                                    <th class="bg-success text-light">is PWD?</th>
                                    <th class="bg-success text-light">Address</th>
                                    <th class="bg-success text-light">Fee</th>
                                    <th class="bg-success text-light">Action</th>
                                </tr>
                            </thead>
                            <tbody id="add_companionsTableBody"></tbody>
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
                                        <input type="text" name="total_fee" id="total_fee" value="0.00"
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

    <!-- Edit Entrance Modal -->
    <div class="modal fade" id="editEntranceModal" tabindex="-1" role="dialog"
        aria-labelledby="editEntranceModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <form action="{{ route('entrance.update') }}" method="POST" id="entranceEditForm">
                <input type="hidden" name="entrance_id" id="edit_entrance_id">
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
                        <input type="hidden" name="edit_date_visit" value="{{ now()->toDateString() }}"
                            class="form-control" required />
                        <div
                            class="bg-theme-primary d-flex align-items-center gap-2 justify-content-center text-light p-2 mb-3">
                            <i class="fa fa-book fa-2x"></i>
                            <h3 class="m-0">ENTRANCE FEE</h3>
                        </div>
                        <b>GUEST INFORMATION</b>
                        <div class="form-group mb-2">
                            <div class="d-flex align-items-center gap-3">
                                <label style="min-width: 120px;">Complete Name:</label>
                                <div class="col-3">
                                    <input type="text" name="edit_guest_first_name" class="form-control"
                                        placeholder="First Name" required>
                                </div>
                                <div class="col-3">
                                    <input type="text" name="edit_guest_middle_name" class="form-control"
                                        placeholder="Middle Name">
                                </div>
                                <div class="col-3">
                                    <input type="text" name="edit_guest_last_name" class="form-control"
                                        placeholder="Last Name" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-2">
                            <div class="d-flex align-items-center gap-3">
                                <label style="min-width: 120px;">Contact Number:</label>
                                <div class="col-3">
                                    <input type="text" name="edit_guest_contact_number" class="form-control" required>
                                </div>
                                <label>Age:</label>
                                <div class="col-2">
                                    <input type="number" name="edit_guest_age" id="edit_guest_age" class="form-control"
                                        required onchange="calculateEditGuestFee()">
                                </div>
                                <label>Sex:</label>
                                <div class="col-2">
                                    <select name="edit_guest_gender" class="form-control" required>
                                        <option value="">Select sex</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-2">
                            <div class="d-flex align-items-center gap-3">
                                <label style="min-width: 120px;">Address:</label>
                                <div class="col-5">
                                    <input type="text" name="edit_guest_address" class="form-control" required>
                                </div>
                                <label style="min-width: 50px;">is PWD?</label>
                                <div class="col-1">
                                    <input type="checkbox" name="edit_guest_is_pwd" id="edit_guest_is_pwd"
                                        value="1" class="form-check-input" onchange="calculateEditGuestFee()">
                                </div>
                                <label>Guest Fee:</label>
                                <div class="col-2">
                                    <div class="d-flex">
                                        <span class="input-group-text bg-theme-primary text-light">₱</span>
                                        <input type="number" readonly name="edit_guest_fee" id="edit_guest_fee"
                                            min="0" value="0" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <b>ADD COMPANIONS</b>
                        <div class="form-group mb-2">
                            <div class="d-flex align-items-center gap-3">
                                <label>No. of Companions:</label>
                                <div class="col-1">
                                    <input type="number" id="edit_companionsCount" name="edit_guest_members"
                                        min="0" value="0" class="form-control">
                                </div>
                            </div>
                        </div>

                        <table class="table table-bordered border-dark" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="bg-success text-light">No.</th>
                                    <th class="bg-success text-light">Name</th>
                                    <th class="bg-success text-light">Sex</th>
                                    <th class="bg-success text-light">Age</th>
                                    <th class="bg-success text-light">is PWD?</th>
                                    <th class="bg-success text-light">Address</th>
                                    <th class="bg-success text-light">Fee</th>
                                    <th class="bg-success text-light">Action</th>
                                </tr>
                            </thead>
                            <tbody id="edit_companionsTableBody"></tbody>
                        </table>

                        <div class="form-group mb-2">
                            <div class="d-flex align-items-center gap-3">
                                <label>Payment Status:</label>
                                <div class="col-2">
                                    <select name="edit_payment_status" class="form-control" required>
                                        <option value="">Select status</option>
                                        <option value="Paid">Paid</option>
                                        <option value="Unpaid">Unpaid</option>
                                    </select>
                                </div>
                                <label>Total Fee:</label>
                                <div class="col-3">
                                    <div class="d-flex">
                                        <span class="input-group-text bg-theme-primary text-light">₱</span>
                                        <input type="text" name="edit_total_fee" id="edit_total_fee" value="0.00"
                                            class="form-control" readonly required>
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
@endsection <!-- End the content section -->

<script>
    const entranceFees = @json($entranceFees);

    /* ---------------------------------
       BUILD FEE MAP
    ----------------------------------*/
    let feeMap = {};

    entranceFees.forEach(fee => {
        if (fee.service_name === "Adult") {
            feeMap['adult'] = parseFloat(fee.fee);
        } else if (fee.service_name === "PWD") {
            feeMap['pwd'] = parseFloat(fee.fee);
        } else if (fee.service_name === "Child") {
            feeMap['child'] = parseFloat(fee.fee);
        }
    });

    /* ---------------------------------
       GET FEE BASED ON AGE + PWD
    ----------------------------------*/
    function getFee(age, isPwd) {
        if (isPwd) return feeMap['pwd'] ?? 0;
        if (age <= 15) return feeMap['child'] ?? 0;
        return feeMap['adult'] ?? 0;
    }

    /* ---------------------------------
       GET CATEGORY
    ----------------------------------*/
    function getCategory(age, isPwd) {
        if (isPwd) return "PWD";
        if (age <= 15) return "Child";
        return "Adult";
    }

    /* ---------------------------------
       GUEST FEE (ADD MODAL)
    ----------------------------------*/
    window.calculateGuestFee = function() {
        let age = parseInt(document.getElementById('guest_age').value) || 0;
        let isPwd = document.getElementById('guest_is_pwd').checked;
        let fee = getFee(age, isPwd);
        document.getElementById('guest_fee').value = fee.toFixed(2);
        calculateTotal();
    }

    /* ---------------------------------
       GUEST FEE (EDIT MODAL)
    ----------------------------------*/
    window.calculateEditGuestFee = function() {
        let age = parseInt(document.getElementById('edit_guest_age').value) || 0;
        let isPwd = document.getElementById('edit_guest_is_pwd').checked;
        let fee = getFee(age, isPwd);
        document.getElementById('edit_guest_fee').value = fee.toFixed(2);
        calculateEditTotal();
    }

    /* ---------------------------------
       COMPANION FEE (ADD MODAL)
    ----------------------------------*/
    window.calculateCompanionFee = function(element) {
        const row = element.closest("tr");
        const ageInput = row.querySelector(".companion-age");
        const pwdCheckbox = row.querySelector(".companion-pwd");
        const feeInput = row.querySelector(".companion-fee");
        let age = parseInt(ageInput.value) || 0;
        let isPwd = pwdCheckbox.checked;
        let fee = getFee(age, isPwd);
        feeInput.value = fee.toFixed(2);
        calculateTotal();
    }

    /* ---------------------------------
       COMPANION FEE (EDIT MODAL)
    ----------------------------------*/
    window.calculateEditCompanionFee = function(element) {
        const row = element.closest("tr");
        const ageInput = row.querySelector(".edit-companion-age");
        const pwdCheckbox = row.querySelector(".edit-companion-pwd");
        const feeInput = row.querySelector(".edit-companion-fee");
        let age = parseInt(ageInput.value) || 0;
        let isPwd = pwdCheckbox.checked;
        let fee = getFee(age, isPwd);
        feeInput.value = fee.toFixed(2);
        calculateEditTotal();
    }

    /* ---------------------------------
       TOTAL CALCULATION (ADD MODAL)
    ----------------------------------*/
    function calculateTotal() {
        let total = 0;
        let guestFee = parseFloat(document.getElementById('guest_fee').value) || 0;
        total += guestFee;
        document.querySelectorAll("#add_companionsTableBody .companion-fee").forEach(function(input) {
            total += parseFloat(input.value) || 0;
        });
        document.getElementById("total_fee").value = total.toFixed(2);
    }

    /* ---------------------------------
       TOTAL CALCULATION (EDIT MODAL)
    ----------------------------------*/
    function calculateEditTotal() {
        let total = 0;
        let guestFee = parseFloat(document.getElementById('edit_guest_fee').value) || 0;
        total += guestFee;
        document.querySelectorAll("#edit_companionsTableBody .edit-companion-fee").forEach(function(input) {
            total += parseFloat(input.value) || 0;
        });
        document.getElementById("edit_total_fee").value = total.toFixed(2);
    }

    document.addEventListener("DOMContentLoaded", function() {
        // ========== ADD MODAL FUNCTIONALITY ==========
        const addCompanionsCount = document.getElementById("add_companionsCount");
        const addTableBody = document.getElementById("add_companionsTableBody");

        function createAddRow(index) {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${index + 1}</td>
                <td>
                    <input type="text" name="companion_name[${index}]" class="form-control" required>
                </td>
                <td>
                    <select name="companion_gender[${index}]" class="form-control" required>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </td>
                <td width="10%">
                    <input type="number" name="companion_age[${index}]" class="form-control companion-age" min="0" max="110" required oninput="calculateCompanionFee(this)">
                </td>
                <td class="text-center">
                    <input type="checkbox" name="companion_is_pwd[${index}]" value="1" class="form-check-input companion-pwd" onchange="calculateCompanionFee(this)">
                </td>
                <td>
                    <input type="text" name="companion_address[${index}]" class="form-control" required>
                </td>
                <td width="12%">
                    <input type="number" name="companion_fee[${index}]" class="form-control companion-fee" readonly step="0.01" min="0">
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm remove-member">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;
            return row;
        }

        if (addCompanionsCount) {
            addCompanionsCount.addEventListener("input", function() {
                let members = parseInt(this.value) || 0;
                let currentRows = addTableBody.querySelectorAll("tr").length;

                if (members > currentRows) {
                    for (let i = currentRows; i < members; i++) {
                        addTableBody.appendChild(createAddRow(i));
                    }
                } else if (members < currentRows) {
                    for (let i = currentRows; i > members; i--) {
                        addTableBody.removeChild(addTableBody.lastElementChild);
                    }
                }
                updateRowNumbers(addTableBody);
                calculateTotal();
            });
        }

        // ========== EDIT MODAL FUNCTIONALITY ==========
        const editCompanionsCount = document.getElementById("edit_companionsCount");
        const editTableBody = document.getElementById("edit_companionsTableBody");

        function createEditRow(index, companionData = null) {
            const row = document.createElement("tr");
            const name = companionData ? companionData.name : '';
            const gender = companionData ? companionData.gender : 'Male';
            const age = companionData ? companionData.age : '';
            const isPwd = companionData ? (companionData.isPWD == 1) : false;
            const address = companionData ? companionData.address : '';
            const fee = companionData ? getFee(companionData.age, companionData.isPWD).toFixed(2) : '0.00';

            row.innerHTML = `
                <td>${index + 1}</td>
                <td>
                    <input type="text" name="edit_companion_name[${index}]" class="form-control" value="${name.replace(/"/g, '&quot;')}" required>
                </td>
                <td>
                    <select name="edit_companion_gender[${index}]" class="form-control" required>
                        <option value="Male" ${gender === 'Male' ? 'selected' : ''}>Male</option>
                        <option value="Female" ${gender === 'Female' ? 'selected' : ''}>Female</option>
                    </select>
                </td>
                <td width="10%">
                    <input type="number" name="edit_companion_age[${index}]" class="form-control edit-companion-age" value="${age}" min="0" max="110" required oninput="calculateEditCompanionFee(this)">
                </td>
                <td class="text-center">
                    <input type="checkbox" name="edit_companion_is_pwd[${index}]" value="1" class="form-check-input edit-companion-pwd" ${isPwd ? 'checked' : ''} onchange="calculateEditCompanionFee(this)">
                </td>
                <td>
                    <input type="text" name="edit_companion_address[${index}]" class="form-control" value="${address.replace(/"/g, '&quot;')}" required>
                </td>
                <td width="12%">
                    <input type="number" name="edit_companion_fee[${index}]" class="form-control edit-companion-fee" value="${fee}" readonly step="0.01" min="0">
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm remove-edit-member">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;
            return row;
        }

        if (editCompanionsCount) {
            editCompanionsCount.addEventListener("input", function() {
                let members = parseInt(this.value) || 0;
                let currentRows = editTableBody.querySelectorAll("tr").length;

                if (members > currentRows) {
                    for (let i = currentRows; i < members; i++) {
                        editTableBody.appendChild(createEditRow(i));
                    }
                } else if (members < currentRows) {
                    for (let i = currentRows; i > members; i--) {
                        editTableBody.removeChild(editTableBody.lastElementChild);
                    }
                }
                updateRowNumbers(editTableBody);
                calculateEditTotal();
            });
        }

        // Helper function to update row numbers
        function updateRowNumbers(tableBody) {
            const rows = tableBody.querySelectorAll("tr");
            rows.forEach((row, index) => {
                row.children[0].innerText = index + 1;
            });
        }

        // Remove member handlers
        if (addTableBody) {
            addTableBody.addEventListener("click", function(e) {
                if (e.target.closest(".remove-member")) {
                    e.target.closest("tr").remove();
                    if (addCompanionsCount) {
                        addCompanionsCount.value = addTableBody.querySelectorAll("tr").length;
                    }
                    updateRowNumbers(addTableBody);
                    calculateTotal();
                }
            });
        }

        if (editTableBody) {
            editTableBody.addEventListener("click", function(e) {
                if (e.target.closest(".remove-edit-member")) {
                    e.target.closest("tr").remove();
                    if (editCompanionsCount) {
                        editCompanionsCount.value = editTableBody.querySelectorAll("tr").length;
                    }
                    updateRowNumbers(editTableBody);
                    calculateEditTotal();
                }
            });
        }

        // ========== EDIT BUTTON CLICK HANDLER ==========
        document.querySelectorAll(".editEntranceBtn").forEach(button => {
            button.addEventListener("click", function() {
                // Basic information
                document.getElementById("edit_entrance_id").value = this.dataset.id;
                document.querySelector("[name='edit_guest_first_name']").value = this.dataset
                    .first_name || '';
                document.querySelector("[name='edit_guest_middle_name']").value = this.dataset
                    .middle_name || '';
                document.querySelector("[name='edit_guest_last_name']").value = this.dataset
                    .last_name || '';
                document.querySelector("[name='edit_guest_contact_number']").value = this
                    .dataset.contact || '';
                document.querySelector("[name='edit_guest_age']").value = this.dataset.age ||
                '';
                document.querySelector("[name='edit_guest_gender']").value = this.dataset
                    .gender || '';
                document.querySelector("[name='edit_guest_address']").value = this.dataset
                    .address || '';
                document.querySelector("[name='edit_payment_status']").value = this.dataset.status ||
                    '';

                // PWD checkbox
                const pwdCheckbox = document.getElementById("edit_guest_is_pwd");
                if (this.dataset.pwd == 1) {
                    pwdCheckbox.checked = true;
                } else {
                    pwdCheckbox.checked = false;
                }

                // Calculate guest fee
                calculateEditGuestFee();

                // Handle companions
                try {
                    const companions = JSON.parse(this.dataset.companions || '[]');
                    const membersCount = parseInt(this.dataset.members) || companions.length;

                    // Set companions count
                    if (editCompanionsCount) {
                        editCompanionsCount.value = membersCount;
                    }

                    // Clear and populate companions table
                    if (editTableBody) {
                        editTableBody.innerHTML = '';

                        if (companions.length > 0) {
                            companions.forEach((companion, index) => {
                                editTableBody.appendChild(createEditRow(index,
                                    companion));
                            });
                        } else {
                            // Create empty rows based on members count
                            for (let i = 0; i < membersCount; i++) {
                                editTableBody.appendChild(createEditRow(i));
                            }
                        }
                    }
                } catch (e) {
                    console.error('Error parsing companions data:', e);
                }

                // Calculate total fee
                calculateEditTotal();
            });
        });

        // ========== MODAL RESET HANDLERS ==========
        $('#addEntranceModal').on('hidden.bs.modal', function() {
            document.getElementById("entranceAddForm").reset();
            if (addTableBody) addTableBody.innerHTML = "";
            if (addCompanionsCount) addCompanionsCount.value = 0;
            document.getElementById("guest_fee").value = "0";
            document.getElementById("total_fee").value = "0";
        });

        $('#editEntranceModal').on('hidden.bs.modal', function() {
            document.getElementById("entranceEditForm").reset();
            if (editTableBody) editTableBody.innerHTML = "";
            if (editCompanionsCount) editCompanionsCount.value = 0;
            document.getElementById("edit_guest_fee").value = "0";
            document.getElementById("edit_total_fee").value = "0";
        });
    });
</script>
