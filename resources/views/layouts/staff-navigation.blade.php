<div class="d-flex align-items-center justify-content-between gap-5 bg-theme-primary p-2">
    <img src="{{ asset('public/img/jbp-icon.jpg') }}" width="60" alt="jbp-logo">
    <div class="d-flex gap-2">
        <a href="{{ url()->current() }}" class="btn btn-danger">
            <i class="fas fa-refresh"></i> Reload
        </a>
        <a href="{{ url('attendance') }}" class="btn {{ Request::is('attendance') ? 'btn-success' : 'btn-outline-light ' }} d-flex align-items-center gap-2">
            <i class="fas fa-calendar-alt"></i>
            Attendance
        </a>
        <a href="{{ url('staff') }}" class="btn {{ Request::is('staff') ? 'btn-success' : 'btn-outline-light ' }} d-flex align-items-center gap-2">
            <i class="fas fa-users"></i>
            Staffs
        </a>
    </div>
</div>
