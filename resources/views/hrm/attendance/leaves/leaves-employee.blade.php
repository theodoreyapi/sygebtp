@extends('layouts.master', ['title' => 'Conges'])

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

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/plugins/select2/css/select2.min.css">

    <!-- Bootstrap Tagsinput CSS -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/css/style.css">
@endpush

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    // incendit
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
                    url: "{{ route('leaves-employee.store') }}",
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
                            Votre demande de congé a bien été envoyé avec succès !
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
                <h2 class="mb-1">Congés</h2>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="index.html"><i class="ti ti-smart-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            Employé
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Mes congés</li>
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
                    <a href="#" data-bs-toggle="modal" data-bs-target="#add_leaves"
                        class="btn btn-primary d-flex align-items-center"><i class="ti ti-circle-plus me-2"></i>Ajouter
                        congé</a>
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

        <!-- Leaves Info -->
        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card bg-black-le">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="text-start">
                                <p class="mb-1">Conngés annuels</p>
                                <h4>{{ $leaveStats['Annual']['taken'] }}</h4>
                            </div>
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-2">
                                    <span class="avatar avatar-md d-flex">
                                        <i class="ti ti-calendar-event fs-32"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <span class="badge bg-secondary-transparent">Congés restants :
                            {{ $leaveStats['Annual']['remaining'] }}</span>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-blue-le">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="text-start">
                                <p class="mb-1">Congés médicaux</p>
                                <h4>{{ $leaveStats['Medical']['taken'] }}</h4>
                            </div>
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-2">
                                    <span class="avatar avatar-md d-flex">
                                        <i class="ti ti-vaccine fs-32"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        {{-- <span class="badge bg-info-transparent">Remaining Leaves : 01</span> --}}
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-purple-le">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="text-start">
                                <p class="mb-1">Congés occasionnels</p>
                                <h4>{{ $leaveStats['Casual']['taken'] }}</h4>
                            </div>
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-2">
                                    <span class="avatar avatar-md d-flex">
                                        <i class="ti ti-hexagon-letter-c fs-32"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        {{-- <span class="badge bg-transparent-purple">Remaining Leaves : 10</span> --}}
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-pink-le">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="text-start">
                                <p class="mb-1">Autres congés</p>
                                <h4>{{ $leaveStats['Autres']['taken'] }}</h4>
                            </div>
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-2">
                                    <span class="avatar avatar-md d-flex">
                                        <i class="ti ti-hexagonal-prism-plus fs-32"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        {{-- <span class="badge bg-pink-transparent">Remaining Leaves : 05</span> --}}
                    </div>
                </div>
            </div>
        </div>
        <!-- /Leaves Info -->

        <!-- Leaves list -->
        <div class="card">
            {{-- <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                <div class="d-flex">
                    <h5 class="me-2">Liste des congés</h5>
                    <span class="badge bg-primary-transparent me-2">Nombre total de congés : 48</span>
                    <span class="badge bg-secondary-transparent">Total des feuilles restantes : 23</span>
                </div>
                <div class="d-flex my-xl-auto right-content align-items-center flex-wrap row-gap-3">
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
                            class="dropdown-toggle btn btn-sm btn-white d-inline-flex align-items-center"
                            data-bs-toggle="dropdown">
                            Leave Type
                        </a>
                        <ul class="dropdown-menu  dropdown-menu-end p-3">
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item rounded-1">Medical Leave</a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item rounded-1">Casual Leave</a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item rounded-1">Annual Leave</a>
                            </li>
                        </ul>
                    </div>
                    <div class="dropdown me-3">
                        <a href="javascript:void(0);"
                            class="dropdown-toggle btn btn-sm btn-white d-inline-flex align-items-center"
                            data-bs-toggle="dropdown">
                            Approved By
                        </a>
                        <ul class="dropdown-menu  dropdown-menu-end p-3">
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item rounded-1">Doglas Martini</a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item rounded-1">Warren Morales</a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item rounded-1">Doglas Martini</a>
                            </li>
                        </ul>
                    </div>
                    <div class="dropdown me-3">
                        <a href="javascript:void(0);"
                            class="dropdown-toggle btn btn-sm btn-white d-inline-flex align-items-center"
                            data-bs-toggle="dropdown">
                            Select Status
                        </a>
                        <ul class="dropdown-menu  dropdown-menu-end p-3">
                            <li>
                                <a href="javascript:void(0);"
                                    class="dropdown-item rounded-1 d-flex justify-content-start align-items-center"><span
                                        class="rounded-circle bg-transparent-success d-flex justify-content-center align-items-center me-2"><i
                                            class="ti ti-point-filled text-success"></i></span>Approved</a>
                            </li>
                            <li>
                                <a href="javascript:void(0);"
                                    class="dropdown-item rounded-1 d-flex justify-content-start align-items-center"><span
                                        class="rounded-circle bg-transparent-danger d-flex justify-content-center align-items-center me-2"><i
                                            class="ti ti-point-filled text-danger"></i></span>Declined</a>
                            </li>
                            <li>
                                <a href="javascript:void(0);"
                                    class="dropdown-item rounded-1 d-flex justify-content-start align-items-center"><span
                                        class="rounded-circle bg-transparent-purple d-flex justify-content-center align-items-center me-2"><i
                                            class="ti ti-point-filled text-purple"></i></span>New</a>
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
            </div> --}}
            <div class="card-body p-0">
                <div class="custom-datatable-filter table-responsive">
                    <table class="table datatable">
                        <thead class="thead-light">
                            <tr>
                                <th>Type congé</th>
                                <th>De</th>
                                <th>Approuvé par</th>
                                <th>À</th>
                                <th>Nombre de jour</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="employee-list">
                            @foreach ($leaves as $leave)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <p class="mb-0">{{ $leave->leave_type }}</p>
                                            @if ($leave->reason)
                                                <a href="#" class="ms-2" data-bs-toggle="tooltip"
                                                    title="{{ $leave->reason }}">
                                                    <i class="ti ti-info-circle text-info"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                    <td>{{ $leave->start_date->format('d M Y') }}</td>
                                    <td>
                                        @if ($leave->approver)
                                            <div class="d-flex align-items-center">
                                                <p class="mb-0">{{ $leave->approver->name }}</p>
                                                @if ($leave->justification)
                                                    <a href="#" class="ms-2" data-bs-toggle="tooltip"
                                                        title="{{ $leave->justification }}">
                                                        <i class="ti ti-info-circle text-info"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>{{ $leave->end_date->format('d M Y') }}</td>
                                    <td>{{ $leave->total_days }} Jour{{ $leave->total_days > 1 ? 's' : '' }}</td>
                                    <td>
                                        <span
                                            class="badge bg-{{ $leave->status === 'Approved' ? 'success' : ($leave->status === 'Declined' ? 'danger' : 'secondary') }}">
                                            {{ $leave->status }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="action-icon d-inline-flex">
                                            {{-- <a href="#" class="me-2" data-bs-toggle="modal"
                                                data-bs-target="#edit_holiday"><i class="ti ti-edit"></i></a> --}}
                                            <a href="javascript:void(0);" data-bs-toggle="modal"
                                                data-bs-target="#delete_modal{{ $leave->leave_id }}"><i
                                                    class="ti ti-trash"></i></a>
                                            <div class="modal fade" id="delete_modal{{ $leave->leave_id }}">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-body text-center">
                                                            <span
                                                                class="avatar avatar-xl bg-transparent-danger text-danger mb-3">
                                                                <i class="ti ti-trash-x fs-36"></i>
                                                            </span>
                                                            <h4 class="mb-1">Confirme la suppression</h4>
                                                            <p class="mb-3">You want to delete all the marked items, this
                                                                cant be undone once you delete.</p>
                                                            <form
                                                                action="{{ route('leaves-employee.destroy', $leave->leave_id) }}"
                                                                method="post">
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
        <!-- /Leaves list -->
    </div>

    <!-- Add Leaves -->
    <div class="modal fade" id="add_leaves">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Demnde de congés</h4>
                    <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
                <div id="ajax-alert-container"></div>
                <form action="{{ route('leaves-employee.store') }}" method="post">
                    @csrf
                    <div class="modal-body pb-0">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Type congé</label>
                                    <select name="leave_type" required class="select">
                                        <option value="">Sélectionne</option>
                                        <option value="Medical">Congé médical</option>
                                        <option value="Casual">Congé occasionnel</option>
                                        <option value="Annual">Congé annuel</option>
                                        <option value="Autres">Autres congés</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">De </label>
                                    <div class="input-icon-end position-relative">
                                        <input name="start_date" required type="text"
                                            class="form-control datetimepicker" placeholder="dd/mm/yyyy">
                                        <span class="input-icon-addon">
                                            <i class="ti ti-calendar text-gray-7"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">À </label>
                                    <div class="input-icon-end position-relative">
                                        <input name="end_date" required type="text"
                                            class="form-control datetimepicker" placeholder="dd/mm/yyyy">
                                        <span class="input-icon-addon">
                                            <i class="ti ti-calendar text-gray-7"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-md-6">
                                <div class="mb-3">
                                    <div class="input-icon-end position-relative">
                                        <input name="day_type" type="text" class="form-control datetimepicker"
                                            placeholder="dd/mm/yyyy" disabled>
                                        <span class="input-icon-addon">
                                            <i class="ti ti-calendar text-gray-7"></i>
                                        </span>
                                    </div>
                                </div>
                            </div> --}}
                            {{-- <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nombre de jour</label>
                                    <input type="text" class="form-control" disabled>
                                </div>
                            </div> --}}
                            {{-- <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Jours restant</label>
                                    <input type="text" class="form-control" value="8" disabled>
                                </div>
                            </div> --}}

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Raison</label>
                                    <textarea name="reason" class="form-control" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Demander</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /Add Leaves -->

    <!-- Edit Leaves -->
    <div class="modal fade" id="edit_leaves">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Leave</h4>
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
                                    <label class="form-label">Employee Name</label>
                                    <select class="select">
                                        <option selected>Anthony Lewis</option>
                                        <option>Brian Villalobos</option>
                                        <option>Harvey Smith</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Leave Type</label>
                                    <select class="select">
                                        <option selected>Medical Leave</option>
                                        <option>Casual Leave</option>
                                        <option>Annual Leave</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">From </label>
                                    <div class="input-icon-end position-relative">
                                        <input type="text" class="form-control datetimepicker" value="14 Jan 24"
                                            placeholder="dd/mm/yyyy">
                                        <span class="input-icon-addon">
                                            <i class="ti ti-calendar text-gray-7"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">To </label>
                                    <div class="input-icon-end position-relative">
                                        <input type="text" class="form-control datetimepicker" value="15/01/24"
                                            placeholder="dd/mm/yyyy">
                                        <span class="input-icon-addon">
                                            <i class="ti ti-calendar text-gray-7"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <div class="input-icon-end position-relative">
                                        <input type="text" class="form-control datetimepicker" value="15/01/24"
                                            disabled>
                                        <span class="input-icon-addon">
                                            <i class="ti ti-calendar text-gray-7"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <select class="select">
                                        <option>Select</option>
                                        <option>Full DAy</option>
                                        <option selected>First Half</option>
                                        <option>Second Half</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">No of Days</label>
                                    <input type="text" class="form-control" value="01" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Remaining Days</label>
                                    <input type="text" class="form-control" value="07" disabled>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="form-check me-2">
                                        <input class="form-check-input" type="radio" name="leave1" value="option4"
                                            id="leave6">
                                        <label class="form-check-label" for="leave6">
                                            Full Day
                                        </label>
                                    </div>
                                    <div class="form-check me-2">
                                        <input class="form-check-input" type="radio" name="leave1" value="option5"
                                            id="leave5">
                                        <label class="form-check-label" for="leave5">
                                            First Half
                                        </label>
                                    </div>
                                    <div class="form-check me-2">
                                        <input class="form-check-input" type="radio" name="leave1" value="option6"
                                            id="leave4">
                                        <label class="form-check-label" for="leave4">
                                            Second Half
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Reason</label>
                                    <textarea class="form-control" rows="3"> Going to Hospital </textarea>
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
    <!-- /Edit Leaves -->

    <!-- Delete Modal -->

    <!-- /Delete Modal -->
@endsection
