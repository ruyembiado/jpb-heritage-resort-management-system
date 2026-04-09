@extends('layouts.auth')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div class="d-flex">
            <i class="fas fa-bowl-food fa-2x text-dark me-2"></i>
            <div class="d-flex flex-column">
                <h1 class="h3 mb-0 text">AVAILED SERVICES</h1>
                <h6 class="mb-0">Guest | Food Fees</h6>
            </div>
        </div>
        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMeals">Add Food & Drink Fee</a>
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
            <div class="d-flex gap-2">
                <a href="{{ url('meals') }}" class="btn btn-success d-flex align-items-center gap-2">
                    <i class="fa-solid fa-bowl-food"></i>
                    Foods
                </a>
                <a href="{{ url('beverages') }}" class="btn bg-theme-primary text-light d-flex align-items-center gap-2">
                    <i class="fa-solid fa-bottle-water"></i>
                    Drinks
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0"
                    style="min-width:1400px;">
                    <thead>
                        <tr>
                            <th class="bg-theme-primary text-light">NO.</th>
                            <th class="bg-theme-primary text-light">NAME OF GUEST</th>
                            <th class="bg-theme-primary text-light">MEMBERS</th>
                            <th class="bg-theme-primary text-light text-center">ORDER DETAILS</th>
                            <th class="bg-theme-primary text-light">TOTAL FEE</th>
                            <th class="bg-theme-primary text-light">STATUS</th>
                            <th class="bg-theme-primary text-light">DATE CREATED</th>
                            <th class="bg-theme-primary text-light sticky-action">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($meals as $meal)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    {{ optional($meal->visitor)->first_name }}
                                    {{ optional($meal->visitor)->middle_name }}
                                    {{ optional($meal->visitor)->last_name }}
                                </td>
                                <td>{{ $meal->visitor->members }}</td>

                                @php
                                    $item_names = json_decode($meal->item_name, true);
                                    $fee = json_decode($meal->fee, true);
                                    $quantity = json_decode($meal->quantity, true);
                                    $types = json_decode($meal->type, true);
                                    $categories = json_decode($meal->category, true);

                                    $groupedItems = [];

                                    foreach ($item_names as $index => $item) {
                                        $currentType = $types[$index] ?? 'solo';
                                        $itemFee = $fee[$index] ?? 0;
                                        $itemQty = $quantity[$index] ?? 0;

                                        if (!isset($groupedItems[$item])) {
                                            // Initialize both types
                                            $groupedItems[$item] = [
                                                'solo_fee' => 0,
                                                'group_fee' => 0,
                                                'solo_qty' => 0,
                                                'group_qty' => 0,
                                            ];
                                        }

                                        // Assign fee if not already set for that type
                                        if ($currentType === 'solo') {
                                            if ($groupedItems[$item]['solo_fee'] == 0) {
                                                $groupedItems[$item]['solo_fee'] = $itemFee;
                                            }
                                            $groupedItems[$item]['solo_qty'] += $itemQty;
                                        }

                                        if ($currentType === 'group') {
                                            if ($groupedItems[$item]['group_fee'] == 0) {
                                                $groupedItems[$item]['group_fee'] = $itemFee;
                                            }
                                            $groupedItems[$item]['group_qty'] += $itemQty;
                                        }
                                    }
                                @endphp

                                <td class="p-0">
                                    <table class="table table-bordered border-dark m-0" cellspacing="0"
                                        style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th class="align-middle text-center bg-success text-light" rowspan="2"
                                                    style="padding:5px;">Item</th>
                                                <th class="align-middle text-center bg-success text-light" colspan="2"
                                                    style="padding:5px;">Price</th>
                                                <th class="align-middle text-center bg-success text-light" colspan="2"
                                                    style="padding:5px;">Qty</th>
                                                <th class="align-middle text-center bg-success text-light" rowspan="2"
                                                    style="padding:5px;">Subtotal</th>
                                            </tr>
                                            <tr>
                                                <th class="align-middle text-center bg-success text-light"
                                                    style="padding:5px;">Solo</th>
                                                <th class="align-middle text-center bg-success text-light"
                                                    style="padding:5px;">Group</th>
                                                <th class="align-middle text-center bg-success text-light"
                                                    style="padding:5px;">Solo</th>
                                                <th class="align-middle text-center bg-success text-light"
                                                    style="padding:5px;">Group</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($groupedItems as $name => $data)
                                                @php
                                                    $subtotal =
                                                        $data['solo_fee'] * $data['solo_qty'] +
                                                        $data['group_fee'] * $data['group_qty'];
                                                @endphp
                                                <tr>
                                                    <td style="padding:8px;">{{ $name }}</td>
                                                    <td style="padding:8px;">₱{{ number_format($data['solo_fee'], 2) }}
                                                    </td>
                                                    <td style="padding:8px;">₱{{ number_format($data['group_fee'], 2) }}
                                                    </td>
                                                    <td style="padding:8px;">{{ $data['solo_qty'] }}</td>
                                                    <td style="padding:8px;">{{ $data['group_qty'] }}</td>
                                                    <td style="padding:8px;">₱{{ number_format($subtotal, 2) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </td>

                                <td>₱ {{ number_format($meal->total_payment, 2) }}</td>
                                <td>
                                    <span class="badge {{ $meal->status === 'Paid' ? 'bg-success' : 'bg-danger' }}">
                                        {{ $meal->status }}
                                    </span>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($meal->created_at)->format('F j, Y') }}</td>
                                <td class="sticky-action">
                                    <div class="d-flex align-items-center justify-c gap-2">
                                        <a href="#" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#editMealsModal" data-meal-id="{{ $meal->id }}"
                                            data-visitor-id="{{ $meal->visitor_id }}" data-items='<?php echo json_encode([
                                                'item_name' => $item_names,
                                                'fee' => $fee,
                                                'quantity' => $quantity,
                                                'type' => $types,
                                                'category' => $categories,
                                            ]); ?>'
                                            data-total-payment="{{ $meal->total_payment }}"
                                            data-payment-status="{{ $meal->status }}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('meal.destroy', $meal->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to delete this food(s) record?')">
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

    <!-- Add Meals Modal -->
    <div class="modal fade" id="addMeals" tabindex="-1" role="dialog" aria-labelledby="addMealsLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document" style="max-width: 1500px;">
            <form action="{{ route('meal.store') }}" method="POST">
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
                        <div class="form-group mb-3">
                            <div class="d-flex align-items-start gap-1">
                                <div class="col-4 d-flex align-items-center gap-3">
                                    <label for="visitor_id">Name:</label>
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
                            </div>
                        </div>

                        <div class="row">
                            <!-- Foods Section -->
                            <div class="col-md-6">
                                <div
                                    class="bg-theme-primary d-flex align-items-center gap-2 justify-content-center text-light p-2">
                                    <i class="fa fa-bowl-food fa-2x"></i>
                                    <h3 class="m-0">FOODS</h3>
                                </div>

                                <div class="table-responsive">
                                    @php
                                        $grouped = $mealFees
                                            ->groupBy('food_category')
                                            ->map(fn($items) => $items->groupBy('service_name'));
                                        $mealIndex = 0;
                                    @endphp

                                    <table class="table table-bordered border-dark">
                                        <thead class="bg-success text-light">
                                            <tr>
                                                <th rowspan="2" class="align-middle text-center bg-success text-light">
                                                    CATEGORY</th>
                                                <th rowspan="2" width="30%"
                                                    class="align-middle text-center bg-success text-light">MENU</th>
                                                <th colspan="2" class="text-center bg-success text-light">PRICE</th>
                                                <th colspan="2" class="text-center bg-success text-light">QUANTITY</th>
                                                <th rowspan="2" class="align-middle text-center bg-success text-light">
                                                    SUB TOTAL</th>
                                            </tr>
                                            <tr>
                                                <th class="text-center bg-success text-light">SOLO</th>
                                                <th class="text-center bg-success text-light">GROUP</th>
                                                <th class="text-center bg-success text-light">SOLO</th>
                                                <th class="text-center bg-success text-light">GROUP</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($grouped as $category => $menus)
                                                @php $rowspan = count($menus); @endphp

                                                @foreach ($menus as $name => $types)
                                                    @php
                                                        $solo = $types->firstWhere('food_type', 'solo');
                                                        $group = $types->firstWhere('food_type', 'group');
                                                    @endphp

                                                    <tr>
                                                        @if ($loop->first)
                                                            <td rowspan="{{ $rowspan }}"
                                                                class="align-middle text-center">
                                                                {{ ucfirst($category) }}
                                                            </td>
                                                        @endif

                                                        <!-- MENU -->
                                                        <td>
                                                            <input type="hidden"
                                                                name="meal_items[{{ $mealIndex }}][name]"
                                                                value="{{ $name }}">
                                                            <input type="hidden"
                                                                name="meal_items[{{ $mealIndex }}][category]"
                                                                value="{{ $category }}">
                                                            <input type="text" class="form-control"
                                                                value="{{ $name }}" readonly>
                                                        </td>

                                                        <!-- PRICE -->
                                                        <td>
                                                            <input type="text" class="form-control"
                                                                name="meal_items[{{ $mealIndex }}][solo_fee]"
                                                                value="{{ $solo->fee ?? 0 }}" readonly>
                                                        </td>

                                                        <td>
                                                            <input type="text" class="form-control"
                                                                name="meal_items[{{ $mealIndex }}][group_fee]"
                                                                value="{{ $group->fee ?? 0 }}" readonly>
                                                        </td>

                                                        <!-- QUANTITY -->
                                                        <td>
                                                            <input type="number"
                                                                name="meal_items[{{ $mealIndex }}][solo_qty]"
                                                                class="form-control qty-input"
                                                                data-price="{{ $solo->fee ?? 0 }}" min="0"
                                                                value="0">
                                                        </td>

                                                        <td>
                                                            <input type="number"
                                                                name="meal_items[{{ $mealIndex }}][group_qty]"
                                                                class="form-control qty-input"
                                                                data-price="{{ $group->fee ?? 0 }}" min="0"
                                                                value="0">
                                                        </td>

                                                        <!-- SUBTOTAL -->
                                                        <td>
                                                            <input type="text" class="form-control subtotal"
                                                                value="0.00" readonly>
                                                        </td>
                                                    </tr>

                                                    @php $mealIndex++; @endphp
                                                @endforeach
                                            @endforeach
                                        </tbody>
                                    </table>

                                    <!-- TOTAL -->
                                    <div class="form-group">
                                        <div class="d-flex align-items-center justify-content-end gap-3">
                                            <label>Payment Status:</label>
                                            <div class="col-3">
                                                <select name="meal_payment_status" class="form-control">
                                                    <option value="">Select status</option>
                                                    <option value="Paid">Paid</option>
                                                    <option value="Unpaid">Unpaid</option>
                                                </select>
                                            </div>

                                            <label>Total Fee:</label>
                                            <div class="col-3">
                                                <div class="d-flex">
                                                    <span class="input-group-text bg-theme-primary text-light">₱</span>
                                                    <input type="text" name="meal_total_payment"
                                                        id="meal_total_payment" value="0.00" class="form-control"
                                                        readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Drinks Section -->
                            <div class="col-md-6">
                                <div
                                    class="bg-theme-primary d-flex align-items-center gap-2 justify-content-center text-light p-2">
                                    <i class="fa fa-bottle-water fa-2x"></i>
                                    <h3 class="m-0">DRINKS</h3>
                                </div>

                                <div class="table-responsive">
                                    @php
                                        $groupedDrinks = $drinkFees->groupBy('service_name');
                                        $drinkIndex = 0;
                                    @endphp

                                    <table class="table table-bordered border-dark">
                                        <thead class="bg-success text-light">
                                            <tr>
                                                <th rowspan="2" width="30%"
                                                    class="align-middle text-center bg-success text-light">DRINK</th>
                                                <th colspan="2" class="text-center bg-success text-light">PRICE</th>
                                                <th colspan="2" class="text-center bg-success text-light">QUANTITY</th>
                                                <th rowspan="2" class="align-middletext-center bg-success text-light">
                                                    SUB TOTAL</th>
                                            </tr>
                                            <tr>
                                                <th class="text-center bg-success text-light">SOLO</th>
                                                <th class="text-center bg-success text-light">GROUP</th>
                                                <th class="text-center bg-success text-light">SOLO</th>
                                                <th class="text-center bg-success text-light">GROUP</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($groupedDrinks as $name => $types)
                                                @php
                                                    $solo = $types->firstWhere('food_type', 'solo');
                                                    $group = $types->firstWhere('food_type', 'group');
                                                @endphp

                                                <tr>
                                                    <!-- NAME -->
                                                    <td>
                                                        <input type="hidden"
                                                            name="drink_items[{{ $drinkIndex }}][name]"
                                                            value="{{ $name }}">
                                                        <input type="text" class="form-control"
                                                            value="{{ $name }}" readonly>
                                                    </td>

                                                    <!-- PRICE -->
                                                    <td>
                                                        <input type="text" class="form-control"
                                                            name="drink_items[{{ $drinkIndex }}][solo_fee]"
                                                            value="{{ $solo->fee ?? 0 }}" readonly>
                                                    </td>

                                                    <td>
                                                        <input type="text" class="form-control"
                                                            name="drink_items[{{ $drinkIndex }}][group_fee]"
                                                            value="{{ $group->fee ?? 0 }}" readonly>
                                                    </td>

                                                    <!-- QUANTITY -->
                                                    <td>
                                                        <input type="number"
                                                            name="drink_items[{{ $drinkIndex }}][solo_qty]"
                                                            class="form-control drink-qty-input"
                                                            data-price="{{ $solo->fee ?? 0 }}" min="0"
                                                            value="0">
                                                    </td>

                                                    <td>
                                                        <input type="number"
                                                            name="drink_items[{{ $drinkIndex }}][group_qty]"
                                                            class="form-control drink-qty-input"
                                                            data-price="{{ $group->fee ?? 0 }}" min="0"
                                                            value="0">
                                                    </td>

                                                    <!-- SUBTOTAL -->
                                                    <td>
                                                        <input type="text" class="form-control drink-subtotal"
                                                            value="0.00" readonly>
                                                    </td>
                                                </tr>

                                                @php $drinkIndex++; @endphp
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <!-- TOTAL -->
                                <div class="form-group mt-2">
                                    <div class="d-flex align-items-center justify-content-end gap-3">
                                        <label>Payment Status:</label>
                                        <div class="col-3">
                                            <select name="drink_payment_status" class="form-control">
                                                <option value="">Select status</option>
                                                <option value="Paid">Paid</option>
                                                <option value="Unpaid">Unpaid</option>
                                            </select>
                                        </div>

                                        <label>Total Fee:</label>
                                        <div class="col-3">
                                            <div class="d-flex">
                                                <span class="input-group-text bg-theme-primary text-light">₱</span>
                                                <input type="text" name="drink_total_payment" id="drink_total_payment"
                                                    value="0.00" class="form-control" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="grand_total" id="grand_total" value="0.00">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Save</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Meals Modal -->
    <div class="modal fade" id="editMealsModal" tabindex="-1" role="dialog" aria-labelledby="editMealsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form action="{{ route('meal.update') }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="meal_id" id="edit_meal_id">
                <input type="hidden" name="visitor_id" id="edit_visitor_id_hidden">
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
                        <div class="form-group mb-3">
                            <div class="col-8 d-flex align-items-center gap-3">
                                <label for="edit_visitor_id">Name:</label>
                                <select name="visitor_id" class="form-control select2" id="edit_visitor_id" required
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
                        </div>
                        <div class="row">
                            <!-- Meal Section -->
                            <div class="">
                                <div
                                    class="bg-theme-primary d-flex align-items-center gap-2 justify-content-center text-light p-2">
                                    <i class="fa fa-bowl-food fa-2x"></i>
                                    <h3 class="m-0">FOOD</h3>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered border-dark">
                                        <thead class="bg-success text-light">
                                            <tr>
                                                <th rowspan="2" class="text-center bg-success text-light align-middle">Category</th>
                                                <th rowspan="2" width="30%"
                                                    class="text-center bg-success text-light align-middle">ITEM</th>
                                                <th colspan="2" class="text-center bg-success text-light">PRICE</th>
                                                <th colspan="2" class="text-center bg-success text-light">QUANTITY</th>
                                                <th rowspan="2" class="text-center bg-success text-light align-middle">
                                                    SUBTOTAL</th>
                                            </tr>
                                            <tr>
                                                <th class="text-center bg-success text-light">SOLO</th>
                                                <th class="text-center bg-success text-light">GROUP</th>
                                                <th class="text-center bg-success text-light">SOLO</th>
                                                <th class="text-center bg-success text-light">GROUP</th>
                                            </tr>
                                        </thead>

                                        <tbody id="edit_meal_items">
                                            @php
                                                $grouped = $mealFees
                                                    ->groupBy('food_category')
                                                    ->map(fn($items) => $items->groupBy('service_name'));

                                                $editIndex = 0;
                                            @endphp

                                            @foreach ($grouped as $category => $menus)
                                                @foreach ($menus as $name => $types)
                                                    @php
                                                        $solo = $types->firstWhere('food_type', 'solo');
                                                        $group = $types->firstWhere('food_type', 'group');
                                                    @endphp

                                                    <tr>
                                                        <!-- ITEM -->
                                                        @if ($loop->first)
                                                            <td rowspan="{{ $rowspan }}"
                                                                class="align-middle text-center">
                                                                {{ ucfirst($category) }}
                                                            </td>
                                                        @endif
                                                        <td>
                                                            <input type="hidden"
                                                                name="meal_items[{{ $editIndex }}][name]"
                                                                value="{{ $name }}">
                                                            <input type="hidden"
                                                                name="meal_items[{{ $editIndex }}][category]"
                                                                value="{{ $category }}">
                                                            <input type="text" class="form-control"
                                                                value="{{ $name }}" readonly>
                                                        </td>

                                                        <!-- PRICE -->
                                                        <td>
                                                            <input type="text" class="form-control"
                                                                value="{{ $solo->fee ?? 0 }}" readonly>
                                                            <input type="hidden" class="edit-solo-price"
                                                                value="{{ $solo->fee ?? 0 }}">
                                                            <input type="hidden"
                                                                name="meal_items[{{ $editIndex }}][solo_fee]"
                                                                value="{{ $solo->fee ?? 0 }}">
                                                        </td>

                                                        <td>
                                                            <input type="text" class="form-control"
                                                                value="{{ $group->fee ?? 0 }}" readonly>
                                                            <input type="hidden" class="edit-group-price"
                                                                value="{{ $group->fee ?? 0 }}">
                                                            <input type="hidden"
                                                                name="meal_items[{{ $editIndex }}][group_fee]"
                                                                value="{{ $group->fee ?? 0 }}">
                                                        </td>

                                                        <!-- QUANTITY -->
                                                        <td>
                                                            <input type="number"
                                                                name="meal_items[{{ $editIndex }}][solo_qty]"
                                                                class="form-control edit-qty" min="0"
                                                                value="0">
                                                        </td>

                                                        <td>
                                                            <input type="number"
                                                                name="meal_items[{{ $editIndex }}][group_qty]"
                                                                class="form-control edit-qty" min="0"
                                                                value="0">
                                                        </td>

                                                        <!-- SUBTOTAL -->
                                                        <td>
                                                            <input type="text" class="form-control edit-subtotal"
                                                                value="0.00" readonly>
                                                        </td>
                                                    </tr>

                                                    @php $editIndex++; @endphp
                                                @endforeach
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="form-group">
                                    <div class="d-flex align-items-center justify-content-end gap-3">
                                        <label>Payment Status:</label>
                                        <div class="col-3">
                                            <select name="meal_payment_status" class="form-control"
                                                id="edit_meal_payment_status">
                                                <option value="">Select status</option>
                                                <option value="Paid">Paid</option>
                                                <option value="Unpaid">Unpaid</option>
                                            </select>
                                        </div>
                                        <label>Total Fee:</label>
                                        <div class="col-3">
                                            <div class="d-flex">
                                                <span class="input-group-text bg-theme-primary text-light">₱</span>
                                                <input type="text" name="total_payment" id="edit_total_payment"
                                                    value="0.00" class="form-control" readonly>
                                            </div>
                                        </div>
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
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {

        // -------------------
        // Initialize Select2
        // -------------------
        $('#addMeals').on('shown.bs.modal', function() {
            $('#visitor_name').select2({
                theme: 'bootstrap4',
                width: '100%',
                placeholder: "Select a visitor",
                allowClear: true,
                dropdownParent: $('#addMeals')
            });
        });

        $('#editMealsModal').on('shown.bs.modal', function() {
            $('#edit_visitor_id').select2({
                theme: 'bootstrap4',
                width: '100%',
                placeholder: "Select a visitor",
                allowClear: true,
                dropdownParent: $('#editMealsModal')
            });
        });

        // -------------------
        // ADD MODAL CALCULATIONS
        // -------------------

        // Foods quantity change
        $(document).on('input', '.qty-input', function() {
            const row = $(this).closest('tr');

            const soloQty = parseFloat(row.find('input.qty-input').first().val()) || 0;
            const soloPrice = parseFloat(row.find('input.qty-input').first().data('price')) || 0;

            const groupQty = parseFloat(row.find('input.qty-input').last().val()) || 0;
            const groupPrice = parseFloat(row.find('input.qty-input').last().data('price')) || 0;

            const subtotal = (soloQty * soloPrice) + (groupQty * groupPrice);
            row.find('.subtotal').val(subtotal.toFixed(2));

            updateAddTotalPayment();
        });

        // Drinks quantity change
        $(document).on('input', '.drink-qty-input', function() {
            const row = $(this).closest('tr');

            const soloQty = parseFloat(row.find('.drink-qty-input').first().val()) || 0;
            const soloPrice = parseFloat(row.find('.drink-qty-input').first().data('price')) || 0;

            const groupQty = parseFloat(row.find('.drink-qty-input').last().val()) || 0;
            const groupPrice = parseFloat(row.find('.drink-qty-input').last().data('price')) || 0;

            const subtotal = (soloQty * soloPrice) + (groupQty * groupPrice);
            row.find('.drink-subtotal').val(subtotal.toFixed(2));

            updateAddTotalPayment();
        });

        // Update total payment for Add Modal
        function updateAddTotalPayment() {
            let foodTotal = 0;
            let drinkTotal = 0;

            $('.subtotal').each(function() {
                foodTotal += parseFloat($(this).val()) || 0;
            });

            $('.drink-subtotal').each(function() {
                drinkTotal += parseFloat($(this).val()) || 0;
            });

            $('#meal_total_payment').val(foodTotal.toFixed(2));
            $('#drink_total_payment').val(drinkTotal.toFixed(2));
            $('#grand_total').val((foodTotal + drinkTotal).toFixed(2));
        }

        // Reset Add Modal
        $('#addMeals').on('hidden.bs.modal', function() {
            $(this).find('form')[0].reset();
            $('.subtotal, .drink-subtotal').val('0.00');
            $('#meal_total_payment, #drink_total_payment, #grand_total').val('0.00');
            $('#visitor_name').val(null).trigger('change');
        });

        // -------------------
        // OPEN EDIT MODAL
        // -------------------
        $('#editMealsModal').on('show.bs.modal', function(event) {
            const button = event.relatedTarget;

            const mealId = button.getAttribute('data-meal-id');
            const visitorId = button.getAttribute('data-visitor-id');
            const items = JSON.parse(button.getAttribute('data-items'));

            $('#edit_meal_id').val(mealId);
            $('#edit_visitor_id_hidden').val(visitorId);
            $('#edit_visitor_id').val(visitorId).trigger('change');

            // Reset all
            $('.edit-qty').val(0);
            $('.edit-subtotal').val('0.00');

            const paymentStatus = button.getAttribute('data-payment-status');
            $('#edit_meal_payment_status').val(paymentStatus).trigger('change');

            // -------------------
            // GROUP EXISTING DATA
            // -------------------
            let grouped = {};

            items.item_name.forEach((name, index) => {
                if (!grouped[name]) {
                    grouped[name] = {
                        solo_qty: 0,
                        group_qty: 0,
                        solo_fee: 0,
                        group_fee: 0,
                    };
                }

                // Detect if solo or group based on type
                if (items.type[index] === 'solo') {
                    grouped[name].solo_qty = parseFloat(items.quantity[index]) || 0;
                    grouped[name].solo_fee = parseFloat(items.fee[index]) || 0;
                } else if (items.type[index] === 'group') {
                    grouped[name].group_qty = parseFloat(items.quantity[index]) || 0;
                    grouped[name].group_fee = parseFloat(items.fee[index]) || 0;
                }
            });

            // -------------------
            // APPLY TO TABLE
            // -------------------
            $('#edit_meal_items tr').each(function() {
                const row = $(this);
                const name = row.find('input[name*="[name]"]').val();

                if (grouped[name]) {
                    row.find('input[name*="[solo_qty]"]').val(grouped[name].solo_qty);
                    row.find('input[name*="[group_qty]"]').val(grouped[name].group_qty);

                    const soloPrice = parseFloat(row.find('.edit-solo-price').val()) || 0;
                    const groupPrice = parseFloat(row.find('.edit-group-price').val()) || 0;

                    const subtotal =
                        (grouped[name].solo_qty * soloPrice) +
                        (grouped[name].group_qty * groupPrice);

                    row.find('.edit-subtotal').val(subtotal.toFixed(2));
                }
            });

            updateEditTotalPayment();
        });

        // -------------------
        // EDIT QTY CHANGE
        // -------------------
        $(document).on('input', '.edit-qty', function() {
            const row = $(this).closest('tr');

            const soloQty = parseFloat(row.find('input[name*="[solo_qty]"]').val()) || 0;
            const groupQty = parseFloat(row.find('input[name*="[group_qty]"]').val()) || 0;

            const soloPrice = parseFloat(row.find('.edit-solo-price').val()) || 0;
            const groupPrice = parseFloat(row.find('.edit-group-price').val()) || 0;

            const subtotal = (soloQty * soloPrice) + (groupQty * groupPrice);

            row.find('.edit-subtotal').val(subtotal.toFixed(2));

            updateEditTotalPayment();
        });

        // -------------------
        // UPDATE TOTAL
        // -------------------
        function updateEditTotalPayment() {
            let total = 0;

            $('.edit-subtotal').each(function() {
                total += parseFloat($(this).val()) || 0;
            });

            $('#edit_total_payment').val(total.toFixed(2));
        }

        // -------------------
        // RESET EDIT MODAL
        // -------------------
        $('#editMealsModal').on('hidden.bs.modal', function() {
            $('.edit-qty').val(0);
            $('.edit-subtotal').val('0.00');
            $('#edit_total_payment').val('0.00');
            $('#edit_visitor_id').val(null).trigger('change');
        });

    });
</script>
