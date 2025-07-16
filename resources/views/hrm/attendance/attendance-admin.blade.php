@extends('layouts.master', ['title' => 'Presences'])

@push('csss')
    <!-- Tabler Icon CSS -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/plugins/tabler-icons/tabler-icons.css">

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/plugins/select2/css/select2.min.css">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/plugins/fontawesome/css/all.min.css">

    <!-- Datetimepicker CSS -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/css/bootstrap-datetimepicker.min.css">

    <!-- Color Picker Css -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/plugins/flatpickr/flatpickr.min.css">
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/plugins/@simonwep/pickr/themes/nano.min.css">

    <!-- Daterangepikcer CSS -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/plugins/daterangepicker/daterangepicker.css">

    <!-- Datatable CSS -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/css/dataTables.bootstrap5.min.css">

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/plugins/select2/css/select2.min.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/css/style.css">
@endpush
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('timelineStackedChart').getContext('2d');

        const labels = [
            @foreach ($states['timeline'] as $hour => $data)
                '{{ str_pad($hour, 2, '0', STR_PAD_LEFT) }}:00',
            @endforeach
        ];

        const productiveData = [
            @foreach ($states['timeline'] as $data)
                {{ round($data['productive'], 2) }},
            @endforeach
        ];

        const breakData = [
            @foreach ($states['timeline'] as $data)
                {{ round($data['break'], 2) }},
            @endforeach
        ];

        const overtimeData = [
            @foreach ($states['timeline'] as $data)
                {{ round($data['overtime'], 2) }},
            @endforeach
        ];

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                        label: 'Productifs',
                        data: productiveData,
                        backgroundColor: '#28a745' // Vert
                    },
                    {
                        label: 'Pause',
                        data: breakData,
                        backgroundColor: '#ffc107' // Jaune
                    },
                    {
                        label: 'Heures supplémentaires',
                        data: overtimeData,
                        backgroundColor: '#1B84FF' // Bleu
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        stacked: true
                    },
                    y: {
                        stacked: true,
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Heures'
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>

    <script>
        let timelineChart = null;

        function renderChart(data) {
            const ctx = document.getElementById('timelineStackedChart').getContext('2d');
            const labels = Object.keys(data).map(h => h.toString().padStart(2, '0') + ':00');
            const productiveData = Object.values(data).map(d => d.productive.toFixed(2));
            const breakData = Object.values(data).map(d => d.break.toFixed(2));
            const overtimeData = Object.values(data).map(d => d.overtime.toFixed(2));

            if (timelineChart !== null) {
                timelineChart.destroy();
            }

            timelineChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                            label: 'Productifs',
                            data: productiveData,
                            backgroundColor: '#28a745'
                        },
                        {
                            label: 'Pause',
                            data: breakData,
                            backgroundColor: '#ffc107'
                        },
                        {
                            label: 'Heures supplémentaires',
                            data: overtimeData,
                            backgroundColor: '#1B84FF'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            stacked: true
                        },
                        y: {
                            stacked: true,
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        }

        // Chargement initial
        $(document).ready(function() {
            fetchAndRenderChart($('#filter-date').val());

            $('#filter-form').on('submit', function(e) {
                e.preventDefault();
                let date = $('#filter-date').val();
                fetchAndRenderChart(date);
            });
        });

        function fetchAndRenderChart(date) {
            $.get("{{ route('attendance.timeline') }}", {
                date: date
            }, function(data) {
                renderChart(data);
            });
        }
    </script>

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

    <!-- Custom JS -->
    <script src="{{ URL::asset('') }}assets/js/theme-colorpicker.js"></script>
    <script src="{{ URL::asset('') }}assets/js/script.js"></script>
@endpush

@section('content')
    <div class="content">
        <!-- Breadcrumb -->
        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
            <div class="my-auto mb-2">
                <h2 class="mb-1">Administration des présences</h2>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="#"><i class="ti ti-smart-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            Employé
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Administration des présences</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex my-xl-auto right-content align-items-center flex-wrap ">
                <div class="me-2 mb-2">
                    <div class="d-flex align-items-center border bg-white rounded p-1 me-2 icon-list">
                        <a href="attendance-employee.html" class="btn btn-icon btn-sm  me-1"><i
                                class="ti ti-brand-days-counter"></i></a>
                        <a href="attendance-admin.html" class="btn btn-icon btn-sm active bg-primary text-white"><i
                                class="ti ti-calendar-event"></i></a>
                    </div>
                </div>
                <div class="me-2 mb-2">
                    <div class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle btn btn-white d-inline-flex align-items-center"
                            data-bs-toggle="dropdown">
                            <i class="ti ti-file-export me-1"></i>Exporter
                        </a>
                        <ul class="dropdown-menu  dropdown-menu-end p-3">
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item rounded-1"><i
                                        class="ti ti-file-type-pdf me-1"></i>Export en PDF</a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item rounded-1"><i
                                        class="ti ti-file-type-xls me-1"></i>Export en Excel </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="ms-2 head-icons">
                    <a href="javascript:void(0);" class="" data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-original-title="Collapse" id="collapse-header">
                        <i class="ti ti-chevrons-up"></i>
                    </a>
                </div>
            </div>
        </div>
        <!-- /Breadcrumb -->

        <div class="card border-0">
            <div class="card-body">
                <div class="row align-items-center mb-4">
                    <div class="col-md-5">
                        <div class="mb-3 mb-md-0">
                            <h4 class="mb-1">Détails de la présence aujourd'hui</h4>
                        </div>
                    </div>
                </div>
                <div class="border rounded">
                    <div class="row gx-0">
                        <div class="col-md col-sm-4 border-end">
                            <div class="p-3">
                                <span class="fw-medium mb-1 d-block">Présents</span>
                                <div class="d-flex align-items-center justify-content-between">
                                    <h5>{{ $presenceDetails['present'] }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md col-sm-4 border-end">
                            <div class="p-3">
                                <span class="fw-medium mb-1 d-block">Retardataires</span>
                                <div class="d-flex align-items-center justify-content-between">
                                    <h5>{{ $presenceDetails['late'] }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md col-sm-4">
                            <div class="p-3">
                                <span class="fw-medium mb-1 d-block">Absents</span>
                                <div class="d-flex align-items-center justify-content-between">
                                    <h5>{{ $presenceDetails['absent'] }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <form id="filter-form" class="d-flex align-items-center gap-2 mb-3">
            <input type="date" name="date" id="filter-date" class="form-control w-auto"
                value="{{ now()->toDateString() }}">
            <button type="submit" class="btn btn-primary">Filtrer</button>
        </form>


        <div class="row mt-4">
            <div class="col-md-12">
                <canvas id="timelineStackedChart" height="130"></canvas>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12 col-lg-12 d-flex">
                <div class="row flex-fill">
                    <div class="col-xl-4 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="border-bottom mb-2 pb-2">
                                    <span class="avatar avatar-sm bg-primary mb-2"><i class="ti ti-clock-stop"></i></span>
                                    <h2 class="mb-2">{{ number_format($stats['today'], 2) }} h</h2>
                                    <p class="fw-medium text-truncate">Nombre total d'heures aujourd'hui</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="border-bottom mb-2 pb-2">
                                    <span class="avatar avatar-sm bg-dark mb-2"><i class="ti ti-clock-up"></i></span>
                                    <h2 class="mb-2">{{ number_format($stats['week'], 2) }} h</h2>
                                    <p class="fw-medium text-truncate">Total cette semaine</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="border-bottom mb-2 pb-2">
                                    <span class="avatar avatar-sm bg-dark mb-2"><i class="ti ti-clock-up"></i></span>
                                    <h2 class="mb-2">{{ number_format($stats['month'], 2) }} h</h2>
                                    <p class="fw-medium text-truncate">Total ce mois-ci</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="border-bottom mb-2 pb-2">
                                    <span class="avatar avatar-sm bg-dark mb-2"><i class="ti ti-clock-up"></i></span>
                                    <h2 class="mb-2">{{ number_format($stats['productive_today'], 2) }} h</h2>
                                    <p class="fw-medium text-truncate">Heures productives aujourd'hui</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="border-bottom mb-2 pb-2">
                                    <span class="avatar avatar-sm bg-info mb-2"><i class="ti ti-calendar-up"></i></span>
                                    <h2 class="mb-2">{{ number_format($stats['break_today'], 2) }} h</h2>
                                    <p class="fw-medium text-truncate">Pause aujourd'hui</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="border-bottom mb-2 pb-2">
                                    <span class="avatar avatar-sm bg-pink mb-2"><i class="ti ti-calendar-star"></i></span>
                                    <h2 class="mb-2">{{ number_format($stats['overtime'], 2) }} h</h2>
                                    <p class="fw-medium text-truncate">Pause</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                <h5>Présence administrative</h5>
            </div>
            <div class="card-body p-0">
                <div class="custom-datatable-filter table-responsive">
                    @php
                        use Carbon\Carbon;
                    @endphp
                    <table class="table datatable">
                        <thead class="thead-light">
                            <tr>
                                <th>Date</th>
                                <th>Pointage entrée</th>
                                <th>Statut</th>
                                <th>Pointage sortie</th>
                                <th>Pause</th>
                                <th>Retard</th>
                                <th>Heure supplementaire</th>
                                <th>Heure de production</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($attendance as $att)
                                @php
                                    // Format date
                                    $dateFormatted = optional($att->date)->format('d M Y');

                                    // Format Check In / Out
                                    $checkIn = optional($att->punch_in_time)->format('h:i A') ?? '-';
                                    $checkOut = optional($att->punch_out_time)->format('h:i A') ?? '-';

                                    // Calcul du retard (Check In après 09:00)
                                    $expectedIn = $att->date
                                        ? Carbon::parse($att->date->format('Y-m-d') . ' 09:00:00')
                                        : null;
                                    $late =
                                        $att->punch_in_time && $expectedIn && $att->punch_in_time->gt($expectedIn)
                                            ? $att->punch_in_time->diffInMinutes($expectedIn)
                                            : null;

                                    // Break (formaté)
                                    $breakFormatted = $att->break_minutes ? $att->break_minutes . ' Min' : '-';

                                    // Overtime (en minutes)
                                    $overtimeFormatted = $att->overtime_hours
                                        ? round($att->overtime_hours * 60) . ' Min'
                                        : '-';

                                    // Productive hours (formaté)
                                    $productiveFormatted = number_format($att->productive_hours ?? 0, 2) . ' Hrs';

                                    // Badge couleur en fonction des heures productives
                                    $prodBadge = 'danger';
                                    if ($att->productive_hours >= 8) {
                                        $prodBadge = 'success';
                                    } elseif ($att->productive_hours >= 6) {
                                        $prodBadge = 'info';
                                    }
                                @endphp

                                <tr>
                                    <td>{{ $dateFormatted }}</td>
                                    <td>{{ $checkIn }}</td>
                                    <td>
                                        @if ($att->status == 'Present')
                                            <span class="badge badge-success-transparent d-inline-flex align-items-center">
                                                <i class="ti ti-point-filled me-1"></i>Present
                                            </span>
                                        @elseif($att->status == 'Absent')
                                            <span class="badge badge-danger-transparent d-inline-flex align-items-center">
                                                <i class="ti ti-point-filled me-1"></i>Absent
                                            </span>
                                        @else
                                            <span class="badge badge-secondary">-</span>
                                        @endif
                                    </td>
                                    <td>{{ $checkOut }}</td>
                                    <td>{{ $breakFormatted }}</td>
                                    <td>{{ $late ? $late . ' Min' : '-' }}</td>
                                    <td>{{ $overtimeFormatted }}</td>
                                    <td>
                                        <span class="badge badge-{{ $prodBadge }} d-inline-flex align-items-center">
                                            <i class="ti ti-clock-hour-11 me-1"></i>{{ $productiveFormatted }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <!-- Edit Attendance -->
    <div class="modal fade" id="edit_attendance">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Attendance</h4>
                    <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
                <form action="attendance-admin.html">
                    <div class="modal-body pb-0">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Date</label>
                                    <div class="input-icon position-relative w-100 me-2">
                                        <input type="text" class="form-control datetimepicker ps-3"
                                            value="15 Apr 2025">
                                        <span class="input-icon-addon">
                                            <i class="ti ti-calendar"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Check In</label>
                                    <div class="input-icon position-relative w-100">
                                        <input type="text" class="form-control timepicker ps-3" value="09:00 AM">
                                        <span class="input-icon-addon">
                                            <i class="ti ti-clock-hour-3"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Check Out</label>
                                    <div class="input-icon position-relative w-100">
                                        <input type="text" class="form-control timepicker ps-3" value="06:45 PM">
                                        <span class="input-icon-addon">
                                            <i class="ti ti-clock-hour-3"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Break</label>
                                    <input type="text" class="form-control" value="30 Min	">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Late</label>
                                    <input type="text" class="form-control" value="32 Min">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Production Hours</label>
                                    <div class="input-icon position-relative w-100">
                                        <input type="text" class="form-control timepicker ps-3" value="8.55 Hrs">
                                        <span class="input-icon-addon">
                                            <i class="ti ti-clock-hour-3"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3 ">
                                    <label class="form-label">Status</label>
                                    <select class="select">
                                        <option>Select</option>
                                        <option selected>Present</option>
                                        <option>Absent</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /Edit Attendance -->

    <!-- Attendance Report -->
    <div class="modal fade" id="attendance_report">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Attendance</h4>
                    <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card shadow-none bg-transparent-light">
                        <div class="card-body pb-1">
                            <div class="row align-items-center">
                                <div class="col-lg-4">
                                    <div class="d-flex align-items-center mb-3">
                                        <span class="avatar avatar-sm avatar-rounded flex-shrink-0 me-2">
                                            <img src="{{ URL::asset('') }}assets/img/profiles/avatar-02.jpg"
                                                alt="Img">
                                        </span>
                                        <div>
                                            <h6 class="fw-medium">Anthony Lewis</h6>
                                            <span>UI/UX Team</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="mb-3 text-sm-end">
                                                <span>Date</span>
                                                <p class="text-gray-9 fw-medium">15 Apr 2025</p>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="mb-3 text-sm-end">
                                                <span>Punch in at</span>
                                                <p class="text-gray-9 fw-medium">09:00 AM</p>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="mb-3 text-sm-end">
                                                <span>Punch out at</span>
                                                <p class="text-gray-9 fw-medium">06:45 PM</p>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="mb-3 text-sm-end">
                                                <span>Status</span>
                                                <p class="text-gray-9 fw-medium">Present</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow-none border mb-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-3">
                                    <div class="mb-4">
                                        <p class="d-flex align-items-center mb-1"><i
                                                class="ti ti-point-filled text-dark-transparent me-1"></i>Total
                                            Working hours</p>
                                        <h3>12h 36m</h3>
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="mb-4">
                                        <p class="d-flex align-items-center mb-1"><i
                                                class="ti ti-point-filled text-success me-1"></i>Productive Hours
                                        </p>
                                        <h3>08h 36m</h3>
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="mb-4">
                                        <p class="d-flex align-items-center mb-1"><i
                                                class="ti ti-point-filled text-warning me-1"></i>Break hours</p>
                                        <h3>22m 15s</h3>
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="mb-4">
                                        <p class="d-flex align-items-center mb-1"><i
                                                class="ti ti-point-filled text-info me-1"></i>Overtime</p>
                                        <h3>02h 15m</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8 mx-auto">
                                    <div class="progress bg-transparent-dark mb-3" style="height: 24px;">
                                        <div class="progress-bar bg-success rounded me-2" role="progressbar"
                                            style="width: 18%;"></div>
                                        <div class="progress-bar bg-warning rounded me-2" role="progressbar"
                                            style="width: 5%;"></div>
                                        <div class="progress-bar bg-success rounded me-2" role="progressbar"
                                            style="width: 28%;"></div>
                                        <div class="progress-bar bg-warning rounded me-2" role="progressbar"
                                            style="width: 17%;"></div>
                                        <div class="progress-bar bg-success rounded me-2" role="progressbar"
                                            style="width: 22%;"></div>
                                        <div class="progress-bar bg-warning rounded me-2" role="progressbar"
                                            style="width: 5%;"></div>
                                        <div class="progress-bar bg-info rounded me-2" role="progressbar"
                                            style="width: 3%;"></div>
                                        <div class="progress-bar bg-info rounded" role="progressbar" style="width: 2%;">
                                        </div>
                                    </div>

                                </div>
                                <div class="co-md-12">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <span class="fs-10">06:00</span>
                                        <span class="fs-10">07:00</span>
                                        <span class="fs-10">08:00</span>
                                        <span class="fs-10">09:00</span>
                                        <span class="fs-10">10:00</span>
                                        <span class="fs-10">11:00</span>
                                        <span class="fs-10">12:00</span>
                                        <span class="fs-10">01:00</span>
                                        <span class="fs-10">02:00</span>
                                        <span class="fs-10">03:00</span>
                                        <span class="fs-10">04:00</span>
                                        <span class="fs-10">05:00</span>
                                        <span class="fs-10">06:00</span>
                                        <span class="fs-10">07:00</span>
                                        <span class="fs-10">08:00</span>
                                        <span class="fs-10">09:00</span>
                                        <span class="fs-10">10:00</span>
                                        <span class="fs-10">11:00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Attendance Report -->
@endsection
