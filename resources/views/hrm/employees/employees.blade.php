@extends('layouts.master', [
    'title' => 'Employees',
])

@push('csss')
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    // employee
    <script>
        $(document).ready(function() {
            $('#employee-form').on('submit', function(e) {
                e.preventDefault();

                let formData = $(this).serialize();
                let submitBtn = $('#employee-form button[type=submit]');
                submitBtn.prop('disabled', true).text('Enregistrement...');

                // Nettoyage des anciennes alertes
                $('#ajax-alert-container').html('');

                $.ajax({
                    url: "{{ route('employees.store') }}",
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        // Fermer la modal
                        // $('#add_employee').modal('hide');

                        // Réinitialiser le formulaire
                        $('#employee-form')[0].reset();

                        // Recharger la liste sans recharger la page
                        $('#employee-list').load(location.href + " #employee-list>*", "");

                        // Afficher une alerte de succès
                        $('#ajax-alert-container').html(`
                        <div class="alert alert-success rounded-pill alert-dismissible fade show mt-3">
                            Vous avez ajouté un employé avec succès !
                            <button type="button" class="btn-close custom-close" data-bs-dismiss="alert" aria-label="Close">
                                <i class="fas fa-xmark"></i>
                            </button>
                        </div>
                    `);
                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON?.errors;
                        if (errors) {
                            for (const key in errors) {
                                $('#ajax-alert-container').append(`
                                <div class="alert alert-danger rounded-pill alert-dismissible fade show mt-2">
                                    ${errors[key][0]}
                                    <button type="button" class="btn-close custom-close" data-bs-dismiss="alert" aria-label="Close">
                                        <i class="fas fa-xmark text-white" style="color: #fff !important;"></i>
                                    </button>
                                </div>
                            `);
                            }
                        } else {
                            $('#ajax-alert-container').html(`
                            <div class="alert alert-danger rounded-pill alert-dismissible fade show mt-3">
                                Une erreur est survenue. Veuillez réessayer.
                                <button type="button" class="btn-close custom-close" data-bs-dismiss="alert" aria-label="Close">
                                    <i class="fas fa-xmark text-white" style="color: #fff !important;"></i>
                                </button>
                            </div>
                        `);
                        }
                    },
                    complete: function() {
                        submitBtn.prop('disabled', false).text('Enregistrer');
                    }
                });
            });
        });

        $(document).ready(function() {
            // ⚠️ Utilise "on" sur document pour intercepter tous les nouveaux éléments
            $(document).on('click', '.edit-education', function() {
                // Récupération des données dynamiques
                let id = $(this).data('id');
                let school = $(this).data('school');
                let formation = $(this).data('formation');
                let debut = $(this).data('debut');
                let fin = $(this).data('fin');

                // Injection dans les champs
                $('#edit-id').val(id);
                $('#edit-school').val(school);
                $('#edit-formation').val(formation);
                $('#edit-debut').val(debut);
                $('#edit-fin').val(fin);
            });

            // Soumission du formulaire de modification (existant)
            $('#edit-education-form').on('submit', function(e) {
                e.preventDefault();

                let formData = $(this).serialize();
                let id = $('#edit-id').val();

                $.ajax({
                    url: `/edit-education/${id}`,
                    method: 'POST',
                    data: formData,
                    success: function() {
                        $('#edit_education_modal').modal('hide');
                        $('#education-list').load(location.href + " #education-list>*", "");

                        $('#ajax-alert-container').html(`
                    <div class="alert alert-success rounded-pill alert-dismissible fade show mt-3">
                        Éducation modifiée avec succès !
                        <button type="button" class="btn-close" data-bs-dismiss="alert">
                            <i class="fas fa-xmark"></i>
                        </button>
                    </div>
                `);
                    },
                    error: function() {
                        alert('Erreur lors de la modification');
                    }
                });
            });
        });

        $(document).ready(function() {
            let deleteId = null;

            // Récupère l’ID quand on clique sur l’icône
            $(document).on('click', '.delete-education', function() {
                deleteId = $(this).data('id');
                $('#delete-education-id').val(deleteId); // facultatif
            });

            // Quand on clique sur le bouton "Oui, supprimer"
            $('#confirm-delete-education').on('click', function() {
                const id = deleteId;

                $.ajax({
                    url: `/delete-education/${id}`,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function() {
                        $('#delete_education_modal').modal('hide');
                        $('#education-list').load(location.href + " #education-list>*", "");
                        $('#ajax-alert-container').html(`
                        <div class="alert alert-success rounded-pill alert-dismissible fade show mt-3">
                            Éducation supprimée avec succès.
                            <button type="button" class="btn-close" data-bs-dismiss="alert">
                                <i class="fas fa-xmark"></i>
                            </button>
                        </div>
                    `);
                    },
                    error: function() {
                        alert('Erreur lors de la suppression.');
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#departement-select').on('change', function() {
                let departementId = $(this).val();
                $('#designation-select').html('<option value="">Chargement...</option>');

                if (departementId) {
                    $.ajax({
                        url: `/get-designations/${departementId}`,
                        type: 'GET',
                        success: function(data) {
                            let options = '<option value="">Sélectionne</option>';
                            data.forEach(function(designation) {
                                options +=
                                    `<option value="${designation.design}">${designation.name_designation}</option>`;
                            });
                            $('#designation-select').html(options);
                        },
                        error: function() {
                            $('#designation-select').html(
                                '<option value="">Erreur de chargement</option>');
                        }
                    });
                } else {
                    $('#designation-select').html(
                        '<option value="">Sélectionne un département d\'abord</option>');
                }
            });
        });
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
        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
            <div class="my-auto mb-2">
                <h2 class="mb-1">Employés</h2>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="#"><i class="ti ti-smart-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            Employés
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Liste des employés</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex my-xl-auto right-content align-items-center flex-wrap ">
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
                    <a href="#" data-bs-toggle="modal" data-bs-target="#add_employee"
                        class="btn btn-primary d-flex align-items-center"><i class="ti ti-circle-plus me-2"></i>Ajouter
                        Employé</a>
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

        @include('layouts.status')

        <div class="row">

            <!-- Total Plans -->
            <div class="col-lg-3 col-md-6 d-flex">
                <div class="card flex-fill">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center overflow-hidden">
                            <div>
                                <span class="avatar avatar-lg bg-dark rounded-circle"><i class="ti ti-users"></i></span>
                            </div>
                            <div class="ms-2 overflow-hidden">
                                <p class="fs-12 fw-medium mb-1 text-truncate">Total Employé</p>
                                <h4>{{ $total }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Total Plans -->

            <!-- Total Plans -->
            <div class="col-lg-3 col-md-6 d-flex">
                <div class="card flex-fill">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center overflow-hidden">
                            <div>
                                <span class="avatar avatar-lg bg-success rounded-circle"><i
                                        class="ti ti-user-share"></i></span>
                            </div>
                            <div class="ms-2 overflow-hidden">
                                <p class="fs-12 fw-medium mb-1 text-truncate">Active</p>
                                <h4>{{ $active }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Total Plans -->

            <!-- Inactive Plans -->
            <div class="col-lg-3 col-md-6 d-flex">
                <div class="card flex-fill">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center overflow-hidden">
                            <div>
                                <span class="avatar avatar-lg bg-danger rounded-circle"><i
                                        class="ti ti-user-pause"></i></span>
                            </div>
                            <div class="ms-2 overflow-hidden">
                                <p class="fs-12 fw-medium mb-1 text-truncate">InActive</p>
                                <h4>{{ $inactive }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Inactive Companies -->

            <!-- No of Plans  -->
            <div class="col-lg-3 col-md-6 d-flex">
                <div class="card flex-fill">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center overflow-hidden">
                            <div>
                                <span class="avatar avatar-lg bg-warning rounded-circle"><i
                                        class="ti ti-user-plus"></i></span>
                            </div>
                            <div class="ms-2 overflow-hidden">
                                <p class="fs-12 fw-medium mb-1 text-truncate">Recrutement en cours</p>
                                <h4>{{ $encours }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /No of Plans -->
        </div>

        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                <h5>Employés</h5>
                <div class="d-flex my-xl-auto right-content align-items-center flex-wrap row-gap-3">

                    <div class="dropdown me-3">
                        <a href="javascript:void(0);" class="dropdown-toggle btn btn-white d-inline-flex align-items-center"
                            data-bs-toggle="dropdown">
                            Département
                        </a>
                        <ul class="dropdown-menu  dropdown-menu-end p-3">
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item rounded-1">Finance</a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item rounded-1">Developer</a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item rounded-1">Executive</a>
                            </li>
                        </ul>
                    </div>
                    <div class="dropdown me-3">
                        <a href="javascript:void(0);"
                            class="dropdown-toggle btn btn-white d-inline-flex align-items-center"
                            data-bs-toggle="dropdown">
                            Select Status
                        </a>
                        <ul class="dropdown-menu  dropdown-menu-end p-3">
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item rounded-1">Active</a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item rounded-1">Inactive</a>
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
                                <th>Emp ID</th>
                                <th>Nom</th>
                                <th>E-mail</th>
                                <th>Téléphone</th>
                                <th>Département</th>
                                <th>Date embauche</th>
                                <th>Statut</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="employee-list">
                            @foreach ($all as $item)
                                <tr>
                                    <td><a
                                            href="{{ route('employees.show', $item->id) }}"><strong>Emp-00{{ $item->id }}</strong></a>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <a href="#" class="avatar avatar-md" data-bs-toggle="modal"
                                                data-bs-target="#view_details"><img
                                                    src="{{ $item->photo == '' ? URL::asset('assets/img/users/user-36.jpg') : url($item->photo) }}"
                                                    class="img-fluid rounded-circle" alt="img"></a>
                                            <div class="ms-2">
                                                <p class="text-dark mb-0"><a
                                                        href="{{ route('employees.show', $item->id) }}">{{ $item->name }}
                                                        {{ $item->last_name }}</a>
                                                </p>
                                                <span class="fs-12">{{ $item->deparment_name }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->phone }}</td>
                                    <td>
                                        {{ $item->name_designation }}
                                    </td>
                                    <td>{{ $item->date_embauche }}</td>
                                    <td>
                                        @if ($item->statut == 'Active')
                                            <span class="badge badge-success d-inline-flex align-items-center badge-sm">
                                                <i class="ti ti-point-filled me-1"></i>Active
                                            </span>
                                        @else
                                            <span class="badge badge-danger d-inline-flex align-items-center badge-sm">
                                                <i class="ti ti-point-filled me-1"></i>Inactive
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="action-icon d-inline-flex">
                                            <a href="#" class="me-2" data-bs-toggle="modal"
                                                data-bs-target="#edit_employee{{ $item->id }}"><i
                                                    class="ti ti-edit"></i></a>
                                            <div class="modal fade" id="edit_employee{{ $item->id }}">
                                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <div class="d-flex align-items-center">
                                                                <h4 class="modal-title me-2">Modifier employé</h4>
                                                                <span>Employé ID : EMP-00{{ $item->id }}</span>
                                                            </div>
                                                            <button type="button" class="btn-close custom-btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close">
                                                                <i class="ti ti-x"></i>
                                                            </button>
                                                        </div>
                                                        <form action="{{ route('employees.update', $item->id) }}"
                                                            method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PATCH')
                                                            <div class="contact-grids-tab">
                                                                <ul class="nav nav-underline" id="myTab2"
                                                                    role="tablist">
                                                                    <li class="nav-item" role="presentation">
                                                                        <button class="nav-link active" id="info-tab2"
                                                                            data-bs-toggle="tab"
                                                                            data-bs-target="#basic-info2" type="button"
                                                                            role="tab" aria-selected="true">Données
                                                                            professionnelles</button>
                                                                    </li>
                                                                    <li class="nav-item" role="presentation">
                                                                        <button class="nav-link" id="address-tab2"
                                                                            data-bs-toggle="tab"
                                                                            data-bs-target="#address2" type="button"
                                                                            role="tab" aria-selected="false">Données
                                                                            personnelles</button>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <div class="tab-content" id="myTabContent2">
                                                                <div class="tab-pane fade show active" id="basic-info2"
                                                                    role="tabpanel" aria-labelledby="info-tab2"
                                                                    tabindex="0">
                                                                    <div class="modal-body pb-0 ">
                                                                        <div class="card bg-light-500 shadow-none">
                                                                            <div
                                                                                class="card-body d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                                                                                <h6>Recrutement</h6>
                                                                                <div
                                                                                    class="d-flex align-items-center justify-content-end">
                                                                                    <div class="form-check me-2">
                                                                                        <label
                                                                                            class="form-check-label mt-0">
                                                                                            <input value="Recruter"
                                                                                                name="recrutement"
                                                                                                @if ($item->type_recru == 'Recruter') checked @endif
                                                                                                class="form-check-input me-2"
                                                                                                type="radio">
                                                                                            Recruter
                                                                                        </label>
                                                                                    </div>
                                                                                    <div
                                                                                        class="form-check d-flex align-items-center">
                                                                                        <label
                                                                                            class="form-check-label mt-0">
                                                                                            <input value="Encours"
                                                                                                name="recrutement"
                                                                                                @if ($item->type_recru == 'Encours') checked @endif
                                                                                                class="form-check-input me-2"
                                                                                                type="radio">
                                                                                            En cours
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <div
                                                                                    class="d-flex align-items-center flex-wrap row-gap-3 bg-light w-100 rounded p-3 mb-4">
                                                                                    <div
                                                                                        class="d-flex align-items-center justify-content-center avatar avatar-xxl rounded-circle border border-dashed me-2 flex-shrink-0 text-dark frames">
                                                                                        <img src="{{ $item->photo == '' ? URL::asset('assets/img/users/user-13.jpg') : url($item->photo) }}"
                                                                                            alt="img"
                                                                                            class="rounded-circle">
                                                                                    </div>
                                                                                    <div class="profile-upload">
                                                                                        <div class="mb-2">
                                                                                            <h6 class="mb-1">Photo
                                                                                            </h6>
                                                                                            <p class="fs-12">Image
                                                                                                should
                                                                                                be below 4 mb</p>
                                                                                        </div>
                                                                                        <div
                                                                                            class="profile-uploader d-flex align-items-center">
                                                                                            <input type="file"
                                                                                                name="photo"
                                                                                                class="form-control image-sign">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="mb-3">
                                                                                    <label class="form-label">Nom <span
                                                                                            class="text-danger">
                                                                                            *</span></label>
                                                                                    <input name="nom" required
                                                                                        type="text"
                                                                                        value="{{ $item->name }}"
                                                                                        class="form-control">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="mb-3">
                                                                                    <label
                                                                                        class="form-label">Prénom</label>
                                                                                    <input name="prenom" required
                                                                                        type="text"
                                                                                        value="{{ $item->last_name }}"
                                                                                        class="form-control">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="mb-3">
                                                                                    <label class="form-label">E-mail
                                                                                        <span class="text-danger">
                                                                                            *</span></label>
                                                                                    <input name="email" required
                                                                                        type="email"
                                                                                        value="{{ $item->email }}"
                                                                                        class="form-control">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="mb-3">
                                                                                    <label class="form-label">Date
                                                                                        d'embauche <span
                                                                                            class="text-danger">
                                                                                            *</span></label>
                                                                                    <div
                                                                                        class="input-icon-end position-relative">
                                                                                        <input name="embauche" required
                                                                                            type="text"
                                                                                            value="{{ $item->date_embauche }}"
                                                                                            class="form-control datetimepicker"
                                                                                            placeholder="dd/mm/yyyy">
                                                                                        <span class="input-icon-addon">
                                                                                            <i
                                                                                                class="ti ti-calendar text-gray-7"></i>
                                                                                        </span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="mb-3">
                                                                                    <label class="form-label">Type de
                                                                                        contrat</label>
                                                                                    <br>
                                                                                    <select name="contrat" class="select">
                                                                                        <option
                                                                                            @if ($item->contrat == 'CDD') selected @endif
                                                                                            value="CDD">
                                                                                            CDD</option>
                                                                                        <option
                                                                                            @if ($item->contrat == 'CDI') selected @endif
                                                                                            value="CDI">
                                                                                            CDI</option>
                                                                                        <option
                                                                                            @if ($item->contrat == 'INTERIM') selected @endif
                                                                                            value="INTERIM">
                                                                                            Interim
                                                                                        </option>
                                                                                        <option
                                                                                            @if ($item->contrat == 'CONSULTANT') selected @endif
                                                                                            value="CONSULTANT">
                                                                                            Consultant</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="mb-3">
                                                                                    <label class="form-label">Contrat
                                                                                        (Document)
                                                                                    </label>
                                                                                    <input type="file" name="docontrat"
                                                                                        class="form-control image-sign">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="mb-3">
                                                                                    <label class="form-label">Numéro
                                                                                        CNPS</label>
                                                                                    <input name="cnps" type="text"
                                                                                        value="{{ $item->cnps }}"
                                                                                        class="form-control">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="mb-3">
                                                                                    <label class="form-label">Diplôme
                                                                                        (Document)</label>
                                                                                    <input type="file" name="diplome"
                                                                                        class="form-control image-sign">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="mb-3">
                                                                                    <label
                                                                                        class="form-label">Salaire</label>
                                                                                    <input name="salaire" type="number"
                                                                                        value="{{ $item->salaire }}"
                                                                                        class="form-control">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="mb-3">
                                                                                    <label
                                                                                        class="form-label">Département</label>
                                                                                    <br>
                                                                                    <select id="departement-select-"
                                                                                        name="departement" required
                                                                                        class="select">
                                                                                        <option
                                                                                            value="{{ $item->department_id }}">
                                                                                            Sélectionne
                                                                                        </option>
                                                                                        @foreach ($department as $depart)
                                                                                            <option
                                                                                                value="{{ $depart->depart }}">
                                                                                                {{ $depart->deparment_name }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="mb-3">
                                                                                    <label
                                                                                        class="form-label">Désignation</label>
                                                                                    <br>
                                                                                    <select id="designation-select-"
                                                                                        name="designation" required
                                                                                        class="select">
                                                                                        <option
                                                                                            value="{{ $item->designation_id }}">
                                                                                            Sélectionne
                                                                                        </option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="tab-pane fade" id="address2" role="tabpanel"
                                                                    aria-labelledby="address-tab2" tabindex="0">
                                                                    <div class="modal-body">
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <div class="mb-3">
                                                                                    <label
                                                                                        class="form-label">Nationnalité</label>
                                                                                    <input name="nationnalite"
                                                                                        type="text"
                                                                                        value="{{ $item->nationnalite }}"
                                                                                        class="form-control">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="mb-3">
                                                                                    <label class="form-label">Type de
                                                                                        pièce</label>
                                                                                    <br>
                                                                                    <select name="piece" class="select">
                                                                                        <option
                                                                                            @if ($item->type_papier == 'CNI') selected @endif
                                                                                            value="CNI">
                                                                                            CNI</option>
                                                                                        <option
                                                                                            @if ($item->type_papier == 'PASSEPORT') selected @endif
                                                                                            value="PASSEPORT">PASSEPORT
                                                                                        </option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="mb-3">
                                                                                    <label class="form-label">Numéro
                                                                                        pièce</label>
                                                                                    <input name="numero" type="text"
                                                                                        value="{{ $item->numero_papier }}"
                                                                                        class="form-control">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="mb-3">
                                                                                    <label class="form-label">Date de
                                                                                        naissance <span
                                                                                            class="text-danger">
                                                                                            *</span></label>
                                                                                    <div
                                                                                        class="input-icon-end position-relative">
                                                                                        <input name="naissance" required
                                                                                            type="text"
                                                                                            value="{{ $item->date_naissance }}"
                                                                                            class="form-control datetimepicker"
                                                                                            placeholder="dd/mm/yyyy">
                                                                                        <span class="input-icon-addon">
                                                                                            <i
                                                                                                class="ti ti-calendar text-gray-7"></i>
                                                                                        </span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="mb-3">
                                                                                    <label class="form-label">Lieu de
                                                                                        naissance </label>
                                                                                    <input name="lieu" type="text"
                                                                                        value="{{ $item->lieu_naissance }}"
                                                                                        class="form-control">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="mb-3">
                                                                                    <label class="form-label">Lieu de
                                                                                        résidence</label>
                                                                                    <input name="residence" type="text"
                                                                                        value="{{ $item->lieu_residence }}"
                                                                                        class="form-control">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="mb-3">
                                                                                    <label class="form-label">Téléphone
                                                                                        <span class="text-danger">
                                                                                            *</span></label>
                                                                                    <input type="text" required
                                                                                        name="phone"
                                                                                        value="{{ $item->phone }}"
                                                                                        class="form-control image-sign">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="mb-3">
                                                                                    <label class="form-label">Situation
                                                                                        matrimoniale</label>
                                                                                    <input name="situation" type="text"
                                                                                        value="{{ $item->situation_matrimoniale }}"
                                                                                        class="form-control">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="mb-3">
                                                                                    <label class="form-label">Sexe
                                                                                        <span class="text-danger">
                                                                                            *</span></label>
                                                                                    <br>
                                                                                    <select name="sexe" required
                                                                                        class="select">
                                                                                        <option
                                                                                            @if ($item->sexe == 'Homme') selected @endif
                                                                                            value="Homme">
                                                                                            Homme
                                                                                        </option>
                                                                                        <option
                                                                                            @if ($item->sexe == 'Femme') selected @endif
                                                                                            value="Femme">
                                                                                            Femme
                                                                                        </option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="mb-3">
                                                                                    <label class="form-label">Nombre
                                                                                        d'enfant</label>
                                                                                    <input name="enfant" type="number"
                                                                                        value="{{ $item->enfant }}"
                                                                                        class="form-control">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="mb-3 ">
                                                                                    <label class="form-label">Mot de
                                                                                        passe</label>
                                                                                    <div class="pass-group">
                                                                                        <input type="password"
                                                                                            name="password"
                                                                                            class="pass-input form-control">
                                                                                        <span
                                                                                            class="ti toggle-password ti-eye-off"></span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="mb-3">
                                                                                    <label class="form-label">Rôle
                                                                                        <span class="text-danger">
                                                                                            *</span></label>
                                                                                    <br>
                                                                                    <select name="role" required
                                                                                        class="select">
                                                                                        <option
                                                                                            @if ($item->role == 'Admin') selected @endif
                                                                                            value="Admin">
                                                                                            Admin
                                                                                        </option>
                                                                                        <option
                                                                                            @if ($item->role == 'Respo') selected @endif
                                                                                            value="Respo">
                                                                                            Responsable
                                                                                        </option>
                                                                                        <option
                                                                                            @if ($item->role == 'Employe') selected @endif
                                                                                            value="Employe">Employé
                                                                                        </option>
                                                                                        <option
                                                                                            @if ($item->role == 'RH') selected @endif
                                                                                            value="RH">
                                                                                            RH</option>
                                                                                        <option
                                                                                            @if ($item->role == 'Resporh') selected @endif
                                                                                            value="Resporh">Responsable
                                                                                            Resource Humaine</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="mb-3">
                                                                                    <label class="form-label">Statut
                                                                                        <span class="text-danger">
                                                                                            *</span></label>
                                                                                    <br>
                                                                                    <select name="staut" required
                                                                                        class="select">
                                                                                        <option
                                                                                            @if ($item->statut == 'Active') selected @endif
                                                                                            value="Active">
                                                                                            Active
                                                                                        </option>
                                                                                        <option
                                                                                            @if ($item->statut == 'Inactive') selected @endif
                                                                                            value="Inactive">
                                                                                            Inactive
                                                                                        </option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-12">
                                                                                <div class="mb-3">
                                                                                    <label
                                                                                        class="form-label">Apropos</label>
                                                                                    <textarea name="about" class="form-control" rows="3">
                                                                                        {{ $item->about }}
                                                                                    </textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button"
                                                                            class="btn btn-outline-light border me-2"
                                                                            data-bs-dismiss="modal">Annuler</button>
                                                                        <button type="button"
                                                                            class="btn btn-primary">Modifier</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <a href="#" data-bs-toggle="modal"
                                                data-bs-target="#delete_modal{{ $item->id }}"><i
                                                    class="ti ti-trash"></i></a>
                                            <div class="modal fade" id="delete_modal{{ $item->id }}">
                                                <div class="modal-dialog modal-dialog-centered modal-sm">
                                                    <div class="modal-content">
                                                        <div class="modal-body text-center">
                                                            <span
                                                                class="avatar avatar-xl bg-transparent-danger text-danger mb-3">
                                                                <i class="ti ti-trash-x fs-36"></i>
                                                            </span>
                                                            <h4 class="mb-1">Confirmez la suppression</h4>
                                                            <p class="mb-3">You want to delete all the marked items,
                                                                <br>
                                                                this
                                                                cant be undone once you
                                                                delete.
                                                            </p>
                                                            <form action="{{ route('employees.destroy', $item->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <div class="d-flex justify-content-center">
                                                                    <a href="javascript:void(0);"
                                                                        class="btn btn-light me-3"
                                                                        data-bs-dismiss="modal">Annuler</a>
                                                                    <button type="submit" class="btn btn-danger">Oui,
                                                                        Supprimer</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <!-- Add Employee -->
    <div class="modal fade" id="add_employee">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="d-flex align-items-center">
                        <h4 class="modal-title me-2">Ajouter un nouveau employé</h4>
                    </div>
                    <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
                <div id="ajax-alert-container"></div>
                <form id="employee-form" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="contact-grids-tab">
                        <ul class="nav nav-underline" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="info-tab" data-bs-toggle="tab"
                                    data-bs-target="#basic-info" type="button" role="tab"
                                    aria-selected="true">Données professionnelles</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="address-tab" data-bs-toggle="tab" data-bs-target="#address"
                                    type="button" role="tab" aria-selected="false">Données personnelles</button>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="basic-info" role="tabpanel"
                            aria-labelledby="info-tab" tabindex="0">
                            <div class="modal-body pb-0 ">
                                <div class="card bg-light-500 shadow-none">
                                    <div
                                        class="card-body d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                                        <h6>Recrutement</h6>
                                        <div class="d-flex align-items-center justify-content-end">
                                            <div class="form-check me-2">
                                                <label class="form-check-label mt-0">
                                                    <input value="Recruter" name="recrutement"
                                                        class="form-check-input me-2" type="radio">
                                                    Recruter
                                                </label>
                                            </div>
                                            <div class="form-check d-flex align-items-center">
                                                <label class="form-check-label mt-0">
                                                    <input value="Encours" name="recrutement"
                                                        class="form-check-input me-2" type="radio">
                                                    En cours
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div
                                            class="d-flex align-items-center flex-wrap row-gap-3 bg-light w-100 rounded p-3 mb-4">
                                            <div class="profile-upload">
                                                <div class="mb-2">
                                                    <h6 class="mb-1">Photo</h6>
                                                    <p class="fs-12">Image should be below 4 mb</p>
                                                </div>
                                                <div class="profile-uploader d-flex align-items-center">
                                                    <input type="file" name="photo" class="form-control image-sign">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Nom <span class="text-danger">
                                                    *</span></label>
                                            <input name="nom" required type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Prénom</label>
                                            <input name="prenom" required type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">E-mail <span class="text-danger">
                                                    *</span></label>
                                            <input name="email" required type="email" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Date d'embauche <span class="text-danger">
                                                    *</span></label>
                                            <div class="input-icon-end position-relative">
                                                <input name="embauche" required type="text"
                                                    class="form-control datetimepicker" placeholder="dd/mm/yyyy">
                                                <span class="input-icon-addon">
                                                    <i class="ti ti-calendar text-gray-7"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Type de contrat</label>
                                            <select name="contrat" class="select">
                                                <option value="">Sélectionne</option>
                                                <option value="CDD">CDD</option>
                                                <option value="CDI">CDI</option>
                                                <option value="INTERIM">Interim</option>
                                                <option value="CONSULTANT">Consultant</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Contrat (Document)</label>
                                            <input type="file" name="docontrat" class="form-control image-sign">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Numéro CNPS</label>
                                            <input name="cnps" type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Diplôme (Document)</label>
                                            <input type="file" name="diplome" class="form-control image-sign">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Salaire</label>
                                            <input name="salaire" type="number" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Département <span
                                                    class="text-danger">*</span></label>
                                            <select name="departement" id="departement-select" required
                                                class="form-select">
                                                <option value="">Sélectionne</option>
                                                @foreach ($department as $depart)
                                                    <option value="{{ $depart->depart }}">{{ $depart->deparment_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Désignation <span
                                                    class="text-danger">*</span></label>
                                            <select name="designation" id="designation-select" required
                                                class="form-select">
                                                <option value="">Sélectionne un département d'abord</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="address" role="tabpanel" aria-labelledby="address-tab"
                            tabindex="0">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Nationnalité</label>
                                            <input name="nationnalite" type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Type de pièce</label>
                                            <select name="piece" class="select">
                                                <option value="">Sélectionne</option>
                                                <option value="CNI">CNI</option>
                                                <option value="PASSEPORT">PASSEPORT</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Numéro pièce</label>
                                            <input name="numero" type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Date de naissance <span class="text-danger">
                                                    *</span></label>
                                            <div class="input-icon-end position-relative">
                                                <input name="naissance" required type="text"
                                                    class="form-control datetimepicker" placeholder="dd/mm/yyyy">
                                                <span class="input-icon-addon">
                                                    <i class="ti ti-calendar text-gray-7"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Lieu de naissance </label>
                                            <input name="lieu" type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Lieu de résidence</label>
                                            <input name="residence" type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Téléphone <span class="text-danger">
                                                    *</span></label>
                                            <input type="text" required name="phone"
                                                class="form-control image-sign">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Situation matrimoniale</label>
                                            <input name="situation" type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Sexe <span class="text-danger">
                                                    *</span></label>
                                            <select name="sexe" required class="select">
                                                <option value="">Sélectionne</option>
                                                <option value="Homme">Homme</option>
                                                <option value="Femme">Femme</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Nombre d'enfant</label>
                                            <input name="enfant" type="number" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3 ">
                                            <label class="form-label">Mot de passe <span class="text-danger">
                                                    *</span></label>
                                            <div class="pass-group">
                                                <input type="password" name="password" required
                                                    class="pass-input form-control">
                                                <span class="ti toggle-password ti-eye-off"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Rôle <span class="text-danger">
                                                    *</span></label>
                                            <select name="role" required class="select">
                                                <option value="">Sélectionne</option>
                                                <option value="Admin">Admin</option>
                                                <option value="Respo">Responsable</option>
                                                <option value="Employé">Employé</option>
                                                <option value="RH">RH</option>
                                                <option value="Resporh">Responsable Resource Humaine</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Apropos</label>
                                            <textarea name="about" class="form-control" rows="3"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-light border me-2"
                                    data-bs-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-primary">Enregistrer</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /Add Employee -->
@endsection
