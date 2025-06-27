@extends('layouts.master', ['title' => 'Tickets'])

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

    <!-- Bootstrap Tagsinput JS -->
    <script src="{{ URL::asset('') }}assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>

    <!-- Chart JS -->
    <script src="{{ URL::asset('') }}assets/plugins/peity/jquery.peity.min.js"></script>
    <script src="{{ URL::asset('') }}assets/plugins/peity/chart-data.js"></script>

    <!-- Custom JS -->
    <script src="{{ URL::asset('') }}assets/js/theme-colorpicker.js"></script>
    <script src="{{ URL::asset('') }}assets/js/script.js"></script>
@endpush

@section('content')
    <div class="content">

        <!-- Breadcrumb -->
        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
            <div class="my-auto mb-2">
                <h2 class="mb-1">Tickets</h2>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="index.html"><i class="ti ti-smart-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            Employee
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Tickets</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex my-xl-auto right-content align-items-center flex-wrap ">
                <div class="me-2 mb-2">
                    <div class="d-flex align-items-center border bg-white rounded p-1 me-2 icon-list">
                        <a href="tickets.html" class="btn btn-icon btn-sm active bg-primary text-white me-1"><i
                                class="ti ti-list-tree"></i></a>
                        <a href="tickets-grid.html" class="btn btn-icon btn-sm"><i class="ti ti-layout-grid"></i></a>
                    </div>
                </div>
                <div class="me-2 mb-2">
                    <div class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle btn btn-white d-inline-flex align-items-center"
                            data-bs-toggle="dropdown">
                            <i class="ti ti-file-export me-1"></i>Export
                        </a>
                        <ul class="dropdown-menu  dropdown-menu-end p-3">
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item rounded-1"><i
                                        class="ti ti-file-type-pdf me-1"></i>Export as PDF</a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item rounded-1"><i
                                        class="ti ti-file-type-xls me-1"></i>Export as Excel </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="mb-2">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#add_ticket"
                        class="btn btn-primary d-flex align-items-center"><i class="ti ti-circle-plus me-2"></i>Add New
                        Ticket</a>
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

        <div class="row">
            <div class="col-xl-3 col-md-6 d-flex">
                <div class="card flex-fill">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6 d-flex">
                                <div class="flex-fill">
                                    <div
                                        class="border border-dashed border-primary rounded-circle d-inline-flex align-items-center justify-content-center p-1 mb-3">
                                        <span class="avatar avatar-lg avatar-rounded bg-primary-transparent "><i
                                                class="ti ti-ticket fs-20"></i></span>
                                    </div>
                                    <p class="fw-medium fs-12 mb-1">New Tickets</p>
                                    <h4>120</h4>
                                </div>
                            </div>
                            <div class="col-6 text-end d-flex">
                                <div class="d-flex flex-column justify-content-between align-items-end">
                                    <span class="badge bg-transparent-purple d-inline-flex align-items-center mb-3">
                                        <i class="ti ti-arrow-wave-right-down me-1"></i>
                                        +19.01%
                                    </span>
                                    <div class="ticket-chart-1">8,5,6,3,4,6,7,3,8,6,4,7</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 d-flex">
                <div class="card flex-fill">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6 d-flex">
                                <div class="flex-fill">
                                    <div
                                        class="border border-dashed border-purple rounded-circle d-inline-flex align-items-center justify-content-center p-1 mb-3">
                                        <span class="avatar avatar-lg avatar-rounded bg-transparent-purple"><i
                                                class="ti ti-folder-open fs-20"></i></span>
                                    </div>
                                    <p class="fw-medium fs-12 mb-1">Open Tickets</p>
                                    <h4>60</h4>
                                </div>
                            </div>
                            <div class="col-6 text-end d-flex">
                                <div class="d-flex flex-column justify-content-between align-items-end">
                                    <span class="badge bg-transparent-dark text-dark d-inline-flex align-items-center mb-3">
                                        <i class="ti ti-arrow-wave-right-down me-1"></i>
                                        +19.01%
                                    </span>
                                    <div class="ticket-chart-2">8,5,6,3,4,6,7,3,8,6,4,7</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 d-flex">
                <div class="card flex-fill">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6 d-flex">
                                <div class="flex-fill">
                                    <div
                                        class="border border-dashed border-success rounded-circle d-inline-flex align-items-center justify-content-center p-1 mb-3">
                                        <span class="avatar avatar-lg avatar-rounded bg-success-transparent"><i
                                                class="ti ti-checks fs-20"></i></span>
                                    </div>
                                    <p class="fw-medium fs-12 mb-1">Solved Tickets</p>
                                    <h4>50</h4>
                                </div>
                            </div>
                            <div class="col-6 text-end d-flex">
                                <div class="d-flex flex-column justify-content-between align-items-end">
                                    <span class="badge bg-info-transparent d-inline-flex align-items-center mb-3">
                                        <i class="ti ti-arrow-wave-right-down me-1"></i>
                                        +19.01%
                                    </span>
                                    <div class="ticket-chart-3">8,5,6,3,4,6,7,3,8,6,4,7</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 d-flex">
                <div class="card flex-fill">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6 d-flex">
                                <div class="flex-fill">
                                    <div
                                        class="border border-dashed border-info rounded-circle d-inline-flex align-items-center justify-content-center p-1 mb-3">
                                        <span class="avatar avatar-lg avatar-rounded bg-info-transparent"><i
                                                class="ti ti-progress-alert fs-20"></i></span>
                                    </div>
                                    <p class="fw-medium fs-12 mb-1">Pending Tickets</p>
                                    <h4>10</h4>
                                </div>
                            </div>
                            <div class="col-6 text-end d-flex">
                                <div class="d-flex flex-column justify-content-between align-items-end">
                                    <span class="badge bg-secondary-transparent d-inline-flex align-items-center mb-3">
                                        <i class="ti ti-arrow-wave-right-down me-1"></i>
                                        +19.01%
                                    </span>
                                    <div class="ticket-chart-4">8,5,6,3,4,6,7,3,8,6,4,7</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                    <h5>Ticket List</h5>
                    <div class="d-flex align-items-center flex-wrap row-gap-3">
                        <div class="dropdown me-2">
                            <a href="javascript:void(0);"
                                class="dropdown-toggle btn btn-sm btn-white d-inline-flex align-items-center"
                                data-bs-toggle="dropdown">
                                Priority
                            </a>
                            <ul class="dropdown-menu  dropdown-menu-end p-3">
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item rounded-1">Priority</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item rounded-1">High</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item rounded-1">Low</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item rounded-1">Medium</a>
                                </li>
                            </ul>
                        </div>
                        <div class="dropdown me-2">
                            <a href="javascript:void(0);"
                                class="dropdown-toggle btn btn-sm btn-white d-inline-flex align-items-center"
                                data-bs-toggle="dropdown">
                                Select Status
                            </a>
                            <ul class="dropdown-menu  dropdown-menu-end p-3">
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item rounded-1">Open</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item rounded-1">On Hold</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="dropdown-item rounded-1">Reopened</a>
                                </li>
                            </ul>
                        </div>
                        <div class="dropdown">
                            <a href="javascript:void(0);"
                                class="dropdown-toggle btn btn-sm btn-white d-inline-flex align-items-center"
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
            </div>
        </div>
        <div class="row">
            <div class="col-xl-9 col-md-8">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                        <h5 class="text-info fw-medium">IT Support</h5>
                        <div class="d-flex align-items-center">
                            <span class="badge badge-danger d-inline-flex align-items-center"><i
                                    class="ti ti-circle-filled fs-5 me-1"></i>High</span>

                        </div>
                    </div>
                    <div class="card-body">
                        <div>
                            <span class="badge badge-info rounded-pill mb-2">Tic - 001</span>
                            <div class="d-flex align-items-center mb-2">
                                <h5 class="fw-semibold me-2"><a href="ticket-details.html">Laptop Issue</a></h5>
                                <span class="badge bg-outline-pink d-flex align-items-center ms-1"><i
                                        class="ti ti-circle-filled fs-5 me-1"></i>Open</span>
                            </div>
                            <div class="d-flex align-items-center flex-wrap row-gap-2">
                                <p class="d-flex align-items-center mb-0 me-2">
                                    <img src="{{ URL::asset('') }}assets/img/profiles/avatar-03.jpg"
                                        class="avatar avatar-xs rounded-circle me-2" alt="img"> Assigned to <span
                                        class="text-dark ms-1"> Edgar Hansel</span>
                                </p>
                                <p class="d-flex align-items-center mb-0 me-2"><i
                                        class="ti ti-calendar-bolt me-1"></i>Updated 10 hours ago</p>
                                <p class="d-flex align-items-center mb-0"><i class="ti ti-message-share me-1"></i>9
                                    Comments</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                        <h5 class="text-info fw-medium">IT Support</h5>
                        <div class="d-flex align-items-center">
                            <span class="badge badge-success d-inline-flex align-items-center"><i
                                    class="ti ti-circle-filled fs-5 me-1"></i>Low</span>

                        </div>
                    </div>
                    <div class="card-body">
                        <div>
                            <span class="badge badge-info rounded-pill mb-2">Tic - 002</span>
                            <div class="d-flex align-items-center mb-2">
                                <h5 class="fw-semibold me-2"><a href="ticket-details.html">Payment Issue</a></h5>
                                <span class="badge bg-outline-warning d-flex align-items-center ms-1"><i
                                        class="ti ti-circle-filled fs-5 me-1"></i>On Hold</span>
                            </div>
                            <div class="d-flex align-items-center flex-wrap row-gap-2">
                                <p class="d-flex align-items-center mb-0 me-2">
                                    <img src="{{ URL::asset('') }}assets/img/profiles/avatar-01.jpg"
                                        class="avatar avatar-xs rounded-circle me-2" alt="img"> Assigned to <span
                                        class="text-dark ms-1">Ann Lynch</span>
                                </p>
                                <p class="d-flex align-items-center mb-0 me-2"><i
                                        class="ti ti-calendar-bolt me-1"></i>Updated 15 hours ago</p>
                                <p class="d-flex align-items-center mb-0"><i class="ti ti-message-share me-1"></i>9
                                    Comments</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                        <h5 class="text-info fw-medium">IT Support</h5>
                        <div class="d-flex align-items-center">
                            <span class="badge badge-warning d-inline-flex align-items-center"><i
                                    class="ti ti-circle-filled fs-5 me-1"></i>Medium</span>

                        </div>
                    </div>
                    <div class="card-body">
                        <div>
                            <span class="badge badge-info rounded-pill mb-2">Tic - 003</span>
                            <div class="d-flex align-items-center mb-2">
                                <h5 class="fw-semibold me-2"><a href="ticket-details.html">Bug Report</a></h5>
                                <span class="badge bg-outline-purple d-flex align-items-center ms-1"><i
                                        class="ti ti-circle-filled fs-5 me-1"></i>Reopened</span>
                            </div>
                            <div class="d-flex align-items-center flex-wrap row-gap-2">
                                <p class="d-flex align-items-center mb-0 me-2">
                                    <img src="{{ URL::asset('') }}assets/img/profiles/avatar-06.jpg"
                                        class="avatar avatar-xs rounded-circle me-2" alt="img"> Assigned to <span
                                        class="text-dark ms-1">Juan Hermann</span>
                                </p>
                                <p class="d-flex align-items-center mb-0 me-2"><i
                                        class="ti ti-calendar-bolt me-1"></i>Updated 20 hours ago</p>
                                <p class="d-flex align-items-center mb-0"><i class="ti ti-message-share me-1"></i>9
                                    Comments</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                        <h5 class="text-info fw-medium">IT Support</h5>
                        <div class="d-flex align-items-center">
                            <span class="badge badge-success d-inline-flex align-items-center"><i
                                    class="ti ti-circle-filled fs-5 me-1"></i>Low</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div>
                            <span class="badge badge-info rounded-pill mb-2">Tic - 004</span>
                            <div class="d-flex align-items-center mb-2">
                                <h5 class="fw-semibold me-2"><a href="ticket-details.html">Access Denied</a></h5>
                                <span class="badge bg-outline-pink d-flex align-items-center ms-1"><i
                                        class="ti ti-circle-filled fs-5 me-1"></i>Open</span>
                            </div>
                            <div class="d-flex align-items-center flex-wrap row-gap-2">
                                <p class="d-flex align-items-center mb-0 me-2">
                                    <img src="{{ URL::asset('') }}assets/img/profiles/avatar-05.jpg"
                                        class="avatar avatar-xs rounded-circle me-2" alt="img"> Assigned to <span
                                        class="text-dark ms-1">Jessie Otero</span>
                                </p>
                                <p class="d-flex align-items-center mb-0 me-2"><i
                                        class="ti ti-calendar-bolt me-1"></i>Updated 23 hours ago</p>
                                <p class="d-flex align-items-center mb-0"><i class="ti ti-message-share me-1"></i>9
                                    Comments</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center mb-4">
                    <a href="#" class="btn btn-primary"><i class="ti ti-loader-3 me-1"></i>Load More</a>
                </div>
            </div>
            <div class="col-xl-3 col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h4>Ticket Categories</h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="d-flex flex-column">
                            <div class="d-flex align-items-center justify-content-between border-bottom p-3">
                                <a href="javascript:void(0);">Internet Issue</a>
                                <div class="d-flex align-items-center">
                                    <span class="badge badge-xs bg-dark rounded-circle">0</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between border-bottom p-3">
                                <a href="javascript:void(0);">Computer</a>
                                <div class="d-flex align-items-center">
                                    <span class="badge badge-xs bg-dark rounded-circle">1</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between border-bottom p-3">
                                <a href="javascript:void(0);">Redistribute</a>
                                <div class="d-flex align-items-center">
                                    <span class="badge badge-xs bg-dark rounded-circle">0</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between border-bottom p-3">
                                <a href="javascript:void(0);">Payment</a>
                                <div class="d-flex align-items-center">
                                    <span class="badge badge-xs bg-dark rounded-circle">2</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between p-3">
                                <a href="javascript:void(0);">Complaint</a>
                                <div class="d-flex align-items-center">
                                    <span class="badge badge-xs bg-dark rounded-circle">1</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4>Support Agents</h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="d-flex flex-column">
                            <div class="d-flex align-items-center justify-content-between border-bottom p-3">
                                <span class="d-flex align-items-center">
                                    <img src="{{ URL::asset('') }}assets/img/profiles/avatar-01.jpg"
                                        class="avatar avatar-xs rounded-circle me-2" alt="img">Edgar Hansel
                                </span>
                                <div class="d-flex align-items-center">
                                    <span class="badge badge-xs bg-dark rounded-circle">0</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between border-bottom p-3">
                                <span class="d-flex align-items-center">
                                    <img src="{{ URL::asset('') }}assets/img/profiles/avatar-02.jpg"
                                        class="avatar avatar-xs rounded-circle me-2" alt="img">Ann Lynch
                                </span>
                                <div class="d-flex align-items-center">
                                    <span class="badge badge-xs bg-dark rounded-circle">1</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between border-bottom p-3">
                                <span class="d-flex align-items-center">
                                    <img src="{{ URL::asset('') }}assets/img/profiles/avatar-03.jpg"
                                        class="avatar avatar-xs rounded-circle me-2" alt="img">Juan Hermann
                                </span>
                                <div class="d-flex align-items-center">
                                    <span class="badge badge-xs bg-dark rounded-circle">0</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between p-3">
                                <span class="d-flex align-items-center">
                                    <img src="{{ URL::asset('') }}assets/img/profiles/avatar-04.jpg"
                                        class="avatar avatar-xs rounded-circle me-2" alt="img">Jessie Otero
                                </span>
                                <div class="d-flex align-items-center">
                                    <span class="badge badge-xs bg-dark rounded-circle">2</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Add Ticket -->
    <div class="modal fade" id="add_ticket">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Ticket</h4>
                    <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
                <form action="tickets.html">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Title</label>
                                    <input type="text" class="form-control" placeholder="Enter Title">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Event Category</label>
                                    <select class="select">
                                        <option>Select</option>
                                        <option>Internet Issue</option>
                                        <option>Redistribute</option>
                                        <option>Computer</option>
                                        <option>Complaint</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Subject</label>
                                    <input type="text" class="form-control" placeholder="Enter Subject">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Assign To</label>
                                    <input class="input-tags form-control" placeholder="Add new" type="text"
                                        data-role="tagsinput" name="Label" value="Vaughan Lewis">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Ticket Description</label>
                                    <textarea class="form-control" placeholder="Add Question"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Priority</label>
                                    <select class="select">
                                        <option>Select</option>
                                        <option>High</option>
                                        <option>Low</option>
                                        <option>Medium</option>
                                    </select>
                                </div>
                                <div class="mb-0">
                                    <label class="form-label">Status</label>
                                    <select class="select">
                                        <option>Select</option>
                                        <option>Closed</option>
                                        <option>Reopened</option>
                                        <option>Inprogress</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</a>
                        <button type="submit" class="btn btn-primary">Add Ticket</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /Add Ticket -->
@endsection
