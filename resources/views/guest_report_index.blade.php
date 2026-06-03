@extends('layouts.auth') <!-- Extend the main layout -->
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div class="d-flex">
            <i class="fa fa-address-book fa-2x text-dark me-2"></i>
            <div class="d-flex flex-column">
                <h1 class="h3 mb-0 text">LIST OF GUEST</h1>
                <h6 class="mb-0">Report | Guest Report</h6>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="card col-5 m-auto shadow mb-4 px-0">
            <div class="card-body">
                <div class="col-12 p-4 text-light bg-theme-primary">
                    <div class="d-flex align-items-center gap-2 justify-content-center">
                        <img src="{{ asset('public/img/jbp-icon.jpg') }}" width="70" alt="jpb-heritage-logo">
                        <div class="d-flex flex-column">
                            <b class="modal-title mt-2 h5 text-bold">JPB Heritage Inland Resort</b>
                            <span>Progreso Street Illauod, Bugasong, Antique</span>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <form action="{{ route('guestReportDate') }}">
                        <div class="form-group mb-2">
                            <div class="d-flex flex-column align-items-start gap-3">
                                <label>Select Date:</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-theme-primary text-light">
                                        <i class="fas fa-file-invoice-dollar"></i>
                                    </span>
                                    <input type="date" name="start_date" value="{{ request('start_date') }}"
                                        class="form-control rounded-0"
                                        onchange="document.getElementById('dateRangeForm').submit();">
                                </div>
                                <button type="submit" class="btn btn-success bg-theme-primary w-100">View Report</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection <!-- End the content section -->
