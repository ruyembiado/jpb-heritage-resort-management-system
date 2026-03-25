@extends('layouts.auth')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div class="d-flex">
            <i class="fas fa-bottle-water fa-2x text-dark me-2"></i>
            <div class="d-flex flex-column">
                <h1 class="h3 mb-0 text">AVAILED SERVICES</h1>
                <h6 class="mb-0">Guest | Drink Fees</h6>
            </div>
        </div>
        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBeverages">Add Beverages Fee</a>
    </div>

    <!-- Content Row -->
    @include('layouts.services-navigation')
    <div class="card shadow mb-4">
        <div class="card-body">
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
                    <a href="{{ url('meals') }}" class="btn bg-theme-primary text-light d-flex align-items-center gap-2">
                        <i class="fa-solid fa-bowl-food"></i>
                        Foods
                    </a>
                    <a href="{{ url('beverages') }}" class="btn btn-success d-flex align-items-center gap-2">
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
                                <th class="bg-theme-primary text-light">ORDER DETAILS</th>
                                <th class="bg-theme-primary text-light">TOTAL FEE</th>
                                <th class="bg-theme-primary text-light">STATUS</th>
                                <th class="bg-theme-primary text-light">DATE CREATED</th>
                                <th class="bg-theme-primary text-light sticky-action">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($beverages as $beverage)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        {{ optional($beverage->visitor)->first_name }}
                                        {{ optional($beverage->visitor)->middle_name }}
                                        {{ optional($beverage->visitor)->last_name }}
                                    </td>
                                    <td>
                                        {{ optional($beverage->visitor->members) }}
                                    </td>
                                    @php
                                        $item_names = json_decode($beverage->item_name, true);
                                        $fee = json_decode($beverage->fee, true);
                                        $quantity = json_decode($beverage->quantity, true);
                                    @endphp
                                    <td style="padding: 10px;">
                                        <table style="width: 100%; border-collapse: collapse;">
                                            <thead>
                                                <tr>
                                                    <th style="padding: 5px;">Item Name</th>
                                                    <th style="padding: 5px;">Price</th>
                                                    <th style="padding: 5px;">Qty.</th>
                                                    <th style="padding: 5px;">Sub-total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($item_names as $index => $item)
                                                    @if (!empty($quantity[$index]))
                                                        <tr>
                                                            <td width="50%" style="padding: 8px;">{{ $item }}
                                                            </td>
                                                            <td style="padding: 8px;">{{ $fee[$index] }}</td>
                                                            <td style="padding: 8px;">{{ $quantity[$index] ?? 'N/A' }}</td>
                                                            <td style="padding: 8px;">
                                                                ₱{{ number_format((float) ($fee[$index] ?? 0) * (float) ($quantity[$index] ?? 0), 2) }}
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </td>
                                    <td>₱ {{ number_format($beverage->total_payment, 2) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($beverage->created_at)->format('F j, Y') }}</td>
                                    <td class="sticky-action">
                                        <div class="d-flex align-items-center justify-c gap-2">
                                            <a href="#" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editBeveragesModal" data-meal-id="{{ $beverage->id }}"
                                                data-visitor-id="{{ $beverage->visitor_id }}"
                                                data-items='<?php echo json_encode([
                                                    'item_name' => $item_names,
                                                    'fee' => $fee,
                                                    'quantity' => $quantity,
                                                ]); ?>'
                                                data-total-payment="{{ $beverage->total_payment }}">
                                                Edit
                                            </a>
                                            <form action="{{ route('beverage.destroy', $beverage->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Are you sure you want to delete this beverage(s) record?')">
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

        <!-- Add Meals Modal -->
        <div class="modal fade" id="addBeverages" tabindex="-1" role="dialog" aria-labelledby="addBeveragesLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <form action="{{ route('beverage.store') }}" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addBeveragesLabel">Add Beverages Fee</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                                </div>
                            </div>

                            <div class="form-group mb-2">
                                <table style="width: 100%; border-collapse: collapse;">
                                    <thead>
                                        <tr class="bg-secondary text-light">
                                            <th style="padding: 10px;">ITEMS</th>
                                            <th style="padding: 10px;">PRICE</th>
                                            <th style="padding: 10px;">QUANTITY</th>
                                            <th style="padding: 10px;">SUB-TOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $beverageItems = [
                                                [
                                                    'name' => 'Bottled Water',
                                                    'price' => '25.00',
                                                ],
                                                [
                                                    'name' => 'Sotfdrinks (12oz)',
                                                    'price' => '35.00',
                                                ],
                                                [
                                                    'name' => 'Softdrinks (1.5L)',
                                                    'price' => '60.00',
                                                ],
                                                [
                                                    'name' => 'Iced Tea (1 Pitcher)',
                                                    'price' => '60.00',
                                                ],
                                                [
                                                    'name' => 'Iced Tea (1 Glass)',
                                                    'price' => '25.00',
                                                ],
                                                [
                                                    'name' => 'Lemonade (1 Pitcher)',
                                                    'price' => '60.00',
                                                ],
                                            ];
                                        @endphp

                                        @foreach ($beverageItems as $index => $item)
                                            <tr>
                                                <td width="50%" style="padding: 5px;">
                                                    <input type="hidden"
                                                        name="beverage_items[{{ $index }}][name]"
                                                        value="{{ $item['name'] }}">
                                                    <input readonly class="form-control" value="{{ $item['name'] }}">
                                                </td>
                                                <td width="15%" style="padding: 5px;">
                                                    <input type="hidden"
                                                        name="beverage_items[{{ $index }}][price]"
                                                        value="{{ $item['price'] }}">
                                                    <input class="form-control" type="text"
                                                        value="{{ $item['price'] }}" readonly>
                                                </td>
                                                <td width="15%" style="padding: 5px;">
                                                    <input class="form-control quantity-input" type="number"
                                                        name="beverage_items[{{ $index }}][quantity]"
                                                        min="0" value="0" data-price="{{ $item['price'] }}">
                                                </td>
                                                <td width="20%" style="padding: 5px;">
                                                    <input type="text" class="form-control subtotal"
                                                        name="beverage_items[{{ $index }}][subtotal]"
                                                        value="0.00" readonly>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex align-items-center justify-content-end mt-3">
                                    <div class="col-3">
                                        <label for="total_payment">Total Payment</label>
                                        <div class="input-group">
                                            <span class="input-group-text">₱</span>
                                            <input type="text" name="total_payment" id="total_payment"
                                                class="form-control" value="0.00" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Add Beverage Fee</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Edit Meals Modal -->
        <div class="modal fade" id="editBeveragesModal" tabindex="-1" role="dialog"
            aria-labelledby="editBeveragesModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <form action="{{ route('beverage.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="beverage_id" id="edit_beverage_id">
                    <input type="hidden" name="visitor_id" id="edit_visitor_id_hidden">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editBeveragesModalLabel">Edit Beverage Fee</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group mb-3">
                                <div class="d-flex align-items-start gap-1">
                                    <div class="form-group col-6">
                                        <label for="visitor_id">Name</label>
                                        <select disabled name="visitor_id_display" class="form-control select2"
                                            id="edit_visitor_id" required data-placeholder="Select a visitor">
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

                            <div class="form-group mb-2">
                                <table style="width: 100%; border-collapse: collapse;">
                                    <thead>
                                        <tr class="bg-secondary text-light">
                                            <th style="padding: 10px;">ITEMS</th>
                                            <th style="padding: 10px;">PRICE</th>
                                            <th style="padding: 10px;">QUANTITY</th>
                                            <th style="padding: 10px;">SUB-TOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody id="edit_beverage_items">
                                        @foreach ($beverageItems as $index => $item)
                                            <tr>
                                                <td width="50%" style="padding: 5px;">
                                                    <input type="hidden"
                                                        name="beverage_items[{{ $index }}][name]"
                                                        value="{{ $item['name'] }}">
                                                    <input readonly class="form-control" value="{{ $item['name'] }}">
                                                </td>
                                                <td width="15%" style="padding: 5px;">
                                                    <input type="hidden"
                                                        name="beverage_items[{{ $index }}][price]"
                                                        value="{{ $item['price'] }}">
                                                    <input class="form-control" type="text"
                                                        value="{{ $item['price'] }}" readonly>
                                                </td>
                                                <td width="15%" style="padding: 5px;">
                                                    <input class="form-control edit-quantity-input" type="number"
                                                        name="beverage_items[{{ $index }}][quantity]"
                                                        min="0" value="0" data-price="{{ $item['price'] }}">
                                                </td>
                                                <td width="20%" style="padding: 5px;">
                                                    <input type="text" class="form-control edit-subtotal"
                                                        name="beverage_items[{{ $index }}][subtotal]"
                                                        value="0.00" readonly>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex align-items-center justify-content-end mt-3">
                                    <div class="col-3">
                                        <label for="edit_total_payment">Total Payment</label>
                                        <div class="input-group">
                                            <span class="input-group-text">₱</span>
                                            <input type="text" name="total_payment" id="edit_total_payment"
                                                class="form-control" value="0.00" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Update Beverage Fee</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endsection

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Select2 for visitor_name
            $('#addBeverages').on('shown.bs.modal', function() {
                $('#visitor_name').select2({
                    theme: 'bootstrap4',
                    width: '100%',
                    placeholder: "Select a visitor",
                    allowClear: true,
                    dropdownParent: $('#addBeverages')
                });
            });

            // Calculate subtotals and total when quantity changes
            $(document).on('input', '.quantity-input', function() {
                const quantity = parseInt($(this).val()) || 0;
                const price = parseFloat($(this).data('price')) || 0;
                const subtotal = quantity * price;

                // Update subtotal for this row
                $(this).closest('tr').find('.subtotal').val(subtotal.toFixed(2));

                // Update total payment
                updateTotalPayment();
            });

            function updateTotalPayment() {
                let total = 0;
                $('.subtotal').each(function() {
                    total += parseFloat($(this).val()) || 0;
                });
                $('#total_payment').val(total.toFixed(2));
            }

            // Reset form when modal is closed
            $('#addBeverages').on('hidden.bs.modal', function() {
                $(this).find('form')[0].reset();
                $('.subtotal').val('0.00');
                $('#total_payment').val('0.00');
                $('#visitor_name').val(null).trigger('change');
            });

            // Edit Meal Modal Handling
            $('#editBeveragesModal').on('show.bs.modal', function(event) {
                // First reset all quantities and subtotals to 0
                $('.edit-quantity-input').val(0);
                $('.edit-subtotal').val('0.00');
                $('#edit_total_payment').val('0.00');

                // Then load the new data
                const button = event.relatedTarget;
                const mealId = button.getAttribute('data-meal-id');
                const visitorId = button.getAttribute('data-visitor-id');
                const items = JSON.parse(button.getAttribute('data-items'));
                const totalPayment = button.getAttribute('data-total-payment');

                // Set hidden inputs
                $('#edit_beverage_id').val(mealId);
                $('#edit_visitor_id_hidden').val(visitorId);

                // Set visitor select
                $('#edit_visitor_id').val(visitorId).trigger('change');

                // Create a map of item names to their data
                const itemMap = {};
                items.item_name.forEach((name, index) => {
                    itemMap[name] = {
                        quantity: items.quantity[index],
                        fee: items.fee[index]
                    };
                });

                // Populate meal items by matching names
                $('#edit_beverage_items tr').each(function() {
                    const row = $(this);
                    const itemName = row.find('input[type="hidden"][name*="[name]"]').val();

                    if (itemMap[itemName]) {
                        const quantity = itemMap[itemName].quantity;
                        const price = parseFloat(itemMap[itemName].fee) || 0;
                        const subtotal = quantity * price;

                        row.find('.edit-quantity-input').val(quantity);
                        row.find('.edit-subtotal').val(subtotal.toFixed(2));
                    }
                });

                // Set total payment
                $('#edit_total_payment').val(totalPayment);
            });

            // Reset edit modal when closed
            $('#editBeveragesModal').on('hidden.bs.modal', function() {
                $('.edit-quantity-input').val(0);
                $('.edit-subtotal').val('0.00');
                $('#edit_total_payment').val('0.00');
                $('#edit_visitor_id').val(null).trigger('change');
            });

            // Calculate subtotals and total when quantity changes in edit modal
            $(document).on('input', '.edit-quantity-input', function() {
                const quantity = parseInt($(this).val()) || 0;
                const price = parseFloat($(this).data('price')) || 0;
                const subtotal = quantity * price;

                // Update subtotal for this row
                $(this).closest('tr').find('.edit-subtotal').val(subtotal.toFixed(2));

                // Update total payment
                updateEditTotalPayment();
            });

            function updateEditTotalPayment() {
                let total = 0;
                $('.edit-subtotal').each(function() {
                    total += parseFloat($(this).val()) || 0;
                });
                $('#edit_total_payment').val(total.toFixed(2));
            }

            // Initialize Select2 for edit visitor select
            $('#editBeveragesModal').on('shown.bs.modal', function() {
                $('#edit_visitor_id').select2({
                    theme: 'bootstrap4',
                    width: '100%',
                    placeholder: "Select a visitor",
                    allowClear: true,
                    dropdownParent: $('#editBeveragesModal')
                });
            });
        });
    </script>
