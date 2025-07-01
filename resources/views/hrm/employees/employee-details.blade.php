@extends('layouts.master', ['title' => 'Details employe'])

@push('csss')
    <!-- Datatable CSS -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/css/dataTables.bootstrap5.min.css">

    <!-- Tabler Icon CSS -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/plugins/tabler-icons/tabler-icons.css">

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/plugins/select2/css/select2.min.css">

    <!-- Datetimepicker CSS -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/css/bootstrap-datetimepicker.min.css">

    <!-- Summernote CSS -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/plugins/summernote/summernote-lite.min.css">

    <!-- Color Picker Css -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/plugins/flatpickr/flatpickr.min.css">
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/plugins/@simonwep/pickr/themes/nano.min.css">

    <!-- Daterangepikcer CSS -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/plugins/daterangepicker/daterangepicker.css">

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/plugins/select2/css/select2.min.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ URL::asset('') }}assets/css/style.css">
@endpush

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    // education
    <script>
        $(document).ready(function() {
            $('#education-form').on('submit', function(e) {
                e.preventDefault();

                let formData = $(this).serialize();
                let submitBtn = $('#education-form button[type=submit]');
                submitBtn.prop('disabled', true).text('Enregistrement...');

                // Nettoyage des anciennes alertes
                $('#ajax-alert-container').html('');

                $.ajax({
                    url: "{{ url('add-education/' . $details->id) }}",
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        // Fermer la modal
                        $('#add_education').modal('hide');

                        // Réinitialiser le formulaire
                        $('#education-form')[0].reset();

                        // Recharger la liste sans recharger la page
                        $('#education-list').load(location.href + " #education-list>*", "");

                        // Afficher une alerte de succès
                        $('#ajax-alert-container').html(`
                        <div class="alert alert-success rounded-pill alert-dismissible fade show mt-3">
                            Vous avez ajouté une formation avec succès !
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
                $('#edit-debutt').val(debut);
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

    // experience
    <script>
        $(document).ready(function() {
            $('#experience-form').on('submit', function(e) {
                e.preventDefault();

                let formData = $(this).serialize();
                let submitBtn = $('#experience-form button[type=submit]');
                submitBtn.prop('disabled', true).text('Enregistrement...');

                // Nettoyage des anciennes alertes
                $('#ajax-alert-container').html('');

                $.ajax({
                    url: "{{ url('add-experience/' . $details->id) }}",
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        // Fermer la modal
                        $('#add_experience').modal('hide');

                        // Réinitialiser le formulaire
                        $('#experience-form')[0].reset();

                        // Recharger la liste sans recharger la page
                        $('#experience-list').load(location.href + " #experience-list>*", "");

                        // Afficher une alerte de succès
                        $('#ajax-alert-container').html(`
                        <div class="alert alert-success rounded-pill alert-dismissible fade show mt-3">
                            Vous avez ajouté une experience avec succès !
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
            $(document).on('click', '.edit-experience', function() {
                // Récupération des données dynamiques
                let id = $(this).data('id');
                let entreprise = $(this).data('entreprise');
                let poste = $(this).data('poste');
                let debut = $(this).data('debut');
                let fin = $(this).data('fin');
                let present = $(this).data('present');

                // Injection dans les champs
                $('#edit-id').val(id);
                $('#edit-entreprise').val(entreprise);
                $('#edit-poste').val(poste);
                $('#edit-debut').val(debut);
                $('#edit-fin').val(fin);
                $('#edit-present').val(present);
            });

            // Soumission du formulaire de modification (existant)
            $('#edit-experience-form').on('submit', function(e) {
                e.preventDefault();

                let formData = $(this).serialize();
                let id = $('#edit-id').val();

                $.ajax({
                    url: `/edit-experience/${id}`,
                    method: 'POST',
                    data: formData,
                    success: function() {
                        $('#edit_experience_modal').modal('hide');
                        $('#experience-list').load(location.href + " #experience-list>*", "");

                        $('#ajax-alert-container').html(`
                    <div class="alert alert-success rounded-pill alert-dismissible fade show mt-3">
                        Experience modifiée avec succès !
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
            $(document).on('click', '.delete-experience', function() {
                deleteId = $(this).data('id');
                $('#delete-experience-id').val(deleteId); // facultatif
            });

            // Quand on clique sur le bouton "Oui, supprimer"
            $('#confirm-delete-experience').on('click', function() {
                const id = deleteId;

                $.ajax({
                    url: `/delete-experience/${id}`,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function() {
                        $('#delete_experience_modal').modal('hide');
                        $('#experience-list').load(location.href + " #experience-list>*", "");
                        $('#ajax-alert-container').html(`
                        <div class="alert alert-success rounded-pill alert-dismissible fade show mt-3">
                            Experience supprimée avec succès.
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

    <!-- Summernote JS -->
    <script src="{{ URL::asset('') }}assets/plugins/summernote/summernote-lite.min.js"></script>

    <!-- Sticky Sidebar JS -->
    <script src="{{ URL::asset('') }}assets/plugins/theia-sticky-sidebar/ResizeSensor.js"></script>
    <script src="{{ URL::asset('') }}assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js"></script>

    <!-- Color Picker JS -->
    <script src="{{ URL::asset('') }}assets/plugins/@simonwep/pickr/pickr.es5.min.js"></script>

    <!-- Datatable JS -->
    <script src="{{ URL::asset('') }}assets/js/jquery.dataTables.min.js"></script>
    <script src="{{ URL::asset('') }}assets/js/dataTables.bootstrap5.min.js"></script>

    <!-- Datetimepicker JS -->
    <script src="{{ URL::asset('') }}assets/js/moment.js"></script>

    <!-- Daterangepikcer JS -->
    <script src="{{ URL::asset('') }}assets/js/moment.js"></script>
    <script src="{{ URL::asset('') }}assets/plugins/daterangepicker/daterangepicker.js"></script>
    <script src="{{ URL::asset('') }}assets/js/bootstrap-datetimepicker.min.js"></script>

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
                <h6 class="fw-medium d-inline-flex align-items-center mb-3 mb-sm-0"><a href="{{ url('employees') }}">
                        <i class="ti ti-arrow-left me-2"></i>Détails Employé</a>
                </h6>
            </div>
            <div class="d-flex my-xl-auto right-content align-items-center flex-wrap ">
                {{-- <div class="mb-2">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#add_bank_satutory"
                        class="btn btn-primary d-flex align-items-center"><i class="ti ti-circle-plus me-2"></i>Bank &
                        Statutory</a>
                </div> --}}
                <div class="head-icons ms-2">
                    <a href="javascript:void(0);" class="" data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-original-title="Collapse" id="collapse-header">
                        <i class="ti ti-chevrons-up"></i>
                    </a>
                </div>
            </div>
        </div>
        <!-- /Breadcrumb -->

        <div id="ajax-alert-container"></div>

        <div class="row">
            <div class="col-xl-4 theiaStickySidebar">
                <div class="card card-bg-1">
                    <div class="card-body p-0">
                        <span class="avatar avatar-xl avatar-rounded border border-2 border-white m-auto d-flex mb-2">
                            <img src="{{ $details->photo == '' ? URL::asset('assets/img/users/user-13.jpg') : url($details->photo) }}"
                                class="w-auto h-auto" alt="Img">
                        </span>
                        <div class="text-center px-3 pb-3 border-bottom">
                            <div class="mb-3">
                                <h5 class="d-flex align-items-center justify-content-center mb-1">
                                    {{ $details->name }} {{ $details->last_name }}
                                    <i class="ti ti-discount-check-filled text-success ms-1"></i>
                                </h5>
                                <span class="badge badge-soft-dark fw-medium me-2">
                                    <i class="ti ti-point-filled me-1"></i>
                                    {{ $details->name_designation }}
                                </span>
                                {{-- <span class="badge badge-soft-secondary fw-medium">10+ years of
                                    Experience</span> --}}
                            </div>
                            <div>
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="d-inline-flex align-items-center">
                                        <i class="ti ti-id me-2"></i>
                                        Employé ID
                                    </span>
                                    <p class="text-dark">EMP-00{{ $details->id }}</p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="d-inline-flex align-items-center">
                                        <i class="ti ti-star me-2"></i>
                                        Equipe
                                    </span>
                                    <p class="text-dark">{{ $details->deparment_name }}</p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="d-inline-flex align-items-center">
                                        <i class="ti ti-calendar-check me-2"></i>
                                        Date d'embauche
                                    </span>
                                    <p class="text-dark">{{ $details->date_embauche }}</p>
                                </div>
                                {{-- <div class="d-flex align-items-center justify-content-between">
                                    <span class="d-inline-flex align-items-center">
                                        <i class="ti ti-calendar-check me-2"></i>
                                        Report Office
                                    </span>
                                    <div class="d-flex align-items-center">
                                        <span class="avatar avatar-sm avatar-rounded me-2">
                                            <img src="{{ URL::asset('') }}assets/img/profiles/avatar-12.jpg"
                                                alt="Img">
                                        </span>
                                        <p class="text-gray-9 mb-0">Doglas Martini</p>
                                    </div>
                                </div> --}}
                                {{-- <div class="row gx-2 mt-3">
                                    <div class="col-6">
                                        <div>
                                            <a href="#" class="btn btn-dark w-100" data-bs-toggle="modal"
                                                data-bs-target="#edit_employee"><i class="ti ti-edit me-1"></i>Edit Info</a>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div>
                                            <a href="chat.html" class="btn btn-primary w-100"><i
                                                    class="ti ti-message-heart me-1"></i>Message</a>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                        <div class="p-3 border-bottom">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6>Informations basiques</h6>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="d-inline-flex align-items-center">
                                    <i class="ti ti-phone me-2"></i>
                                    Téléphone
                                </span>
                                <p class="text-dark">{{ $details->phone }}</p>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="d-inline-flex align-items-center">
                                    <i class="ti ti-mail-check me-2"></i>
                                    E-mail
                                </span>
                                <a href="javascript:void(0);"
                                    class="text-info d-inline-flex align-items-center">{{ $details->email }}<i
                                        class="ti ti-copy text-dark ms-2"></i></a>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="d-inline-flex align-items-center">
                                    <i class="ti ti-gender-male me-2"></i>
                                    Sexe
                                </span>
                                <p class="text-dark text-end">{{ $details->sexe }}</p>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="d-inline-flex align-items-center">
                                    <i class="ti ti-cake me-2"></i>
                                    Date anniversaire
                                </span>
                                <p class="text-dark text-end">{{ $details->date_naissance }}</p>
                            </div>
                            <div class="d-flex align-items-center justify-content-between">
                                <span class="d-inline-flex align-items-center">
                                    <i class="ti ti-map-pin-check me-2"></i>
                                    Habitation
                                </span>
                                <p class="text-dark text-end">{{ $details->lieu_residence }}</p>
                            </div>
                        </div>
                        <div class="p-3 border-bottom">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6>Informationns personnelles</h6>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="d-inline-flex align-items-center">
                                    <i class="ti ti-e-passport me-2"></i>
                                    Type pièce
                                </span>
                                <p class="text-dark">{{ $details->type_papier }}</p>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="d-inline-flex align-items-center">
                                    <i class="ti ti-e-passport me-2"></i>
                                    Numéro pièce
                                </span>
                                <p class="text-dark">{{ $details->numero_papier }}</p>
                            </div>
                            {{-- <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="d-inline-flex align-items-center">
                                    <i class="ti ti-calendar-x me-2"></i>
                                    Passport Exp Date
                                </span>
                                <p class="text-dark text-end">15 May 2029</p>
                            </div> --}}
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="d-inline-flex align-items-center">
                                    <i class="ti ti-gender-male me-2"></i>
                                    Nationnalité
                                </span>
                                <p class="text-dark text-end">{{ $details->nationnalite }}</p>
                            </div>
                            {{-- <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="d-inline-flex align-items-center">
                                    <i class="ti ti-bookmark-plus me-2"></i>
                                    Religion
                                </span>
                                <p class="text-dark text-end">Christianity</p>
                            </div> --}}
                            {{-- <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="d-inline-flex align-items-center">
                                    <i class="ti ti-hotel-service me-2"></i>
                                    Marital status
                                </span>
                                <p class="text-dark text-end">Yes</p>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="d-inline-flex align-items-center">
                                    <i class="ti ti-briefcase-2 me-2"></i>
                                    Employment of spouse
                                </span>
                                <p class="text-dark text-end">No</p>
                            </div> --}}
                            <div class="d-flex align-items-center justify-content-between">
                                <span class="d-inline-flex align-items-center">
                                    <i class="ti ti-baby-bottle me-2"></i>
                                    Nombre enfant
                                </span>
                                <p class="text-dark text-end">{{ $details->enfant }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <h6>Contact en cas d'urgence</h6>
                    <a href="javascript:void(0);" class="btn btn-icon btn-sm" data-bs-toggle="modal"
                        data-bs-target="#edit_emergency"><i class="ti ti-edit"></i></a>
                </div>
                <div class="card">
                    <div class="card-body p-0">
                        <div class="p-3 border-bottom">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <span class="d-inline-flex align-items-center">
                                        Primary
                                    </span>
                                    <h6 class="d-flex align-items-center fw-medium mt-1">Adrian Peralt <span
                                            class="d-inline-flex mx-1"><i
                                                class="ti ti-point-filled text-danger"></i></span>Father</h6>
                                </div>
                                <p class="text-dark">+1 127 2685 598</p>
                            </div>
                        </div>
                        <div class="p-3 border-bottom">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <span class="d-inline-flex align-items-center">
                                        Secondry
                                    </span>
                                    <h6 class="d-flex align-items-center fw-medium mt-1">Karen Wills <span
                                            class="d-inline-flex mx-1"><i
                                                class="ti ti-point-filled text-danger"></i></span>Mother</h6>
                                </div>
                                <p class="text-dark">+1 989 7774 787</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-8">
                <div>
                    <div class="tab-content custom-accordion-items">
                        <div class="tab-pane active show" id="bottom-justified-tab1" role="tabpanel">
                            <div class="accordion accordions-items-seperate" id="accordionExample">
                                <div class="accordion-item">
                                    <div class="accordion-header" id="headingOne">
                                        <div class="accordion-button">
                                            <div class="d-flex align-items-center flex-fill">
                                                <h5>Apropos</h5>
                                                <a href="#" class="btn btn-sm btn-icon ms-auto"></a>
                                                <a href="#"
                                                    class="d-flex align-items-center collapsed collapse-arrow"
                                                    data-bs-toggle="collapse" data-bs-target="#primaryBorderOne"
                                                    aria-expanded="false" aria-controls="primaryBorderOne">
                                                    <i class="ti ti-chevron-down fs-18"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="primaryBorderOne" class="accordion-collapse collapse show border-top"
                                        aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        <div class="accordion-body mt-2">
                                            {{ $details->about }}
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <div class="accordion-header" id="headingTwo">
                                        <div class="accordion-button">
                                            <div class="d-flex align-items-center flex-fill">
                                                <h5>Information bancaire</h5>
                                                <a href="#" class="btn btn-sm btn-icon ms-auto"
                                                    data-bs-toggle="modal" data-bs-target="#add_bank"><i
                                                        class="ti ti-plus"></i></a>
                                                <a href="#"
                                                    class="d-flex align-items-center collapsed collapse-arrow"
                                                    data-bs-toggle="collapse" data-bs-target="#primaryBorderTwo"
                                                    aria-expanded="false" aria-controls="primaryBorderTwo">
                                                    <i class="ti ti-chevron-down fs-18"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="primaryBorderTwo" class="accordion-collapse collapse border-top"
                                        aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            @foreach ($banks as $bank)
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <span class="d-inline-flex align-items-center">
                                                            Nom de la banque
                                                        </span>
                                                        <h6 class="d-flex align-items-center fw-medium mt-1">
                                                            {{ $bank->name_bank }}
                                                        </h6>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <span class="d-inline-flex align-items-center">
                                                            Code banque
                                                        </span>
                                                        <h6 class="d-flex align-items-center fw-medium mt-1">
                                                            {{ $bank->code_bank }}</h6>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <span class="d-inline-flex align-items-center">
                                                            Code guichet
                                                        </span>
                                                        <h6 class="d-flex align-items-center fw-medium mt-1">
                                                            {{ $bank->code_guichet_bank }}</h6>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <span class="d-inline-flex align-items-center">
                                                            Numéro compte
                                                        </span>
                                                        <h6 class="d-flex align-items-center fw-medium mt-1">
                                                            {{ $bank->number_compte_bank }}</h6>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <span class="d-inline-flex align-items-center">
                                                            Clé RIB
                                                        </span>
                                                        <h6 class="d-flex align-items-center fw-medium mt-1">
                                                            {{ $bank->cle_rib_bank }}</h6>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <span class="d-inline-flex align-items-center">
                                                            IBAN
                                                        </span>
                                                        <h6 class="d-flex align-items-center fw-medium mt-1">
                                                            {{ $bank->iban_bank }}</h6>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <span class="d-inline-flex align-items-center">
                                                            SWIFT
                                                        </span>
                                                        <h6 class="d-flex align-items-center fw-medium mt-1">
                                                            {{ $bank->swift_bank }}</h6>
                                                    </div>
                                                    <div class="col-md-3">
                                                        @if ($bank->statut_bank == 'Active')
                                                            <span
                                                                class="badge badge-success d-inline-flex align-items-center badge-sm">
                                                                <i class="ti ti-point-filled me-1"></i>Active
                                                            </span>
                                                        @else
                                                            <span
                                                                class="badge badge-danger d-inline-flex align-items-center badge-sm">
                                                                <i class="ti ti-point-filled me-1"></i>Inactive
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-3">
                                                        <a href="#" class="me-2" data-bs-toggle="modal"
                                                            data-bs-target="#edit_employee{{ $bank->bank }}"><i
                                                                class="ti ti-edit text-info"></i></a>
                                                        <div class="modal fade" id="edit_employee{{ $bank->bank }}">
                                                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title">Modification</h4>
                                                                        <button type="button"
                                                                            class="btn-close custom-btn-close"
                                                                            data-bs-dismiss="modal" aria-label="Close">
                                                                            <i class="ti ti-x"></i>
                                                                        </button>
                                                                    </div>
                                                                    <form action="{{ url('bankupdate', $bank->bank) }}"
                                                                        method="POST" role="form">
                                                                        @csrf
                                                                        @method('PATCH')
                                                                        <div class="modal-body pb-0">
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <div class="mb-3">
                                                                                        <label class="form-label">Nom de la
                                                                                            banque <span
                                                                                                class="text-danger">
                                                                                                *</span></label>
                                                                                        <input required name="libelle"
                                                                                            type="text"
                                                                                            value="{{ $bank->name_bank }}"
                                                                                            class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-12">
                                                                                    <div class="mb-3">
                                                                                        <label class="form-label">Code
                                                                                            banque <span
                                                                                                class="text-danger">
                                                                                                *</span></label>
                                                                                        <input required name="code"
                                                                                            type="text"
                                                                                            value="{{ $bank->code_bank }}"
                                                                                            class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-12">
                                                                                    <div class="mb-3">
                                                                                        <label class="form-label">Code
                                                                                            guichet <span
                                                                                                class="text-danger">
                                                                                                *</span></label>
                                                                                        <input required name="guichet"
                                                                                            type="text"
                                                                                            value="{{ $bank->code_guichet_bank }}"
                                                                                            class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-12">
                                                                                    <div class="mb-3">
                                                                                        <label class="form-label">Numéro de
                                                                                            compte <span
                                                                                                class="text-danger">
                                                                                                *</span></label>
                                                                                        <input required name="numero"
                                                                                            type="text"
                                                                                            value="{{ $bank->number_compte_bank }}"
                                                                                            class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-12">
                                                                                    <div class="mb-3">
                                                                                        <label class="form-label">Clé RIB
                                                                                            <span class="text-danger">
                                                                                                *</span></label>
                                                                                        <input required name="rib"
                                                                                            type="text"
                                                                                            value="{{ $bank->cle_rib_bank }}"
                                                                                            class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-12">
                                                                                    <div class="mb-3">
                                                                                        <label class="form-label">IBAN
                                                                                            <span class="text-danger">
                                                                                                *</span></label>
                                                                                        <input required name="iban"
                                                                                            type="text"
                                                                                            value="{{ $bank->iban_bank }}"
                                                                                            class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-12">
                                                                                    <div class="mb-3">
                                                                                        <label class="form-label">SWIFT
                                                                                            <span class="text-danger">
                                                                                                *</span></label>
                                                                                        <input required name="swift"
                                                                                            type="text"
                                                                                            value="{{ $bank->swift_bank }}"
                                                                                            class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button"
                                                                                class="btn btn-white border me-2"
                                                                                data-bs-dismiss="modal">Annuler</button>
                                                                            <button type="submit"
                                                                                class="btn btn-info">Modifier</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <a href="#" data-bs-toggle="modal"
                                                            data-bs-target="#delete_modal{{ $bank->bank }}"><i
                                                                class="ti ti-trash text-danger"></i></a>
                                                        <div class="modal fade" id="delete_modal{{ $bank->bank }}">
                                                            <div class="modal-dialog modal-dialog-centered modal-sm">
                                                                <div class="modal-content">
                                                                    <div class="modal-body text-center">
                                                                        <span
                                                                            class="avatar avatar-xl bg-transparent-danger text-danger mb-3">
                                                                            <i class="ti ti-trash-x fs-36"></i>
                                                                        </span>
                                                                        <h4 class="mb-1">Confirmez la suppression</h4>
                                                                        <p class="mb-3">You want to delete all the marked
                                                                            items, <br>
                                                                            this
                                                                            cant be undone once you
                                                                            delete.</p>
                                                                        <form action="{{ url('bankdestroy', $bank->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <div class="d-flex justify-content-center">
                                                                                <a href="javascript:void(0);"
                                                                                    class="btn btn-light me-3"
                                                                                    data-bs-dismiss="modal">Annuler</a>
                                                                                <button type="submit"
                                                                                    class="btn btn-danger">Oui,
                                                                                    Supprimer</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <div class="accordion-header" id="headingThree">
                                        <div class="accordion-button">
                                            <div class="d-flex align-items-center justify-content-between flex-fill">
                                                <h5>Information familliale</h5>
                                                <div class="d-flex">
                                                    <a href="#" class="btn btn-icon btn-sm" data-bs-toggle="modal"
                                                        data-bs-target="#add_familyinformation"><i
                                                            class="ti ti-plus"></i></a>
                                                    <a href="#"
                                                        class="d-flex align-items-center collapsed collapse-arrow"
                                                        data-bs-toggle="collapse" data-bs-target="#primaryBorderThree"
                                                        aria-expanded="false" aria-controls="primaryBorderThree">
                                                        <i class="ti ti-chevron-down fs-18"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="primaryBorderThree" class="accordion-collapse collapse border-top"
                                        aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            @foreach ($family as $famil)
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <span class="d-inline-flex align-items-center">
                                                            Nom complet
                                                        </span>
                                                        <h6 class="d-flex align-items-center fw-medium mt-1">
                                                            {{ $famil->complet_name }}</h6>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <span class="d-inline-flex align-items-center">
                                                            Lien familliale
                                                        </span>
                                                        <h6 class="d-flex align-items-center fw-medium mt-1">
                                                            {{ $famil->relation_family }}</h6>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <span class="d-inline-flex align-items-center">
                                                            Date d'anniversaire
                                                        </span>
                                                        <h6 class="d-flex align-items-center fw-medium mt-1">25
                                                            {{ $famil->naissance_family }}</h6>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <span class="d-inline-flex align-items-center">
                                                            Téléphone
                                                        </span>
                                                        <h6 class="d-flex align-items-center fw-medium mt-1">+1
                                                            {{ $famil->phone_family }}</h6>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <a href="#" class="me-2" data-bs-toggle="modal"
                                                            data-bs-target="#edit_family{{ $famil->faminf }}"><i
                                                                class="ti ti-edit text-info"></i></a>
                                                        <div class="modal fade" id="edit_family{{ $famil->faminf }}">
                                                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title">Modification</h4>
                                                                        <button type="button"
                                                                            class="btn-close custom-btn-close"
                                                                            data-bs-dismiss="modal" aria-label="Close">
                                                                            <i class="ti ti-x"></i>
                                                                        </button>
                                                                    </div>
                                                                    <form
                                                                        action="{{ url('familyupdate', $famil->faminf) }}"
                                                                        method="POST" role="form">
                                                                        @csrf
                                                                        @method('PATCH')
                                                                        <div class="modal-body pb-0">
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <div class="mb-3">
                                                                                        <label class="form-label">Nom
                                                                                            complet <span
                                                                                                class="text-danger">
                                                                                                *</span></label>
                                                                                        <input type="text"
                                                                                            value="{{ $famil->complet_name }}"
                                                                                            name="name" required
                                                                                            class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-12">
                                                                                    <div class="mb-3">
                                                                                        <label class="form-label">Lien
                                                                                            familliale <span
                                                                                                class="text-danger">
                                                                                                *</span></label>
                                                                                        <input type="text"
                                                                                            value="{{ $famil->relation_family }}"
                                                                                            name="lien" required
                                                                                            class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-12">
                                                                                    <div class="mb-3">
                                                                                        <label class="form-label">Téléphone
                                                                                        </label>
                                                                                        <input type="text"
                                                                                            name="phone"
                                                                                            value="{{ $famil->phone_family }}"
                                                                                            class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-12">
                                                                                    <div class="mb-3">
                                                                                        <label class="form-label">Date de
                                                                                            naissance</label>
                                                                                        <div
                                                                                            class="input-icon-end position-relative">
                                                                                            <input type="text"
                                                                                                class="form-control datetimepicker"
                                                                                                placeholder="dd/mm/yyyy"
                                                                                                value="{{ $famil->naissance_family }}"
                                                                                                name="date">
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
                                                                                class="btn btn-info">Modifier</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <a href="#" data-bs-toggle="modal"
                                                            data-bs-target="#delete_family{{ $famil->faminf }}"><i
                                                                class="ti ti-trash text-danger"></i></a>
                                                        <div class="modal fade" id="delete_family{{ $famil->faminf }}">
                                                            <div class="modal-dialog modal-dialog-centered modal-sm">
                                                                <div class="modal-content">
                                                                    <div class="modal-body text-center">
                                                                        <span
                                                                            class="avatar avatar-xl bg-transparent-danger text-danger mb-3">
                                                                            <i class="ti ti-trash-x fs-36"></i>
                                                                        </span>
                                                                        <h4 class="mb-1">Confirmez la suppression</h4>
                                                                        <p class="mb-3">You want to delete all the marked
                                                                            items, <br>
                                                                            this
                                                                            cant be undone once you
                                                                            delete.</p>
                                                                        <form
                                                                            action="{{ url('familydestroy', $famil->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <div class="d-flex justify-content-center">
                                                                                <a href="javascript:void(0);"
                                                                                    class="btn btn-light me-3"
                                                                                    data-bs-dismiss="modal">Annuler</a>
                                                                                <button type="submit"
                                                                                    class="btn btn-danger">Oui,
                                                                                    Supprimer</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="accordion-item">
                                            <div class="row">
                                                <div class="accordion-header" id="headingFour">
                                                    <div class="accordion-button">
                                                        <div
                                                            class="d-flex align-items-center justify-content-between flex-fill">
                                                            <h5>Détails éducation</h5>
                                                            <div class="d-flex">
                                                                <a href="#" class="btn btn-icon btn-sm"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#add_education"><i
                                                                        class="ti ti-plus"></i></a>
                                                                <a href="#"
                                                                    class="d-flex align-items-center collapsed collapse-arrow"
                                                                    data-bs-toggle="collapse"
                                                                    data-bs-target="#primaryBorderFour"
                                                                    aria-expanded="false"
                                                                    aria-controls="primaryBorderFour">
                                                                    <i class="ti ti-chevron-down fs-18"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="primaryBorderFour" class="accordion-collapse collapse border-top"
                                                    aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <div id="education-list">
                                                            @foreach ($education as $edu)
                                                                <div class="mb-3">
                                                                    <div
                                                                        class="d-flex align-items-center justify-content-between">
                                                                        <div>
                                                                            <span
                                                                                class="d-inline-flex align-items-center fw-normal">
                                                                                {{ $edu->school }}
                                                                            </span>
                                                                            <h6 class="d-flex align-items-center mt-1">
                                                                                {{ $edu->formation }}</h6>
                                                                        </div>
                                                                        <p class="text-dark">{{ $edu->debut }} -
                                                                            {{ $edu->fin }}</p>
                                                                    </div>
                                                                    <a href="#"
                                                                        class="btn btn-icon btn-sm edit-education"
                                                                        data-bs-toggle="modal"
                                                                        data-id="{{ $edu->educ }}"
                                                                        data-school="{{ $edu->school }}"
                                                                        data-formation="{{ $edu->formation }}"
                                                                        data-debut="{{ $edu->debut }}"
                                                                        data-fin="{{ $edu->fin }}"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#edit_education_modal"><i
                                                                            class="ti ti-edit text-info"></i></a>

                                                                    <a href="#" class="delete-education"
                                                                        data-id="{{ $edu->educ }}"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#delete_education_modal"><i
                                                                            class="ti ti-trash text-danger"></i></a>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="accordion-item">
                                            <div class="row">
                                                <div class="accordion-header" id="headingFive">
                                                    <div class="accordion-button collapsed">
                                                        <div
                                                            class="d-flex align-items-center justify-content-between flex-fill">
                                                            <h5>Expérience</h5>
                                                            <div class="d-flex">
                                                                <a href="#" class="btn btn-icon btn-sm"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#add_experience"><i
                                                                        class="ti ti-plus"></i></a>
                                                                <a href="#"
                                                                    class="d-flex align-items-center collapsed collapse-arrow"
                                                                    data-bs-toggle="collapse"
                                                                    data-bs-target="#primaryBorderFive"
                                                                    aria-expanded="false"
                                                                    aria-controls="primaryBorderFive">
                                                                    <i class="ti ti-chevron-down fs-18"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="primaryBorderFive" class="accordion-collapse collapse border-top"
                                                    aria-labelledby="headingFive" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <div id="experience-list">
                                                            @foreach ($experience as $expe)
                                                                <div class="mb-3">
                                                                    <div
                                                                        class="d-flex align-items-center justify-content-between">
                                                                        <div>
                                                                            <h6
                                                                                class="d-inline-flex align-items-center fw-medium">
                                                                                {{ $expe->entreprise }}
                                                                            </h6>
                                                                            <span
                                                                                class="d-flex align-items-center badge bg-secondary-transparent mt-1"><i
                                                                                    class="ti ti-point-filled me-1"></i>
                                                                                {{ $expe->poste }}
                                                                                </span>
                                                                        </div>
                                                                        <p class="text-dark">{{ $expe->debut }} - {{ $expe->en_poste == false ? $expe->fin : 'Present' }}
                                                                        </p>
                                                                    </div>
                                                                <a href="#"
                                                                        class="btn btn-icon btn-sm edit-experience"
                                                                        data-bs-toggle="modal"
                                                                        data-id="{{ $expe->expe }}"
                                                                        data-entreprise="{{ $expe->entreprise }}"
                                                                        data-poste="{{ $expe->poste }}"
                                                                        data-debut="{{ $expe->debut }}"
                                                                        data-fin="{{ $expe->debut }}"
                                                                        data-present="{{ $expe->en_poste }}"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#edit_experience_modal"><i
                                                                            class="ti ti-edit text-info"></i></a>

                                                                    <a href="#" class="delete-experience"
                                                                        data-id="{{ $expe->expe }}"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#delete_experience_modal"><i
                                                                            class="ti ti-trash text-danger"></i></a>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="card">
                                    <div class="card-body">
                                        <div class="contact-grids-tab p-0 mb-3">
                                            <ul class="nav nav-underline" id="myTab" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link active" id="info-tab2" data-bs-toggle="tab"
                                                        data-bs-target="#basic-info2" type="button" role="tab"
                                                        aria-selected="true">Projets</button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link" id="address-tab2" data-bs-toggle="tab"
                                                        data-bs-target="#address2" type="button" role="tab"
                                                        aria-selected="false">Assets</button>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="tab-content" id="myTabContent3">
                                            <div class="tab-pane fade show active" id="basic-info2" role="tabpanel"
                                                aria-labelledby="info-tab2" tabindex="0">
                                                <div class="row">
                                                    <div class="col-md-6 d-flex">
                                                        <div class="card flex-fill mb-4 mb-md-0">
                                                            <div class="card-body">
                                                                <div
                                                                    class="d-flex align-items-center pb-3 mb-3 border-bottom">
                                                                    <a href="project-details.html"
                                                                        class="flex-shrink-0 me-2">
                                                                        <img src="{{ URL::asset('') }}assets/img/social/project-03.svg"
                                                                            alt="Img">
                                                                    </a>
                                                                    <div>
                                                                        <h6 class="mb-1"><a
                                                                                href="project-details.html">World
                                                                                Health</a></h6>
                                                                        <div class="d-flex align-items-center">
                                                                            <p class="mb-0 fs-13">8 tasks</p>
                                                                            <p class="fs-13"><span class="mx-1"><i
                                                                                        class="ti ti-point-filled text-primary"></i></span>15
                                                                                Completed</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div>
                                                                            <span class="mb-1 d-block">Deadline</span>
                                                                            <p class="text-dark">31 July 2025
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div>
                                                                            <span class="mb-1 d-block">Project
                                                                                Lead</span>
                                                                            <a href="#"
                                                                                class="fw-normal d-flex align-items-center">
                                                                                <img class="avatar avatar-sm rounded-circle me-2"
                                                                                    src="{{ URL::asset('') }}assets/img/profiles/avatar-01.jpg"
                                                                                    alt="Img">
                                                                                Leona
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 d-flex">
                                                        <div class="card flex-fill mb-0">
                                                            <div class="card-body">
                                                                <div
                                                                    class="d-flex align-items-center pb-3 mb-3 border-bottom">
                                                                    <a href="project-details.html"
                                                                        class="flex-shrink-0 me-2">
                                                                        <img src="{{ URL::asset('') }}assets/img/social/project-01.svg"
                                                                            alt="Img">
                                                                    </a>
                                                                    <div>
                                                                        <h6 class="mb-1 text-truncate"><a
                                                                                href="project-details.html">Hospital
                                                                                Administration</a></h6>
                                                                        <div class="d-flex align-items-center">
                                                                            <p class="mb-0 fs-13">8 tasks</p>
                                                                            <p class="fs-13"><span class="mx-1"><i
                                                                                        class="ti ti-point-filled text-primary"></i></span>15
                                                                                Completed</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div>
                                                                            <span class="mb-1 d-block">Deadline</span>
                                                                            <p class="text-dark">31 July 2025
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div>
                                                                            <span class="mb-1 d-block">Project
                                                                                Lead</span>
                                                                            <a href="#"
                                                                                class="fw-normal d-flex align-items-center">
                                                                                <img class="avatar avatar-sm rounded-circle me-2"
                                                                                    src="{{ URL::asset('') }}assets/img/profiles/avatar-01.jpg"
                                                                                    alt="Img">
                                                                                Leona
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="address2" role="tabpanel"
                                                aria-labelledby="address-tab2" tabindex="0">
                                                <div class="row">
                                                    <div class="col-md-12 d-flex">
                                                        <div class="card flex-fill">
                                                            <div class="card-body">
                                                                <div class="row align-items-center">
                                                                    <div class="col-md-8">
                                                                        <div class="d-flex align-items-center">
                                                                            <a href="project-details.html"
                                                                                class="flex-shrink-0 me-2">
                                                                                <img src="{{ URL::asset('') }}assets/img/products/product-05.jpg"
                                                                                    class="img-fluid rounded-circle"
                                                                                    alt="img">
                                                                            </a>
                                                                            <div>
                                                                                <h6 class="mb-1"><a
                                                                                        href="project-details.html">Dell
                                                                                        Laptop - #343556656</a>
                                                                                </h6>
                                                                                <div class="d-flex align-items-center">
                                                                                    <p><span class="text-primary">AST
                                                                                            - 001<i
                                                                                                class="ti ti-point-filled text-primary mx-1"></i></span>Assigned
                                                                                        on 22 Nov, 2022 10:32AM
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div>
                                                                            <span class="mb-1 d-block">Assigned
                                                                                by</span>
                                                                            <a href="#"
                                                                                class="fw-normal d-flex align-items-center">
                                                                                <img class="avatar avatar-sm rounded-circle me-2"
                                                                                    src="{{ URL::asset('') }}assets/img/profiles/avatar-01.jpg"
                                                                                    alt="Img">
                                                                                Andrew Symon
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-1">
                                                                        <div class="dropdown ms-2">
                                                                            <a href="javascript:void(0);"
                                                                                class="d-inline-flex align-items-center"
                                                                                data-bs-toggle="dropdown"
                                                                                aria-expanded="false">
                                                                                <i class="ti ti-dots-vertical"></i>
                                                                            </a>
                                                                            <ul
                                                                                class="dropdown-menu dropdown-menu-end p-3">
                                                                                <li>
                                                                                    <a href="javascript:void(0);"
                                                                                        class="dropdown-item rounded-1"
                                                                                        data-bs-toggle="modal"
                                                                                        data-bs-target="#asset_info">View
                                                                                        Info</a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="javascript:void(0);"
                                                                                        class="dropdown-item rounded-1"
                                                                                        data-bs-toggle="modal"
                                                                                        data-bs-target="#refuse_msg">Raise
                                                                                        Issue </a>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 d-flex">
                                                        <div class="card flex-fill mb-0">
                                                            <div class="card-body">
                                                                <div class="row align-items-center">
                                                                    <div class="col-md-8">
                                                                        <div class="d-flex align-items-center">
                                                                            <a href="project-details.html"
                                                                                class="flex-shrink-0 me-2">
                                                                                <img src="{{ URL::asset('') }}assets/img/products/product-06.jpg"
                                                                                    class="img-fluid rounded-circle"
                                                                                    alt="img">
                                                                            </a>
                                                                            <div>
                                                                                <h6 class="mb-1"><a
                                                                                        href="project-details.html">Bluetooth
                                                                                        Mouse - #478878</a></h6>
                                                                                <div class="d-flex align-items-center">
                                                                                    <p><span class="text-primary">AST
                                                                                            - 001<i
                                                                                                class="ti ti-point-filled text-primary mx-1"></i></span>Assigned
                                                                                        on 22 Nov, 2022 10:32AM
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div>
                                                                            <span class="mb-1 d-block">Assigned
                                                                                by</span>
                                                                            <a href="#"
                                                                                class="fw-normal d-flex align-items-center">
                                                                                <img class="avatar avatar-sm rounded-circle me-2"
                                                                                    src="{{ URL::asset('') }}assets/img/profiles/avatar-01.jpg"
                                                                                    alt="Img">
                                                                                Andrew Symon
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-1">
                                                                        <div class="dropdown ms-2">
                                                                            <a href="javascript:void(0);"
                                                                                class="d-inline-flex align-items-center"
                                                                                data-bs-toggle="dropdown"
                                                                                aria-expanded="false">
                                                                                <i class="ti ti-dots-vertical"></i>
                                                                            </a>
                                                                            <ul
                                                                                class="dropdown-menu dropdown-menu-end p-3">
                                                                                <li>
                                                                                    <a href="javascript:void(0);"
                                                                                        class="dropdown-item rounded-1"
                                                                                        data-bs-toggle="modal"
                                                                                        data-bs-target="#asset_info">View
                                                                                        Info</a>
                                                                                </li>
                                                                                <li>
                                                                                    <a href="javascript:void(0);"
                                                                                        class="dropdown-item rounded-1"
                                                                                        data-bs-toggle="modal"
                                                                                        data-bs-target="#refuse_msg">Raise
                                                                                        Issue </a>
                                                                                </li>
                                                                            </ul>
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
                                <div class="card">
                                    <div class="card-body">
                                        <div class="contact-grids-tab p-0 mb-3">
                                            <ul class="nav nav-underline" id="myTab" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link active" id="info-tab2" data-bs-toggle="tab"
                                                        data-bs-target="#basic-info2" type="button" role="tab"
                                                        aria-selected="true">Contrat</button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link" id="address-tab2" data-bs-toggle="tab"
                                                        data-bs-target="#address2" type="button" role="tab"
                                                        aria-selected="false">Diplôme</button>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="tab-content" id="myTabContent3">
                                            <div class="tab-pane fade show active" id="basic-info2" role="tabpanel"
                                                aria-labelledby="info-tab2" tabindex="0">
                                                <div class="row">
                                                    <div class="col-md-12 d-flex">
                                                        <div class="card flex-fill">
                                                            <div class="card-body">
                                                                <div class="row align-items-center">
                                                                    <div class="col-md-12">
                                                                        <div class="d-flex align-items-center">
                                                                            <div>
                                                                                <h6 class="mb-1"><a
                                                                                        href="#">{{ $details->contrat }}</a>
                                                                                </h6>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        Le fichier
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="address2" role="tabpanel"
                                                aria-labelledby="address-tab2" tabindex="0">
                                                <div class="row">
                                                    <div class="col-md-12 d-flex">
                                                        <div class="col-md-12 d-flex">
                                                            <div class="card flex-fill">
                                                                <div class="card-body">
                                                                    <div class="row align-items-center">
                                                                        <div class="col-md-12">
                                                                            <div class="d-flex align-items-center">
                                                                                <div>
                                                                                    <h6 class="mb-1"><a
                                                                                            href="#">DIPLÔME</a>
                                                                                    </h6>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-12">
                                                                            Le fichier
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="delete_education_modal">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <span class="avatar avatar-xl bg-transparent-danger text-danger mb-3">
                        <i class="ti ti-trash-x fs-36"></i>
                    </span>
                    <h4 class="mb-1">Confirmez la suppression</h4>
                    <p class="mb-3">Cette action est irréversible.</p>
                    <input type="hidden" id="delete-education-id">
                    <div class="d-flex justify-content-center">
                        <a href="javascript:void(0);" class="btn btn-light me-3" data-bs-dismiss="modal">Annuler</a>
                        <button id="confirm-delete-education" type="submit" class="btn btn-danger">Oui,
                            Supprimer</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="delete_experience_modal">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <span class="avatar avatar-xl bg-transparent-danger text-danger mb-3">
                        <i class="ti ti-trash-x fs-36"></i>
                    </span>
                    <h4 class="mb-1">Confirmez la suppression</h4>
                    <p class="mb-3">Cette action est irréversible.</p>
                    <input type="hidden" id="delete-experience-id">
                    <div class="d-flex justify-content-center">
                        <a href="javascript:void(0);" class="btn btn-light me-3" data-bs-dismiss="modal">Annuler</a>
                        <button id="confirm-delete-experience" type="submit" class="btn btn-danger">Oui,
                            Supprimer</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Emergency Contact -->
    <div class="modal fade" id="edit_emergency">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Emergency Contact Details</h4>
                    <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
                <form action="employee-details.html">
                    <div class="modal-body pb-0">
                        <div class="border-bottom mb-3 ">
                            <div class="row">
                                <h5 class="mb-3">Secondary Contact Details</h5>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Name <span class="text-danger">
                                                *</span></label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Relationship </label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Phone No 1 <span class="text-danger">
                                                *</span></label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Phone No 2 </label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white border me-2" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /Edit Emergency Contact -->

    <!-- Edit Bank -->
    <div class="modal fade" id="add_bank">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Ajouter une banque</h4>
                    <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
                <form action="{{ url('add-bank', $details->id) }}" method="POST" role="form">
                    @csrf
                    <div class="modal-body pb-0">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Nom de la banque <span class="text-danger">
                                            *</span></label>
                                    <input required name="libelle" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Code banque <span class="text-danger">
                                            *</span></label>
                                    <input required name="code" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Code guichet <span class="text-danger">
                                            *</span></label>
                                    <input required name="guichet" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Numéro de compte <span class="text-danger">
                                            *</span></label>
                                    <input required name="numero" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Clé RIB <span class="text-danger">
                                            *</span></label>
                                    <input required name="rib" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">IBAN <span class="text-danger">
                                            *</span></label>
                                    <input required name="iban" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">SWIFT <span class="text-danger">
                                            *</span></label>
                                    <input required name="swift" type="text" class="form-control">
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
    <!-- /Edit Bank -->

    <!-- Add Family -->
    <div class="modal fade" id="add_familyinformation">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Ajouter une Information familliale</h4>
                    <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
                <form action="{{ url('add-famille', $details->id) }}" method="post" role="form">
                    @csrf
                    <div class="modal-body pb-0">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Nom complet <span class="text-danger"> *</span></label>
                                    <input type="text" name="name" required class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Lien familliale <span class="text-danger"> *</span></label>
                                    <input type="text" name="lien" required class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Téléphone </label>
                                    <input type="text" name="phone" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Date de naissance</label>
                                    <div class="input-icon-end position-relative">
                                        <input type="text" class="form-control datetimepicker"
                                            placeholder="dd/mm/yyyy" name="date">
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
    <!-- /Add Family -->

    <!-- Add Education -->
    <div class="modal fade" id="add_education">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Education</h4>
                    <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
                <form id="education-form" method="post" role="form">
                    @csrf
                    <input type="hidden" name="employe_id" value="{{ $details->id }}">
                    <div class="modal-body pb-0">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nom école <span class="text-danger">
                                            *</span></label>
                                    <input type="text" name="school" required class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Formation <span class="text-danger"> *</span></label>
                                    <input type="text" name="formation" required class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Date début <span class="text-danger">
                                            *</span></label>
                                    <div class="input-icon-end position-relative">
                                        <input type="text" class="form-control datetimepicker"
                                            placeholder="dd/mm/yyyy" name="start" required>
                                        <span class="input-icon-addon">
                                            <i class="ti ti-calendar text-gray-7"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Date fin <span class="text-danger">
                                            *</span></label>
                                    <div class="input-icon-end position-relative">
                                        <input type="text" class="form-control datetimepicker"
                                            placeholder="dd/mm/yyyy" name="end" required>
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

    <div class="modal fade" id="edit_education_modal">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Modifier Education</h4>
                    <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
                <form id="edit-education-form" role="form">
                    @csrf
                    <input type="hidden" name="id" id="edit-id">
                    <div class="modal-body pb-0">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nom école <span class="text-danger">
                                            *</span></label>
                                    <input type="text" name="school" id="edit-school" required class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Formation <span class="text-danger"> *</span></label>
                                    <input type="text" name="formation" id="edit-formation" required
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Date début <span class="text-danger">
                                            *</span></label>
                                    <div class="input-icon-end position-relative">
                                        <input type="text" class="form-control datetimepicker"
                                            placeholder="dd/mm/yyyy" name="debut" required id="edit-debut">
                                        <span class="input-icon-addon">
                                            <i class="ti ti-calendar text-gray-7"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Date fin <span class="text-danger">
                                            *</span></label>
                                    <div class="input-icon-end position-relative">
                                        <input type="text" class="form-control datetimepicker"
                                            placeholder="dd/mm/yyyy" name="fin" required id="edit-fin">
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
                        <button type="submit" class="btn btn-info">Modifier</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /Add Education -->

    <!-- Add Experience -->
    <div class="modal fade" id="add_experience">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Expérience</h4>
                    <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
                <form id="experience-form" method="post" role="form">
                    @csrf
                    <input type="hidden" name="employe_id" value="{{ $details->id }}">
                    <div class="modal-body pb-0">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Entreprise <span class="text-danger">
                                            *</span></label>
                                    <input type="text" name="entreprise" required class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Poste occupé <span class="text-danger">
                                            *</span></label>
                                    <input type="text" name="poste" required class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Date début <span class="text-danger">
                                            *</span></label>
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
                                        <input name="fin" type="text" class="form-control datetimepicker"
                                            placeholder="dd/mm/yyyy">
                                        <span class="input-icon-addon">
                                            <i class="ti ti-calendar text-gray-7"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-check-label d-flex align-items-center mt-0">
                                        <input name="present" class="form-check-input mt-0 me-2" type="checkbox">
                                        <span class="text-dark">Vous y travaillez actuellement</span>
                                    </label>
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

     <div class="modal fade" id="edit_experience_modal">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Modifier Experience</h4>
                    <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
                <form id="edit-experience-form" role="form">
                    @csrf
                    <input type="hidden" name="id" id="edit-id">
                    <div class="modal-body pb-0">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Entreprise <span class="text-danger">
                                            *</span></label>
                                    <input type="text" name="entreprise" required class="form-control" id="edit-entreprise">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Poste occupé <span class="text-danger">
                                            *</span></label>
                                    <input type="text" name="poste" required class="form-control" id="edit-poste">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Date début <span class="text-danger">
                                            *</span></label>
                                    <div class="input-icon-end position-relative">
                                        <input name="debut" required type="text" class="form-control datetimepicker"
                                            placeholder="dd/mm/yyyy" id="edit-debutt">
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
                                        <input name="fin" type="text" class="form-control datetimepicker"
                                            placeholder="dd/mm/yyyy" id="edit-fin">
                                        <span class="input-icon-addon">
                                            <i class="ti ti-calendar text-gray-7"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-check-label d-flex align-items-center mt-0">
                                        <input name="present" class="form-check-input mt-0 me-2" type="checkbox" id="edit-present">
                                        <span class="text-dark">Vous y travaillez actuellement</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white border me-2" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-info">Modifier</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /Add Experience -->

    <!-- Add Statuorty -->
    <div class="modal fade" id="add_bank_satutory">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Bank & Statutory</h4>
                    <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
                <form action="employee-details.html">
                    <div class="modal-body pb-0">
                        <div class="border-bottom mb-4">
                            <h5 class="mb-3">Basic Salary Information</h5>
                            <div class="row mb-2">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Salary basis <span class="text-danger">
                                                *</span></label>
                                        <select class="select">
                                            <option>Select</option>
                                            <option>Weekly</option>
                                            <option>Monthly</option>
                                            <option>Annualy</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Salary basis</label>
                                        <input type="text" class="form-control" value="$">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Payment type</label>
                                        <select class="select">
                                            <option>Select</option>
                                            <option>Cash</option>
                                            <option>Debit Card</option>
                                            <option>Mobile Payment</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="border-bottom mb-4">
                            <h5 class="mb-3">PF Information</h5>
                            <div class="row mb-2">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">PF contribution <span class="text-danger">
                                                *</span></label>
                                        <select class="select">
                                            <option>Select</option>
                                            <option>Employee Contribution</option>
                                            <option>Employer Contribution</option>
                                            <option>Provident Fund Interest</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">PF No</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Employee PF rate</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Additional rate</label>
                                        <select class="select">
                                            <option>Select</option>
                                            <option>ESI</option>
                                            <option>EPS</option>
                                            <option>EPF</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Total rate</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h5 class="mb-3">ESI Information</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">ESI contribution<span class="text-danger">
                                            *</span></label>
                                    <select class="select">
                                        <option>Select</option>
                                        <option>Employee Contribution</option>
                                        <option>Employer Contribution</option>
                                        <option>Maternity Benefit </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">ESI Number</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Employee ESI rate<span class="text-danger">
                                            *</span></label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Additional rate</label>
                                    <select class="select">
                                        <option>Select</option>
                                        <option>ESI</option>
                                        <option>EPS</option>
                                        <option>EPF</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Total rate</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white border me-2"
                            data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /Add Statuorty -->

    <!-- Asset Information -->
    <div class="modal fade" id="asset_info">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Asset Information</h4>
                    <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="bg-light p-3 rounded d-flex align-items-center mb-3">
                        <span class="avatar avatar-lg flex-shrink-0 me-2">
                            <img src="{{ URL::asset('') }}assets/img/laptop.jpg" alt="img"
                                class="ig-fluid rounded-circle">
                        </span>
                        <div>
                            <h6>Dell Laptop - #343556656</h6>
                            <p class="fs-13"><span class="text-primary">AST - 001 </span><i
                                    class="ti ti-point-filled text-primary"></i> Assigned on 22 Nov, 2022 10:32AM
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <p class="fs-13 mb-0">Type</p>
                                <p class="text-gray-9">Laptop</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <p class="fs-13 mb-0">Brand</p>
                                <p class="text-gray-9">Dell</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <p class="fs-13 mb-0">Category</p>
                                <p class="text-gray-9">Computer</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <p class="fs-13 mb-0">Serial No</p>
                                <p class="text-gray-9">3647952145678</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <p class="fs-13 mb-0">Cost</p>
                                <p class="text-gray-9">$800</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <p class="fs-13 mb-0">Vendor</p>
                                <p class="text-gray-9">Compusoft Systems Ltd.,</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <p class="fs-13 mb-0">Warranty</p>
                                <p class="text-gray-9">12 Jan 2022 - 12 Jan 2026</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <p class="fs-13 mb-0">Location</p>
                                <p class="text-gray-9">46 Laurel Lane, TX 79701</p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <p class="fs-13 mb-2">Asset Images</p>
                        <div class="d-flex align-items-center">
                            <img src="{{ URL::asset('') }}assets/img/laptop-01.jpg" alt="img"
                                class="img-fluid rounded me-2">
                            <img src="{{ URL::asset('') }}assets/img/laptop-2.jpg" alt="img"
                                class="img-fluid rounded me-2">
                            <img src="{{ URL::asset('') }}assets/img/laptop-3.jpg" alt="img"
                                class="img-fluid rounded">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Asset Information -->

    <!-- Refuse -->
    <div class="modal fade" id="refuse_msg">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Raise Issue</h4>
                    <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
                <form action="employee-details.html">
                    <div class="modal-body pb-0">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Description<span class="text-danger">
                                            *</span></label>
                                    <textarea class="form-control" rows="4"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white border me-2"
                            data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /Refuse -->

    <!-- Delete Modal -->
    <div class="modal fade" id="delete_modal">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <span class="avatar avatar-xl bg-transparent-danger text-danger mb-3">
                        <i class="ti ti-trash-x fs-36"></i>
                    </span>
                    <h4 class="mb-1">Confirm Delete</h4>
                    <p class="mb-3">You want to delete all the marked items, this cant be undone once you
                        delete.</p>
                    <div class="d-flex justify-content-center">
                        <a href="javascript:void(0);" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</a>
                        <a href="employee-details.html" class="btn btn-danger">Yes, Delete</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Delete Modal -->
@endsection
