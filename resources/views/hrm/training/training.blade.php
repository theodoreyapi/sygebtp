@extends('layouts.master', ['title' => 'Formation'])

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
                <h2 class="mb-1">Formation</h2>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="#"><i class="ti ti-smart-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            Performance
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Formation</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex my-xl-auto right-content align-items-center flex-wrap ">
                <div class="mb-2">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#add_training"
                        class="btn btn-primary d-flex align-items-center"><i class="ti ti-circle-plus me-2"></i>Ajouter une
                        formation
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
                <h5>Liste des formations</h5>
            </div>
            <div class="card-body p-0">
                <div class="custom-datatable-filter table-responsive">
                    <table class="table datatable">
                        <thead class="thead-light">
                            <tr>
                                <th>Type formation</th>
                                <th>Formateur</th>
                                <th>Employés</th>
                                <th>Durée</th>
                                <th>Description</th>
                                <th>Coût</th>
                                <th>Statut</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($all as $item => $items)
                                @php $formation = $items->first(); @endphp
                                <tr>
                                    <td>
                                        {{ $formation->type }}
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center file-name-icon">
                                            <div class="ms-2">
                                                <h6 class="fw-medium"><a href="#">{{ $formation->name_trai }}
                                                        {{ $formation->lastname_trai }}</a></h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="avatar-list-stacked avatar-group-sm">
                                            @foreach ($items as $emp)
                                                <span class="avatar border-0">
                                                    <img title="{{ $emp->employe_name }} {{ $emp->employe_last_name ?? '' }}"
                                                        src="{{ $emp->employe_photo == '' ? URL::asset('assets/img/users/user-01.jpg') : url($emp->employe_photo) }} }}"
                                                        class="rounded-circle" alt="img">
                                                </span>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td>{{ $formation->start_traini }} - {{ $formation->end_traini }}</td>
                                    <td>{{ $formation->description_traini }}</td>
                                    <td>{{ $formation->cost_traini }} FCFA</td>
                                    <td>
                                        @if ($formation->status_traini == 'Active')
                                            <span class="badge badge-success d-inline-flex align-items-center badge-xs">
                                                <i class="ti ti-point-filled me-1"></i>Active
                                            </span>
                                        @else
                                            <span class="badge badge-danger d-inline-flex align-items-center badge-xs">
                                                <i class="ti ti-point-filled me-1"></i>Inactive
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="action-icon d-inline-flex">
                                            <a href="#" class="me-2" data-bs-toggle="modal"
                                                data-bs-target="#edit_training{{ $formation->traini }}"><i
                                                    class="ti ti-edit"></i></a>
                                            <a href="#" data-bs-toggle="modal"
                                                data-bs-target="#delete_modal{{ $formation->traini }}"><i
                                                    class="ti ti-trash"></i></a>
                                            <!-- Edit Training -->
                                            <div class="modal fade" id="edit_training{{ $formation->traini }}">
                                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Modification</h4>
                                                            <button type="button" class="btn-close custom-btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close">
                                                                <i class="ti ti-x"></i>
                                                            </button>
                                                        </div>
                                                        <form action="{{ route('training.update', $formation->traini) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('PATCH')
                                                            <div class="modal-body pb-0">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Type de
                                                                                formation</label>
                                                                            <br>
                                                                            <select name="type" required class="select">
                                                                                <option value="">Sélectionne</option>
                                                                                @foreach ($types as $type)
                                                                                    <option
                                                                                        @if ($type->trai_type == $formation->type_id) selected @endif
                                                                                        value="{{ $type->trai_type }}">
                                                                                        {{ $type->type }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Formateur</label>
                                                                            <br>
                                                                            <select name="formateur" required
                                                                                class="select">
                                                                                <option value="">Sélectionne</option>
                                                                                @foreach ($formateurs as $formateur)
                                                                                    <option
                                                                                        @if ($formateur->trai == $formation->trainer_id) selected @endif
                                                                                        value="{{ $formateur->trai }}">
                                                                                        {{ $formateur->name_trai }}
                                                                                        {{ $formateur->lastname_trai }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Employé</label>
                                                                            <br>
                                                                            <select name="employe[]" required
                                                                                class="select2 select2-hidden-accessible"
                                                                                multiple>
                                                                                @foreach ($employes as $employe)
                                                                                    <option
                                                                                        @if ($employe->id == $formation->employe_id) selected @endif
                                                                                        value="{{ $employe->id }}">
                                                                                        {{ $employe->name }}
                                                                                        {{ $employe->last_name }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Coût de la
                                                                                formation</label>
                                                                            <input name="cout" required type="number"
                                                                                class="form-control"
                                                                                value="{{ $formation->cost_traini }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Date début</label>
                                                                            <div class="input-icon-end position-relative">
                                                                                <input name="debut" required
                                                                                    type="text"
                                                                                    value="{{ $formation->start_traini }}"
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
                                                                            <label class="form-label">Date fin</label>
                                                                            <div class="input-icon-end position-relative">
                                                                                <input required name="fin"
                                                                                    type="text"
                                                                                    value="{{ $formation->end_traini }}"
                                                                                    class="form-control datetimepicker"
                                                                                    placeholder="dd/mm/yyyy">
                                                                                <span class="input-icon-addon">
                                                                                    <i
                                                                                        class="ti ti-calendar text-gray-7"></i>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Description</label>
                                                                            <textarea name="description" class="form-control">
                                                                                {{ $formation->description_traini }}
                                                                            </textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Statut</label>
                                                                            <br>
                                                                            <select name="statut" required
                                                                                class="select">
                                                                                <option
                                                                                    @if ($formation->start_traini == 'Active') selected @endif
                                                                                    value="Active">Active</option>
                                                                                <option
                                                                                    @if ($formation->start_traini == 'Inactive') selected @endif
                                                                                    value="Inactive">Inactive</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-light me-2"
                                                                    data-bs-dismiss="modal">Annuler</button>
                                                                <button type="submit"
                                                                    class="btn btn-info">Modifier</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /Edit Training -->

                                            <!-- Delete Modal -->
                                            <div class="modal fade" id="delete_modal{{ $formation->traini }}">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-body text-center">
                                                            <span
                                                                class="avatar avatar-xl bg-transparent-danger text-danger mb-3">
                                                                <i class="ti ti-trash-x fs-36"></i>
                                                            </span>
                                                            <h4 class="mb-1">Confirmez la suppression</h4>
                                                            <p class="mb-3">You want to delete all the marked items, this
                                                                cant be undone once you delete.</p>
                                                            <form
                                                                action="{{ route('training.destroy', $formation->traini) }}"
                                                                method="post">
                                                                @csrf
                                                                @method('DELETE')
                                                                <div class="d-flex justify-content-center">
                                                                    <a href="javascript:void(0);"
                                                                        class="btn btn-light me-3"
                                                                        data-bs-dismiss="modal">Annuler</a>
                                                                    <button class="btn btn-danger">Oui,
                                                                        Supprimer</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /Delete Modal -->
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
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
                    <h4 class="modal-title">Ajout d'une formation</h4>
                    <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
                <form action="{{ route('training.store') }}" method="post" role="form">
                    @csrf
                    <div class="modal-body pb-0">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Type de formation</label>
                                    <select name="type" required class="select">
                                        <option value="">Sélectionne</option>
                                        @foreach ($types as $type)
                                            <option value="{{ $type->trai_type }}">
                                                {{ $type->type }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Formateur</label>
                                    <select name="formateur" required class="select">
                                        <option value="">Sélectionne</option>
                                        @foreach ($formateurs as $formateur)
                                            <option value="{{ $formateur->trai }}">{{ $formateur->name_trai }}
                                                {{ $formateur->lastname_trai }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Employé</label>
                                    <select name="employe[]" required class="select2 select2-hidden-accessible" multiple>
                                        @foreach ($employes as $employe)
                                            <option value="{{ $employe->id }}">{{ $employe->name }}
                                                {{ $employe->last_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Coût de la formation</label>
                                    <input name="cout" required type="number" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Date début</label>
                                    <div class="input-icon-end position-relative">
                                        <input name="debut" required type="text" class="form-control datetimepicker"
                                            placeholder="dd/mm/yyyy">
                                        <span class="input-icon-addon">
                                            <i class="ti ti-calendar text-gray-7"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Date fin</label>
                                    <div class="input-icon-end position-relative">
                                        <input required name="fin" type="text" class="form-control datetimepicker"
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
                                    <textarea name="description" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Statut</label>
                                    <select name="statut" required class="select">
                                        <option value="">Sélectionne</option>
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Ajouter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /Add Training -->
@endsection
