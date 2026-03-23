@extends('layouts.auth')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div class="d-flex">
            <i class="fas fa-money-bill fa-2x text-dark me-2"></i>
            <div class="d-flex flex-column">
                <h1 class="h3 mb-0 text">SETTINGS</h1>
                <h6 class="mb-0">Dashboard | Services</h6>
            </div>
        </div>
        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addServiceModal">Add Service</a>
    </div>

    <!-- Content Row -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="bg-theme-primary text-light border-dark">No.</th>
                            <th class="bg-theme-primary text-light border-dark">Name</th>
                            <th class="bg-theme-primary text-light border-dark">Service Type</th>
                            <th class="bg-theme-primary text-light border-dark">Food Category</th>
                            <th class="bg-theme-primary text-light border-dark">Food/Drink Type</th>
                            <th class="bg-theme-primary text-light border-dark">Fee</th>
                            <th class="bg-theme-primary text-light border-dark">Date Created</th>
                            <th class="bg-theme-primary text-light border-dark">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($services as $index => $service)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $service->service_name }}</td>
                                <td>{{ ucwords(str_replace('_', ' ', $service->service_type)) }}</td>
                                <td>{{ $service->food_category ? ucfirst($service->food_category) : 'N/A' }}</td>
                                <td>{{ $service->food_type ? ucfirst($service->food_type) : 'N/A' }}</td>
                                <td>₱{{ number_format($service->fee, 2) }}</td>
                                <td>{{ $service->created_at->format('F j, Y') }}</td>
                                <td class="d-flex gap-1">
                                    <!-- Edit Button -->
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#editServiceModal{{ $service->id }}">
                                        Edit
                                    </button>

                                    <!-- Update Modal -->
                                    <div class="modal fade" id="editServiceModal{{ $service->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-lg">
                                            <form action="{{ route('service.update', $service->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <div class="col-12">
                                                            <div class="text-end">
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <div
                                                                class="d-flex align-items-center gap-2 justify-content-center">
                                                                <img src="{{ asset('public/img/jbp-icon.jpg') }}"
                                                                    width="70">
                                                                <div class="d-flex flex-column">
                                                                    <b class="modal-title mt-2 text-bold">JPB Heritage
                                                                        Inland
                                                                        Resort</b>
                                                                    <span>Progreso Street Illauod, Bugasong, Antique</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div
                                                            class="bg-theme-primary d-flex align-items-center gap-2 justify-content-center text-light p-2 mb-3">
                                                            <i class="fa fa-edit fa-2x"></i>
                                                            <h3 class="m-0">UPDATE SERVICE</h3>
                                                        </div>

                                                        <!-- Name + Service Type -->
                                                        <div class="form-group mb-2">
                                                            <div class="d-flex align-items-center gap-3">
                                                                <label>Name:</label>
                                                                <div class="col-4">
                                                                    <input type="text" name="service_name"
                                                                        class="form-control"
                                                                        value="{{ $service->service_name }}" required>
                                                                </div>
                                                                <label>Service Type:</label>
                                                                <div class="col-3">
                                                                    <select name="service_type"
                                                                        class="form-control edit_service_type"
                                                                        data-id="{{ $service->id }}" required>
                                                                        <option value="entrance_fee"
                                                                            {{ $service->service_type == 'entrance_fee' ? 'selected' : '' }}>
                                                                            Entrance Fee
                                                                        </option>
                                                                        <option value="foods"
                                                                            {{ $service->service_type == 'foods' ? 'selected' : '' }}>
                                                                            Foods
                                                                        </option>
                                                                        <option value="drinks"
                                                                            {{ $service->service_type == 'drinks' ? 'selected' : '' }}>
                                                                            Drinks
                                                                        </option>
                                                                        <option value="accommodation"
                                                                            {{ $service->service_type == 'accommodation' ? 'selected' : '' }}>
                                                                            Accommodation
                                                                        </option>
                                                                        <option value="function_hall"
                                                                            {{ $service->service_type == 'function_hall' ? 'selected' : '' }}>
                                                                            Function Hall
                                                                        </option>
                                                                        <option value="cottage_fee"
                                                                            {{ $service->service_type == 'cottage_fee' ? 'selected' : '' }}>
                                                                            Cottage Fee
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Food/Drink Fields -->
                                                        <div class="form-group mb-2">
                                                            <div class="d-flex flex-wrap align-items-center gap-2">
                                                                <!-- Foods: Category + Type -->
                                                                <div class="col-12" id="editFoodFields{{ $service->id }}"
                                                                    style="{{ $service->service_type == 'foods' ? '' : 'display:none;' }}">
                                                                    <div class="d-flex flex-wrap align-items-center gap-3">
                                                                        <label>Food Category:</label>
                                                                        <div class="col-4">
                                                                            <select name="food_category"
                                                                                class="form-control">
                                                                                <option value="">Select Category
                                                                                </option>
                                                                                <option value="noodles"
                                                                                    {{ $service->food_category == 'noodles' ? 'selected' : '' }}>
                                                                                    Noodles</option>
                                                                                <option value="soup"
                                                                                    {{ $service->food_category == 'soup' ? 'selected' : '' }}>
                                                                                    Soup</option>
                                                                                <option value="main"
                                                                                    {{ $service->food_category == 'main' ? 'selected' : '' }}>
                                                                                    Main</option>
                                                                            </select>
                                                                        </div>
                                                                        <label>Food Type:</label>
                                                                        <div class="col-4">
                                                                            <select name="food_type" class="form-control">
                                                                                <option value="">Select Type</option>
                                                                                <option value="solo"
                                                                                    {{ $service->food_type == 'solo' ? 'selected' : '' }}>
                                                                                    Solo</option>
                                                                                <option value="group"
                                                                                    {{ $service->food_type == 'group' ? 'selected' : '' }}>
                                                                                    Group</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- Drinks: Only Type -->
                                                                <div class="col-5" id="editDrinkFields{{ $service->id }}"
                                                                    style="{{ $service->service_type == 'drinks' ? '' : 'display:none;' }}">
                                                                    <div class="d-flex align-items-center gap-3">
                                                                        <label>Drink Type:</label>
                                                                        <div class="col-8">
                                                                            <select name="drink_type" class="form-control">
                                                                                <option value="">Select Type</option>
                                                                                <option value="solo"
                                                                                    {{ $service->food_type == 'solo' ? 'selected' : '' }}>
                                                                                    Solo</option>
                                                                                <option value="group"
                                                                                    {{ $service->food_type == 'group' ? 'selected' : '' }}>
                                                                                    Group</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <label>Fee:</label>
                                                                <div class="col-2">
                                                                    <input type="number" name="fee"
                                                                        class="form-control" value="{{ $service->fee }}"
                                                                        min="0" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-success">Update</button>
                                                        <button type="button" class="btn btn-danger"
                                                            data-bs-dismiss="modal">Cancel</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Delete -->
                                    <form action="{{ route('service.destroy', $service->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this service?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
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

    <!-- Add Service Modal -->
    <div class="modal fade" id="addServiceModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('service.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="col-12">
                            <div class="text-end">
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="d-flex align-items-center gap-2 justify-content-center">
                                <img src="{{ asset('public/img/jbp-icon.jpg') }}" width="70">
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
                            <h3 class="m-0">ADD SERVICE</h3>
                        </div>

                        <div class="form-group mb-2">
                            <div class="d-flex align-items-center gap-3">
                                <label>Name:</label>
                                <div class="col-4">
                                    <input type="text" name="service_name" class="form-control" placeholder="Name"
                                        required>
                                </div>
                                <label>Service Type:</label>
                                <div class="col-3">
                                    <select name="service_type" id="service_type" class="form-control" required>
                                        <option value="">Select type</option>
                                        <option value="entrance_fee">Entrance Fee</option>
                                        <option value="foods">Foods</option>
                                        <option value="drinks">Drinks</option>
                                        <option value="accommodation">Accommodation</option>
                                        <option value="function_hall">Function Hall</option>
                                        <option value="cottage_fee">Cottage Fee</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Food Fields -->
                        <div class="form-group mb-2">
                            <div class="d-flex flex-wrap align-items-center gap-2">
                                <div class="col-12" id="foodFields" style="display:none;">
                                    <div class="d-flex flex-wrap align-items-center gap-3">
                                        <label>Food Category:</label>
                                        <div class="col-4">
                                            <select name="food_category" class="form-control">
                                                <option value="">Select Category</option>
                                                <option value="noodles">Noodles</option>
                                                <option value="soup">Soup</option>
                                                <option value="main">Main</option>
                                            </select>
                                        </div>
                                        <label>Food Type:</label>
                                        <div class="col-4">
                                            <select name="food_type" class="form-control">
                                                <option value="">Select Type</option>
                                                <option value="solo">Solo</option>
                                                <option value="group">Group</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-5" id="drinkFields" style="display:none;">
                                    <div class="d-flex align-items-center gap-3">
                                        <label>Drink Type:</label>
                                        <div class="col-8">
                                            <select name="food_type" class="form-control">
                                                <option value="">Select Type</option>
                                                <option value="solo">Solo</option>
                                                <option value="group">Group</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <label>Fee:</label>
                                <div class="col-2">
                                    <input type="number" name="fee" class="form-control" min="0"
                                        placeholder="Amount" required>
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
@endsection

<script>
    document.addEventListener("DOMContentLoaded", function() {

        // Add Modal
        const serviceType = document.getElementById("service_type");
        const foodFields = document.getElementById("foodFields");
        const drinkFields = document.getElementById("drinkFields");

        function toggleAddFields() {
            if (serviceType.value === "foods") {
                foodFields.style.display = "block";
                drinkFields.style.display = "none";
            } else if (serviceType.value === "drinks") {
                drinkFields.style.display = "block";
                foodFields.style.display = "none";
            } else {
                foodFields.style.display = "none";
                drinkFields.style.display = "none";
            }
        }

        serviceType.addEventListener("change", toggleAddFields);

        // Edit Modals
        document.querySelectorAll('.edit_service_type').forEach(select => {
            select.addEventListener('change', function() {
                let id = this.dataset.id;
                let foodFields = document.getElementById('editFoodFields' + id);
                let drinkFields = document.getElementById('editDrinkFields' + id);

                if (this.value === 'foods') {
                    foodFields.style.display = 'block';
                    drinkFields.style.display = 'none';
                } else if (this.value === 'drinks') {
                    drinkFields.style.display = 'block';
                    foodFields.style.display = 'none';
                } else {
                    foodFields.style.display = 'none';
                    drinkFields.style.display = 'none';
                }
            });
        });
    });
</script>
