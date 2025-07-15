@extends('layouts.master', ['title' => 'Incidents'])

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
                    url: "{{ route('attendance-incendit.store') }}",
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
                            Vous avez un incendit / accident avec succès !
                            <button type="button" class="btn-close custom-close" data-bs-dismiss="alert" aria-label="Close">
                                <i class="fas fa-xmark"></i>
                            </button>
                        </div>
                    `);
                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON?.errors;
                        console.error(xhr.responseText);
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

    <!-- Custom JS -->
    <script src="{{ URL::asset('') }}assets/js/theme-colorpicker.js"></script>
    <script src="{{ URL::asset('') }}assets/js/script.js"></script>
@endpush

@section('content')
    <div class="content">
        <!-- Breadcrumb -->
        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
            <div class="my-auto mb-2">
                <h2 class="mb-1">Incidents / Accidents</h2>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="#"><i class="ti ti-smart-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            HRM
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Incidents - Accidents</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex my-xl-auto right-content align-items-center flex-wrap ">
                <div class="mb-2">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#add_holiday"
                        class="btn btn-primary d-flex align-items-center"><i class="ti ti-circle-plus me-2"></i>Déclarer un
                        incident</a>
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

        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                <h5>Liste des incidents et accidents</h5>
            </div>
            <div class="card-body p-0">
                <div class="custom-datatable-filter table-responsive">
                    <table class="table datatable">
                        <thead class="thead-light">
                            <tr>
                                <th>Références</th>
                                <th>Date</th>
                                <th>Employé</th>
                                <th>Type</th>
                                <th>Lieu</th>
                                <th>Gravité</th>
                                <th>Statut</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="employee-list">
                            @foreach ($all as $item)
                                <tr>
                                    <td>
                                        <h6 class="fw-medium">{{ $item->reference_incendit }}</h6>
                                    </td>
                                    <td>{{ $item->date_incendit }}</td>
                                    <td>{{ $item->employe_name }} {{ $item->employe_last_name }}</td>
                                    <td>{{ $item->type_incendit }}</td>
                                    <td>{{ $item->lieu_incendit }}</td>
                                    <td>
                                        @if ($item->gravite_incendit == 'Mineur')
                                            <span class="badge badge-info d-inline-flex align-items-center badge-xs">
                                                <i class="ti ti-point-filled me-1"></i>Mineur
                                            </span>
                                        @elseif ($item->gravite_incendit == 'Majeur')
                                            <span class="badge badge-warning d-inline-flex align-items-center badge-xs">
                                                <i class="ti ti-point-filled me-1"></i>Majeur
                                            </span>
                                        @else
                                            <span class="badge badge-danger d-inline-flex align-items-center badge-xs">
                                                <i class="ti ti-point-filled me-1"></i>Critique
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->statut_incendit == 'Traite')
                                            <span class="badge badge-success d-inline-flex align-items-center badge-xs">
                                                <i class="ti ti-point-filled me-1"></i>Traité
                                            </span>
                                        @elseif ($item->statut_incendit == 'Encours')
                                            <span class="badge badge-warning d-inline-flex align-items-center badge-xs">
                                                <i class="ti ti-point-filled me-1"></i>En cours
                                            </span>
                                        @else
                                            <span class="badge badge-danger d-inline-flex align-items-center badge-xs">
                                                <i class="ti ti-point-filled me-1"></i>Refusé
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="action-icon d-inline-flex">
                                            <a href="#" class="me-2" data-bs-toggle="modal"
                                                data-bs-target="#view_holiday{{ $item->incendit_id }}"><i
                                                    class="ti ti-eye"></i></a>
                                            <a href="#" class="me-2" data-bs-toggle="modal"
                                                data-bs-target="#edit_holiday{{ $item->incendit_id }}"><i
                                                    class="ti ti-edit"></i></a>
                                            <a href="javascript:void(0);" data-bs-toggle="modal"
                                                data-bs-target="#delete_modal{{ $item->incendit_id }}"><i
                                                    class="ti ti-trash"></i></a>
                                        </div>
                                        <!-- View Plan -->
                                        <div class="modal fade" id="view_holiday{{ $item->incendit_id }}">
                                            <div class="modal-dialog modal-dialog-centered modal-md">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Détails</h4>
                                                        <button type="button" class="btn-close custom-btn-close"
                                                            data-bs-dismiss="modal" aria-label="Close">
                                                            <i class="ti ti-x"></i>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body pb-0">
                                                        <div class="row">
                                                            <div
                                                                class="d-flex align-items-center justify-content-between mb-2">
                                                                <span
                                                                    class="badge badge-info d-inline-flex align-items-center badge-xs">
                                                                    {{ $item->reference_incendit }}
                                                                </span>
                                                                <p class="text-dark">
                                                                    @if ($item->statut_incendit == 'Traite')
                                                                        <span
                                                                            class="badge badge-success d-inline-flex align-items-center badge-xs">
                                                                            Traité
                                                                        </span>
                                                                    @elseif ($item->statut_incendit == 'Encours')
                                                                        <span
                                                                            class="badge badge-warning d-inline-flex align-items-center badge-xs">
                                                                            En cours
                                                                        </span>
                                                                    @else
                                                                        <span
                                                                            class="badge badge-danger d-inline-flex align-items-center badge-xs">
                                                                            Refusé
                                                                        </span>
                                                                    @endif
                                                                    @if ($item->gravite_incendit == 'Mineur')
                                                                        <span
                                                                            class="badge badge-info d-inline-flex align-items-center badge-xs">
                                                                            Mineur
                                                                        </span>
                                                                    @elseif ($item->gravite_incendit == 'Majeur')
                                                                        <span
                                                                            class="badge badge-warning d-inline-flex align-items-center badge-xs">
                                                                            Majeur
                                                                        </span>
                                                                    @else
                                                                        <span
                                                                            class="badge badge-danger d-inline-flex align-items-center badge-xs">
                                                                            Critique
                                                                        </span>
                                                                    @endif
                                                                </p>
                                                            </div>
                                                            <div
                                                                class="d-flex align-items-center justify-content-between mb-2">
                                                                <h6>Informationns générales</h6>
                                                            </div>
                                                            <div
                                                                class="d-flex align-items-center justify-content-between mb-2">
                                                                <span class="d-inline-flex align-items-center">
                                                                    Date
                                                                </span>
                                                                <p class="text-dark">{{ $item->date_incendit }}</p>
                                                            </div>
                                                            <div
                                                                class="d-flex align-items-center justify-content-between mb-2">
                                                                <span class="d-inline-flex align-items-center">
                                                                    Type
                                                                </span>
                                                                <p class="text-dark">{{ $item->type_incendit }}</p>
                                                            </div>
                                                            <div
                                                                class="d-flex align-items-center justify-content-between mb-2">
                                                                <span class="d-inline-flex align-items-center">
                                                                    Lieu
                                                                </span>
                                                                <p class="text-dark">{{ $item->lieu_incendit }}</p>
                                                            </div>
                                                            <div
                                                                class="d-flex align-items-center justify-content-between mb-2">
                                                                <h6>Employé concerné</h6>
                                                            </div>
                                                            <div class="d-flex align-items-center">
                                                                <a href="#" class="avatar avatar-md"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#view_details"><img
                                                                        src="{{ $item->employe_photo == '' ? URL::asset('assets/img/users/user-36.jpg') : url($item->employe_photo) }}"
                                                                        class="img-fluid rounded-circle"
                                                                        alt="img"></a>
                                                                <div class="ms-2">
                                                                    <p class="text-dark mb-0"><a
                                                                            href="#">{{ $item->employe_name }}
                                                                            {{ $item->employe_last_name }}</a>
                                                                    </p>
                                                                    <span
                                                                        class="fs-12">{{ $item->employe_designation }}</span>
                                                                </div>
                                                            </div>
                                                            <span class="d-inline-flex align-items-center">
                                                                Matricule: EMP-00{{ $item->employe_emp_id }} | Département:
                                                                {{ $item->employe_departement }}
                                                            </span>
                                                            <br>
                                                            <br>
                                                            <div
                                                                class="d-flex align-items-center justify-content-between mb-2">
                                                                <h6>Description</h6>
                                                            </div>
                                                            <div
                                                                class="alert alert-dark rounded-pill alert-dismissible fade show">
                                                                {{ $item->description_incendit }}
                                                            </div>
                                                            <br>
                                                            <br>
                                                            <div
                                                                class="d-flex align-items-center justify-content-between mb-2">
                                                                <h6>Emetteur</h6>
                                                            </div>
                                                            <div>
                                                                <li>{{ $item->created_at }}</li>
                                                                <strong>Déclaration de l'incendit</strong>
                                                                <p>Par: {{ $item->emetteur_name }}
                                                                    {{ $item->emetteur_last_name }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light me-2"
                                                            data-bs-dismiss="modal">Fermer</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /View Plan -->
                                        <!-- Edit Plan -->
                                        <div class="modal fade" id="edit_holiday{{ $item->incendit_id }}">
                                            <div class="modal-dialog modal-dialog-centered modal-md">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Modification</h4>
                                                        <button type="button" class="btn-close custom-btn-close"
                                                            data-bs-dismiss="modal" aria-label="Close">
                                                            <i class="ti ti-x"></i>
                                                        </button>
                                                    </div>
                                                    <form
                                                        action="{{ route('attendance-incendit.update', $item->incendit_id) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('PATCH')
                                                        <div class="modal-body pb-0">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Date de
                                                                            l'évènement</label>
                                                                        <div class="input-icon-end position-relative">
                                                                            <input name="date" required type="text"
                                                                                class="form-control datetimepicker"
                                                                                placeholder="dd/mm/yyyy"
                                                                                value="{{ $item->date_incendit }}">
                                                                            <span class="input-icon-addon">
                                                                                <i class="ti ti-calendar text-gray-7"></i>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Employé concerné</label>
                                                                        <br>
                                                                        <select name="employe" required class="select">
                                                                            @foreach ($employes as $employ)
                                                                                <option
                                                                                    @if ($item->employe_id == $employ->id) selected @endif
                                                                                    value="{{ $employ->id }}">
                                                                                    {{ $employ->name }}
                                                                                    {{ $employ->last_name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Type</label>
                                                                        <br>
                                                                        <select name="type" required class="select">
                                                                            <option
                                                                                @if ($item->type_incendit == 'Incendit') selected @endif
                                                                                value="Incendit">Incendit</option>
                                                                            <option
                                                                                @if ($item->type_incendit == 'Accident') selected @endif
                                                                                value="Accident">Accident</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Lieu</label>
                                                                        <input type="text" name="lieu" required
                                                                            value="{{ $item->lieu_incendit }}"
                                                                            class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Gravité</label>
                                                                        <br>
                                                                        <select name="gravite" required class="select">
                                                                            <option
                                                                                @if ($item->gravite_incendit == 'Mineur') selected @endif
                                                                                value="Mineur">Mineur</option>
                                                                            <option
                                                                                @if ($item->gravite_incendit == 'Majeur') selected @endif
                                                                                value="Majeur">Majeur</option>
                                                                            <option
                                                                                @if ($item->gravite_incendit == 'Critique') selected @endif
                                                                                value="Critique">Critique</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Statut</label>
                                                                        <br>
                                                                        <select name="statut" required class="select">
                                                                            <option
                                                                                @if ($item->statut_incendit == 'Traite') selected @endif
                                                                                value="Traite">Traité</option>
                                                                            <option
                                                                                @if ($item->statut_incendit == 'Encours') selected @endif
                                                                                value="Encours">En cours</option>
                                                                            <option
                                                                                @if ($item->statut_incendit == 'Refuse') selected @endif
                                                                                value="Refuse">Refusé</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Description /
                                                                            Détails</label>
                                                                        <textarea name="description" required class="form-control" rows="3">
                                                                            {{ $item->description_incendit }}
                                                                        </textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-light me-2"
                                                                data-bs-dismiss="modal">Annuler</button>
                                                            <button type="submit"
                                                                class="btn btn-primary">Modifier</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /Edit Plan -->

                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="delete_modal{{ $item->incendit_id }}">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-body text-center">
                                                        <span
                                                            class="avatar avatar-xl bg-transparent-danger text-danger mb-3">
                                                            <i class="ti ti-trash-x fs-36"></i>
                                                        </span>
                                                        <h4 class="mb-1">Confirme la suppression</h4>
                                                        <p class="mb-3">You want to delete all the marked items, <br>
                                                            this cant be
                                                            undone once you delete.</p>
                                                        <form
                                                            action="{{ route('attendance-incendit.destroy', $item->incendit_id) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <div class="d-flex justify-content-center">
                                                                <button type="button" class="btn btn-light me-3"
                                                                    data-bs-dismiss="modal">Annuler</button>
                                                                <button type="submit" class="btn btn-danger">Oui,
                                                                    Supprimer</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /Delete Modal -->
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <!-- Add Plan -->
    <div class="modal fade" id="add_holiday">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Déclarer un incident</h4>
                    <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
                <div id="ajax-alert-container"></div>
                <form id="employee-form" method="post">
                    @csrf
                    <div class="modal-body pb-0">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Date de l'évènement</label>
                                    <div class="input-icon-end position-relative">
                                        <input name="date" required type="text" class="form-control datetimepicker"
                                            placeholder="dd/mm/yyyy">
                                        <span class="input-icon-addon">
                                            <i class="ti ti-calendar text-gray-7"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Employé concerné</label>
                                    <select name="employe" required class="select">
                                        <option value="">Sélectionner un employé</option>
                                        @foreach ($employes as $employe)
                                            <option value="{{ $employe->id }}">{{ $employe->name }}
                                                {{ $employe->last_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Type</label>
                                    <select name="type" required class="select">
                                        <option value="">Sélectionner</option>
                                        <option value="Incendit">Incendit</option>
                                        <option value="Accident">Accident</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Lieu</label>
                                    <input type="text" name="lieu" required class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Gravité</label>
                                    <select name="gravite" required class="select">
                                        <option value="">Sélectionner</option>
                                        <option value="Mineur">Mineur</option>
                                        <option value="Majeur">Majeur</option>
                                        <option value="Critique">Critique</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Statut</label>
                                    <select name="statut" required class="select">
                                        <option value="">Sélectionne</option>
                                        <option value="Traite">Traité</option>
                                        <option value="Encours">En cours</option>
                                        <option value="Refuse">Refusé</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Description / Détails</label>
                                    <textarea name="description" required class="form-control" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /Add Plan -->
@endsection
