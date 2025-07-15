@extends('layouts.master', [
    'title' => 'Evaluations',
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
    <script>
        let objectifIndex = 1;

        document.getElementById('add-objectif').addEventListener('click', function() {
            const wrapper = document.getElementById('objectifs-wrapper');

            const bloc = document.createElement('div');
            bloc.className =
                "objectif-bloc d-flex align-items-center flex-wrap row-gap-3 bg-light w-100 rounded p-3 mb-4";
            bloc.innerHTML = `
        <div class="profile-upload row col-md-12">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Objectif</label>
                    <input name="objectifs[${objectifIndex}][objectif]" required type="text" class="form-control">
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Note (sur 5) <span class="text-danger">*</span></label>
                    <input name="objectifs[${objectifIndex}][note]" required type="number" min="0" max="5" class="form-control">
                </div>
            </div>
            <div class="col-md-12">
                <div class="mb-3">
                    <label class="form-label">Appréciation <span class="text-danger">*</span></label>
                    <input name="objectifs[${objectifIndex}][appreciation]" required type="text" class="form-control">
                </div>
            </div>
            <div class="col-md-12 text-end">
                <button type="button" class="btn btn-danger btn-sm remove-objectif">Supprimer</button>
            </div>
        </div>
    `;
            wrapper.appendChild(bloc);
            objectifIndex++;
        });

        // Suppression dynamique
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-objectif')) {
                const bloc = e.target.closest('.objectif-bloc');
                if (bloc) bloc.remove();
            }
        });
    </script>

    <script>
        document.addEventListener('input', function(e) {
            if (e.target.matches('input[name^="objectifs"][name$="[note]"]')) {
                calculerMoyenne();
            }
        });

        function calculerMoyenne() {
            const notes = document.querySelectorAll('input[name^="objectifs"][name$="[note]"]');
            let total = 0;
            let count = 0;

            notes.forEach(input => {
                const value = parseFloat(input.value);
                if (!isNaN(value)) {
                    total += value;
                    count++;
                }
            });

            const moyenne = count > 0 ? (total / count).toFixed(2) : '';
            document.getElementById('moyenne-note').value = moyenne;
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    // evaluation
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
                    url: "{{ route('evaluations.store') }}",
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
                            Vous avez évaluer un employé avec succès !
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
                <h2 class="mb-1">Evaluations</h2>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="#"><i class="ti ti-smart-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            Evaluations
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Liste des Evaluations</li>
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
                        class="btn btn-primary d-flex align-items-center">
                        <i class="ti ti-circle-plus me-2"></i>
                        Nouvelle évaluation
                    </a>
                </div>
            </div>
        </div>
        <!-- /Breadcrumb -->

        @include('layouts.status')

        <div class="card">
            <div class="card-body p-0">
                <div class="custom-datatable-filter table-responsive">
                    <table class="table datatable">
                        <thead class="thead-light">
                            <tr>
                                <th>Référence</th>
                                <th>Employé</th>
                                <th>Date</th>
                                <th>Période</th>
                                <th>Note moyenne</th>
                                <th>Evaluateur</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="employee-list">
                            @foreach ($all as $item)
                                <tr>
                                    <td><a
                                            href="{{ route('evaluations.show', $item->evaluation_id) }}"><strong>Ref-00{{ $item->evaluation_id }}</strong></a>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <a href="#" class="avatar avatar-md" data-bs-toggle="modal"
                                                data-bs-target="#view_details"><img
                                                    src="{{ $item->employe_photo == '' ? URL::asset('assets/img/users/user-36.jpg') : url($item->employe_photo) }}"
                                                    class="img-fluid rounded-circle" alt="img"></a>
                                            <div class="ms-2">
                                                <p class="text-dark mb-0"><a href="#">{{ $item->employe_name }}<br>
                                                        {{ $item->employe_last_name }}</a>
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $item->date_evaluation }}</td>
                                    <td>Du {{ $item->periode_debut }} <br>au {{ $item->periode_fin }}</td>
                                    <td>{{ $item->note_moyenne }} sur 5</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <a href="#" class="avatar avatar-md" data-bs-toggle="modal"
                                                data-bs-target="#view_details"><img
                                                    src="{{ $item->evaluateur_photo == '' ? URL::asset('assets/img/users/user-36.jpg') : url($item->evaluateur_photo) }}"
                                                    class="img-fluid rounded-circle" alt="img"></a>
                                            <div class="ms-2">
                                                <p class="text-dark mb-0"><a
                                                        href="#">{{ $item->evaluateur_name }}<br>
                                                        {{ $item->evaluateur_last_name }}</a>
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="action-icon d-inline-flex">
                                            <a href="{{ route('evaluations.show', $item->evaluation_id) }}"
                                                class="me-2"><i class="ti ti-eye"></i></a>
                                            <a href="#" class="me-2" data-bs-toggle="modal"
                                                data-bs-target="#edit_employee{{ $item->evaluation_id }}"><i
                                                    class="ti ti-edit"></i></a>
                                            <div class="modal fade" id="edit_employee{{ $item->evaluation_id }}">
                                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <div class="d-flex align-items-center">
                                                                <h4 class="modal-title me-2">Modification</h4>
                                                                <span>Référence : Ref-00{{ $item->evaluation_id }}</span>
                                                            </div>
                                                            <button type="button" class="btn-close custom-btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close">
                                                                <i class="ti ti-x"></i>
                                                            </button>
                                                        </div>
                                                        <form
                                                            action="{{ route('evaluations.update', $item->evaluation_id) }}"
                                                            method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PATCH')
                                                            <div class="tab-content" id="myTabContent">
                                                                <div class="tab-pane fade show active" id="basic-info"
                                                                    role="tabpanel" aria-labelledby="info-tab"
                                                                    tabindex="0">
                                                                    <div class="modal-body pb-0 ">
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <div class="mb-3">
                                                                                    <label class="form-label">Employé <span
                                                                                            class="text-danger">*</span></label>
                                                                                    <select name="employe"
                                                                                        id="departement-select" required
                                                                                        class="form-select">
                                                                                        <option value="">Sélectionne
                                                                                        </option>
                                                                                        @foreach ($active as $depart)
                                                                                            <option
                                                                                                @if ($item->employe_id == $depart->id) selected @endif
                                                                                                value="{{ $depart->id }}">
                                                                                                {{ $depart->name }}
                                                                                                {{ $depart->last_name }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="mb-3">
                                                                                    <label class="form-label">Période
                                                                                        d'évaluation <span
                                                                                            class="text-danger">
                                                                                            *</span></label>
                                                                                    <div class="row">
                                                                                        <div
                                                                                            class="input-icon-end position-relative col-md-6">
                                                                                            <input name="debut" required
                                                                                                type="text"
                                                                                                value="{{ $item->periode_debut }}"
                                                                                                class="form-control datetimepicker"
                                                                                                placeholder="dd/mm/yyyy">
                                                                                            <span class="input-icon-addon">
                                                                                                <i
                                                                                                    class="ti ti-calendar text-gray-7"></i>
                                                                                            </span>
                                                                                        </div>
                                                                                        <div
                                                                                            class="input-icon-end position-relative col-md-6">
                                                                                            <input name="fin" required
                                                                                                type="text"
                                                                                                value="{{ $item->periode_fin }}"
                                                                                                class="form-control datetimepicker"
                                                                                                placeholder="dd/mm/yyyy">
                                                                                            <span class="input-icon-addon">
                                                                                                <i
                                                                                                    class="ti ti-calendar text-gray-7"></i>
                                                                                            </span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="mb-3">
                                                                                    <label class="form-label">Date
                                                                                        d'évaluation <span
                                                                                            class="text-danger">
                                                                                            *</span></label>
                                                                                    <div
                                                                                        class="input-icon-end position-relative">
                                                                                        <input name="date" required
                                                                                            type="text"
                                                                                            value="{{ $item->date_evaluation }}"
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
                                                                                    <label class="form-label">Evaluateur
                                                                                        <span
                                                                                            class="text-danger">*</span></label>
                                                                                    <select name="evaluateur" required
                                                                                        class="form-select">
                                                                                        <option value="">Sélectionne
                                                                                        </option>
                                                                                        @foreach ($active as $eva)
                                                                                            <option
                                                                                                @if ($item->evaluateur_id == $eva->id) selected @endif
                                                                                                value="{{ $eva->id }}">
                                                                                                {{ $eva->name }}
                                                                                                {{ $eva->last_name }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-12">
                                                                                <div class="mb-3">
                                                                                    <label class="form-label">Note moyenne
                                                                                        <span class="text-danger">
                                                                                            *</span></label>
                                                                                    <input name="notes" disabled required
                                                                                        type="number"
                                                                                        value="{{ $item->note_moyenne }}"
                                                                                        class="form-control">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-12">
                                                                                <div class="mb-3">
                                                                                    <label class="form-label">Commentaire
                                                                                        générale</label>
                                                                                    <textarea name="commentaire" class="form-control" rows="3">
                                                                                        {{ $item->commentaire }}
                                                                                    </textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button"
                                                                            class="btn btn-outline-light border me-2"
                                                                            data-bs-dismiss="modal">Annuler</button>
                                                                        <button type="submit"
                                                                            class="btn btn-info">Modifier</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <a href="#" data-bs-toggle="modal"
                                                data-bs-target="#delete_modal{{ $item->evaluation_id }}"><i
                                                    class="ti ti-trash"></i></a>
                                            <div class="modal fade" id="delete_modal{{ $item->evaluation_id }}">
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
                                                            <form
                                                                action="{{ route('evaluations.destroy', $item->evaluation_id) }}"
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
                        <h4 class="modal-title me-2">Evaluation</h4>
                    </div>
                    <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
                <div id="ajax-alert-container"></div>
                <form id="employee-form" method="post">
                    @csrf
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="basic-info" role="tabpanel"
                            aria-labelledby="info-tab" tabindex="0">
                            <div class="modal-body pb-0 ">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Employé <span class="text-danger">*</span></label>
                                            <select name="employe" id="departement-select" required class="form-select">
                                                <option value="">Sélectionne</option>
                                                @foreach ($active as $depart)
                                                    <option value="{{ $depart->id }}">
                                                        {{ $depart->name }} {{ $depart->last_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Période d'évaluation <span class="text-danger">
                                                    *</span></label>
                                            <div class="row">
                                                <div class="input-icon-end position-relative col-md-6">
                                                    <input name="debut" required type="text"
                                                        class="form-control datetimepicker" placeholder="dd/mm/yyyy">
                                                    <span class="input-icon-addon">
                                                        <i class="ti ti-calendar text-gray-7"></i>
                                                    </span>
                                                </div>
                                                <div class="input-icon-end position-relative col-md-6">
                                                    <input name="fin" required type="text"
                                                        class="form-control datetimepicker" placeholder="dd/mm/yyyy">
                                                    <span class="input-icon-addon">
                                                        <i class="ti ti-calendar text-gray-7"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <label for="">Objectif et critère d'évaluation</label>
                                    <div class="col-md-12">
                                        <div id="objectifs-wrapper">
                                            <div
                                                class="objectif-bloc d-flex align-items-center flex-wrap row-gap-3 bg-light w-100 rounded p-3 mb-4">
                                                <div class="profile-upload row col-md-12">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">Objectif <span class="text-danger">
                                                                    *</span></label></label>
                                                            <input name="objectifs[0][objectif]" required type="text"
                                                                class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">Note (sur 5) <span
                                                                    class="text-danger">*</span></label>
                                                            <input name="objectifs[0][note]" required type="number"
                                                                min="0" max="5" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="mb-3">
                                                            <label class="form-label">Appréciation <span
                                                                    class="text-danger">*</span></label>
                                                            <input name="objectifs[0][appreciation]" required
                                                                type="text" class="form-control">
                                                        </div>
                                                    </div>
                                                    <!-- Bouton Supprimer -->
                                                    <div class="col-md-12 text-end">
                                                        <button type="button"
                                                            class="btn btn-danger btn-sm remove-objectif">Supprimer</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Bouton Ajouter -->
                                        <button type="button" class="btn btn-primary btn-sm" id="add-objectif">Ajouter
                                            un objectif</button>
                                        <br>
                                        <br>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Date d'évaluation <span class="text-danger">
                                                    *</span></label>
                                            <div class="input-icon-end position-relative">
                                                <input name="date" required type="text"
                                                    class="form-control datetimepicker" placeholder="dd/mm/yyyy">
                                                <span class="input-icon-addon">
                                                    <i class="ti ti-calendar text-gray-7"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Evaluateur <span
                                                    class="text-danger">*</span></label>
                                            <select name="evaluateur" required class="form-select">
                                                <option value="">Sélectionne</option>
                                                @foreach ($active as $eva)
                                                    <option value="{{ $eva->id }}">
                                                        {{ $eva->name }} {{ $eva->last_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Note moyenne <span class="text-danger">
                                                    *</span></label>
                                            <input name="notes" disabled id="moyenne-note" required type="number"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Commentaire générale</label>
                                            <textarea name="commentaire" class="form-control" rows="3"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-light border me-2"
                                    data-bs-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-primary">Evaluer</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /Add Employee -->
@endsection
