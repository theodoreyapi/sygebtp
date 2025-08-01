@extends('layouts.master', ['title' => 'Mes Présences'])

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
        $(document).ready(function() {
            $('#punch-btn').click(function() {
                $.ajax({
                    url: "{{ route('attendance.punch') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        $('#punch-message').text(response.message).removeClass('text-danger')
                            .addClass('text-success');

                        // Mise à jour dynamique de l'affichage
                        if (response.data) {
                            $('.badge-primary').text('Production : ' + response.data
                                .productive_hours + ' hrs');
                            $('.punch-in-time').text('Punch In at ' + response.data.punch_in);
                            // tu peux aussi stocker dans des inputs cachés pour un affichage plus poussé
                        }
                    },
                    error: function(xhr) {
                        $('#punch-message').text("Erreur lors du pointage.").removeClass(
                            'text-success').addClass('text-danger');
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>

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
    <script src="{{ URL::asset('') }}assets/js/circle-progress.js"></script>
    <script src="{{ URL::asset('') }}assets/js/theme-colorpicker.js"></script>
    <script src="{{ URL::asset('') }}assets/js/script.js"></script>
@endpush

@section('content')
    <div class="content">

        <!-- Breadcrumb -->
        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
            <div class="my-auto mb-2">
                <h2 class="mb-1">Mes Présences</h2>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="index.html"><i class="ti ti-smart-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            Employé
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Mes Présences</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex my-xl-auto right-content align-items-center flex-wrap ">
                <div class="me-2 mb-2">
                    <div class="d-flex align-items-center border bg-white rounded p-1 me-2 icon-list">
                        <a href="attendance-admin.html" class="btn btn-icon btn-sm active bg-primary text-white me-1"><i
                                class="ti ti-brand-days-counter"></i></a>
                        <a href="attendance-admin.html" class="btn btn-icon btn-sm"><i class="ti ti-calendar-event"></i></a>
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
                                        class="ti ti-file-type-pdf me-1"></i>Exporter en PDF</a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item rounded-1"><i
                                        class="ti ti-file-type-xls me-1"></i>Exporter en Excel </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="mb-2">
                    <a href="#" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal"
                        data-bs-target="#attendance_report"><i class="ti ti-file-analytics me-2"></i>Rapport</a>
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

        <script>
            function updateDateTime() {
                const now = new Date();

                // Heure au format 24h avec les minutes
                const time = now.toLocaleTimeString('fr-FR', {
                    hour: '2-digit',
                    minute: '2-digit'
                }).replace(':', 'h'); // ex: 19:07 -> 19h07

                // Date formatée (jour, mois abrégé, année)
                const date = now.toLocaleDateString('fr-FR', {
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric'
                });

                document.getElementById('currentTime').textContent = `${time}, ${date}`;
            }

            // Mise à jour chaque minute
            setInterval(updateDateTime, 1000);
            updateDateTime();
        </script>

        <div class="row">
            <div class="col-xl-3 col-lg-4 d-flex">
                <div class="card flex-fill">
                    <div class="card-body">
                        <div class="mb-3 text-center">
                            <h6 class="fw-medium text-gray-5 mb-2">Bonjour, {{ Auth::user()->name }}</h6>
                            <h4 id="currentTime"></h4>
                        </div>
                        <div class="attendance-circle-progress mx-auto mb-3" data-value='65'>
                            <span class="progress-left">
                                <span class="progress-bar border-success"></span>
                            </span>
                            <span class="progress-right">
                                <span class="progress-bar border-success"></span>
                            </span>
                            <div class="avatar avatar-xxl avatar-rounded">
                                <img src="{{ URL::asset('') }}assets/img/profiles/avatar-27.jpg" alt="Img">
                            </div>
                        </div>
                        <div class="text-center" id="punch-section">
                            <div class="badge badge-md badge-primary mb-3"></div>
                            <h6 class="fw-medium d-flex align-items-center justify-content-center mb-3 punch-in-time">
                                <i class="ti ti-fingerprint text-primary me-1"></i>

                            </h6>

                            <button id="punch-btn" href="#" class="btn btn-dark w-100">Pointage entrée / Pointage
                                sortie</button>
                            <div id="punch-message" class="mt-2 text-success fw-bold"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-9 col-lg-8 d-flex">
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

        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                <h5>Mes présences</h5>
                {{-- <div class="d-flex my-xl-auto right-content align-items-center flex-wrap row-gap-3">
                    <div class="me-3">
                        <div class="input-icon-end position-relative">
                            <input type="text" class="form-control date-range bookingrange"
                                placeholder="dd/mm/yyyy - dd/mm/yyyy">
                            <span class="input-icon-addon">
                                <i class="ti ti-chevron-down"></i>
                            </span>
                        </div>
                    </div>
                    <div class="dropdown me-3">
                        <a href="javascript:void(0);"
                            class="dropdown-toggle btn btn-white d-inline-flex align-items-center"
                            data-bs-toggle="dropdown">
                            Select Status
                        </a>
                        <ul class="dropdown-menu  dropdown-menu-end p-3">
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item rounded-1">Present</a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item rounded-1">Absent</a>
                            </li>
                        </ul>
                    </div>
                    <div class="dropdown">
                        <a href="javascript:void(0);"
                            class="dropdown-toggle btn btn-white d-inline-flex align-items-center"
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
                </div> --}}
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
@endsection
