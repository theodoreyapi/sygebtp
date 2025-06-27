@extends('layouts.master', ['title' => 'Training'])

@push('csss')
    <!-- Tabler Icon CSS -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/plugins/tabler-icons/tabler-icons.css">

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/plugins/select2/css/select2.min.css">

    <!-- Datetimepicker CSS -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/css/bootstrap-datetimepicker.min.css">

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

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/plugins/select2/css/select2.min.css">

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

    <!-- Chart JS -->
    <script src="{{ URL::asset('') }}assets/plugins/apexchart/apexcharts.min.js"></script>
    <script src="{{ URL::asset('') }}assets/plugins/apexchart/chart-data.js"></script>

    <!-- Bootstrap Tagsinput JS -->
    <script src="{{ URL::asset('') }}assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>

    <!-- Custom JS -->
    <script src="{{ URL::asset('') }}assets/js/theme-colorpicker.js"></script>
    <script src="{{ URL::asset('') }}assets/js/script.js"></script>
@endpush

@section('content')
    <div class="content">

        <!-- Breadcrumb -->
        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
            <div class="my-auto mb-2">
                <h2 class="mb-1">Training</h2>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="index.html"><i class="ti ti-smart-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            Performance
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Add Training</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex my-xl-auto right-content align-items-center flex-wrap ">
                <div class="mb-2">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#add_training"
                        class="btn btn-primary d-flex align-items-center"><i class="ti ti-circle-plus me-2"></i>Add Training
                    </a>
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

        <!-- Performance Indicator list -->
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                <h5>Training List</h5>
                <div class="d-flex my-xl-auto right-content align-items-center flex-wrap row-gap-3">

                    <div class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle btn btn-white d-inline-flex align-items-center"
                            data-bs-toggle="dropdown">
                            Sort By : Last 7 Days
                        </a>
                        <ul class="dropdown-menu  dropdown-menu-end p-3">
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item rounded-1">Recently Added</a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item rounded-1">Ascending</a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item rounded-1">Desending</a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item rounded-1">Last Month</a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item rounded-1">Last 7 Days</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="custom-datatable-filter table-responsive">
                    <table class="table datatable">
                        <thead class="thead-light">
                            <tr>
                                <th class="no-sort">
                                    <div class="form-check form-check-md">
                                        <input class="form-check-input" type="checkbox" id="select-all">
                                    </div>
                                </th>
                                <th>Training Type</th>
                                <th>Trainer</th>
                                <th>Employee</th>
                                <th>Time Duration</th>
                                <th>Description</th>
                                <th>Cost</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="form-check form-check-md">
                                        <input class="form-check-input" type="checkbox">
                                    </div>
                                </td>
                                <td>
                                    Git Training
                                </td>
                                <td>
                                    <div class="d-flex align-items-center file-name-icon">
                                        <a href="#" class="avatar avatar-md border avatar-rounded">
                                            <img src="{{ URL::asset('') }}assets/img/users/user-32.jpg" class="img-fluid"
                                                alt="img">
                                        </a>
                                        <div class="ms-2">
                                            <h6 class="fw-medium"><a href="#">Anthony Lewis</a></h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="avatar-list-stacked avatar-group-sm">
                                        <span class="avatar border-0">
                                            <img src="{{ URL::asset('') }}assets/img/users/user-01.jpg"
                                                class="rounded-circle" alt="img">
                                        </span>
                                        <span class="avatar border-0">
                                            <img src="{{ URL::asset('') }}assets/img/users/user-02.jpg"
                                                class="rounded-circle" alt="img">
                                        </span>
                                        <span class="avatar border-0">
                                            <img src="{{ URL::asset('') }}assets/img/users/user-03.jpg"
                                                class="rounded-circle" alt="img">
                                        </span>
                                        <span class="avatar border-0">
                                            <img src="{{ URL::asset('') }}assets/img/users/user-04.jpg"
                                                class="rounded-circle" alt="img">
                                        </span>
                                        <span class="avatar border-0">
                                            <img src="{{ URL::asset('') }}assets/img/users/user-05.jpg"
                                                class="rounded-circle" alt="img">
                                        </span>
                                        <span class="avatar group-counts bg-primary rounded-circle border-0 fs-10">
                                            +4
                                        </span>
                                    </div>
                                </td>
                                <td>12 Jan 2024 - 12 Feb 2024</td>
                                <td>Version control and code collaboration.</td>
                                <td>$200</td>
                                <td>
                                    <span class="badge badge-success d-inline-flex align-items-center badge-xs">
                                        <i class="ti ti-point-filled me-1"></i>Active
                                    </span>
                                </td>
                                <td>
                                    <div class="action-icon d-inline-flex">
                                        <a href="#" class="me-2" data-bs-toggle="modal"
                                            data-bs-target="#edit_training"><i class="ti ti-edit"></i></a>
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#delete_modal"><i
                                                class="ti ti-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-check form-check-md">
                                        <input class="form-check-input" type="checkbox">
                                    </div>
                                </td>
                                <td>
                                    HTML Training
                                </td>
                                <td>
                                    <div class="d-flex align-items-center file-name-icon">
                                        <a href="#" class="avatar avatar-md border avatar-rounded">
                                            <img src="{{ URL::asset('') }}assets/img/users/user-09.jpg" class="img-fluid"
                                                alt="img">
                                        </a>
                                        <div class="ms-2">
                                            <h6 class="fw-medium"><a href="#">Brian Villalobos</a></h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="avatar-list-stacked avatar-group-sm">
                                        <span class="avatar border-0">
                                            <img src="{{ URL::asset('') }}assets/img/users/user-30.jpg"
                                                class="rounded-circle" alt="img">
                                        </span>
                                        <span class="avatar border-0">
                                            <img src="{{ URL::asset('') }}assets/img/users/user-28.jpg"
                                                class="rounded-circle" alt="img">
                                        </span>
                                        <span class="avatar border-0">
                                            <img src="{{ URL::asset('') }}assets/img/users/user-03.jpg"
                                                class="rounded-circle" alt="img">
                                        </span>
                                        <span class="avatar border-0">
                                            <img src="{{ URL::asset('') }}assets/img/users/user-07.jpg"
                                                class="rounded-circle" alt="img">
                                        </span>
                                        <span class="avatar border-0">
                                            <img src="{{ URL::asset('') }}assets/img/users/user-09.jpg"
                                                class="rounded-circle" alt="img">
                                        </span>
                                        <span class="avatar group-counts bg-primary rounded-circle border-0 fs-10">
                                            +3
                                        </span>
                                    </div>
                                </td>
                                <td>17 Jan 2024 - 17 Feb 2024</td>
                                <td>Basics of web page structure and markup.</td>
                                <td>$100</td>
                                <td>
                                    <span class="badge badge-success d-inline-flex align-items-center badge-xs">
                                        <i class="ti ti-point-filled me-1"></i>Active
                                    </span>
                                </td>
                                <td>
                                    <div class="action-icon d-inline-flex">
                                        <a href="#" class="me-2" data-bs-toggle="modal"
                                            data-bs-target="#edit_training"><i class="ti ti-edit"></i></a>
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#delete_modal"><i
                                                class="ti ti-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-check form-check-md">
                                        <input class="form-check-input" type="checkbox">
                                    </div>
                                </td>
                                <td>
                                    React Training
                                </td>
                                <td>
                                    <div class="d-flex align-items-center file-name-icon">
                                        <a href="#" class="avatar avatar-md border avatar-rounded">
                                            <img src="{{ URL::asset('') }}assets/img/users/user-01.jpg" class="img-fluid"
                                                alt="img">
                                        </a>
                                        <div class="ms-2">
                                            <h6 class="fw-medium"><a href="#">Harvey Smith</a></h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="avatar-list-stacked avatar-group-sm">
                                        <span class="avatar border-0">
                                            <img src="{{ URL::asset('') }}assets/img/users/user-32.jpg"
                                                class="rounded-circle" alt="img">
                                        </span>
                                        <span class="avatar border-0">
                                            <img src="{{ URL::asset('') }}assets/img/users/user-21.jpg"
                                                class="rounded-circle" alt="img">
                                        </span>
                                        <span class="avatar border-0">
                                            <img src="{{ URL::asset('') }}assets/img/users/user-01.jpg"
                                                class="rounded-circle" alt="img">
                                        </span>
                                        <span class="avatar border-0">
                                            <img src="{{ URL::asset('') }}assets/img/users/user-05.jpg"
                                                class="rounded-circle" alt="img">
                                        </span>
                                        <span class="avatar border-0">
                                            <img src="{{ URL::asset('') }}assets/img/users/user-18.jpg"
                                                class="rounded-circle" alt="img">
                                        </span>
                                        <span class="avatar group-counts bg-primary rounded-circle border-0 fs-10">
                                            +6
                                        </span>
                                    </div>
                                </td>
                                <td>10 Feb 2024 - 10 Mar 2024</td>
                                <td>Dynamic web applications with components</td>
                                <td>$300</td>
                                <td>
                                    <span class="badge badge-success d-inline-flex align-items-center badge-xs">
                                        <i class="ti ti-point-filled me-1"></i>Active
                                    </span>
                                </td>
                                <td>
                                    <div class="action-icon d-inline-flex">
                                        <a href="#" class="me-2" data-bs-toggle="modal"
                                            data-bs-target="#edit_training"><i class="ti ti-edit"></i></a>
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#delete_modal"><i
                                                class="ti ti-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-check form-check-md">
                                        <input class="form-check-input" type="checkbox">
                                    </div>
                                </td>
                                <td>
                                    Nodejs Training
                                </td>
                                <td>
                                    <div class="d-flex align-items-center file-name-icon">
                                        <a href="#" class="avatar avatar-md border avatar-rounded">
                                            <img src="{{ URL::asset('') }}assets/img/users/user-33.jpg" class="img-fluid"
                                                alt="img">
                                        </a>
                                        <div class="ms-2">
                                            <h6 class="fw-medium"><a href="#">Stephan Peralt</a></h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="avatar-list-stacked avatar-group-sm">
                                        <span class="avatar border-0">
                                            <img src="{{ URL::asset('') }}assets/img/users/user-28.jpg"
                                                class="rounded-circle" alt="img">
                                        </span>
                                        <span class="avatar border-0">
                                            <img src="{{ URL::asset('') }}assets/img/users/user-19.jpg"
                                                class="rounded-circle" alt="img">
                                        </span>
                                        <span class="avatar border-0">
                                            <img src="{{ URL::asset('') }}assets/img/users/user-11.jpg"
                                                class="rounded-circle" alt="img">
                                        </span>
                                        <span class="avatar border-0">
                                            <img src="{{ URL::asset('') }}assets/img/users/user-22.jpg"
                                                class="rounded-circle" alt="img">
                                        </span>
                                        <span class="avatar border-0">
                                            <img src="{{ URL::asset('') }}assets/img/users/user-17.jpg"
                                                class="rounded-circle" alt="img">
                                        </span>
                                        <span class="avatar group-counts bg-primary rounded-circle border-0 fs-10">
                                            +5
                                        </span>
                                    </div>
                                </td>
                                <td>20 Feb 2024 - 20 Mar 2024</td>
                                <td>Building scalable server-side applications</td>
                                <td>$250</td>
                                <td>
                                    <span class="badge badge-success d-inline-flex align-items-center badge-xs">
                                        <i class="ti ti-point-filled me-1"></i>Active
                                    </span>
                                </td>
                                <td>
                                    <div class="action-icon d-inline-flex">
                                        <a href="#" class="me-2" data-bs-toggle="modal"
                                            data-bs-target="#edit_training"><i class="ti ti-edit"></i></a>
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#delete_modal"><i
                                                class="ti ti-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-check form-check-md">
                                        <input class="form-check-input" type="checkbox">
                                    </div>
                                </td>
                                <td>
                                    Vuejs Training
                                </td>
                                <td>
                                    <div class="d-flex align-items-center file-name-icon">
                                        <a href="#" class="avatar avatar-md border avatar-rounded">
                                            <img src="{{ URL::asset('') }}assets/img/users/user-34.jpg" class="img-fluid"
                                                alt="img">
                                        </a>
                                        <div class="ms-2">
                                            <h6 class="fw-medium"><a href="#">Doglas Martini</a></h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="avatar-list-stacked avatar-group-sm">
                                        <span class="avatar border-0">
                                            <img src="{{ URL::asset('') }}assets/img/users/user-23.jpg"
                                                class="rounded-circle" alt="img">
                                        </span>
                                        <span class="avatar border-0">
                                            <img src="{{ URL::asset('') }}assets/img/users/user-13.jpg"
                                                class="rounded-circle" alt="img">
                                        </span>
                                        <span class="avatar border-0">
                                            <img src="{{ URL::asset('') }}assets/img/users/user-12.jpg"
                                                class="rounded-circle" alt="img">
                                        </span>
                                        <span class="avatar border-0">
                                            <img src="{{ URL::asset('') }}assets/img/users/user-25.jpg"
                                                class="rounded-circle" alt="img">
                                        </span>
                                        <span class="avatar border-0">
                                            <img src="{{ URL::asset('') }}assets/img/users/user-19.jpg"
                                                class="rounded-circle" alt="img">
                                        </span>
                                        <span class="avatar group-counts bg-primary rounded-circle border-0 fs-10">
                                            +7
                                        </span>
                                    </div>
                                </td>
                                <td>16 Mar 2024 - 16 Apr 2024</td>
                                <td>Interactive single-page applications</td>
                                <td>$280</td>
                                <td>
                                    <span class="badge badge-success d-inline-flex align-items-center badge-xs">
                                        <i class="ti ti-point-filled me-1"></i>Active
                                    </span>
                                </td>
                                <td>
                                    <div class="action-icon d-inline-flex">
                                        <a href="#" class="me-2" data-bs-toggle="modal"
                                            data-bs-target="#edit_training"><i class="ti ti-edit"></i></a>
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#delete_modal"><i
                                                class="ti ti-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- /Performance Indicator list -->

    </div>

    <!-- Add Training -->
    <div class="modal fade" id="add_training">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Training</h4>
                    <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
                <form action="training.html">
                    <div class="modal-body pb-0">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Training Type</label>
                                    <select class="select">
                                        <option>Select</option>
                                        <option>Git Training</option>
                                        <option>HTML Training</option>
                                        <option>React Training</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Trainer</label>
                                    <select class="select">
                                        <option>Select</option>
                                        <option>Anthony Lewis</option>
                                        <option>Brian Villalobos</option>
                                        <option>Harvey Smith</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Employees</label>
                                    <select class="select">
                                        <option>Select</option>
                                        <option>Bernardo Galaviz</option>
                                        <option>Jeffrey Warden</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Training Cost</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Start Date</label>
                                    <div class="input-icon-end position-relative">
                                        <input type="text" class="form-control datetimepicker"
                                            placeholder="dd/mm/yyyy">
                                        <span class="input-icon-addon">
                                            <i class="ti ti-calendar text-gray-7"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">End Date</label>
                                    <div class="input-icon-end position-relative">
                                        <input type="text" class="form-control datetimepicker"
                                            placeholder="dd/mm/yyyy">
                                        <span class="input-icon-addon">
                                            <i class="ti ti-calendar text-gray-7"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select class="select">
                                        <option>Select</option>
                                        <option selected>Active</option>
                                        <option>Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Training</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /Add Training -->

    <!-- Edit Training -->
    <div class="modal fade" id="edit_training">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Training</h4>
                    <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
                <form action="training.html">
                    <div class="modal-body pb-0">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Training Type</label>
                                    <select class="select">
                                        <option>Select</option>
                                        <option selected>Git Training</option>
                                        <option>HTML Training</option>
                                        <option>React Training</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Trainer</label>
                                    <select class="select">
                                        <option>Select</option>
                                        <option selected>Anthony Lewis</option>
                                        <option>Brian Villalobos</option>
                                        <option>Harvey Smith</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Employees</label>
                                    <select class="select">
                                        <option>Select</option>
                                        <option selected>Bernardo Galaviz</option>
                                        <option>Jeffrey Warden</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Training Cost</label>
                                    <input type="text" class="form-control" value="$200">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Start Date</label>
                                    <div class="input-icon-end position-relative">
                                        <input type="text" class="form-control datetimepicker"
                                            placeholder="dd/mm/yyyy" value="12 Jan 2024">
                                        <span class="input-icon-addon">
                                            <i class="ti ti-calendar text-gray-7"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">End Date</label>
                                    <div class="input-icon-end position-relative">
                                        <input type="text" class="form-control datetimepicker"
                                            placeholder="dd/mm/yyyy" value="12 Feb 2024">
                                        <span class="input-icon-addon">
                                            <i class="ti ti-calendar text-gray-7"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control">Version control and code collaboration.</textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select class="select">
                                        <option>Select</option>
                                        <option selected>Active</option>
                                        <option>Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Training</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /Edit Training -->

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
                        <a href="training.html" class="btn btn-danger">Yes, Delete</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Delete Modal -->
@endsection
