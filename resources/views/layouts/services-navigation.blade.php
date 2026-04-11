<div class="d-flex align-items-center justify-content-between gap-5 bg-theme-primary p-2">
    <img src="{{ asset('public/img/jbp-icon.jpg') }}" width="60" alt="jbp-logo">
    <div class="d-flex gap-2">
        <a href="{{ url()->current() }}" class="btn btn-danger">
            <i class="fas fa-refresh"></i> Reload
        </a>
        <a href="{{ url('bills') }}" class="btn {{ Request::is('bills') ? 'btn-success' : 'btn-outline-light ' }} d-flex align-items-center gap-2">
            <i class="fas fa-file-invoice"></i>
            Bill
        </a>
        <a href="{{ url('meals') }}" class="btn {{ Request::is('meals') || Request::is('beverages') ? 'btn-success' : 'btn-outline-light ' }} d-flex align-items-center gap-2">
            <i class="fas fa-utensils"></i>
            Food & Drinks
        </a>
        <a href="{{ url('accommodations') }}" class="btn {{ Request::is('accommodations') || Request::is('function-halls') ? 'btn-success' : 'btn-outline-light ' }} d-flex align-items-center gap-2">
            <i class="fa-solid fa-building-user"></i>
            Facilities
        </a>
        <a href="{{ url('cottages') }}"
            class="btn {{ Request::is('cottages') ? 'btn-success' : 'btn-outline-light ' }} d-flex align-items-center gap-2">
            <i class="fas fa-home"></i>
            Cottage Fee
        </a>
        <a href="{{ url('entrances') }}"
            class="btn {{ Request::is('entrances') ? 'btn-success' : 'btn-outline-light ' }} d-flex align-items-center gap-2">
            <i class="fas fa-money-bill"></i>
            Entrance Fee
        </a>
    </div>
</div>
