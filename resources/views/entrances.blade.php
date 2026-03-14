@extends('layouts.auth') <!-- Extend the main layout -->

@section('content')
    <!-- Start the content section -->
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div class="d-flex">
            <i class="fas fa-money-bill fa-2x text-dark me-2"></i>
            <div class="d-flex flex-column">
                <h1 class="h3 mb-0 text">AVAILED SERVICES</h1>
                <h6 class="mb-0">Dashboard | Entrance Fees</h6>
            </div>
        </div>
        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEntranceModal">Add Entrance Fee</a>
    </div>

    <!-- Content Row -->
    <div class="d-flex align-items-center justify-content-center gap-5 bg-theme-primary p-2">
        <img src="{{ asset('public/img/jbp-icon.jpg') }}" width="60" alt="jbp-logo">
        <div class="d-flex gap-2">
            <a href="{{ url()->current() }}" class="btn btn-danger">
                <i class="fas fa-refresh"></i> Reload
            </a>
            <a href="{{ url('entrances') }}"
                class="btn {{ Request::is('entrances') ? 'btn-success' : 'btn-outline-light ' }} d-flex align-items-center gap-2">
                <i class="fas fa-money-bill"></i>
                Entrance Fee
            </a>
            <a href="#" class="btn btn-outline-light d-flex align-items-center gap-2">
                <i class="fas fa-home"></i>
                Cottage Fee
            </a>
            <a href="#" class="btn btn-outline-light d-flex align-items-center gap-2">
                <i class="fas fa-tools"></i>
                Facilities
            </a>
            <a href="#" class="btn btn-outline-light d-flex align-items-center gap-2">
                <i class="fas fa-utensils"></i>
                Food & Drinks
            </a>
            <a href="#" class="btn btn-outline-light d-flex align-items-center gap-2">
                <i class="fas fa-file-invoice"></i>
                Bill
            </a>
        </div>
    </div>
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
                                <td class="text-center">
                                    {{ $entrance->visitor->members ?? 0 }}
                                    @if (!empty($entrance->companions))
                                        <table class="table table-bordered mt-2">
                                            <thead>
                                                <tr>
                                                    <th class="bg-success">No.</th>
                                                    <th class="bg-success">Name</th>
                                                    <th class="bg-success">Category</th>
                                                    <th class="bg-success">Sex</th>
                                                    <th class="bg-success">Age</th>
                                                    <th class="bg-success">Address</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($entrance->companions as $index => $companion)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $companion->name }}</td>
                                                        <td>{{ $companion->category }}</td>
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
                                    <form action="{{ route('visitor.destroy', $entrance->visitor_id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this visitor record?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i>
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

    <!-- Add Entrance Modal -->
    <div class="modal fade" id="addEntranceModal" tabindex="-1" role="dialog" aria-labelledby="addEntranceModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <form action="{{ route('entrance.store') }}" method="POST" id="entranceForm">
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
                                    <input type="number" id="companionsCount" name="guest_members" min="0"
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
                            <tbody id="companionsTableBody"></tbody>
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
        if (isPwd) {
            return feeMap['pwd'] ?? 0;
        }
        if (age <= 15) {
            return feeMap['child'] ?? 0;
        }
        return feeMap['adult'] ?? 0;
    }

    /* ---------------------------------
       GET CATEGORY
    ----------------------------------*/

    function getCategory(age, isPwd) {
        if (isPwd) {
            return "PWD";
        }
        if (age <= 15) {
            return "Child";
        }
        return "Adult";
    }


    /* ---------------------------------
       GUEST FEE
    ----------------------------------*/

    window.calculateGuestFee = function() {
        let age = parseInt(document.getElementById('guest_age').value) || 0;
        let isPwd = document.getElementById('guest_is_pwd').checked;
        let fee = getFee(age, isPwd);
        document.getElementById('guest_fee').value = fee.toFixed(2);
        calculateTotal();
    }

    /* ---------------------------------
       COMPANION FEE
    ----------------------------------*/
    window.calculateCompanionFee = function(element) {
        const row = element.closest("tr");
        const ageInput = row.querySelector(".companion-age");
        const pwdCheckbox = row.querySelector(".companion-pwd");
        const feeInput = row.querySelector(".companion-fee");
        const categoryInput = row.querySelector(".companion-category");
        let age = parseInt(ageInput.value) || 0;
        let isPwd = pwdCheckbox.checked;
        let fee = getFee(age, isPwd);
        let category = getCategory(age, isPwd);
        feeInput.value = fee.toFixed(2);
        if (categoryInput) {
            categoryInput.value = category;
        }
        calculateTotal();
    }


    /* ---------------------------------
       TOTAL CALCULATION
    ----------------------------------*/

    function calculateTotal() {
        let total = 0;
        let guestFee = parseFloat(document.getElementById('guest_fee').value) || 0;
        total += guestFee;
        document.querySelectorAll(".companion-fee").forEach(function(input) {
            total += parseFloat(input.value) || 0;
        });
        document.getElementById("total_fee").value = total.toFixed(2);
    }

    /* ---------------------------------
       COMPANION ROW MANAGEMENT
    ----------------------------------*/
    document.addEventListener("DOMContentLoaded", function() {
        const companionsCount = document.getElementById("companionsCount");
        const tableBody = document.getElementById("companionsTableBody");

        function createRow(index) {
            const row = document.createElement("tr");
            row.innerHTML = `
        <td>${index+1}</td>
        <td>
            <input type="text" name="companion_name[]" class="form-control" required>
        </td>
        <td>
            <select name="companion_gender[]" class="form-control" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
        </td>
        <td width="10%">
            <input type="number"
            name="companion_age[]"
            class="form-control companion-age"
            min="0"
            max="110"
            required
            oninput="calculateCompanionFee(this)">
        </td>
        <td class="text-center">
            <input type="checkbox"
            name="companion_is_pwd[]"
            value="1"
            class="form-check-input companion-pwd"
            onchange="calculateCompanionFee(this)">
        </td>
        <td>
            <input type="text"
            name="companion_address[]"
            class="form-control"
            required>
        </td>
        <td width="12%">
            <input type="number"
            name="companion_fee[]"
            class="form-control companion-fee"
            readonly
            step="0.01"
            min="0">
        </td>
        <td>
            <button type="button" class="btn btn-danger btn-sm remove-member">
                <i class="fas fa-trash"></i>
            </button>
        </td>
        `;

            const categoryInput = document.createElement("input");
            categoryInput.type = "hidden";
            categoryInput.name = "companion_category[]";
            categoryInput.className = "companion-category";
            row.appendChild(categoryInput);
            return row;
        }

        function updateCompanionRows() {
            let members = parseInt(companionsCount.value) || 0;
            let currentRows = tableBody.querySelectorAll("tr").length;
            if (members > currentRows) {
                for (let i = currentRows; i < members; i++) {
                    tableBody.appendChild(createRow(i));
                }
            } else if (members < currentRows) {
                for (let i = currentRows; i > members; i--) {
                    tableBody.removeChild(tableBody.lastElementChild);
                }
            }
            updateRowNumbers();
            calculateTotal();
        }

        function updateRowNumbers() {
            const rows = tableBody.querySelectorAll("tr");
            rows.forEach((row, index) => {
                row.children[0].innerText = index + 1;
            });
        }

        companionsCount.addEventListener("input", updateCompanionRows);
        tableBody.addEventListener("click", function(e) {
            if (e.target.closest(".remove-member")) {
                e.target.closest("tr").remove();
                companionsCount.value = tableBody.querySelectorAll("tr").length;
                updateRowNumbers();
                calculateTotal();
            }
        });

        $('#addEntranceModal').on('hidden.bs.modal', function() {
            document.getElementById("entranceForm").reset();
            tableBody.innerHTML = "";
            companionsCount.value = 0;
            document.getElementById("guest_fee").value = "0";
            document.getElementById("total_fee").value = "0";
        });
    });
</script>
