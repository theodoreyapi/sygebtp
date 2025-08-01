@extends('layouts.master', [
    'title' => 'Tableau de bord',
])

@push('csss')
    <!-- Summernote CSS -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/plugins/summernote/summernote-lite.min.css">

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/plugins/select2/css/select2.min.css">

    <!-- Bootstrap Tagsinput CSS -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/plugins/fontawesome/css/all.min.css">

    <!-- Datetimepicker CSS -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/css/bootstrap-datetimepicker.min.css">

    <!-- Daterangepikcer CSS -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/plugins/daterangepicker/daterangepicker.css">

    <!-- Color Picker Css -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/plugins/flatpickr/flatpickr.min.css">
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/plugins/@simonwep/pickr/themes/nano.min.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/css/style.css">
@endpush

@push('scripts')
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

    <!-- Slimscroll JS -->
    <script src="{{ URL::asset('') }}assets/js/jquery.slimscroll.min.js"></script>
    <script src="{{ URL::asset('') }}assets/plugins/daterangepicker/daterangepicker.js"></script>

    <!-- Select2 JS -->
    <script src="{{ URL::asset('') }}assets/plugins/select2/js/select2.min.js"></script>

    <!-- Chart JS -->
    <script src="{{ URL::asset('') }}assets/plugins/apexchart/apexcharts.min.js"></script>
    <script src="{{ URL::asset('') }}assets/plugins/apexchart/chart-data.js"></script>

    <!-- Datetimepicker JS -->
    <script src="{{ URL::asset('') }}assets/js/moment.js"></script>
    <script src="{{ URL::asset('') }}assets/js/bootstrap-datetimepicker.min.js"></script>

    <!-- Bootstrap Tagsinput JS -->
    <script src="{{ URL::asset('') }}assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>

    <!-- Summernote JS -->
    <script src="{{ URL::asset('') }}assets/plugins/summernote/summernote-lite.min.js"></script>

    <!-- Daterangepikcer JS -->
    <script src="{{ URL::asset('') }}assets/plugins/daterangepicker/daterangepicker.js"></script>

    <!-- Color Picker JS -->
    <script src="{{ URL::asset('') }}assets/plugins/@simonwep/pickr/pickr.es5.min.js"></script>

    <!-- Custom JS -->
    <script src="{{ URL::asset('') }}assets/js/circle-progress.js"></script>
    <script src="{{ URL::asset('') }}assets/js/todo.js"></script>
    <script src="{{ URL::asset('') }}assets/js/theme-colorpicker.js"></script>
    <script src="{{ URL::asset('') }}assets/js/script.js"></script>
@endpush

@section('content')
    <div class="content">

        <!-- Breadcrumb -->
        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
            <div class="my-auto mb-2">
                <h2 class="mb-1">Tableau de bord</h2>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="#"><i class="ti ti-smart-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            Tableau de bord
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Tableau de bord</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex my-xl-auto right-content align-items-center flex-wrap ">
                <div class="input-icon w-120 position-relative mb-2">
                    <span class="input-icon-addon">
                        <i class="ti ti-calendar text-gray-9"></i>
                    </span>
                    <input type="text" class="form-control datetimepicker" value="15 Apr 2025">
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

        {{-- <div class="alert bg-secondary-transparent alert-dismissible fade show mb-4">
            Votre demande de congé du “24 Avril 2024” a été approuvée !!!
            <button type="button" class="btn-close fs-14" data-bs-dismiss="alert" aria-label="Close"><i
                    class="ti ti-x"></i></button>
        </div> --}}
        <div class="row">
            <div class="col-xl-4 d-flex">
                <div class="card position-relative flex-fill">
                    <div class="card-header bg-dark">
                        <div class="d-flex align-items-center">
                            <span class="avatar avatar-lg avatar-rounded border border-white border-2 flex-shrink-0 me-2">
                                <img src="{{ Auth::user()->photo == '' ? URL::asset('assets/img/profiles/avatar-12.jpg') : url(Auth::user()->photo) }}"
                                    alt="Img">
                            </span>
                            <div>
                                <h5 class="text-white mb-1">{{ Auth::user()->name }} {{ Auth::user()->last_name }}</h5>
                                {{-- <div class="d-flex align-items-center">
                                    <p class="text-white fs-12 mb-0">Informatique</p>
                                    <span class="mx-1"><i class="ti ti-point-filled text-primary"></i></span>
                                    <p class="fs-12">Développeur Mobile</p>
                                </div> --}}
                            </div>
                        </div>
                        <a href="#" class="btn btn-icon btn-sm text-white rounded-circle edit-top"><i
                                class="ti ti-edit"></i></a>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <span class="d-block mb-1 fs-13">Numéro de téléphone</span>
                            <p class="text-gray-9">{{ Auth::user()->phone }}</p>
                        </div>
                        <div class="mb-3">
                            <span class="d-block mb-1 fs-13">Adresse email</span>
                            <p class="text-gray-9">{{ Auth::user()->email }}</p>
                        </div>
                        <div class="mb-3">
                            <span class="d-block mb-1 fs-13">Nationnalité</span>
                            <p class="text-gray-9">{{ Auth::user()->nationnalite }}</p>
                        </div>
                        <div>
                            <span class="d-block mb-1 fs-13">Date d'embauche</span>
                            <p class="text-gray-9">{{ Auth::user()->date_embauche }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-5 d-flex">
                <div class="card flex-fill">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between flex-wrap">
                            <h5>Membre de l'équipe</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-4 row">
                            @foreach ($membres as $membre)
                                <div class="d-flex align-items-center col-md-6">
                                    <a href="javascript:void(0);" class="avatar flex-shrink-0">
                                        <img src="{{ $membre->photo == '' ? URL::asset('assets/img/profiles/avatar-12.jpg') : url($membre->photo) }}"
                                            class="rounded-circle border border-2" alt="img">
                                    </a>
                                    <div class="ms-2">
                                        <h6 class="fs-14 fw-medium text-truncate mb-1"><a href="#">
                                                {{ $membre->name }} {{ $membre->last_name }}</a>
                                            </a>
                                        </h6>
                                        <p class="fs-13">{{ $membre->department_name }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 d-flex">
                <div class="flex-fill">
                    <div class="card card-bg-5 bg-dark mb-3">
                        @if ($todayBirthdays)
                            <div class="card-body">
                                <div class="text-center">
                                    <h5 class="text-white mb-4">Anniversaire de l'équipe</h5>
                                    <span class="avatar avatar-xl avatar-rounded mb-2">
                                        <img src="assets/img/users/user-35.jpg" alt="Img">
                                    </span>
                                    <div class="mb-3">
                                        <h6 class="text-white fw-medium mb-1">{{ $todayBirthdays->name }}
                                            {{ $todayBirthdays->last_name }}</h6>
                                        <p>{{ $todayBirthdays->name_designation }}</p>
                                    </div>
                                    <a href="#" class="btn btn-sm btn-primary">Envoyer des vœux</a>
                                </div>
                            </div>
                        @else
                            <div class="card-body">
                                <div class="text-center">
                                    <h5 class="text-white mb-4">🎂 Aucun Anniversaire disponible</h5>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="card bg-secondary mb-3">
                        <div class="card-body d-flex align-items-center justify-content-between p-3">
                            <div>
                                <h5 class="text-white mb-1">Politique de congé</h5>
                                <p class="text-white">Dernière mise à jour : aujourd'hui</p>
                            </div>
                            <a href="#" class="btn btn-white btn-sm px-3">Tout voir</a>
                        </div>
                    </div>
                    <div class="card bg-warning">
                        <div class="card-body d-flex align-items-center justify-content-between p-3">
                            <div>
                                <h5 class="mb-1">Prochain férié</h5>
                                @if ($nextHoliday)
                                    <p class="text-gray-9">
                                        {{ $nextHoliday->title }},
                                        {{ \Carbon\Carbon::parse($nextHoliday->date)->translatedFormat('d F Y') }}
                                    </p>
                                @else
                                    <p class="text-gray-9">Aucun jour férié prévu</p>
                                @endif
                            </div>
                            {{-- <a href="{{ url('holidays') }}" class="btn btn-white btn-sm px-3">Tout voir</a> --}}
                        </div>
                    </div>

                </div>
            </div>
            {{-- <div class="col-xl-5 d-flex">
                <div class="card flex-fill">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between flex-wrap row-gap-2">
                            <h5>Détails du congé</h5>
                            <div class="dropdown">
                                <a href="javascript:void(0);"
                                    class="btn btn-white border btn-sm d-inline-flex align-items-center"
                                    data-bs-toggle="dropdown">
                                    <i class="ti ti-calendar me-1"></i>2024
                                </a>
                                <ul class="dropdown-menu  dropdown-menu-end p-3">
                                    <li>
                                        <a href="javascript:void(0);" class="dropdown-item rounded-1">2024</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="dropdown-item rounded-1">2023</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="dropdown-item rounded-1">2022</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <div class="mb-3">
                                        <p class="d-flex align-items-center"><i
                                                class="ti ti-circle-filled fs-8 text-dark me-1"></i>
                                            <span class="text-gray-9 fw-semibold me-1">1254</span>
                                            à l'heure
                                        </p>
                                    </div>
                                    <div class="mb-3">
                                        <p class="d-flex align-items-center"><i
                                                class="ti ti-circle-filled fs-8 text-success me-1"></i>
                                            <span class="text-gray-9 fw-semibold me-1">32</span>
                                            retards de présence
                                        </p>
                                    </div>
                                    <div class="mb-3">
                                        <p class="d-flex align-items-center"><i
                                                class="ti ti-circle-filled fs-8 text-primary me-1"></i>
                                            <span class="text-gray-9 fw-semibold me-1">658</span>
                                            Télétravail
                                        </p>
                                    </div>
                                    <div class="mb-3">
                                        <p class="d-flex align-items-center"><i
                                                class="ti ti-circle-filled fs-8 text-danger me-1"></i>
                                            <span class="text-gray-9 fw-semibold me-1">14</span>
                                            Absent
                                        </p>
                                    </div>
                                    <div>
                                        <p class="d-flex align-items-center"><i
                                                class="ti ti-circle-filled fs-8 text-warning me-1"></i>
                                            <span class="text-gray-9 fw-semibold me-1">68</span>
                                            Congé de maladie
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3 d-flex justify-content-md-end">
                                    <div id="leaves_chart"></div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="checkbox" id="todo1">
                                    <label class="form-check-label" for="todo1">Mieux que <span
                                            class="text-gray-9">85%</span> des employés</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 d-flex">
                <div class="card flex-fill">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between flex-wrap row-gap-2">
                            <h5>Détails du congé</h5>
                            <div class="dropdown">
                                <a href="javascript:void(0);"
                                    class="btn btn-white border btn-sm d-inline-flex align-items-center"
                                    data-bs-toggle="dropdown">
                                    <i class="ti ti-calendar me-1"></i>2024
                                </a>
                                <ul class="dropdown-menu  dropdown-menu-end p-3">
                                    <li>
                                        <a href="javascript:void(0);" class="dropdown-item rounded-1">2024</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="dropdown-item rounded-1">2023</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="dropdown-item rounded-1">2022</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-sm-6">
                                <div class="mb-4">
                                    <span class="d-block mb-1">Total des feuilles</span>
                                    <h4>16</h4>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-4">
                                    <span class="d-block mb-1">Pris</span>
                                    <h4>10</h4>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-4">
                                    <span class="d-block mb-1">Absent</span>
                                    <h4>2</h4>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-4">
                                    <span class="d-block mb-1">Demandes</span>
                                    <h4>0</h4>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-4">
                                    <span class="d-block mb-1">Jours travaillés</span>
                                    <h4>240</h4>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-4">
                                    <span class="d-block mb-1">Perte de salaire</span>
                                    <h4>2</h4>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div>
                                    <a href="#" class="btn btn-dark w-100" data-bs-toggle="modal"
                                        data-bs-target="#add_leaves">Demander un nouveau congé</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
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
        {{-- <div class="row">
            <div class="col-xl-6 d-flex">
                <div class="card flex-fill">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between flex-wrap row-gap-2">
                            <h5>Projects</h5>
                            <div class="dropdown">
                                <a href="javascript:void(0);"
                                    class="btn btn-white border-0 dropdown-toggle border btn-sm d-inline-flex align-items-center"
                                    data-bs-toggle="dropdown">
                                    Ongoing Projects
                                </a>
                                <ul class="dropdown-menu  dropdown-menu-end p-3">
                                    <li>
                                        <a href="javascript:void(0);" class="dropdown-item rounded-1">All Projects</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="dropdown-item rounded-1">Ongoing Projects</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card mb-4 shadow-none mb-md-0">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <h6>Office Management</h6>
                                            <div class="dropdown">
                                                <a href="javascript:void(0);" class="d-inline-flex align-items-center"
                                                    data-bs-toggle="dropdown">
                                                    <i class="ti ti-dots-vertical"></i>
                                                </a>
                                                <ul class="dropdown-menu dropdown-menu-end p-3">
                                                    <li>
                                                        <a href="javascript:void(0);" class="dropdown-item rounded-1"
                                                            data-bs-toggle="modal" data-bs-target="#edit_task"><i
                                                                class="ti ti-edit me-2"></i>Edit</a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);" class="dropdown-item rounded-1"
                                                            data-bs-toggle="modal" data-bs-target="#delete_modal"><i
                                                                class="ti ti-trash me-2"></i>Delete</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="d-flex align-items-center mb-3">
                                                <a href="javascript:void(0);" class="avatar">
                                                    <img src="assets/img/users/user-32.jpg"
                                                        class="img-fluid rounded-circle" alt="img">
                                                </a>
                                                <div class="ms-2">
                                                    <h6 class="fw-normal"><a href="javascript:void(0);">Anthony Lewis</a>
                                                    </h6>
                                                    <span class="fs-13 d-block">Project Leader</span>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center mb-3">
                                                <a href="javascript:void(0);"
                                                    class="avatar bg-soft-primary rounded-circle">
                                                    <i class="ti ti-calendar text-primary fs-16"></i>
                                                </a>
                                                <div class="ms-2">
                                                    <h6 class="fw-normal">14 Jan 2024</h6>
                                                    <span class="fs-13 d-block">Deadline</span>
                                                </div>
                                            </div>
                                            <div
                                                class="d-flex align-items-center justify-content-between bg-transparent-light border border-dashed rounded p-2 mb-3">
                                                <div class="d-flex align-items-center">
                                                    <span
                                                        class="avatar avatar-sm bg-success-transparent rounded-circle me-1"><i
                                                            class="ti ti-checklist fs-16"></i></span>
                                                    <p>Tasks : <span class="text-gray-9">6 </span> /10</p>
                                                </div>
                                                <div class="avatar-list-stacked avatar-group-sm">
                                                    <span class="avatar avatar-rounded">
                                                        <img class="border border-white"
                                                            src="assets/img/profiles/avatar-06.jpg" alt="img">
                                                    </span>
                                                    <span class="avatar avatar-rounded">
                                                        <img class="border border-white"
                                                            src="assets/img/profiles/avatar-07.jpg" alt="img">
                                                    </span>
                                                    <span class="avatar avatar-rounded">
                                                        <img class="border border-white"
                                                            src="assets/img/profiles/avatar-08.jpg" alt="img">
                                                    </span>
                                                    <a class="avatar bg-primary avatar-rounded text-fixed-white fs-12 fw-medium"
                                                        href="javascript:void(0);">
                                                        +2
                                                    </a>
                                                </div>
                                            </div>
                                            <div
                                                class="bg-soft-secondary p-2 rounded d-flex align-items-center justify-content-between">
                                                <p class="text-secondary mb-0 text-truncate">Time Spent</p>
                                                <h5 class="text-secondary text-truncate">65/120 <span
                                                        class="fs-14 fw-normal">Hrs</span></h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card shadow-none mb-0">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <h6>Office Management</h6>
                                            <div class="dropdown">
                                                <a href="javascript:void(0);" class="d-inline-flex align-items-center"
                                                    data-bs-toggle="dropdown">
                                                    <i class="ti ti-dots-vertical"></i>
                                                </a>
                                                <ul class="dropdown-menu dropdown-menu-end p-3">
                                                    <li>
                                                        <a href="javascript:void(0);" class="dropdown-item rounded-1"
                                                            data-bs-toggle="modal" data-bs-target="#edit_task"><i
                                                                class="ti ti-edit me-2"></i>Edit</a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);" class="dropdown-item rounded-1"
                                                            data-bs-toggle="modal" data-bs-target="#delete_modal"><i
                                                                class="ti ti-trash me-2"></i>Delete</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div>
                                            <div class="d-flex align-items-center mb-3">
                                                <a href="javascript:void(0);" class="avatar">
                                                    <img src="assets/img/users/user-33.jpg"
                                                        class="img-fluid rounded-circle" alt="img">
                                                </a>
                                                <div class="ms-2">
                                                    <h6 class="fw-normal"><a href="javascript:void(0);">Anthony Lewis</a>
                                                    </h6>
                                                    <span class="fs-13 d-block">Project Leader</span>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center mb-3">
                                                <a href="javascript:void(0);"
                                                    class="avatar bg-soft-primary rounded-circle">
                                                    <i class="ti ti-calendar text-primary fs-16"></i>
                                                </a>
                                                <div class="ms-2">
                                                    <h6 class="fw-normal">14 Jan 2024</h6>
                                                    <span class="fs-13 d-block">Deadline</span>
                                                </div>
                                            </div>
                                            <div
                                                class="d-flex align-items-center justify-content-between bg-transparent-light border border-dashed rounded p-2 mb-3">
                                                <div class="d-flex align-items-center">
                                                    <span
                                                        class="avatar avatar-sm bg-success-transparent rounded-circle me-1"><i
                                                            class="ti ti-checklist fs-16"></i></span>
                                                    <p>Tasks : <span class="text-gray-9">6 </span> /10</p>
                                                </div>
                                                <div class="avatar-list-stacked avatar-group-sm">
                                                    <span class="avatar avatar-rounded">
                                                        <img class="border border-white"
                                                            src="assets/img/profiles/avatar-06.jpg" alt="img">
                                                    </span>
                                                    <span class="avatar avatar-rounded">
                                                        <img class="border border-white"
                                                            src="assets/img/profiles/avatar-07.jpg" alt="img">
                                                    </span>
                                                    <span class="avatar avatar-rounded">
                                                        <img class="border border-white"
                                                            src="assets/img/profiles/avatar-08.jpg" alt="img">
                                                    </span>
                                                    <a class="avatar bg-primary avatar-rounded text-fixed-white fs-12 fw-medium"
                                                        href="javascript:void(0);">
                                                        +2
                                                    </a>
                                                </div>
                                            </div>
                                            <div
                                                class="bg-soft-secondary p-2 rounded d-flex align-items-center justify-content-between">
                                                <p class="text-secondary mb-0 text-truncate">Time Spent</p>
                                                <h5 class="text-secondary text-truncate">65/120 <span
                                                        class="fs-14 fw-normal">Hrs</span></h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 d-flex">
                <div class="card flex-fill">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between flex-wrap row-gap-2">
                            <h5>Tasks</h5>
                            <div class="dropdown">
                                <a href="javascript:void(0);"
                                    class="btn btn-white border-0 dropdown-toggle border btn-sm d-inline-flex align-items-center"
                                    data-bs-toggle="dropdown">
                                    All Projects
                                </a>
                                <ul class="dropdown-menu  dropdown-menu-end p-3">
                                    <li>
                                        <a href="javascript:void(0);" class="dropdown-item rounded-1">All Projects</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="dropdown-item rounded-1">Ongoing Projects</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item border rounded mb-3 p-2">
                                <div class="row align-items-center row-gap-3">
                                    <div class="col-md-8">
                                        <div class="todo-inbox-check d-flex align-items-center">
                                            <span><i class="ti ti-grid-dots me-2"></i></span>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox">
                                            </div>
                                            <span class="me-2 d-flex align-items-center rating-select"><i
                                                    class="ti ti-star-filled filled"></i></span>
                                            <div class="strike-info">
                                                <h4 class="fs-14 text-truncate">Patient appointment booking</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="d-flex align-items-center justify-content-md-end flex-wrap row-gap-3">
                                            <span class="badge bg-soft-pink d-inline-flex align-items-center me-2"><i
                                                    class="fas fa-circle fs-6 me-1"></i>Onhold</span>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-list-stacked avatar-group-sm">
                                                    <span class="avatar avatar-rounded">
                                                        <img class="border border-white"
                                                            src="assets/img/profiles/avatar-13.jpg" alt="img">
                                                    </span>
                                                    <span class="avatar avatar-rounded">
                                                        <img class="border border-white"
                                                            src="assets/img/profiles/avatar-14.jpg" alt="img">
                                                    </span>
                                                    <span class="avatar avatar-rounded">
                                                        <img class="border border-white"
                                                            src="assets/img/profiles/avatar-15.jpg" alt="img">
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item border rounded mb-3 p-2">
                                <div class="row align-items-center row-gap-3">
                                    <div class="col-md-8">
                                        <div class="todo-inbox-check d-flex align-items-center">
                                            <span><i class="ti ti-grid-dots me-2"></i></span>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox">
                                            </div>
                                            <span class="me-2 rating-select d-flex align-items-center"><i
                                                    class="ti ti-star"></i></span>
                                            <div class="strike-info">
                                                <h4 class="fs-14 text-truncate">Appointment booking with payment</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="d-flex align-items-center justify-content-md-end flex-wrap row-gap-3">
                                            <span class="badge bg-transparent-purple d-flex align-items-center me-2"><i
                                                    class="fas fa-circle fs-6 me-1"></i>Inprogress</span>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-list-stacked avatar-group-sm">
                                                    <span class="avatar avatar-rounded">
                                                        <img class="border border-white"
                                                            src="assets/img/profiles/avatar-20.jpg" alt="img">
                                                    </span>
                                                    <span class="avatar avatar-rounded">
                                                        <img class="border border-white"
                                                            src="assets/img/profiles/avatar-21.jpg" alt="img">
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item border rounded mb-3 p-2">
                                <div class="row align-items-center row-gap-3">
                                    <div class="col-md-8">
                                        <div class="todo-inbox-check d-flex align-items-center">
                                            <span><i class="ti ti-grid-dots me-2"></i></span>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox">
                                            </div>
                                            <span class="me-2 rating-select d-flex align-items-center"><i
                                                    class="ti ti-star"></i></span>
                                            <div class="strike-info">
                                                <h4 class="fs-14 text-truncate">Patient and Doctor video conferencing</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="d-flex align-items-center justify-content-md-end flex-wrap row-gap-3">
                                            <span class="badge badge-soft-success align-items-center me-2"><i
                                                    class="fas fa-circle fs-6 me-1"></i>Completed</span>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-list-stacked avatar-group-sm">
                                                    <span class="avatar avatar-rounded">
                                                        <img class="border border-white"
                                                            src="assets/img/profiles/avatar-28.jpg" alt="img">
                                                    </span>
                                                    <span class="avatar avatar-rounded">
                                                        <img class="border border-white"
                                                            src="assets/img/profiles/avatar-29.jpg" alt="img">
                                                    </span>
                                                    <span class="avatar avatar-rounded">
                                                        <img class="border border-white"
                                                            src="assets/img/profiles/avatar-24.jpg" alt="img">
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item border rounded mb-3 p-2">
                                <div class="row align-items-center row-gap-3">
                                    <div class="col-md-8">
                                        <div class="todo-inbox-check d-flex align-items-center todo-strike-content">
                                            <span><i class="ti ti-grid-dots me-2"></i></span>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" checked="">
                                            </div>
                                            <span class="me-2 rating-select d-flex align-items-center"><i
                                                    class="ti ti-star"></i></span>
                                            <div class="strike-info">
                                                <h4 class="fs-14 text-truncate">Private chat module</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="d-flex align-items-center justify-content-md-end flex-wrap row-gap-3">
                                            <span
                                                class="badge badge-secondary-transparent d-flex align-items-center me-2"><i
                                                    class="fas fa-circle fs-6 me-1"></i>Pending</span>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-list-stacked avatar-group-sm">
                                                    <span class="avatar avatar-rounded">
                                                        <img class="border border-white"
                                                            src="assets/img/profiles/avatar-23.jpg" alt="img">
                                                    </span>
                                                    <span class="avatar avatar-rounded">
                                                        <img class="border border-white"
                                                            src="assets/img/profiles/avatar-24.jpg" alt="img">
                                                    </span>
                                                    <span class="avatar avatar-rounded">
                                                        <img class="border border-white"
                                                            src="assets/img/profiles/avatar-25.jpg" alt="img">
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item border rounded p-2">
                                <div class="row align-items-center row-gap-3">
                                    <div class="col-md-8">
                                        <div class="todo-inbox-check d-flex align-items-center">
                                            <span><i class="ti ti-grid-dots me-2"></i></span>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox">
                                            </div>
                                            <span class="me-2 rating-select d-flex align-items-center"><i
                                                    class="ti ti-star"></i></span>
                                            <div class="strike-info">
                                                <h4 class="fs-14 text-truncate">Go-Live and Post-Implementation Support
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="d-flex align-items-center justify-content-md-end flex-wrap row-gap-3">
                                            <span class="badge bg-transparent-purple d-flex align-items-center me-2"><i
                                                    class="fas fa-circle fs-6 me-1"></i>Inprogress</span>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-list-stacked avatar-group-sm">
                                                    <span class="avatar avatar-rounded">
                                                        <img class="border border-white"
                                                            src="assets/img/profiles/avatar-28.jpg" alt="img">
                                                    </span>
                                                    <span class="avatar avatar-rounded">
                                                        <img class="border border-white"
                                                            src="assets/img/profiles/avatar-29.jpg" alt="img">
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        <div class="row">
            {{-- <div class="col-xl-5 d-flex">
                <div class="card flex-fill">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between flex-wrap row-gap-2">
                            <h5>Performance</h5>
                            <div class="dropdown">
                                <a href="javascript:void(0);"
                                    class="btn btn-white border btn-sm d-inline-flex align-items-center"
                                    data-bs-toggle="dropdown">
                                    <i class="ti ti-calendar me-1"></i>2024
                                </a>
                                <ul class="dropdown-menu  dropdown-menu-end p-3">
                                    <li>
                                        <a href="javascript:void(0);" class="dropdown-item rounded-1">2024</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="dropdown-item rounded-1">2023</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="dropdown-item rounded-1">2022</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div>
                            <div class="bg-light d-flex align-items-center rounded p-2">
                                <h3 class="me-2">98%</h3>
                                <span
                                    class="badge badge-outline-success bg-success-transparent rounded-pill me-1">12%</span>
                                <span>vs last years</span>
                            </div>
                            <div id="performance_chart2"></div>
                        </div>
                    </div>
                </div>
            </div> --}}
            {{-- <div class="col-xl-4 d-flex">
                <div class="card flex-fill">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between flex-wrap row-gap-2">
                            <h5>My Skills</h5>
                            <div class="dropdown">
                                <a href="javascript:void(0);"
                                    class="btn btn-white border btn-sm d-inline-flex align-items-center"
                                    data-bs-toggle="dropdown">
                                    <i class="ti ti-calendar me-1"></i>2024
                                </a>
                                <ul class="dropdown-menu  dropdown-menu-end p-3">
                                    <li>
                                        <a href="javascript:void(0);" class="dropdown-item rounded-1">2024</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="dropdown-item rounded-1">2023</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="dropdown-item rounded-1">2022</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div>
                            <div class="border border-dashed bg-transparent-light rounded p-2 mb-2">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <span class="d-block border border-2 h-12 border-primary rounded-5 me-2"></span>
                                        <div>
                                            <h6 class="fw-medium mb-1">Figma</h6>
                                            <p>Updated : 15 May 2025</p>
                                        </div>
                                    </div>
                                    <div class="circle-progress circle-progress-md" data-value='95'>
                                        <span class="progress-left">
                                            <span class="progress-bar border-primary"></span>
                                        </span>
                                        <span class="progress-right">
                                            <span class="progress-bar border-primary"></span>
                                        </span>
                                        <div class="progress-value">95%</div>
                                    </div>
                                </div>
                            </div>
                            <div class="border border-dashed bg-transparent-light rounded p-2 mb-2">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <span class="d-block border border-2 h-12 border-success rounded-5 me-2"></span>
                                        <div>
                                            <h6 class="fw-medium mb-1">HTML</h6>
                                            <p>Updated : 12 May 2025</p>
                                        </div>
                                    </div>
                                    <div class="circle-progress circle-progress-md" data-value='85'>
                                        <span class="progress-left">
                                            <span class="progress-bar border-success"></span>
                                        </span>
                                        <span class="progress-right">
                                            <span class="progress-bar border-success"></span>
                                        </span>
                                        <div class="progress-value">85%</div>
                                    </div>
                                </div>
                            </div>
                            <div class="border border-dashed bg-transparent-light rounded p-2 mb-2">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <span class="d-block border border-2 h-12 border-purple rounded-5 me-2"></span>
                                        <div>
                                            <h6 class="fw-medium mb-1">CSS</h6>
                                            <p>Updated : 12 May 2025</p>
                                        </div>
                                    </div>
                                    <div class="circle-progress circle-progress-md" data-value='70'>
                                        <span class="progress-left">
                                            <span class="progress-bar border-purple"></span>
                                        </span>
                                        <span class="progress-right">
                                            <span class="progress-bar border-purple"></span>
                                        </span>
                                        <div class="progress-value">70%</div>
                                    </div>
                                </div>
                            </div>
                            <div class="border border-dashed bg-transparent-light rounded p-2 mb-2">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <span class="d-block border border-2 h-12 border-info rounded-5 me-2"></span>
                                        <div>
                                            <h6 class="fw-medium mb-1">Wordpress</h6>
                                            <p>Updated : 15 May 2025</p>
                                        </div>
                                    </div>
                                    <div class="circle-progress circle-progress-md" data-value='61'>
                                        <span class="progress-left">
                                            <span class="progress-bar border-info"></span>
                                        </span>
                                        <span class="progress-right">
                                            <span class="progress-bar border-info"></span>
                                        </span>
                                        <div class="progress-value">61%</div>
                                    </div>
                                </div>
                            </div>
                            <div class="border border-dashed bg-transparent-light rounded p-2">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <span class="d-block border border-2 h-12 border-dark rounded-5 me-2"></span>
                                        <div>
                                            <h6 class="fw-medium mb-1">Javascript</h6>
                                            <p>Updated : 13 May 2025</p>
                                        </div>
                                    </div>
                                    <div class="circle-progress circle-progress-md" data-value='58'>
                                        <span class="progress-left">
                                            <span class="progress-bar border-dark"></span>
                                        </span>
                                        <span class="progress-right">
                                            <span class="progress-bar border-dark"></span>
                                        </span>
                                        <div class="progress-value">58%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
            {{-- <div class="col-xl-4 d-flex">
                <div class="card flex-fill">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between flex-wrap">
                            <h5>Membre de l'équipe</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="d-flex align-items-center">
                                <a href="javascript:void(0);" class="avatar flex-shrink-0">
                                    <img src="assets/img/users/user-27.jpg" class="rounded-circle border border-2"
                                        alt="img">
                                </a>
                                <div class="ms-2">
                                    <h6 class="fs-14 fw-medium text-truncate mb-1"><a href="#">Alexander Jermai</a>
                                    </h6>
                                    <p class="fs-13">UI/UX Designer</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 d-flex">
                <div class="flex-fill">
                    <div class="card card-bg-5 bg-dark mb-3">
                        <div class="card-body">
                            <div class="text-center">
                                <h5 class="text-white mb-4">Anniversaire de l'équipe</h5>
                                <span class="avatar avatar-xl avatar-rounded mb-2">
                                    <img src="assets/img/users/user-35.jpg" alt="Img">
                                </span>
                                <div class="mb-3">
                                    <h6 class="text-white fw-medium mb-1">Andrew Jermia</h6>
                                    <p>IOS Developer</p>
                                </div>
                                <a href="#" class="btn btn-sm btn-primary">Envoyer des vœux</a>
                            </div>
                        </div>
                    </div>
                    <div class="card bg-secondary mb-3">
                        <div class="card-body d-flex align-items-center justify-content-between p-3">
                            <div>
                                <h5 class="text-white mb-1">Politique de congé</h5>
                                <p class="text-white">Dernière mise à jour : aujourd'hui</p>
                            </div>
                            <a href="#" class="btn btn-white btn-sm px-3">Tout voir</a>
                        </div>
                    </div>
                    <div class="card bg-warning">
                        <div class="card-body d-flex align-items-center justify-content-between p-3">
                            <div>
                                <h5 class="mb-1">Prochain férié</h5>
                                <p class="text-gray-9">Diwali, 15 septembre 2025</p>
                            </div>
                            <a href="{{ url('holidays') }}" class="btn btn-white btn-sm px-3">Tout voir</a>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
        {{-- <div class="row">
            <div class="col-xl-4 d-flex">
                <div class="card flex-fill">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between flex-wrap">
                            <h5>Team Members</h5>
                            <div>
                                <a href="#" class="btn btn-light btn-sm">View All</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="d-flex align-items-center">
                                <a href="javascript:void(0);" class="avatar flex-shrink-0">
                                    <img src="assets/img/users/user-27.jpg" class="rounded-circle border border-2"
                                        alt="img">
                                </a>
                                <div class="ms-2">
                                    <h6 class="fs-14 fw-medium text-truncate mb-1"><a href="#">Alexander Jermai</a>
                                    </h6>
                                    <p class="fs-13">UI/UX Designer</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <a href="#" class="btn btn-light btn-icon btn-sm me-2"><i
                                        class="ti ti-phone fs-16"></i></a>
                                <a href="#" class="btn btn-light btn-icon btn-sm me-2"><i
                                        class="ti ti-mail-bolt fs-16"></i></a>
                                <a href="#" class="btn btn-light btn-icon btn-sm"><i
                                        class="ti ti-brand-hipchat fs-16"></i></a>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="d-flex align-items-center">
                                <a href="javascript:void(0);" class="avatar flex-shrink-0">
                                    <img src="assets/img/users/user-42.jpg" class="rounded-circle border border-2"
                                        alt="img">
                                </a>
                                <div class="ms-2">
                                    <h6 class="fs-14 fw-medium text-truncate mb-1"><a href="#">Doglas Martini</a>
                                    </h6>
                                    <p class="fs-13">Product Designer</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <a href="#" class="btn btn-light btn-icon btn-sm me-2"><i
                                        class="ti ti-phone fs-16"></i></a>
                                <a href="#" class="btn btn-light btn-icon btn-sm me-2"><i
                                        class="ti ti-mail-bolt fs-16"></i></a>
                                <a href="#" class="btn btn-light btn-icon btn-sm"><i
                                        class="ti ti-brand-hipchat fs-16"></i></a>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="d-flex align-items-center">
                                <a href="javascript:void(0);" class="avatar flex-shrink-0">
                                    <img src="assets/img/users/user-43.jpg" class="rounded-circle border border-2"
                                        alt="img">
                                </a>
                                <div class="ms-2">
                                    <h6 class="fs-14 fw-medium text-truncate mb-1"><a href="#">Daniel Esbella</a>
                                    </h6>
                                    <p class="fs-13">Project Manager</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <a href="#" class="btn btn-light btn-icon btn-sm me-2"><i
                                        class="ti ti-phone fs-16"></i></a>
                                <a href="#" class="btn btn-light btn-icon btn-sm me-2"><i
                                        class="ti ti-mail-bolt fs-16"></i></a>
                                <a href="#" class="btn btn-light btn-icon btn-sm"><i
                                        class="ti ti-brand-hipchat fs-16"></i></a>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="d-flex align-items-center">
                                <a href="javascript:void(0);" class="avatar flex-shrink-0">
                                    <img src="assets/img/users/user-11.jpg" class="rounded-circle border border-2"
                                        alt="img">
                                </a>
                                <div class="ms-2">
                                    <h6 class="fs-14 fw-medium text-truncate mb-1"><a href="#">Daniel Esbella</a>
                                    </h6>
                                    <p class="fs-13">Team Lead</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <a href="#" class="btn btn-light btn-icon btn-sm me-2"><i
                                        class="ti ti-phone fs-16"></i></a>
                                <a href="#" class="btn btn-light btn-icon btn-sm me-2"><i
                                        class="ti ti-mail-bolt fs-16"></i></a>
                                <a href="#" class="btn btn-light btn-icon btn-sm"><i
                                        class="ti ti-brand-hipchat fs-16"></i></a>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="d-flex align-items-center">
                                <a href="javascript:void(0);" class="avatar flex-shrink-0">
                                    <img src="assets/img/users/user-44.jpg" class="rounded-circle border border-2"
                                        alt="img">
                                </a>
                                <div class="ms-2">
                                    <h6 class="fs-14 fw-medium text-truncate mb-1"><a href="#">Stephan Peralt</a>
                                    </h6>
                                    <p class="fs-13">Team Lead</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <a href="#" class="btn btn-light btn-icon btn-sm me-2"><i
                                        class="ti ti-phone fs-16"></i></a>
                                <a href="#" class="btn btn-light btn-icon btn-sm me-2"><i
                                        class="ti ti-mail-bolt fs-16"></i></a>
                                <a href="#" class="btn btn-light btn-icon btn-sm"><i
                                        class="ti ti-brand-hipchat fs-16"></i></a>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <a href="javascript:void(0);" class="avatar flex-shrink-0">
                                    <img src="assets/img/users/user-54.jpg" class="rounded-circle border border-2"
                                        alt="img">
                                </a>
                                <div class="ms-2">
                                    <h6 class="fs-14 fw-medium text-truncate mb-1"><a href="#">Andrew Jermia</a>
                                    </h6>
                                    <p class="fs-13">Project Lead</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <a href="#" class="btn btn-light btn-icon btn-sm me-2"><i
                                        class="ti ti-phone fs-16"></i></a>
                                <a href="#" class="btn btn-light btn-icon btn-sm me-2"><i
                                        class="ti ti-mail-bolt fs-16"></i></a>
                                <a href="#" class="btn btn-light btn-icon btn-sm"><i
                                        class="ti ti-brand-hipchat fs-16"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 d-flex">
                <div class="card flex-fill">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between flex-wrap">
                            <h5>Notifications</h5>
                            <div>
                                <a href="#" class="btn btn-light btn-sm">View All</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-start mb-4">
                            <a href="javascript:void(0);" class="avatar flex-shrink-0">
                                <img src="assets/img/users/user-27.jpg" class="rounded-circle border border-2"
                                    alt="img">
                            </a>
                            <div class="ms-2">
                                <h6 class="fs-14 fw-medium text-truncate mb-1">Lex Murphy requested access to UNIX </h6>
                                <p class="fs-13 mb-2">Today at 9:42 AM</p>
                                <div class="d-flex align-items-center">
                                    <a href="#" class="avatar avatar-sm border flex-shrink-0 me-2"><img
                                            src="assets/img/social/pdf-icon.svg" class="w-auto h-auto"
                                            alt="Img"></a>
                                    <h6 class="fw-normal"><a href="#">EY_review.pdf</a></h6>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-start mb-4">
                            <a href="javascript:void(0);" class="avatar flex-shrink-0">
                                <img src="assets/img/users/user-28.jpg" class="rounded-circle border border-2"
                                    alt="img">
                            </a>
                            <div class="ms-2">
                                <h6 class="fs-14 fw-medium text-truncate mb-1">Lex Murphy requested access to UNIX </h6>
                                <p class="fs-13 mb-0">Today at 10:00 AM</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-start mb-4">
                            <a href="javascript:void(0);" class="avatar flex-shrink-0">
                                <img src="assets/img/users/user-29.jpg" class="rounded-circle border border-2"
                                    alt="img">
                            </a>
                            <div class="ms-2">
                                <h6 class="fs-14 fw-medium text-truncate mb-1">Lex Murphy requested access to UNIX </h6>
                                <p class="fs-13 mb-2">Today at 10:50 AM</p>
                                <div class="d-flex align-items-center">
                                    <a href="#" class="btn btn-primary btn-sm me-2">Approve</a>
                                    <a href="#" class="btn btn-outline-primary btn-sm">Decline</a>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-start mb-4">
                            <a href="javascript:void(0);" class="avatar flex-shrink-0">
                                <img src="assets/img/users/user-30.jpg" class="rounded-circle border border-2"
                                    alt="img">
                            </a>
                            <div class="ms-2">
                                <h6 class="fs-14 fw-medium text-truncate mb-1">Lex Murphy requested access to UNIX </h6>
                                <p class="fs-13 mb-0">Today at 12:00 PM</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-start">
                            <a href="javascript:void(0);" class="avatar flex-shrink-0">
                                <img src="assets/img/users/user-33.jpg" class="rounded-circle border border-2"
                                    alt="img">
                            </a>
                            <div class="ms-2">
                                <h6 class="fs-14 fw-medium text-truncate mb-1">Lex Murphy requested access to UNIX </h6>
                                <p class="fs-13 mb-0">Today at 05:00 PM</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 d-flex">
                <div class="card flex-fill">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between flex-wrap row-gap-2">
                            <h5>Meetings Schedule</h5>
                            <div class="dropdown">
                                <a href="javascript:void(0);"
                                    class="btn btn-white border btn-sm d-inline-flex align-items-center"
                                    data-bs-toggle="dropdown">
                                    <i class="ti ti-calendar me-1"></i>Today
                                </a>
                                <ul class="dropdown-menu  dropdown-menu-end p-3">
                                    <li>
                                        <a href="javascript:void(0);" class="dropdown-item rounded-1">Today</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="dropdown-item rounded-1">This Month</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="dropdown-item rounded-1">This Year</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body schedule-timeline">
                        <div class="d-flex align-items-start">
                            <div class="d-flex align-items-center active-time">
                                <span>09:25 AM</span>
                                <span><i class="ti ti-point-filled text-primary fs-20"></i></span>
                            </div>
                            <div class="flex-fill ps-3 pb-4 timeline-flow">
                                <div class="bg-light p-2 rounded">
                                    <p class="fw-medium text-gray-9 mb-1">Marketing Strategy Presentation</p>
                                    <span>Marketing</span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-start">
                            <div class="d-flex align-items-center active-time">
                                <span>09:20 AM</span>
                                <span><i class="ti ti-point-filled text-secondary fs-20"></i></span>
                            </div>
                            <div class="flex-fill ps-3 pb-4 timeline-flow">
                                <div class="bg-light p-2 rounded">
                                    <p class="fw-medium text-gray-9 mb-1">Design Review Hospital, doctors Management
                                        Project</p>
                                    <span>Review</span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-start">
                            <div class="d-flex align-items-center active-time">
                                <span>09:18 AM</span>
                                <span><i class="ti ti-point-filled text-warning fs-20"></i></span>
                            </div>
                            <div class="flex-fill ps-3 pb-4 timeline-flow">
                                <div class="bg-light p-2 rounded">
                                    <p class="fw-medium text-gray-9 mb-1">Birthday Celebration of Employee</p>
                                    <span>Celebration</span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-start">
                            <div class="d-flex align-items-center active-time">
                                <span>09:10 AM</span>
                                <span><i class="ti ti-point-filled text-success fs-20"></i></span>
                            </div>
                            <div class="flex-fill ps-3 timeline-flow">
                                <div class="bg-light p-2 rounded">
                                    <p class="fw-medium text-gray-9 mb-1">Update of Project Flow</p>
                                    <span>Development</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
@endsection
