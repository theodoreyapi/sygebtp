@extends('layouts.master', ['title' => 'Presences'])

@push('csss')
    <!-- Tabler Icon CSS -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/plugins/tabler-icons/tabler-icons.css">

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/plugins/select2/css/select2.min.css">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/plugins/fontawesome/css/all.min.css">

    <!-- Color Picker Css -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/plugins/flatpickr/flatpickr.min.css">
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/plugins/@simonwep/pickr/themes/nano.min.css">

    <!-- Daterangepikcer CSS -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/plugins/daterangepicker/daterangepicker.css">

    <!-- Datatable CSS -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/css/dataTables.bootstrap5.min.css">

    <!-- Datetimepicker CSS -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/css/bootstrap-datetimepicker.min.css">

    <!-- Bootstrap Tagsinput CSS -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/css/style.css">
@endpush

@push('scripts')
    <!-- Slimscroll JS -->
    <script src="{{ URL::asset('') }}assets/js/jquery.slimscroll.min.js"></script>

    <!-- Color Picker JS -->
    <script src="{{ URL::asset('') }}assets/plugins/@simonwep/pickr/pickr.es5.min.js"></script>

    <!-- Datatable JS -->
    <script src="{{ URL::asset('') }}assets/js/jquery.dataTables.min.js"></script>
    <script src="{{ URL::asset('') }}assets/js/dataTables.bootstrap5.min.js"></script>

    <!-- Daterangepikcer JS -->
    <script src="{{ URL::asset('') }}assets/js/moment.js"></script>
    <script src="{{ URL::asset('') }}assets/plugins/daterangepicker/daterangepicker.js"></script>
    <script src="{{ URL::asset('') }}assets/js/bootstrap-datetimepicker.min.js"></script>

    <!-- Select2 JS -->
    <script src="{{ URL::asset('') }}assets/plugins/select2/js/select2.min.js"></script>

    <!-- Multiselect JS -->
    <script src="{{ URL::asset('') }}assets/js/multiselect.min.js"></script>

    <!-- Chart JS -->
    <script src="{{ URL::asset('') }}assets/plugins/apexchart/apexcharts.min.js"></script>
    <script src="{{ URL::asset('') }}assets/plugins/apexchart/chart-data.js"></script>

    <!-- Bootstrap Tagsinput JS -->
    <script src="{{ URL::asset('') }}assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>

    <!-- Custom JS -->
    <script src="{{ URL::asset('') }}assets/js/leave-settings.js"></script>
    <script src="{{ URL::asset('') }}assets/js/theme-colorpicker.js"></script>
    <script src="{{ URL::asset('') }}assets/js/script.js"></script>
@endpush

@section('content')
    <div class="content">

        <!-- Breadcrumb -->
        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
            <div class="my-auto mb-2">
                <h2 class="mb-1">Leave Settings</h2>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="index.html"><i class="ti ti-smart-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            Employee
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Leave Settings</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex my-xl-auto right-content align-items-center flex-wrap ">
                <div class="mb-2">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#new_custom_policy"
                        class="btn btn-primary d-flex align-items-center"><i class="ti ti-circle-plus me-2"></i>Add Custom
                        Policy</a>
                </div>
                <div class="head-icons ms-2">
                    <a href="javascript:void(0);" class="" data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-original-title="Collapse" id="collapse-header">
                        <i class="ti ti-chevrons-up"></i>
                    </a>
                </div>
            </div>
        </div>
        <!-- /Breadcrumb -->

        <!-- Leaves Info -->
        <div class="row">
            <div class="col-xl-4 col-md-6">
                <div class="card">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="form-check form-check-md form-switch me-1">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" role="switch" checked>
                                </label>
                            </div>
                            <h6 class="d-flex align-items-center">Annual Leave</h6>
                        </div>
                        <div class="d-flex align-items-center">
                            <a href="javascript:void(0);" class="text-decoration-underline me-2" data-bs-toggle="modal"
                                data-bs-target="#add_custom_policy">Custom Policy</a>
                            <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#annual_leave_settings"> <i
                                    class="ti ti-settings"></i> </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="card">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="form-check form-check-md form-switch me-1">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" role="switch">
                                </label>
                            </div>
                            <h6 class="d-flex align-items-center">Sick Leave</h6>
                        </div>
                        <div class="d-flex align-items-center">
                            <a href="javascript:void(0);" class="text-decoration-underline me-2" data-bs-toggle="modal"
                                data-bs-target="#add_custom_policy">Custom Policy</a>
                            <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#sick_leave_settings"> <i
                                    class="ti ti-settings"></i> </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="card">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="form-check form-check-md form-switch me-1">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" role="switch" checked>
                                </label>
                            </div>
                            <h6 class="d-flex align-items-center">Hospitalisation</h6>
                        </div>
                        <div class="d-flex align-items-center">
                            <a href="javascript:void(0);" class="text-decoration-underline me-2" data-bs-toggle="modal"
                                data-bs-target="#add_custom_policy">Custom Policy</a>
                            <a href="javascript:void(0);" data-bs-toggle="modal"
                                data-bs-target="#hospitalisation_settings"><i class="ti ti-settings"></i> </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="card">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="form-check form-check-md form-switch me-1">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" role="switch" checked>
                                </label>
                            </div>
                            <h6 class="d-flex align-items-center">Maternity</h6>
                        </div>
                        <div class="d-flex align-items-center">
                            <a href="javascript:void(0);" class="text-decoration-underline me-2" data-bs-toggle="modal"
                                data-bs-target="#add_custom_policy">Custom Policy</a>
                            <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#maternity_settings"> <i
                                    class="ti ti-settings"></i> </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="card">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="form-check form-check-md form-switch me-1">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" role="switch">
                                </label>
                            </div>
                            <h6 class="d-flex align-items-center">Paternity</h6>
                        </div>
                        <div class="d-flex align-items-center">
                            <a href="javascript:void(0);" class="text-decoration-underline me-2" data-bs-toggle="modal"
                                data-bs-target="#add_custom_policy">Custom Policy</a>
                            <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#paternity_settings"> <i
                                    class="ti ti-settings"></i> </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="card">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="form-check form-check-md form-switch me-1">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" role="switch">
                                </label>
                            </div>
                            <h6 class="d-flex align-items-center">LOP</h6>
                        </div>
                        <div class="d-flex align-items-center">
                            <a href="javascript:void(0);" class="text-decoration-underline me-2" data-bs-toggle="modal"
                                data-bs-target="#add_custom_policy">Custom Policy</a>
                            <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#lop_settings"> <i
                                    class="ti ti-settings"></i> </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Leaves Info -->

    </div>

    <!-- New Custom Policy -->
    <div class="modal fade" id="new_custom_policy">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">New Custom Policy</h4>
                    <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
                <form action="leaves.html">
                    <div class="modal-body pb-0">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Leave Type</label>
                                    <select class="select">
                                        <option>Select</option>
                                        <option>Medical Leave</option>
                                        <option>Casual Leave</option>
                                        <option>Annual Leave</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Policy Name</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">No of Days</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Add Employee</label>
                                    <select class="select-img">
                                        <option data-image="{{ URL::asset('') }}assets/img/users/user-40.jpg" selected>
                                            Sophie</option>
                                        <option data-image="{{ URL::asset('') }}assets/img/users/user-58.jpg">Cameron
                                        </option>
                                        <option data-image="{{ URL::asset('') }}assets/img/users/user-42.jpg">Doris
                                        </option>
                                        <option data-image="{{ URL::asset('') }}assets/img/users/user-10.jpg">Rufana
                                        </option>
                                        <option data-image="{{ URL::asset('') }}assets/img/users/user-39.jpg">Michael
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Leaves</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /New Custom Policy -->

    <!-- Annual Leave -->
    <div class="modal fade" id="annual_leave_settings">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Annual Leave Settings</h4>
                    <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
                <form action="leaves.html">
                    <div class="contact-grids-tab">
                        <ul class="nav nav-underline" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="settings-tab" data-bs-toggle="tab"
                                    data-bs-target="#settings-info" type="button" role="tab"
                                    aria-selected="true">Settings</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="viwe-custom-policy-tab" data-bs-toggle="tab"
                                    data-bs-target="#policy" type="button" role="tab" aria-selected="false">View
                                    Custom Policy</button>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="settings-info" role="tabpanel"
                            aria-labelledby="settings-tab" tabindex="0">
                            <div class="modal-body pb-0 ">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">No of Days</label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Carry Forward</label>
                                            <div class="d-flex align-items-center">
                                                <div class="form-check me-2">
                                                    <input class="form-check-input" type="radio" name="flexRadio"
                                                        id="flexRadio" checked="">
                                                    <label class="form-label" for="flexRadio">
                                                        Yes
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="flexRadio"
                                                        id="flexRadioOne">
                                                    <label class="form-label" for="flexRadioOne">
                                                        No
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Maximum No of Days</label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Earned leave</label>
                                            <div class="d-flex align-items-center">
                                                <div class="form-check me-2">
                                                    <input class="form-check-input" type="radio" name="flexRadioOne"
                                                        id="flexRadioTwo" checked="">
                                                    <label class="form-label" for="flexRadioTwo">
                                                        Yes
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="flexRadioOne"
                                                        id="flexRadioThree">
                                                    <label class="form-label" for="flexRadioThree">
                                                        No
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-light border me-2"
                                    data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Save Changes </button>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="policy" role="tabpanel"
                            aria-labelledby="viwe-custom-policy-tab" tabindex="0">
                            <div class="modal-body pb-0 ">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card border mb-3">
                                            <div class="card-body pb-1">
                                                <div class="d-flex align-items-center justify-content-between mb-3">
                                                    <div class="text-start">
                                                        <p class="mb-1">Policy Name</p>
                                                        <span class="text-dark fw-normal mb-0">2 Days Leave</span>
                                                    </div>
                                                    <div>
                                                        <p class="mb-1">No Of Days</p>
                                                        <span class="text-dark fw-normal mb-0">2</span>
                                                    </div>
                                                    <div class="avatar-list-stacked avatar-group-sm">
                                                        <span class="avatar border-0">
                                                            <img src="{{ URL::asset('') }}assets/img/users/user-09.jpg"
                                                                class="rounded-circle" alt="img">
                                                        </span>
                                                        <span class="avatar border-0">
                                                            <img src="{{ URL::asset('') }}assets/img/users/user-13.jpg"
                                                                class="rounded-circle" alt="img">
                                                        </span>
                                                        <span class="avatar border-0">
                                                            <img src="{{ URL::asset('') }}assets/img/users/user-11.jpg"
                                                                class="rounded-circle" alt="img">
                                                        </span>
                                                        <span class="avatar border-0">
                                                            <img src="{{ URL::asset('') }}assets/img/users/user-32.jpg"
                                                                class="rounded-circle" alt="img">
                                                        </span>
                                                        <span class="avatar border-0">
                                                            <img src="{{ URL::asset('') }}assets/img/users/user-58.jpg"
                                                                class="rounded-circle" alt="img">
                                                        </span>
                                                        <span
                                                            class="avatar group-counts bg-primary rounded-circle border-0 fs-10">
                                                            +1
                                                        </span>
                                                    </div>
                                                    <div class="action-icon d-inline-flex">
                                                        <a href="#" class="me-2 edit-leave-btn"><i
                                                                class="ti ti-edit"></i></a>
                                                        <a href="#" data-bs-toggle="modal"
                                                            data-bs-target="#delete_modal"><i class="ti ti-trash"></i></a>
                                                    </div>
                                                </div>
                                                <div class="card border edit-leave-details">
                                                    <div class="card-body pb-1">
                                                        <h6 class="border-bottom mb-3 pb-3">Edit Policy</h6>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Policy Name <span
                                                                            class="text-danger"> *</span></label>
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label">No of Days <span
                                                                            class="text-danger"> *</span></label>
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-me-12">
                                                                <label class="form-label">Add Employee</label>
                                                                <select class="select">
                                                                    <option>Select</option>
                                                                    <option>Sophie</option>
                                                                    <option>Cameron</option>
                                                                    <option>Doris</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="card border mb-3">
                                            <div class="card-body pb-1">
                                                <div class="d-flex align-items-center justify-content-between mb-3">
                                                    <div class="text-start">
                                                        <p class="mb-1">Policy Name</p>
                                                        <span class="text-dark fw-normal mb-0">2 Days Leave</span>
                                                    </div>
                                                    <div>
                                                        <p class="mb-1">No Of Days</p>
                                                        <span class="text-dark fw-normal mb-0">2</span>
                                                    </div>
                                                    <div class="avatar-list-stacked avatar-group-sm">
                                                        <span class="avatar border-0">
                                                            <img src="{{ URL::asset('') }}assets/img/users/user-09.jpg"
                                                                class="rounded-circle" alt="img">
                                                        </span>
                                                        <span class="avatar border-0">
                                                            <img src="{{ URL::asset('') }}assets/img/users/user-11.jpg"
                                                                class="rounded-circle" alt="img">
                                                        </span>
                                                        <span class="avatar border-0">
                                                            <img src="{{ URL::asset('') }}assets/img/users/user-32.jpg"
                                                                class="rounded-circle" alt="img">
                                                        </span>
                                                    </div>
                                                    <div class="action-icon d-inline-flex">
                                                        <a href="#" class="me-2 edit-leave-btn"><i
                                                                class="ti ti-edit"></i></a>
                                                        <a href="#" class=""><i class="ti ti-trash"></i></a>
                                                    </div>
                                                </div>
                                                <div class="card border edit-leave-details">
                                                    <div class="card-body">
                                                        <h6 class="border-bottom mb-3 pb-3">Edit Policy</h6>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Policy Name <span
                                                                            class="text-danger"> *</span></label>
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label">No of Days <span
                                                                            class="text-danger"> *</span></label>
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-me-12">
                                                                <label class="form-label">Add Employee</label>
                                                                <select class="select">
                                                                    <option>Select</option>
                                                                    <option>Sophie</option>
                                                                    <option>Cameron</option>
                                                                    <option>Doris</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="card border mb-3">
                                            <div class="card-body pb-1">
                                                <div class="d-flex align-items-center justify-content-between mb-3">
                                                    <div class="text-start">
                                                        <p class="mb-1">Policy Name</p>
                                                        <span class="text-dark fw-normal mb-0">2 Days Leave</span>
                                                    </div>
                                                    <div>
                                                        <p class="mb-1">No Of Days</p>
                                                        <span class="text-dark fw-normal mb-0">2</span>
                                                    </div>
                                                    <div class="avatar-list-stacked avatar-group-sm">
                                                        <span class="avatar border-0">
                                                            <img src="{{ URL::asset('') }}assets/img/users/user-11.jpg"
                                                                class="rounded-circle" alt="img">
                                                        </span>
                                                        <span class="avatar border-0">
                                                            <img src="{{ URL::asset('') }}assets/img/users/user-58.jpg"
                                                                class="rounded-circle" alt="img">
                                                        </span>
                                                    </div>
                                                    <div class="action-icon d-inline-flex">
                                                        <a href="#" class="me-2 edit-leave-btn"><i
                                                                class="ti ti-edit"></i></a>
                                                        <a href="#" data-bs-toggle="modal"
                                                            data-bs-target="#delete_modal"><i class="ti ti-trash"></i></a>
                                                    </div>
                                                </div>
                                                <div class="card border edit-leave-details">
                                                    <div class="card-body">
                                                        <h6 class="border-bottom mb-3 pb-3">Edit Policy</h6>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Policy Name <span
                                                                            class="text-danger"> *</span></label>
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label">No of Days <span
                                                                            class="text-danger"> *</span></label>
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-me-12">
                                                                <label class="form-label">Add Employee</label>
                                                                <select class="select">
                                                                    <option>Select</option>
                                                                    <option>Sophie</option>
                                                                    <option>Cameron</option>
                                                                    <option>Doris</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="card border mb-3">
                                            <div class="card-body pb-1">
                                                <div class="d-flex align-items-center justify-content-between mb-3">
                                                    <div class="text-start">
                                                        <p class="mb-1">Policy Name</p>
                                                        <span class="text-dark fw-normal mb-0">2 Days Leave</span>
                                                    </div>
                                                    <div>
                                                        <p class="mb-1">No Of Days</p>
                                                        <span class="text-dark fw-normal mb-0">2</span>
                                                    </div>
                                                    <div class="avatar-list-stacked avatar-group-sm">
                                                        <span class="avatar border-0">
                                                            <img src="{{ URL::asset('') }}assets/img/users/user-09.jpg"
                                                                class="rounded-circle" alt="img">
                                                        </span>
                                                        <span class="avatar border-0">
                                                            <img src="{{ URL::asset('') }}assets/img/users/user-13.jpg"
                                                                class="rounded-circle" alt="img">
                                                        </span>
                                                    </div>
                                                    <div class="action-icon d-inline-flex">
                                                        <a href="#" class="me-2 edit-leave-btn"><i
                                                                class="ti ti-edit"></i></a>
                                                        <a href="#" data-bs-toggle="modal"
                                                            data-bs-target="#delete_modal"><i class="ti ti-trash"></i></a>
                                                    </div>
                                                </div>
                                                <div class="card border edit-leave-details">
                                                    <div class="card-body">
                                                        <h6 class="border-bottom mb-3 pb-3">Edit Policy</h6>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Policy Name <span
                                                                            class="text-danger"> *</span></label>
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label">No of Days <span
                                                                            class="text-danger"> *</span></label>
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-me-12">
                                                                <label class="form-label">Add Employee</label>
                                                                <select class="select">
                                                                    <option>Select</option>
                                                                    <option>Sophie</option>
                                                                    <option>Cameron</option>
                                                                    <option>Doris</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-light border me-2"
                                    data-bs-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-primary">Save Changes </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /Annual Leave -->

    <!-- Sick Leave -->
    <div class="modal fade" id="sick_leave_settings">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Sick Leave Settings</h4>
                    <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
                <form action="leaves.html">
                    <div class="contact-grids-tab">
                        <ul class="nav nav-underline" id="myTab6" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="settings-one-tab" data-bs-toggle="tab"
                                    data-bs-target="#settings-one-info" type="button" role="tab"
                                    aria-selected="true">Settings</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="viwe-custom-policy-one-tab" data-bs-toggle="tab"
                                    data-bs-target="#policy-one" type="button" role="tab"
                                    aria-selected="false">View Custom Policy</button>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content" id="myTabContent6">
                        <div class="tab-pane fade show active" id="settings-one-info" role="tabpanel"
                            aria-labelledby="settings-one-tab" tabindex="0">
                            <div class="modal-body pb-0 ">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Days</label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-light border me-2"
                                    data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Save Changes </button>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="policy-one" role="tabpanel"
                            aria-labelledby="viwe-custom-policy-one-tab" tabindex="0">
                            <div class="modal-body pb-0 ">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card border mb-3">
                                            <div class="card-body pb-1">
                                                <div class="d-flex align-items-center justify-content-between mb-3">
                                                    <div class="text-start">
                                                        <p class="mb-1">Policy Name</p>
                                                        <span class="text-dark fw-normal mb-0">2 Days Leave</span>
                                                    </div>
                                                    <div>
                                                        <p class="mb-1">No Of Days</p>
                                                        <span class="text-dark fw-normal mb-0">2</span>
                                                    </div>
                                                    <div class="avatar-list-stacked avatar-group-sm">
                                                        <span class="avatar border-0">
                                                            <img src="{{ URL::asset('') }}assets/img/users/user-09.jpg"
                                                                class="rounded-circle" alt="img">
                                                        </span>
                                                        <span class="avatar border-0">
                                                            <img src="{{ URL::asset('') }}assets/img/users/user-13.jpg"
                                                                class="rounded-circle" alt="img">
                                                        </span>
                                                        <span class="avatar border-0">
                                                            <img src="{{ URL::asset('') }}assets/img/users/user-11.jpg"
                                                                class="rounded-circle" alt="img">
                                                        </span>
                                                        <span class="avatar border-0">
                                                            <img src="{{ URL::asset('') }}assets/img/users/user-32.jpg"
                                                                class="rounded-circle" alt="img">
                                                        </span>
                                                        <span class="avatar border-0">
                                                            <img src="{{ URL::asset('') }}assets/img/users/user-58.jpg"
                                                                class="rounded-circle" alt="img">
                                                        </span>
                                                        <span
                                                            class="avatar group-counts bg-primary rounded-circle border-0 fs-10">
                                                            +1
                                                        </span>
                                                    </div>
                                                    <div class="action-icon d-inline-flex">
                                                        <a href="#" class="me-2 edit-leave-btn"><i
                                                                class="ti ti-edit"></i></a>
                                                        <a href="#" data-bs-toggle="modal"
                                                            data-bs-target="#delete_modal"><i class="ti ti-trash"></i></a>
                                                    </div>
                                                </div>
                                                <div class="card border edit-leave-details">
                                                    <div class="card-body">
                                                        <h6 class="border-bottom mb-3 pb-3">Edit Policy</h6>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Policy Name <span
                                                                            class="text-danger"> *</span></label>
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label">No of Days <span
                                                                            class="text-danger"> *</span></label>
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-me-12">
                                                                <label class="form-label">Add Employee</label>
                                                                <select class="select">
                                                                    <option>Select</option>
                                                                    <option>Sophie</option>
                                                                    <option>Cameron</option>
                                                                    <option>Doris</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="card border mb-3">
                                            <div class="card-body pb-1">
                                                <div class="d-flex align-items-center justify-content-between mb-3">
                                                    <div class="text-start">
                                                        <p class="mb-1">Policy Name</p>
                                                        <span class="text-dark fw-normal mb-0">2 Days Leave</span>
                                                    </div>
                                                    <div>
                                                        <p class="mb-1">No Of Days</p>
                                                        <span class="text-dark fw-normal mb-0">2</span>
                                                    </div>
                                                    <div class="avatar-list-stacked avatar-group-sm">
                                                        <span class="avatar border-0">
                                                            <img src="{{ URL::asset('') }}assets/img/users/user-09.jpg"
                                                                class="rounded-circle" alt="img">
                                                        </span>
                                                        <span class="avatar border-0">
                                                            <img src="{{ URL::asset('') }}assets/img/users/user-11.jpg"
                                                                class="rounded-circle" alt="img">
                                                        </span>
                                                        <span class="avatar border-0">
                                                            <img src="{{ URL::asset('') }}assets/img/users/user-32.jpg"
                                                                class="rounded-circle" alt="img">
                                                        </span>
                                                    </div>
                                                    <div class="action-icon d-inline-flex">
                                                        <a href="#" class="me-2 edit-leave-btn"><i
                                                                class="ti ti-edit"></i></a>
                                                        <a href="#" class=""><i class="ti ti-trash"></i></a>
                                                    </div>
                                                </div>
                                                <div class="card border edit-leave-details">
                                                    <div class="card-body">
                                                        <h6 class="border-bottom mb-3 pb-3">Edit Policy</h6>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Policy Name <span
                                                                            class="text-danger"> *</span></label>
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label">No of Days <span
                                                                            class="text-danger"> *</span></label>
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-me-12">
                                                                <label class="form-label">Add Employee</label>
                                                                <select class="select">
                                                                    <option>Select</option>
                                                                    <option>Sophie</option>
                                                                    <option>Cameron</option>
                                                                    <option>Doris</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="card border mb-3">
                                            <div class="card-body pb-1">
                                                <div class="d-flex align-items-center justify-content-between mb-3">
                                                    <div class="text-start">
                                                        <p class="mb-1">Policy Name</p>
                                                        <span class="text-dark fw-normal mb-0">2 Days Leave</span>
                                                    </div>
                                                    <div>
                                                        <p class="mb-1">No Of Days</p>
                                                        <span class="text-dark fw-normal mb-0">2</span>
                                                    </div>
                                                    <div class="avatar-list-stacked avatar-group-sm">
                                                        <span class="avatar border-0">
                                                            <img src="{{ URL::asset('') }}assets/img/users/user-11.jpg"
                                                                class="rounded-circle" alt="img">
                                                        </span>
                                                        <span class="avatar border-0">
                                                            <img src="{{ URL::asset('') }}assets/img/users/user-58.jpg"
                                                                class="rounded-circle" alt="img">
                                                        </span>
                                                    </div>
                                                    <div class="action-icon d-inline-flex">
                                                        <a href="#" class="me-2 edit-leave-btn"><i
                                                                class="ti ti-edit"></i></a>
                                                        <a href="#" data-bs-toggle="modal"
                                                            data-bs-target="#delete_modal"><i class="ti ti-trash"></i></a>
                                                    </div>
                                                </div>
                                                <div class="card border edit-leave-details">
                                                    <div class="card-body">
                                                        <h6 class="border-bottom mb-3 pb-3">Edit Policy</h6>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Policy Name <span
                                                                            class="text-danger"> *</span></label>
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label">No of Days <span
                                                                            class="text-danger"> *</span></label>
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-me-12">
                                                                <label class="form-label">Add Employee</label>
                                                                <select class="select">
                                                                    <option>Select</option>
                                                                    <option>Sophie</option>
                                                                    <option>Cameron</option>
                                                                    <option>Doris</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="card border mb-3">
                                            <div class="card-body pb-1">
                                                <div class="d-flex align-items-center justify-content-between mb-3">
                                                    <div class="text-start">
                                                        <p class="mb-1">Policy Name</p>
                                                        <span class="text-dark fw-normal mb-0">2 Days Leave</span>
                                                    </div>
                                                    <div>
                                                        <p class="mb-1">No Of Days</p>
                                                        <span class="text-dark fw-normal mb-0">2</span>
                                                    </div>
                                                    <div class="avatar-list-stacked avatar-group-sm">
                                                        <span class="avatar border-0">
                                                            <img src="{{ URL::asset('') }}assets/img/users/user-09.jpg"
                                                                class="rounded-circle" alt="img">
                                                        </span>
                                                        <span class="avatar border-0">
                                                            <img src="{{ URL::asset('') }}assets/img/users/user-13.jpg"
                                                                class="rounded-circle" alt="img">
                                                        </span>
                                                    </div>
                                                    <div class="action-icon d-inline-flex">
                                                        <a href="#" class="me-2 edit-leave-btn"><i
                                                                class="ti ti-edit"></i></a>
                                                        <a href="#" data-bs-toggle="modal"
                                                            data-bs-target="#delete_modal"><i class="ti ti-trash"></i></a>
                                                    </div>
                                                </div>
                                                <div class="card border edit-leave-details">
                                                    <div class="card-body">
                                                        <h6 class="border-bottom mb-3 pb-3">Edit Policy</h6>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Policy Name <span
                                                                            class="text-danger"> *</span></label>
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label">No of Days <span
                                                                            class="text-danger"> *</span></label>
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-me-12">
                                                                <label class="form-label">Add Employee</label>
                                                                <select class="select">
                                                                    <option>Select</option>
                                                                    <option>Sophie</option>
                                                                    <option>Cameron</option>
                                                                    <option>Doris</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-light border me-2"
                                    data-bs-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-primary">Save Changes </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /Sick Leave -->

    <!-- Hospitalisation Leave -->
    <div class="modal fade" id="hospitalisation_settings">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Hospitalisation Settings</h4>
                    <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
                <form action="leaves.html">
                    <div class="contact-grids-tab">
                        <ul class="nav nav-underline" id="myTab2" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="settings-two-tab" data-bs-toggle="tab"
                                    data-bs-target="#settings-two-info" type="button" role="tab"
                                    aria-selected="true">Settings</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="viwe-custom-policy-two-tab" data-bs-toggle="tab"
                                    data-bs-target="#policy-two" type="button" role="tab"
                                    aria-selected="false">View Custom Policy</button>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content" id="myTabContent2">
                        <div class="tab-pane fade show active" id="settings-two-info" role="tabpanel"
                            aria-labelledby="settings-two-tab" tabindex="0">
                            <div class="modal-body pb-0 ">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Days</label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-light border me-2"
                                    data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Save Changes </button>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="policy-two" role="tabpanel"
                            aria-labelledby="viwe-custom-policy-two-tab" tabindex="0">
                            <div class="modal-body pb-0 ">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card border mb-3">
                                            <div class="card-body pb-1">
                                                <div class="d-flex align-items-center justify-content-between mb-3">
                                                    <div class="text-start">
                                                        <p class="mb-1">Policy Name</p>
                                                        <span class="text-dark fw-normal mb-0">2 Days Leave</span>
                                                    </div>
                                                    <div>
                                                        <p class="mb-1">No Of Days</p>
                                                        <span class="text-dark fw-normal mb-0">2</span>
                                                    </div>
                                                    <div class="avatar-list-stacked avatar-group-sm">
                                                        <span class="avatar border-0">
                                                            <img src="{{ URL::asset('') }}assets/img/users/user-09.jpg"
                                                                class="rounded-circle" alt="img">
                                                        </span>
                                                        <span class="avatar border-0">
                                                            <img src="{{ URL::asset('') }}assets/img/users/user-13.jpg"
                                                                class="rounded-circle" alt="img">
                                                        </span>
                                                        <span class="avatar border-0">
                                                            <img src="{{ URL::asset('') }}assets/img/users/user-11.jpg"
                                                                class="rounded-circle" alt="img">
                                                        </span>
                                                        <span class="avatar border-0">
                                                            <img src="{{ URL::asset('') }}assets/img/users/user-32.jpg"
                                                                class="rounded-circle" alt="img">
                                                        </span>
                                                        <span class="avatar border-0">
                                                            <img src="{{ URL::asset('') }}assets/img/users/user-58.jpg"
                                                                class="rounded-circle" alt="img">
                                                        </span>
                                                        <span
                                                            class="avatar group-counts bg-primary rounded-circle border-0 fs-10">
                                                            +1
                                                        </span>
                                                    </div>
                                                    <div class="action-icon d-inline-flex">
                                                        <a href="#" class="me-2 edit-leave-btn"><i
                                                                class="ti ti-edit"></i></a>
                                                        <a href="#" data-bs-toggle="modal"
                                                            data-bs-target="#delete_modal"><i class="ti ti-trash"></i></a>
                                                    </div>
                                                </div>
                                                <div class="card border edit-leave-details">
                                                    <div class="card-body">
                                                        <h6 class="border-bottom mb-3 pb-3">Edit Policy</h6>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Policy Name <span
                                                                            class="text-danger"> *</span></label>
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label">No of Days <span
                                                                            class="text-danger"> *</span></label>
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-me-12">
                                                                <label class="form-label">Add Employee</label>
                                                                <select class="select">
                                                                    <option>Select</option>
                                                                    <option>Sophie</option>
                                                                    <option>Cameron</option>
                                                                    <option>Doris</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="card border mb-3">
                                            <div class="card-body pb-1">
                                                <div class="d-flex align-items-center justify-content-between mb-3">
                                                    <div class="text-start">
                                                        <p class="mb-1">Policy Name</p>
                                                        <span class="text-dark fw-normal mb-0">2 Days Leave</span>
                                                    </div>
                                                    <div>
                                                        <p class="mb-1">No Of Days</p>
                                                        <span class="text-dark fw-normal mb-0">2</span>
                                                    </div>
                                                    <div class="avatar-list-stacked avatar-group-sm">
                                                        <span class="avatar border-0">
                                                            <img src="{{ URL::asset('') }}assets/img/users/user-09.jpg"
                                                                class="rounded-circle" alt="img">
                                                        </span>
                                                        <span class="avatar border-0">
                                                            <img src="{{ URL::asset('') }}assets/img/users/user-11.jpg"
                                                                class="rounded-circle" alt="img">
                                                        </span>
                                                        <span class="avatar border-0">
                                                            <img src="{{ URL::asset('') }}assets/img/users/user-32.jpg"
                                                                class="rounded-circle" alt="img">
                                                        </span>
                                                    </div>
                                                    <div class="action-icon d-inline-flex">
                                                        <a href="#" class="me-2 edit-leave-btn"><i
                                                                class="ti ti-edit"></i></a>
                                                        <a href="#" class=""><i class="ti ti-trash"></i></a>
                                                    </div>
                                                </div>
                                                <div class="card border edit-leave-details">
                                                    <div class="card-body">
                                                        <h6 class="border-bottom mb-3 pb-3">Edit Policy</h6>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Policy Name <span
                                                                            class="text-danger"> *</span></label>
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label">No of Days <span
                                                                            class="text-danger"> *</span></label>
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-me-12">
                                                                <label class="form-label">Add Employee</label>
                                                                <select class="select">
                                                                    <option>Select</option>
                                                                    <option>Sophie</option>
                                                                    <option>Cameron</option>
                                                                    <option>Doris</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="card border mb-3">
                                            <div class="card-body pb-1">
                                                <div class="d-flex align-items-center justify-content-between mb-3">
                                                    <div class="text-start">
                                                        <p class="mb-1">Policy Name</p>
                                                        <span class="text-dark fw-normal mb-0">2 Days Leave</span>
                                                    </div>
                                                    <div>
                                                        <p class="mb-1">No Of Days</p>
                                                        <span class="text-dark fw-normal mb-0">2</span>
                                                    </div>
                                                    <div class="avatar-list-stacked avatar-group-sm">
                                                        <span class="avatar border-0">
                                                            <img src="{{ URL::asset('') }}assets/img/users/user-11.jpg"
                                                                class="rounded-circle" alt="img">
                                                        </span>
                                                        <span class="avatar border-0">
                                                            <img src="{{ URL::asset('') }}assets/img/users/user-58.jpg"
                                                                class="rounded-circle" alt="img">
                                                        </span>
                                                    </div>
                                                    <div class="action-icon d-inline-flex">
                                                        <a href="#" class="me-2 edit-leave-btn"><i
                                                                class="ti ti-edit"></i></a>
                                                        <a href="#" data-bs-toggle="modal"
                                                            data-bs-target="#delete_modal"><i class="ti ti-trash"></i></a>
                                                    </div>
                                                </div>
                                                <div class="card border edit-leave-details">
                                                    <div class="card-body">
                                                        <h6 class="border-bottom mb-3 pb-3">Edit Policy</h6>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Policy Name <span
                                                                            class="text-danger"> *</span></label>
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label">No of Days <span
                                                                            class="text-danger"> *</span></label>
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-me-12">
                                                                <label class="form-label">Add Employee</label>
                                                                <select class="select">
                                                                    <option>Select</option>
                                                                    <option>Sophie</option>
                                                                    <option>Cameron</option>
                                                                    <option>Doris</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="card border mb-3">
                                            <div class="card-body pb-1">
                                                <div class="d-flex align-items-center justify-content-between mb-3">
                                                    <div class="text-start">
                                                        <p class="mb-1">Policy Name</p>
                                                        <span class="text-dark fw-normal mb-0">2 Days Leave</span>
                                                    </div>
                                                    <div>
                                                        <p class="mb-1">No Of Days</p>
                                                        <span class="text-dark fw-normal mb-0">2</span>
                                                    </div>
                                                    <div class="avatar-list-stacked avatar-group-sm">
                                                        <span class="avatar border-0">
                                                            <img src="{{ URL::asset('') }}assets/img/users/user-09.jpg"
                                                                class="rounded-circle" alt="img">
                                                        </span>
                                                        <span class="avatar border-0">
                                                            <img src="{{ URL::asset('') }}assets/img/users/user-13.jpg"
                                                                class="rounded-circle" alt="img">
                                                        </span>
                                                    </div>
                                                    <div class="action-icon d-inline-flex">
                                                        <a href="#" class="me-2 edit-leave-btn"><i
                                                                class="ti ti-edit"></i></a>
                                                        <a href="#" data-bs-toggle="modal"
                                                            data-bs-target="#delete_modal"><i
                                                                class="ti ti-trash"></i></a>
                                                    </div>
                                                </div>
                                                <div class="card border edit-leave-details">
                                                    <div class="card-body">
                                                        <h6 class="border-bottom mb-3 pb-3">Edit Policy</h6>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Policy Name <span
                                                                            class="text-danger"> *</span></label>
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label">No of Days <span
                                                                            class="text-danger"> *</span></label>
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-me-12">
                                                                <label class="form-label">Add Employee</label>
                                                                <select class="select">
                                                                    <option>Select</option>
                                                                    <option>Sophie</option>
                                                                    <option>Cameron</option>
                                                                    <option>Doris</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-light border me-2"
                                    data-bs-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-primary">Save Changes </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /Hospitalisation Leave -->

    <!-- Maternity Leave -->
    <div class="modal fade" id="maternity_settings">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Maternity Settings</h4>
                    <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
                <form action="leaves.html">
                    <div class="contact-grids-tab">
                        <ul class="nav nav-underline" id="myTab3" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="settings-three-tab" data-bs-toggle="tab"
                                    data-bs-target="#settings-three-info" type="button" role="tab"
                                    aria-selected="true">Settings</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="viwe-custom-policy-three-tab" data-bs-toggle="tab"
                                    data-bs-target="#policy-three" type="button" role="tab"
                                    aria-selected="false">View Custom Policy</button>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content" id="myTabContent3">
                        <div class="tab-pane fade show active" id="settings-three-info" role="tabpanel"
                            aria-labelledby="settings-three-tab" tabindex="0">
                            <div class="modal-body pb-0 ">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Days <span class="text-gray">(Assigned to Female
                                                    only)</span> </label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-light border me-2"
                                    data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Save Changes </button>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="policy-three" role="tabpanel"
                            aria-labelledby="viwe-custom-policy-three-tab" tabindex="0">
                            <div class="modal-body pb-0 ">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card border mb-3">
                                            <div class="card-body pb-1">
                                                <div class="d-flex align-items-center justify-content-between mb-3">
                                                    <div class="text-start">
                                                        <p class="mb-1">Policy Name</p>
                                                        <span class="text-dark fw-normal mb-0">2 Days Leave</span>
                                                    </div>
                                                    <div>
                                                        <p class="mb-1">No Of Days</p>
                                                        <span class="text-dark fw-normal mb-0">2</span>
                                                    </div>
                                                    <div class="avatar-list-stacked avatar-group-sm">
                                                        <span class="avatar border-0">
                                                            <img src="{{ URL::asset('') }}assets/img/users/user-09.jpg"
                                                                class="rounded-circle" alt="img">
                                                        </span>
                                                        <span class="avatar border-0">
                                                            <img src="{{ URL::asset('') }}assets/img/users/user-13.jpg"
                                                                class="rounded-circle" alt="img">
                                                        </span>
                                                        <span class="avatar border-0">
                                                            <img src="{{ URL::asset('') }}assets/img/users/user-11.jpg"
                                                                class="rounded-circle" alt="img">
                                                        </span>
                                                        <span class="avatar border-0">
                                                            <img src="{{ URL::asset('') }}assets/img/users/user-32.jpg"
                                                                class="rounded-circle" alt="img">
                                                        </span>
                                                        <span class="avatar border-0">
                                                            <img src="{{ URL::asset('') }}assets/img/users/user-58.jpg"
                                                                class="rounded-circle" alt="img">
                                                        </span>
                                                        <span
                                                            class="avatar group-counts bg-primary rounded-circle border-0 fs-10">
                                                            +1
                                                        </span>
                                                    </div>
                                                    <div class="action-icon d-inline-flex">
                                                        <a href="#" class="me-2 edit-leave-btn"><i
                                                                class="ti ti-edit"></i></a>
                                                        <a href="#" data-bs-toggle="modal"
                                                            data-bs-target="#delete_modal"><i
                                                                class="ti ti-trash"></i></a>
                                                    </div>
                                                </div>
                                                <div class="card border edit-leave-details">
                                                    <div class="card-body">
                                                        <h6 class="border-bottom mb-3 pb-3">Edit Policy</h6>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Policy Name <span
                                                                            class="text-danger"> *</span></label>
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label">No of Days <span
                                                                            class="text-danger"> *</span></label>
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-me-12">
                                                                <label class="form-label">Add Employee</label>
                                                                <select class="select">
                                                                    <option>Select</option>
                                                                    <option>Sophie</option>
                                                                    <option>Cameron</option>
                                                                    <option>Doris</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="card border mb-3">
                                            <div class="card-body pb-1">
                                                <div class="d-flex align-items-center justify-content-between mb-3">
                                                    <div class="text-start">
                                                        <p class="mb-1">Policy Name</p>
                                                        <span class="text-dark fw-normal mb-0">2 Days Leave</span>
                                                    </div>
                                                    <div>
                                                        <p class="mb-1">No Of Days</p>
                                                        <span class="text-dark fw-normal mb-0">2</span>
                                                    </div>
                                                    <div class="avatar-list-stacked avatar-group-sm">
                                                        <span class="avatar border-0">
                                                            <img src="{{ URL::asset('') }}assets/img/users/user-09.jpg"
                                                                class="rounded-circle" alt="img">
                                                        </span>
                                                        <span class="avatar border-0">
                                                            <img src="{{ URL::asset('') }}assets/img/users/user-11.jpg"
                                                                class="rounded-circle" alt="img">
                                                        </span>
                                                        <span class="avatar border-0">
                                                            <img src="{{ URL::asset('') }}assets/img/users/user-32.jpg"
                                                                class="rounded-circle" alt="img">
                                                        </span>
                                                    </div>
                                                    <div class="action-icon d-inline-flex">
                                                        <a href="#" class="me-2 edit-leave-btn"><i
                                                                class="ti ti-edit"></i></a>
                                                        <a href="#" class=""><i
                                                                class="ti ti-trash"></i></a>
                                                    </div>
                                                </div>
                                                <div class="card border edit-leave-details">
                                                    <div class="card-body">
                                                        <h6 class="border-bottom mb-3 pb-3">Edit Policy</h6>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Policy Name <span
                                                                            class="text-danger"> *</span></label>
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label">No of Days <span
                                                                            class="text-danger"> *</span></label>
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-me-12">
                                                                <label class="form-label">Add Employee</label>
                                                                <select class="select">
                                                                    <option>Select</option>
                                                                    <option>Sophie</option>
                                                                    <option>Cameron</option>
                                                                    <option>Doris</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="card border mb-3">
                                            <div class="card-body pb-1">
                                                <div class="d-flex align-items-center justify-content-between mb-3">
                                                    <div class="text-start">
                                                        <p class="mb-1">Policy Name</p>
                                                        <span class="text-dark fw-normal mb-0">2 Days Leave</span>
                                                    </div>
                                                    <div>
                                                        <p class="mb-1">No Of Days</p>
                                                        <span class="text-dark fw-normal mb-0">2</span>
                                                    </div>
                                                    <div class="avatar-list-stacked avatar-group-sm">
                                                        <span class="avatar border-0">
                                                            <img src="{{ URL::asset('') }}assets/img/users/user-11.jpg"
                                                                class="rounded-circle" alt="img">
                                                        </span>
                                                        <span class="avatar border-0">
                                                            <img src="{{ URL::asset('') }}assets/img/users/user-58.jpg"
                                                                class="rounded-circle" alt="img">
                                                        </span>
                                                    </div>
                                                    <div class="action-icon d-inline-flex">
                                                        <a href="#" class="me-2 edit-leave-btn"><i
                                                                class="ti ti-edit"></i></a>
                                                        <a href="#" data-bs-toggle="modal"
                                                            data-bs-target="#delete_modal"><i
                                                                class="ti ti-trash"></i></a>
                                                    </div>
                                                </div>
                                                <div class="card border edit-leave-details">
                                                    <div class="card-body">
                                                        <h6 class="border-bottom mb-3 pb-3">Edit Policy</h6>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Policy Name <span
                                                                            class="text-danger"> *</span></label>
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label">No of Days <span
                                                                            class="text-danger"> *</span></label>
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-me-12">
                                                                <label class="form-label">Add Employee</label>
                                                                <select class="select">
                                                                    <option>Select</option>
                                                                    <option>Sophie</option>
                                                                    <option>Cameron</option>
                                                                    <option>Doris</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="card border mb-3">
                                            <div class="card-body pb-1">
                                                <div class="d-flex align-items-center justify-content-between mb-3">
                                                    <div class="text-start">
                                                        <p class="mb-1">Policy Name</p>
                                                        <span class="text-dark fw-normal mb-0">2 Days Leave</span>
                                                    </div>
                                                    <div>
                                                        <p class="mb-1">No Of Days</p>
                                                        <span class="text-dark fw-normal mb-0">2</span>
                                                    </div>
                                                    <div class="avatar-list-stacked avatar-group-sm">
                                                        <span class="avatar border-0">
                                                            <img src="{{ URL::asset('') }}assets/img/users/user-09.jpg"
                                                                class="rounded-circle" alt="img">
                                                        </span>
                                                        <span class="avatar border-0">
                                                            <img src="{{ URL::asset('') }}assets/img/users/user-13.jpg"
                                                                class="rounded-circle" alt="img">
                                                        </span>
                                                    </div>
                                                    <div class="action-icon d-inline-flex">
                                                        <a href="#" class="me-2 edit-leave-btn"><i
                                                                class="ti ti-edit"></i></a>
                                                        <a href="#" data-bs-toggle="modal"
                                                            data-bs-target="#delete_modal"><i
                                                                class="ti ti-trash"></i></a>
                                                    </div>
                                                </div>
                                                <div class="card border edit-leave-details">
                                                    <div class="card-body">
                                                        <h6 class="border-bottom mb-3 pb-3">Edit Policy</h6>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Policy Name <span
                                                                            class="text-danger"> *</span></label>
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label">No of Days <span
                                                                            class="text-danger"> *</span></label>
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-me-12">
                                                                <label class="form-label">Add Employee</label>
                                                                <select class="select">
                                                                    <option>Select</option>
                                                                    <option>Sophie</option>
                                                                    <option>Cameron</option>
                                                                    <option>Doris</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-light border me-2"
                                    data-bs-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-primary">Save Changes </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /Maternity Leave -->

    <!-- Paternity Leave -->
    <div class="modal fade" id="paternity_settings">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Paternity Settings</h4>
                    <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
                <form action="leaves.html">
                    <div class="contact-grids-tab">
                        <ul class="nav nav-underline" id="myTab4" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="settings-four-tab" data-bs-toggle="tab"
                                    data-bs-target="#settings-four-info" type="button" role="tab"
                                    aria-selected="true">Settings</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="viwe-custom-policy-four-tab" data-bs-toggle="tab"
                                    data-bs-target="#policy-four" type="button" role="tab"
                                    aria-selected="false">View Custom Policy</button>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content" id="myTabContent4">
                        <div class="tab-pane fade show active" id="settings-four-info" role="tabpanel"
                            aria-labelledby="settings-four-tab" tabindex="0">
                            <div class="modal-body pb-0 ">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Days <span class="text-gray">(Assigned to Male
                                                    only)</span> </label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-light border me-2"
                                    data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Save Changes </button>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="policy-four" role="tabpanel"
                            aria-labelledby="viwe-custom-policy-four-tab" tabindex="0">
                            <div class="modal-body pb-0 ">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card border mb-3">
                                            <div class="card-body pb-1">
                                                <div class="d-flex align-items-center justify-content-between mb-3">
                                                    <div class="text-start">
                                                        <p class="mb-1">Policy Name</p>
                                                        <span class="text-dark fw-normal mb-0">2 Days Leave</span>
                                                    </div>
                                                    <div>
                                                        <p class="mb-1">No Of Days</p>
                                                        <span class="text-dark fw-normal mb-0">2</span>
                                                    </div>
                                                    <div class="avatar-list-stacked avatar-group-sm">
                                                        <span class="avatar border-0">
                                                            <img src="{{ URL::asset('') }}assets/img/users/user-09.jpg"
                                                                class="rounded-circle" alt="img">
                                                        </span>
                                                        <span class="avatar border-0">
                                                            <img src="{{ URL::asset('') }}assets/img/users/user-13.jpg"
                                                                class="rounded-circle" alt="img">
                                                        </span>
                                                        <span class="avatar border-0">
                                                            <img src="{{ URL::asset('') }}assets/img/users/user-11.jpg"
                                                                class="rounded-circle" alt="img">
                                                        </span>
                                                        <span class="avatar border-0">
                                                            <img src="{{ URL::asset('') }}assets/img/users/user-32.jpg"
                                                                class="rounded-circle" alt="img">
                                                        </span>
                                                        <span class="avatar border-0">
                                                            <img src="{{ URL::asset('') }}assets/img/users/user-58.jpg"
                                                                class="rounded-circle" alt="img">
                                                        </span>
                                                        <span
                                                            class="avatar group-counts bg-primary rounded-circle border-0 fs-10">
                                                            +1
                                                        </span>
                                                    </div>
                                                    <div class="action-icon d-inline-flex">
                                                        <a href="#" class="me-2 edit-leave-btn"><i
                                                                class="ti ti-edit"></i></a>
                                                        <a href="#" data-bs-toggle="modal"
                                                            data-bs-target="#delete_modal"><i
                                                                class="ti ti-trash"></i></a>
                                                    </div>
                                                </div>
                                                <div class="card border edit-leave-details">
                                                    <div class="card-body">
                                                        <h6 class="border-bottom mb-3 pb-3">Edit Policy</h6>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Policy Name <span
                                                                            class="text-danger"> *</span></label>
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label">No of Days <span
                                                                            class="text-danger"> *</span></label>
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-me-12">
                                                                <label class="form-label">Add Employee</label>
                                                                <select class="select">
                                                                    <option>Select</option>
                                                                    <option>Sophie</option>
                                                                    <option>Cameron</option>
                                                                    <option>Doris</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="card border mb-3">
                                            <div class="card-body pb-1">
                                                <div class="d-flex align-items-center justify-content-between mb-3">
                                                    <div class="text-start">
                                                        <p class="mb-1">Policy Name</p>
                                                        <span class="text-dark fw-normal mb-0">2 Days Leave</span>
                                                    </div>
                                                    <div>
                                                        <p class="mb-1">No Of Days</p>
                                                        <span class="text-dark fw-normal mb-0">2</span>
                                                    </div>
                                                    <div class="avatar-list-stacked avatar-group-sm">
                                                        <span class="avatar border-0">
                                                            <img src="{{ URL::asset('') }}assets/img/users/user-09.jpg"
                                                                class="rounded-circle" alt="img">
                                                        </span>
                                                        <span class="avatar border-0">
                                                            <img src="{{ URL::asset('') }}assets/img/users/user-11.jpg"
                                                                class="rounded-circle" alt="img">
                                                        </span>
                                                        <span class="avatar border-0">
                                                            <img src="{{ URL::asset('') }}assets/img/users/user-32.jpg"
                                                                class="rounded-circle" alt="img">
                                                        </span>
                                                    </div>
                                                    <div class="action-icon d-inline-flex">
                                                        <a href="#" class="me-2 edit-leave-btn"><i
                                                                class="ti ti-edit"></i></a>
                                                        <a href="#" class=""><i
                                                                class="ti ti-trash"></i></a>
                                                    </div>
                                                </div>
                                                <div class="card border edit-leave-details">
                                                    <div class="card-body">
                                                        <h6 class="border-bottom mb-3 pb-3">Edit Policy</h6>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Policy Name <span
                                                                            class="text-danger"> *</span></label>
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label">No of Days <span
                                                                            class="text-danger"> *</span></label>
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-me-12">
                                                                <label class="form-label">Add Employee</label>
                                                                <select class="select">
                                                                    <option>Select</option>
                                                                    <option>Sophie</option>
                                                                    <option>Cameron</option>
                                                                    <option>Doris</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="card border mb-3">
                                            <div class="card-body pb-1">
                                                <div class="d-flex align-items-center justify-content-between mb-3">
                                                    <div class="text-start">
                                                        <p class="mb-1">Policy Name</p>
                                                        <span class="text-dark fw-normal mb-0">2 Days Leave</span>
                                                    </div>
                                                    <div>
                                                        <p class="mb-1">No Of Days</p>
                                                        <span class="text-dark fw-normal mb-0">2</span>
                                                    </div>
                                                    <div class="avatar-list-stacked avatar-group-sm">
                                                        <span class="avatar border-0">
                                                            <img src="{{ URL::asset('') }}assets/img/users/user-11.jpg"
                                                                class="rounded-circle" alt="img">
                                                        </span>
                                                        <span class="avatar border-0">
                                                            <img src="{{ URL::asset('') }}assets/img/users/user-58.jpg"
                                                                class="rounded-circle" alt="img">
                                                        </span>
                                                    </div>
                                                    <div class="action-icon d-inline-flex">
                                                        <a href="#" class="me-2 edit-leave-btn"><i
                                                                class="ti ti-edit"></i></a>
                                                        <a href="#" data-bs-toggle="modal"
                                                            data-bs-target="#delete_modal"><i
                                                                class="ti ti-trash"></i></a>
                                                    </div>
                                                </div>
                                                <div class="card border edit-leave-details">
                                                    <div class="card-body">
                                                        <h6 class="border-bottom mb-3 pb-3">Edit Policy</h6>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Policy Name <span
                                                                            class="text-danger"> *</span></label>
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label">No of Days <span
                                                                            class="text-danger"> *</span></label>
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-me-12">
                                                                <label class="form-label">Add Employee</label>
                                                                <select class="select">
                                                                    <option>Select</option>
                                                                    <option>Sophie</option>
                                                                    <option>Cameron</option>
                                                                    <option>Doris</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="card border mb-3">
                                            <div class="card-body pb-1">
                                                <div class="d-flex align-items-center justify-content-between mb-3">
                                                    <div class="text-start">
                                                        <p class="mb-1">Policy Name</p>
                                                        <span class="text-dark fw-normal mb-0">2 Days Leave</span>
                                                    </div>
                                                    <div>
                                                        <p class="mb-1">No Of Days</p>
                                                        <span class="text-dark fw-normal mb-0">2</span>
                                                    </div>
                                                    <div class="avatar-list-stacked avatar-group-sm">
                                                        <span class="avatar border-0">
                                                            <img src="{{ URL::asset('') }}assets/img/users/user-09.jpg"
                                                                class="rounded-circle" alt="img">
                                                        </span>
                                                        <span class="avatar border-0">
                                                            <img src="{{ URL::asset('') }}assets/img/users/user-13.jpg"
                                                                class="rounded-circle" alt="img">
                                                        </span>
                                                    </div>
                                                    <div class="action-icon d-inline-flex">
                                                        <a href="#" class="me-2 edit-leave-btn"><i
                                                                class="ti ti-edit"></i></a>
                                                        <a href="#" data-bs-toggle="modal"
                                                            data-bs-target="#delete_modal"><i
                                                                class="ti ti-trash"></i></a>
                                                    </div>
                                                </div>
                                                <div class="card border edit-leave-details">
                                                    <div class="card-body">
                                                        <h6 class="border-bottom mb-3 pb-3">Edit Policy</h6>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Policy Name <span
                                                                            class="text-danger"> *</span></label>
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label">No of Days <span
                                                                            class="text-danger"> *</span></label>
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-me-12">
                                                                <label class="form-label">Add Employee</label>
                                                                <select class="select">
                                                                    <option>Select</option>
                                                                    <option>Sophie</option>
                                                                    <option>Cameron</option>
                                                                    <option>Doris</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-light border me-2"
                                    data-bs-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-primary">Save Changes </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /Paternity Leave -->

    <!-- LOP Leave -->
    <div class="modal fade" id="lop_settings">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">LOP Settings</h4>
                    <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
                <form action="leaves.html">
                    <div class="contact-grids-tab">
                        <ul class="nav nav-underline" id="myTab5" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="settings-five-tab" data-bs-toggle="tab"
                                    data-bs-target="#settings-five-info" type="button" role="tab"
                                    aria-selected="true">Settings</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="viwe-custom-policy-five-tab" data-bs-toggle="tab"
                                    data-bs-target="#policy-five" type="button" role="tab"
                                    aria-selected="false">View Custom Policy</button>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content" id="myTabContent5">
                        <div class="tab-pane fade show active" id="settings-five-info" role="tabpanel"
                            aria-labelledby="settings-five-tab" tabindex="0">
                            <div class="modal-body pb-0 ">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">No of Days</label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Carry Forward</label>
                                            <div class="d-flex align-items-center">
                                                <div class="form-check me-2">
                                                    <input class="form-check-input" type="radio" name="flexRadio"
                                                        id="flexRadio4" checked="">
                                                    <label class="form-label" for="flexRadio4">
                                                        Yes
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="flexRadio"
                                                        id="flexRadio5">
                                                    <label class="form-label" for="flexRadio5">
                                                        No
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Maximum No of Days</label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Earned leave</label>
                                            <div class="d-flex align-items-center">
                                                <div class="form-check me-2">
                                                    <input class="form-check-input" type="radio" name="flexRadioOne"
                                                        id="flexRadio6" checked="">
                                                    <label class="form-label" for="flexRadio6">
                                                        Yes
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="flexRadioOne"
                                                        id="flexRadio7">
                                                    <label class="form-label" for="flexRadio7">
                                                        No
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-light border me-2"
                                    data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Save Changes </button>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="policy-five" role="tabpanel"
                            aria-labelledby="viwe-custom-policy-five-tab" tabindex="0">
                            <div class="modal-body pb-0 ">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card border mb-3">
                                            <div class="card-body pb-1">
                                                <div class="d-flex align-items-center justify-content-between mb-3">
                                                    <div class="text-start">
                                                        <p class="mb-1">Policy Name</p>
                                                        <span class="text-dark fw-normal mb-0">2 Days Leave</span>
                                                    </div>
                                                    <div>
                                                        <p class="mb-1">No Of Days</p>
                                                        <span class="text-dark fw-normal mb-0">2</span>
                                                    </div>
                                                    <div class="avatar-list-stacked avatar-group-sm">
                                                        <span class="avatar border-0">
                                                            <img src="{{ URL::asset('') }}assets/img/users/user-09.jpg"
                                                                class="rounded-circle" alt="img">
                                                        </span>
                                                        <span class="avatar border-0">
                                                            <img src="{{ URL::asset('') }}assets/img/users/user-13.jpg"
                                                                class="rounded-circle" alt="img">
                                                        </span>
                                                        <span class="avatar border-0">
                                                            <img src="{{ URL::asset('') }}assets/img/users/user-11.jpg"
                                                                class="rounded-circle" alt="img">
                                                        </span>
                                                        <span class="avatar border-0">
                                                            <img src="{{ URL::asset('') }}assets/img/users/user-32.jpg"
                                                                class="rounded-circle" alt="img">
                                                        </span>
                                                        <span class="avatar border-0">
                                                            <img src="{{ URL::asset('') }}assets/img/users/user-58.jpg"
                                                                class="rounded-circle" alt="img">
                                                        </span>
                                                        <span
                                                            class="avatar group-counts bg-primary rounded-circle border-0 fs-10">
                                                            +1
                                                        </span>
                                                    </div>
                                                    <div class="action-icon d-inline-flex">
                                                        <a href="#" class="me-2 edit-leave-btn"><i
                                                                class="ti ti-edit"></i></a>
                                                        <a href="#" data-bs-toggle="modal"
                                                            data-bs-target="#delete_modal"><i
                                                                class="ti ti-trash"></i></a>
                                                    </div>
                                                </div>
                                                <div class="card border edit-leave-details">
                                                    <div class="card-body">
                                                        <h6 class="border-bottom mb-3 pb-3">Edit Policy</h6>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Policy Name <span
                                                                            class="text-danger"> *</span></label>
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label">No of Days <span
                                                                            class="text-danger"> *</span></label>
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-me-12">
                                                                <label class="form-label">Add Employee</label>
                                                                <select class="select">
                                                                    <option>Select</option>
                                                                    <option>Sophie</option>
                                                                    <option>Cameron</option>
                                                                    <option>Doris</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="card border mb-3">
                                            <div class="card-body pb-1">
                                                <div class="d-flex align-items-center justify-content-between mb-3">
                                                    <div class="text-start">
                                                        <p class="mb-1">Policy Name</p>
                                                        <span class="text-dark fw-normal mb-0">2 Days Leave</span>
                                                    </div>
                                                    <div>
                                                        <p class="mb-1">No Of Days</p>
                                                        <span class="text-dark fw-normal mb-0">2</span>
                                                    </div>
                                                    <div class="avatar-list-stacked avatar-group-sm">
                                                        <span class="avatar border-0">
                                                            <img src="{{ URL::asset('') }}assets/img/users/user-09.jpg"
                                                                class="rounded-circle" alt="img">
                                                        </span>
                                                        <span class="avatar border-0">
                                                            <img src="{{ URL::asset('') }}assets/img/users/user-11.jpg"
                                                                class="rounded-circle" alt="img">
                                                        </span>
                                                        <span class="avatar border-0">
                                                            <img src="{{ URL::asset('') }}assets/img/users/user-32.jpg"
                                                                class="rounded-circle" alt="img">
                                                        </span>
                                                    </div>
                                                    <div class="action-icon d-inline-flex">
                                                        <a href="#" class="me-2 edit-leave-btn"><i
                                                                class="ti ti-edit"></i></a>
                                                        <a href="#" class=""><i
                                                                class="ti ti-trash"></i></a>
                                                    </div>
                                                </div>
                                                <div class="card border edit-leave-details">
                                                    <div class="card-body">
                                                        <h6 class="border-bottom mb-3 pb-3">Edit Policy</h6>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Policy Name <span
                                                                            class="text-danger"> *</span></label>
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label">No of Days <span
                                                                            class="text-danger"> *</span></label>
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-me-12">
                                                                <label class="form-label">Add Employee</label>
                                                                <select class="select">
                                                                    <option>Select</option>
                                                                    <option>Sophie</option>
                                                                    <option>Cameron</option>
                                                                    <option>Doris</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="card border mb-3">
                                            <div class="card-body pb-1">
                                                <div class="d-flex align-items-center justify-content-between mb-3">
                                                    <div class="text-start">
                                                        <p class="mb-1">Policy Name</p>
                                                        <span class="text-dark fw-normal mb-0">2 Days Leave</span>
                                                    </div>
                                                    <div>
                                                        <p class="mb-1">No Of Days</p>
                                                        <span class="text-dark fw-normal mb-0">2</span>
                                                    </div>
                                                    <div class="avatar-list-stacked avatar-group-sm">
                                                        <span class="avatar border-0">
                                                            <img src="{{ URL::asset('') }}assets/img/users/user-11.jpg"
                                                                class="rounded-circle" alt="img">
                                                        </span>
                                                        <span class="avatar border-0">
                                                            <img src="{{ URL::asset('') }}assets/img/users/user-58.jpg"
                                                                class="rounded-circle" alt="img">
                                                        </span>
                                                    </div>
                                                    <div class="action-icon d-inline-flex">
                                                        <a href="#" class="me-2 edit-leave-btn"><i
                                                                class="ti ti-edit"></i></a>
                                                        <a href="#" data-bs-toggle="modal"
                                                            data-bs-target="#delete_modal"><i
                                                                class="ti ti-trash"></i></a>
                                                    </div>
                                                </div>
                                                <div class="card border edit-leave-details">
                                                    <div class="card-body">
                                                        <h6 class="border-bottom mb-3 pb-3">Edit Policy</h6>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Policy Name <span
                                                                            class="text-danger"> *</span></label>
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label">No of Days <span
                                                                            class="text-danger"> *</span></label>
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-me-12">
                                                                <label class="form-label">Add Employee</label>
                                                                <select class="select">
                                                                    <option>Select</option>
                                                                    <option>Sophie</option>
                                                                    <option>Cameron</option>
                                                                    <option>Doris</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="card border mb-3">
                                            <div class="card-body pb-1">
                                                <div class="d-flex align-items-center justify-content-between mb-3">
                                                    <div class="text-start">
                                                        <p class="mb-1">Policy Name</p>
                                                        <span class="text-dark fw-normal mb-0">2 Days Leave</span>
                                                    </div>
                                                    <div>
                                                        <p class="mb-1">No Of Days</p>
                                                        <span class="text-dark fw-normal mb-0">2</span>
                                                    </div>
                                                    <div class="avatar-list-stacked avatar-group-sm">
                                                        <span class="avatar border-0">
                                                            <img src="{{ URL::asset('') }}assets/img/users/user-09.jpg"
                                                                class="rounded-circle" alt="img">
                                                        </span>
                                                        <span class="avatar border-0">
                                                            <img src="{{ URL::asset('') }}assets/img/users/user-13.jpg"
                                                                class="rounded-circle" alt="img">
                                                        </span>
                                                    </div>
                                                    <div class="action-icon d-inline-flex">
                                                        <a href="#" class="me-2 edit-leave-btn"><i
                                                                class="ti ti-edit"></i></a>
                                                        <a href="#" data-bs-toggle="modal"
                                                            data-bs-target="#delete_modal"><i
                                                                class="ti ti-trash"></i></a>
                                                    </div>
                                                </div>
                                                <div class="card border edit-leave-details">
                                                    <div class="card-body">
                                                        <h6 class="border-bottom mb-3 pb-3">Edit Policy</h6>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Policy Name <span
                                                                            class="text-danger"> *</span></label>
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label">No of Days <span
                                                                            class="text-danger"> *</span></label>
                                                                    <input type="text" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-me-12">
                                                                <label class="form-label">Add Employee</label>
                                                                <select class="select">
                                                                    <option>Select</option>
                                                                    <option>Sophie</option>
                                                                    <option>Cameron</option>
                                                                    <option>Doris</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-light border me-2"
                                    data-bs-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-primary">Save Changes </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /LOP Leave -->

    <!-- Add Custom Policy Modal -->
    <div id="add_custom_policy" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Custom Policy</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="input-block mb-3">
                            <label class="col-form-label">Policy Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="input-block mb-3">
                            <label class="col-form-label">Days <span class="text-danger">*</span></label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="input-block mb-3 leave-duallist">
                            <label class="col-form-label">Add employee</label>
                            <div class="row">
                                <div class="col-lg-5 col-sm-5">
                                    <select name="customleave_from" id="customleave_select"
                                        class="form-control form-select" size="5" multiple="multiple">
                                        <option value="1">Bernardo Galaviz </option>
                                        <option value="2">Jeffrey Warden</option>
                                        <option value="2">John Doe</option>
                                        <option value="2">John Smith</option>
                                        <option value="3">Mike Litorus</option>
                                    </select>
                                </div>
                                <div class="multiselect-controls col-lg-2 col-sm-2 d-grid gap-2">
                                    <button type="button" id="customleave_select_rightAll"
                                        class="btn w-100 btn-white"><i class="fa fa-forward"></i></button>
                                    <button type="button" id="customleave_select_rightSelected"
                                        class="btn w-100 btn-white"><i class="fa fa-chevron-right"></i></button>
                                    <button type="button" id="customleave_select_leftSelected"
                                        class="btn w-100 btn-white"><i class="fa fa-chevron-left"></i></button>
                                    <button type="button" id="customleave_select_leftAll"
                                        class="btn w-100 btn-white"><i class="fa fa-backward"></i></button>
                                </div>
                                <div class="col-lg-5 col-sm-5">
                                    <select name="customleave_to" id="customleave_select_to"
                                        class="form-control form-select" size="8" multiple="multiple"></select>
                                </div>
                            </div>
                        </div>

                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Add Custom Policy Modal -->

    <!-- Edit Custom Policy Modal -->
    <div id="edit_custom_policy" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Custom Policy</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="input-block mb-3">
                            <label class="col-form-label">Policy Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" value="LOP">
                        </div>
                        <div class="input-block mb-3">
                            <label class="col-form-label">Days <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" value="4">
                        </div>
                        <div class="input-block mb-3 leave-duallist">
                            <label class="col-form-label">Add employee</label>
                            <div class="row">
                                <div class="col-lg-5 col-sm-5">
                                    <select name="edit_customleave_from" id="edit_customleave_select"
                                        class="form-control form-select" size="5" multiple="multiple">
                                        <option value="1">Bernardo Galaviz </option>
                                        <option value="2">Jeffrey Warden</option>
                                        <option value="2">John Doe</option>
                                        <option value="2">John Smith</option>
                                        <option value="3">Mike Litorus</option>
                                    </select>
                                </div>
                                <div class="multiselect-controls col-lg-2 col-sm-2 d-grid gap-2">
                                    <button type="button" id="edit_customleave_select_rightAll"
                                        class="btn w-100 btn-white"><i class="fa fa-forward"></i></button>
                                    <button type="button" id="edit_customleave_select_rightSelected"
                                        class="btn w-100 btn-white"><i class="fa fa-chevron-right"></i></button>
                                    <button type="button" id="edit_customleave_select_leftSelected"
                                        class="btn w-100 btn-white"><i class="fa fa-chevron-left"></i></button>
                                    <button type="button" id="edit_customleave_select_leftAll"
                                        class="btn w-100 btn-white"><i class="fa fa-backward"></i></button>
                                </div>
                                <div class="col-lg-5 col-sm-5">
                                    <select name="customleave_to" id="edit_customleave_select_to"
                                        class="form-control form-select" size="8" multiple="multiple"></select>
                                </div>
                            </div>
                        </div>

                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Edit Custom Policy Modal -->

    <!-- Delete Modal -->
    <div class="modal fade" id="delete_modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <span class="avatar avatar-xl bg-transparent-danger text-danger mb-3">
                        <i class="ti ti-trash-x fs-36"></i>
                    </span>
                    <h4 class="mb-1">Confirm Delete</h4>
                    <p class="mb-3">You want to delete all the marked items, this cant be undone once you delete.</p>
                    <div class="d-flex justify-content-center">
                        <a href="javascript:void(0);" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</a>
                        <a href="leave-settings.html" class="btn btn-danger">Yes, Delete</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Delete Modal -->
@endsection
