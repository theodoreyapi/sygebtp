@extends('layouts.master', ['title' => 'Termination'])

@push('csss')
    <!-- Tabler Icon CSS -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/plugins/tabler-icons/tabler-icons.css">

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/plugins/select2/css/select2.min.css">

    <!-- Player CSS -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/css/plyr.css">

    <!-- Datatable CSS -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/css/dataTables.bootstrap5.min.css">

    <!-- Datepicker CSS -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/css/bootstrap-datetimepicker.min.css">

    <!-- Daterangepikcer CSS -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/plugins/daterangepicker/daterangepicker.css">

    <!-- Owl Carousel -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/plugins/owlcarousel/owl.carousel.min.css">

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/plugins/select2/css/select2.min.css">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/plugins/fontawesome/css/all.min.css">

    <!-- Color Picker Css -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/plugins/flatpickr/flatpickr.min.css">
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/plugins/@simonwep/pickr/themes/nano.min.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/css/style.css">
@endpush
@push('scripts')
    <!-- Slimscroll JS -->
    <script src="{{ URL::asset('') }}assets/js/jquery.slimscroll.min.js"></script>

    <!-- Color Picker JS -->
    <script src="{{ URL::asset('') }}assets/js/plyr-js.js"></script>
    <script src="{{ URL::asset('') }}assets/plugins/@simonwep/pickr/pickr.es5.min.js"></script>

    <!-- Datatable JS -->
    <script src="{{ URL::asset('') }}assets/js/jquery.dataTables.min.js"></script>
    <script src="{{ URL::asset('') }}assets/js/dataTables.bootstrap5.min.js"></script>

    <!-- Datepicker Core JS -->
    <script src="{{ URL::asset('') }}assets/plugins/moment/moment.min.js"></script>
    <script src="{{ URL::asset('') }}assets/js/bootstrap-datetimepicker.min.js"></script>

    <!-- Daterangepikcer JS -->
    <script src="{{ URL::asset('') }}assets/js/moment.js"></script>
    <script src="{{ URL::asset('') }}assets/plugins/daterangepicker/daterangepicker.js"></script>
    <script src="{{ URL::asset('') }}assets/js/bootstrap-datetimepicker.min.js"></script>

    <!-- Chart JS -->
    <script src="{{ URL::asset('') }}assets/plugins/apexchart/apexcharts.min.js"></script>
    <script src="{{ URL::asset('') }}assets/plugins/apexchart/chart-data.js"></script>

    <!-- Owl Carousel -->
    <script src="{{ URL::asset('') }}assets/plugins/owlcarousel/owl.carousel.min.js"></script>

    <!-- Select2 JS -->
    <script src="{{ URL::asset('') }}assets/plugins/select2/js/select2.min.js"></script>

    <!-- Custom JS -->
    <script src="{{ URL::asset('') }}assets/js/theme-colorpicker.js"></script>
    <script src="{{ URL::asset('') }}assets/js/script.js"></script>
@endpush

@section('content')
    <div class="content">

        <!-- Breadcrumb -->
        <div class="d-md-flex d-block align-items-center justify-content-between page-breadcrumb mb-3">
            <div class="my-auto mb-2">
                <h2 class="mb-1">Fin de contrat</h2>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="#"><i class="ti ti-smart-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            Performance
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Fin de contrat</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex my-xl-auto right-content align-items-center flex-wrap ">

                <div class="mb-2">
                    <a href="#" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal"
                        data-bs-target="#new_termination"><i class="ti ti-circle-plus me-2"></i>Ajouter une résiliation</a>
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

        <!-- Termination List -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
                        <h5 class="d-flex align-items-center">Liste de résiliation</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="custom-datatable-filter table-responsive">
                            <table class="table datatable">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Employé démissionnaire</th>
                                        <th>Département</th>
                                        <th>Type de résiliation</th>
                                        <th>Date de l'avis</th>
                                        <th>Raison</th>
                                        <th>Date de démission</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($all as $item)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <a href="#" class="avatar avatar-md" data-bs-toggle="modal"
                                                        data-bs-target="#view_details"><img
                                                            src="{{ $item->employe_photo == '' ? URL::asset('assets/img/users/user-36.jpg') : url($item->employe_photo) }}"
                                                            class="img-fluid rounded-circle" alt="img"></a>
                                                    <div class="ms-2">
                                                        <p class="text-dark mb-0"><a
                                                                href="#">{{ $item->employe_name }}<br>
                                                                {{ $item->employe_last_name }}</a>
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $item->employe_departement }}</td>
                                            <td>{{ $item->type_termi }}</td>
                                            <td>{{ $item->notice_date_termi }}</td>
                                            <td>{{ $item->reason_termi }}</td>
                                            <td>{{ $item->design_date_termi }}</td>
                                            <td>
                                                <div class="action-icon d-inline-flex">
                                                    <a href="#" class="me-2" data-bs-toggle="modal"
                                                        data-bs-target="#edit_termination{{ $item->termi }}"><i
                                                            class="ti ti-edit"></i></a>
                                                    <a href="#" data-bs-toggle="modal"
                                                        data-bs-target="#delete_modal{{ $item->termi }}"><i
                                                            class="ti ti-trash"></i></a>
                                                </div>
                                                <div class="modal fade" id="edit_termination{{ $item->termi }}">
                                                    <div class="modal-dialog modal-dialog-centered modal-md">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Modification</h4>
                                                                <button type="button" class="btn-close custom-btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close">
                                                                    <i class="ti ti-x"></i>
                                                                </button>
                                                            </div>
                                                            <form action="{{ route('termination.update', $item->termi) }}"
                                                                method="post">
                                                                @csrf
                                                                @method('PATCH')
                                                                <div class="modal-body pb-0">
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <div class="mb-3">
                                                                                <label class="form-label">Employé
                                                                                    licencié</label>
                                                                                <br>
                                                                                <select name="employe" required
                                                                                    class="select">
                                                                                    <option>Choisir</option>
                                                                                    @foreach ($employes as $employe)
                                                                                        <option
                                                                                            @if ($item->employe_id == $employe->id) selected @endif
                                                                                            value="{{ $employe->id }}">
                                                                                            {{ $employe->name }}
                                                                                            {{ $employe->last_name }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-12">
                                                                            <div class="mb-3">
                                                                                <label class="form-label">Type de
                                                                                    résiliation</label>
                                                                                <input type="text" name="type"
                                                                                    value="{{ $item->type_termi }}"
                                                                                    required class="form-control"
                                                                                    placeholder="Retirement, Licenciément etc.">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-12">
                                                                            <div class="mb-3">
                                                                                <label class="form-label">Date de
                                                                                    l'avis</label>
                                                                                <div
                                                                                    class="input-icon-end position-relative">
                                                                                    <input name="avis" required
                                                                                        type="text"
                                                                                        value="{{ $item->notice_date_termi }}"
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
                                                                                <label class="form-label">Raison</label>
                                                                                <textarea name="raison" required class="form-control" rows="3">
                                                                                    {{ $item->reason_termi }}
                                                                                </textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-12">
                                                                            <div class="mb-3">
                                                                                <label class="form-label">Date de
                                                                                    démission</label>
                                                                                <div
                                                                                    class="input-icon-end position-relative">
                                                                                    <input name="demission" type="text"
                                                                                        value="{{ $item->design_date_termi }}"
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
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button"
                                                                        class="btn btn-white border me-2"
                                                                        data-bs-dismiss="modal">Annuler</button>
                                                                    <button type="submit"
                                                                        class="btn btn-info">Enregistrer</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal fade" id="delete_modal{{ $item->termi }}">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-body text-center">
                                                                <span
                                                                    class="avatar avatar-xl bg-transparent-danger text-danger mb-3">
                                                                    <i class="ti ti-trash-x fs-36"></i>
                                                                </span>
                                                                <h4 class="mb-1">Confirmez la suppression</h4>
                                                                <p class="mb-3">You want to delete all the marked items,
                                                                    this
                                                                    cant be undone once you delete.</p>
                                                                <form
                                                                    action="{{ route('termination.destroy', $item->termi) }}"
                                                                    method="post">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <div class="d-flex justify-content-center">
                                                                        <a href="javascript:void(0);"
                                                                            class="btn btn-light me-3"
                                                                            data-bs-dismiss="modal">Annuler</a>
                                                                        <button href="termination.html"
                                                                            class="btn btn-danger">Oui,
                                                                            Supprimer</button>
                                                                    </div>
                                                                </form>
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
        </div>
        <!-- /Termination List  -->
    </div>

    <!-- Add Termination -->
    <div class="modal fade" id="new_termination">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Ajouter une résiliation</h4>
                    <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
                <form action="{{ route('termination.store') }}" method="post">
                    @csrf
                    <div class="modal-body pb-0">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Employé licencié</label>
                                    <select name="employe" required class="select">
                                        <option>Choisir</option>
                                        @foreach ($employes as $employe)
                                            <option value="{{ $employe->id }}">{{ $employe->name }}
                                                {{ $employe->last_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Type de résiliation</label>
                                    <input type="text" name="type" required class="form-control"
                                        placeholder="Retirement, Licenciément etc.">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Date de l'avis</label>
                                    <div class="input-icon-end position-relative">
                                        <input name="avis" required type="text" class="form-control datetimepicker"
                                            placeholder="dd/mm/yyyy">
                                        <span class="input-icon-addon">
                                            <i class="ti ti-calendar text-gray-7"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Raison</label>
                                    <textarea name="raison" required class="form-control" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Date de démission</label>
                                    <div class="input-icon-end position-relative">
                                        <input name="demission" type="text" class="form-control datetimepicker"
                                            placeholder="dd/mm/yyyy">
                                        <span class="input-icon-addon">
                                            <i class="ti ti-calendar text-gray-7"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white border me-2" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /Add Termination -->
@endsection
