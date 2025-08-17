@extends('layouts.app')

@section('title', 'Caisses')

@section('content')
    <style>
        /* Effet de survol pour rendre les cartes plus interactives */
        .branch-card {
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }

        .branch-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .1) !important;
        }



        .offcanvas-top {
            top: 0;
            left: 0;
            right: 0;
            width: 100%;
            max-width: 100%;
            margin: 0;
            height: 52vh !important;
            /* Hauteur de 52% de la fenêtre */
            min-height: 400px;
            /* Hauteur minimale pour ne pas être trop petit */
        }

        /* 2. Media Query : Ces styles ne s'appliqueront QUE sur les écrans de petite taille */
        /* Bootstrap considère les écrans en dessous de 768px comme "petits" (mobile) */
        @media (max-width: 767.98px) {
            .offcanvas-top {
                top: 0;
                left: 0;
                right: 0;
                width: 100%;
                max-width: 100%;
                margin: 0;
                height: 100vh !important;
                /* La hauteur prend 100% de l'écran du téléphone */
                min-height: 100vh;
                /* On s'assure que la hauteur minimale est aussi de 100% */
            }
        }

        /* Pour le curseur pointeur, déjà présent dans la classe "cursor-pointer" de Bootstrap 5.1+ */
        .cursor-pointer {
            cursor: pointer;
        }
    </style>

    <div class="page-wrapper">
        <div class="page-content">

            {{-- ========================================================================= --}}
            {{--   BLOC 1 : MESSAGES ET EN-TÊTE DE PAGE                                  --}}
            {{-- ========================================================================= --}}

            <div id="notification-toast"
                class="toast align-items-center text-white bg-success border-0 position-fixed top-0 end-0 m-3" role="alert"
                aria-live="assertive" aria-atomic="true" style="z-index: 1056;">
                <div class="d-flex">
                    <div class="toast-body"></div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Erreur !</strong> Veuillez corriger les problèmes dans le formulaire de création.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Caisses</div>
                <div class="ms-auto">
                    <button type="button" class="btn btn-primary radius-30" data-bs-toggle="offcanvas"
                        data-bs-target="#createCaisseOffcanvas">
                        <i class='bx bx-plus'></i>Nouvelle caisse
                    </button>
                </div>
            </div>

            {{-- ========================================================================= --}}
            {{--   BLOC 2 : GRILLE DES CARTES DE CAISSE (Générée dynamiquement)        --}}
            {{-- ========================================================================= --}}
            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 row-cols-xl-4 g-3">
                @forelse ($caisses as $caisse)
                    <div class="col" id="caisse-card-{{ $caisse->id }}">
                        <div class="d-flex align-items-center p-3 shadow-sm rounded cursor-pointer caisse-card bg-light"
                            role="button" data-bs-toggle="offcanvas" data-bs-target="#caisseDetailOffcanvas"
                            data-id="{{ $caisse->id }}" data-name="{{ $caisse->nom }}"
                            data-branch-name="{{ $caisse->branche->nom }}" data-statut="{{ $caisse->statut }}"
                            data-numero-poste="{{ $caisse->numero_poste ?? 'N/A' }}"
                            data-stat-total-tickets="{{ $caisse->tickets_count }}">

                            <div class="font-22 {{ $caisse->statut === 'ouverte' ? 'text-success' : 'text-danger' }}">
                                <i class='bx bx-desktop'></i>
                            </div>
                            <div class="ms-3">
                                <h6 class="mb-0 caisse-name-display">{{ $caisse->nom }}</h6>
                                <small class="text-secondary">{{ $caisse->branche->nom }}</small>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info">Aucune caisse n'a été trouvée.</div>
                    </div>
                @endforelse
            </div>

        </div>
    </div>

    {{-- ========================================================================= --}}
    {{--   BLOC 3 : OFFCANVAS POUR LES DÉTAILS ET LA MODIFICATION (unique)       --}}
    {{-- ========================================================================= --}}
    <div class="offcanvas offcanvas-top" tabindex="-1" id="caisseDetailOffcanvas"
        aria-labelledby="caisseDetailOffcanvasLabel">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title" id="caisseDetailOffcanvasLabel">Détails de la Caisse</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="row">
                <div class="col-md-4 border-end">
                    <h6><i class="bx bx-edit-alt me-1"></i>Modifier la Caisse</h6>
                    <form id="caisseEditForm">
                        <input type="hidden" id="editCaisseIdInput" name="id">
                        <div class="mb-3">
                            <label for="editCaisseNameInput" class="form-label">Nom de la caisse</label>
                            <input type="text" class="form-control" id="editCaisseNameInput" name="nom" required>
                            <div class="invalid-feedback" id="edit-nom-error"></div>
                        </div>
                        <div class="mb-3">
                            <label for="editCaissePosteInput" class="form-label">Numéro de poste</label>
                            <input type="text" class="form-control" id="editCaissePosteInput" name="numero_poste">
                            <div class="invalid-feedback" id="edit-numero_poste-error"></div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary"  data-loader-target="modifC">Enregistrer</button>
                            <button type="submit" class="btn btn-primary radius-30 shadow" style="display: none;" disabled
                            id="modifC">
                            <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                            Modification en cours...
                        </button>
                            <button type="button" class="btn btn-danger" id="deleteCaisseBtn">Supprimer</button>
                        </div>
                    </form>
                </div>
                <div class="col-md-8">
                    <h6><i class="bx bx-bar-chart-alt-2 me-1"></i>Activité des Tickets</h6>
                    <div class="card radius-10 border-start border-0 border-4 border-success">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Total tickets traités</p>
                                    <h4 class="my-1 text-success" id="offcanvasStatTotalTickets">0</h4>
                                </div>
                                <div class="widgets-icons-2 rounded-circle bg-gradient-ohhappiness text-white ms-auto"><i
                                        class='bx bxs-purchase-tag-alt'></i></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ========================================================================= --}}
    {{--   BLOC 4 : OFFCANVAS POUR LA CRÉATION (classique, sans AJAX)            --}}
    {{-- ========================================================================= --}}
    <div class="offcanvas offcanvas-end" tabindex="-1" id="createCaisseOffcanvas"
        aria-labelledby="createCaisseOffcanvasLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="createCaisseOffcanvasLabel">Nouvelle caisse</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form method="POST" action="{{ route('caisses.store') }}">
                @csrf
                <div class="mb-3">
                    <label for="newCaisseName" class="form-label">Nom de la caisse <span
                            class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nom') is-invalid @enderror" id="newCaisseName"
                        name="nom" value="{{ old('nom') }}" required>
                </div>
                <div class="mb-3">
                    <label for="newCaissePoste" class="form-label">Numéro de poste (optionnel)</label>
                    <input type="text" class="form-control @error('numero_poste') is-invalid @enderror"
                        id="newCaissePoste" name="numero_poste" value="{{ old('numero_poste') }}">
                </div>
                <div class="mb-3">
                    <label for="newCaisseBranche" class="form-label">Branche de rattachement <span
                            class="text-danger">*</span></label>
                    <select class="form-select @error('branche_id') is-invalid @enderror" id="newCaisseBranche"
                        name="branche_id" required>
                        <option value="" disabled selected>Choisir une branche...</option>
                        @foreach ($branches as $branche)
                            <option value="{{ $branche->id }}" @if (old('branche_id') == $branche->id) selected @endif>
                                {{ $branche->nom }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mt-4 pt-3 border-top d-flex justify-content-end">
                    <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="offcanvas">Annuler</button>
                    <button type="submit" class="btn btn-primary" data-loader-target="enregistre">Enregistrer</button>
                    <button type="submit" class="btn btn-primary radius-30 shadow" style="display: none;" disabled
                    id="enregistre">
                    <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                    Enregistrement en cours...
                </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ========================================================================= --}}
    {{--   BLOC 5 : LE JAVASCRIPT COMPLET (Détails, Update, Delete)             --}}
    {{-- ========================================================================= --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const caisseDetailOffcanvasElement = document.getElementById('caisseDetailOffcanvas');
            const notificationToastElement = document.getElementById('notification-toast');
            const notificationToast = new bootstrap.Toast(notificationToastElement);
        
            // === FONCTIONS UTILES ===
            function showToast(message, isError = false) {
                const toastBody = notificationToastElement.querySelector('.toast-body');
                toastBody.textContent = message;
                notificationToastElement.classList.toggle('bg-success', !isError);
                notificationToastElement.classList.toggle('bg-danger', isError);
                notificationToast.show();
            }
            
            function clearValidationErrors(form) {
                form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
                form.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');
            }
            
            function displayValidationErrors(form, errors) {
                clearValidationErrors(form);
                for (const field in errors) {
                    const input = form.querySelector(`[name="${field}"]`);
                    const errorDiv = form.querySelector(`#edit-${field}-error`);
                    if (input) {
                        input.classList.add('is-invalid');
                        if(errorDiv) errorDiv.textContent = errors[field][0];
                    }
                }
            }
        
            // === OUVERTURE OFFCANVAS DÉTAIL ===
            if (caisseDetailOffcanvasElement) {
                caisseDetailOffcanvasElement.addEventListener('show.bs.offcanvas', function (event) {
                    const card = event.relatedTarget;
                    const offcanvas = this;
                    
                    clearValidationErrors(offcanvas.querySelector('#caisseEditForm'));
        
                    offcanvas.querySelector('#caisseDetailOffcanvasLabel').textContent = `Détails : ${card.dataset.name}`;
                    offcanvas.querySelector('#editCaisseIdInput').value = card.dataset.id;
                    offcanvas.querySelector('#editCaisseNameInput').value = card.dataset.name;
                    offcanvas.querySelector('#editCaissePosteInput').value = card.dataset.numeroPoste;
                    offcanvas.querySelector('#offcanvasStatTotalTickets').textContent = card.dataset.statTotalTickets;
                });
            }
        
            // === FORMULAIRE EDIT (PATCH) ===
            const editForm = document.getElementById('caisseEditForm');
            if (editForm) {
                editForm.addEventListener('submit', function(event) {
                    event.preventDefault();
                    const caisseId = document.getElementById('editCaisseIdInput').value;
                    const formData = new FormData(editForm);
                    const data = Object.fromEntries(formData.entries());
        
                    const submitBtn = editForm.querySelector('button[type="submit"]');
                    submitBtn.disabled = true;
        
                    fetch(`/caisses/${caisseId}`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(data)
                    })
                    .then(response => response.json().then(body => ({ status: response.status, body: body })))
                    .then(({ status, body }) => {
                        if (status === 200) {
                            showToast(body.message);
                            bootstrap.Offcanvas.getInstance(caisseDetailOffcanvasElement).hide();
                            
                            // Mise à jour du nom dans la carte
                            const cardName = document.querySelector(`#caisse-card-${caisseId} .caisse-name-display`);
                            if(cardName) cardName.textContent = body.caisse.nom;
                        } else if (status === 422) {
                            displayValidationErrors(editForm, body.errors);
                        } else {
                            showToast(body.message || 'Une erreur est survenue.', true);
                        }
                    })
                    .catch(() => showToast('Erreur de connexion.', true))
                    .finally(() => { submitBtn.disabled = false; });
                });
            }
            
            // === SUPPRESSION (DELETE) ===
            const deleteBtn = document.getElementById('deleteCaisseBtn');
            if(deleteBtn) {
                deleteBtn.addEventListener('click', function() {
                    const caisseId = document.getElementById('editCaisseIdInput').value;
                    const caisseName = document.getElementById('editCaisseNameInput').value;
        
                    if (confirm(`Êtes-vous sûr de vouloir supprimer la caisse "${caisseName}" ? Cette action est irréversible.`)) {
                        fetch(`/caisses/${caisseId}`, {
                            method: 'DELETE',
                            headers: {
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(response => response.json().then(body => ({ status: response.status, body: body })))
                        .then(({ status, body }) => {
                            if (status === 200) {
                                showToast(body.message);
                                bootstrap.Offcanvas.getInstance(caisseDetailOffcanvasElement).hide();
                                document.getElementById(`caisse-card-${caisseId}`).remove();
                            } else if (status === 409) {
                                showToast(body.message || "Impossible de supprimer : caisse liée à d'autres éléments.", true);
                            } else {
                                showToast(body.message || 'Une erreur est survenue.', true);
                            }
                        })
                        .catch(() => showToast('Erreur de connexion.', true));
                    }
                });
            }
        });
        </script>
        
@endsection
