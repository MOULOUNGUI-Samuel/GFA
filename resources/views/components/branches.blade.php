@extends('layouts.app')

@section('title', 'Branches')

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

            {{-- Toast notifications (succès/erreur) --}}
            <div id="notification-toast"
                class="toast align-items-center text-white bg-success border-0 position-fixed top-0 end-0 m-3" role="alert"
                aria-live="assertive" aria-atomic="true" style="z-index:1056;">
                <div class="d-flex">
                    <div class="toast-body"></div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>

            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Branches</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Liste des branches</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <button type="button"
                        class="btn btn-light bg-light radius-30 shadow d-flex align-items-center justify-content-center"
                        data-bs-toggle="offcanvas" data-bs-target="#createBranchOffcanvas">
                        <i class='lni lni-circle-plus mr-1'></i>
                        <span>Nouvelle branche</span>
                    </button>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- CARTES BRANCHES --}}
            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 row-cols-xl-4 g-3">
                @forelse($branches as $branche)
                    <div class="col" id="branch-card-{{ $branche->id }}">
                        <div class="d-flex align-items-center p-3 shadow-sm rounded cursor-pointer branch-card bg-light"
                            role="button" data-bs-toggle="offcanvas" data-bs-target="#branchDetailOffcanvas"
                            data-id="{{ $branche->id }}" data-name="{{ $branche->nom }}"
                            data-description="{{ $branche->description ?? '' }}" data-stat-total-tickets="12,546"
                            data-stat-total-tickets-trend="+3.2% vs semaine passée" data-stat-cancelled-tickets="212"
                            data-stat-cancelled-tickets-trend="+1.4% vs semaine passée"
                            data-stat-favorable-responses="1,895"
                            data-stat-favorable-responses-trend="+8.4% vs semaine passée"
                            data-stat-unfavorable-responses="152"
                            data-stat-unfavorable-responses-trend="-2.1% vs semaine passée">
                            <div class="font-22 text-primary"><i class='bx bx-buildings'></i></div>
                            <div class="ms-3">
                                <h6 class="mb-0 branch-name-display">{{ $branche->nom }}</h6>
                                <small class="text-secondary">Cliquez pour gérer</small>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info">Aucune branche trouvée.</div>
                    </div>
                @endforelse
            </div>

        </div>
    </div>

    {{-- OFFCANVAS DÉTAIL / ÉDITION (unique) --}}
    <div class="offcanvas offcanvas-top" tabindex="-1" id="branchDetailOffcanvas"
        aria-labelledby="branchDetailOffcanvasLabel">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title" id="branchDetailOffcanvasLabel">Détails de la Branche</h5>
            <div class="d-flex align-items-center">
                <div class="dropdown me-2">
                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">Aujourd'hui</button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Aujourd'hui</a></li>
                        <li><a class="dropdown-item" href="#">Hier</a></li>
                        <li><a class="dropdown-item" href="#">Semaine</a></li>
                        <li><a class="dropdown-item" href="#">Mois</a></li>
                        <li><a class="dropdown-item" href="#">Année</a></li>
                    </ul>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
        </div>
        <div class="offcanvas-body">
            <div class="row">
                {{-- Colonne stats gauche --}}
                <div class="col-md-3 border-end">
                    <h6><i class="bx bx-info-circle mb-3"></i>Agences & services</h6>
                    <div class="row row-cols-1 row-cols-md-1">
                        <div class="col">
                            <div class="card radius-10 border-start border-0 border-4 border-dark">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <p class="mb-0 text-secondary">Total d'Agents</p>
                                            <h4 class="my-1 text-dark" id="statTotalAgents">0</h4>
                                            <p class="mb-0 font-13" id="statTotalAgentsTrend">+0.0%</p>
                                        </div>
                                        <div class="widgets-icons-2 rounded-circle bg-dark text-white ms-auto">
                                            <i class='bx bxs-group'></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card radius-10 border-start border-0 border-4 border-secondary">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <p class="mb-0 text-secondary">Total des services</p>
                                            <h4 class="my-1 text-secondary" id="statTotalServices">0</h4>
                                            <p class="mb-0 font-13" id="statTotalServicesTrend">+0.0%</p>
                                        </div>
                                        <div class="widgets-icons-2 rounded-circle bg-secondary text-white ms-auto">
                                            <i class='bx bxs-briefcase-alt-2'></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Colonne stats centre --}}
                <div class="col-md-5">
                    <h6><i class="bx bx-bar-chart-alt-2 mb-3"></i>Statistiques Clés</h6>
                    <div class="row row-cols-1 row-cols-md-2">
                        <div class="col">
                            <div class="card radius-10 border-start border-0 border-4 border-success">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <p class="mb-0 text-secondary">Total de tickets</p>
                                            <h4 class="my-1 text-success" id="statTotalTickets">0</h4>
                                            <p class="mb-0 font-13" id="statTotalTicketsTrend">+0.0%</p>
                                        </div>
                                        <div
                                            class="widgets-icons-2 rounded-circle bg-gradient-ohhappiness text-white ms-auto">
                                            <i class='bx bxs-purchase-tag-alt'></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card radius-10 border-start border-0 border-4 border-danger">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <p class="mb-0 text-secondary">Total de tickets annulés</p>
                                            <h4 class="my-1 text-danger" id="statCancelledTickets">0</h4>
                                            <p class="mb-0 font-13" id="statCancelledTicketsTrend">+0.0%</p>
                                        </div>
                                        <div class="widgets-icons-2 rounded-circle bg-gradient-burning text-white ms-auto">
                                            <i class='bx bxs-x-circle'></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card radius-10 border-start border-0 border-4 border-info">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <p class="mb-0 text-secondary">Réponses favorables</p>
                                            <h4 class="my-1 text-info" id="statFavorableResponses">0</h4>
                                            <p class="mb-0 font-13" id="statFavorableResponsesTrend">+0.0%</p>
                                        </div>
                                        <div class="widgets-icons-2 rounded-circle bg-gradient-blues text-white ms-auto">
                                            <i class='bx bxs-like'></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card radius-10 border-start border-0 border-4 border-warning">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <p class="mb-0 text-secondary">Réponses défavorables</p>
                                            <h4 class="my-1 text-warning" id="statUnfavorableResponses">0</h4>
                                            <p class="mb-0 font-13" id="statUnfavorableResponsesTrend">-0.0%</p>
                                        </div>
                                        <div class="widgets-icons-2 rounded-circle bg-gradient-orange text-white ms-auto">
                                            <i class='bx bxs-dislike'></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- end row -->
                </div>

                {{-- Colonne formulaire droite --}}
                <div class="col-md-4 border-end">
                    <h6><i class="bx bx-edit-alt me-1"></i>Modifier les informations</h6>
                    <form id="branchEditForm">
                        <input type="hidden" id="editBranchIdInput" name="id">

                        <div class="mb-3">
                            <label for="editBranchNameInput" class="form-label">Nom de la branche</label>
                            <input type="text" class="form-control" id="editBranchNameInput" name="branch_name"
                                required>
                            <div class="invalid-feedback" id="edit-branch_name-error"></div>
                        </div>

                        <div class="mb-3">
                            <label for="editBranchDescriptionInput" class="form-label">Description</label>
                            <textarea class="form-control" id="editBranchDescriptionInput" name="branch_description" rows="3"></textarea>
                            <div class="invalid-feedback" id="edit-branch_description-error"></div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary" data-loader-target="modifierB">Modifier</button>
                            <button type="submit" class="btn btn-primary shadow" style="display: none;" disabled
                            id="modifierB">
                            <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                            Modification en cours...
                        </button>
                            <button type="button" class="btn btn-danger" id="deleteBranchBtn">Supprimer</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    {{-- OFFCANVAS CRÉATION --}}
    <div class="offcanvas offcanvas-end" tabindex="-1" id="createBranchOffcanvas"
        aria-labelledby="createBranchOffcanvasLabel" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="createBranchOffcanvasLabel">Nouvelle branche</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <div class="offcanvas-body">
            <form id="newBranchForm" method="POST" action="{{ route('branches.store', $structure_id) }}">
                @csrf
                <div class="mb-3">
                    <label for="newBranchName" class="form-label">Nom de la branche <span
                            class="text-danger">*</span></label>
                    <input type="text" class="form-control shadow-sm @error('branch_name') is-invalid @enderror"
                        id="newBranchName" name="branch_name" placeholder="Ex: Agence Centre" required>
                    @error('branch_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="newBranchDescription" class="form-label">Description</label>
                    <textarea class="form-control shadow-sm @error('branch_description') is-invalid @enderror" id="newBranchDescription"
                        name="branch_description" rows="4" placeholder="Brève description..."></textarea>
                    @error('branch_description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="newBranchLocation" class="form-label">Localisation</label>
                    <input type="text" class="form-control shadow-sm @error('branch_location') is-invalid @enderror"
                        id="newBranchLocation" name="branch_location" placeholder="Ex: Libreville">
                    @error('branch_location')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-4 pt-3 border-top d-flex justify-content-end">
                    <button type="button" class="btn btn-secondary me-2 radius-30 shadow"
                        data-bs-dismiss="offcanvas">Annuler</button>
                    <button type="submit" class="btn btn-primary radius-30 shadow" data-loader-target="enregistre"><i
                            class='bx bx-save me-1'></i>Enregistrer</button>
                    <button type="submit" class="btn btn-primary radius-30 shadow" style="display: none;" disabled
                        id="enregistre">
                        <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                        Enregistrement en cours...
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- JS COMPLET (update + delete AJAX) --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const branchDetailOffcanvasElement = document.getElementById('branchDetailOffcanvas');
            const notificationToastElement = document.getElementById('notification-toast');
            const notificationToast = new bootstrap.Toast(notificationToastElement);

            function showToast(message, isError = false) {
                const body = notificationToastElement.querySelector('.toast-body');
                body.textContent = message;
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
                        if (errorDiv) errorDiv.textContent = errors[field][0];
                    }
                }
            }

            // OUVERTURE OFFCANVAS DYNAMIQUE
            if (branchDetailOffcanvasElement) {
                branchDetailOffcanvasElement.addEventListener('show.bs.offcanvas', function(event) {
                    const card = event.relatedTarget; // .branch-card
                    const offcanvas = this;

                    clearValidationErrors(offcanvas.querySelector('#branchEditForm'));

                    // Remplir formulaire
                    offcanvas.querySelector('#editBranchIdInput').value = card.dataset.id;
                    offcanvas.querySelector('#editBranchNameInput').value = card.dataset.name || '';
                    offcanvas.querySelector('#editBranchDescriptionInput').value = card.dataset
                        .description || '';

                    // Titre
                    offcanvas.querySelector('#branchDetailOffcanvasLabel').textContent =
                        `Détails : ${card.dataset.name}`;

                    // Stats
                    document.getElementById('statTotalTickets').textContent = card.dataset
                        .statTotalTickets || '0';
                    document.getElementById('statTotalTicketsTrend').textContent = card.dataset
                        .statTotalTicketsTrend || '+0.0%';
                    document.getElementById('statCancelledTickets').textContent = card.dataset
                        .statCancelledTickets || '0';
                    document.getElementById('statCancelledTicketsTrend').textContent = card.dataset
                        .statCancelledTicketsTrend || '+0.0%';
                    document.getElementById('statFavorableResponses').textContent = card.dataset
                        .statFavorableResponses || '0';
                    document.getElementById('statFavorableResponsesTrend').textContent = card.dataset
                        .statFavorableResponsesTrend || '+0.0%';
                    document.getElementById('statUnfavorableResponses').textContent = card.dataset
                        .statUnfavorableResponses || '0';
                    document.getElementById('statUnfavorableResponsesTrend').textContent = card.dataset
                        .statUnfavorableResponsesTrend || '-0.0%';
                });
            }

            // EDIT/PATCH
            const editForm = document.getElementById('branchEditForm');
            if (editForm) {
                editForm.addEventListener('submit', function(event) {
                    event.preventDefault();

                    const branchId = document.getElementById('editBranchIdInput').value;
                    const formData = new FormData(editForm);
                    const data = Object.fromEntries(formData.entries());

                    const submitBtn = editForm.querySelector('button[type="submit"]');
                    submitBtn.disabled = true;

                    fetch(`/branches/${branchId}`, {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },
                            body: JSON.stringify({
                                branch_name: data.branch_name,
                                branch_description: data.branch_description
                            })
                        })
                        .then(r => r.json().then(body => ({
                            status: r.status,
                            body
                        })))
                        .then(({
                            status,
                            body
                        }) => {
                            if (status === 200) {
                                showToast(body.message || 'Modifié avec succès.');
                                // MAJ du nom sur la carte
                                const cardName = document.querySelector(
                                    `#branch-card-${branchId} .branch-name-display`);
                                if (cardName && body.branche?.nom) cardName.textContent = body.branche
                                    .nom;
                                // Fermer
                                bootstrap.Offcanvas.getInstance(branchDetailOffcanvasElement).hide();
                            } else if (status === 422) {
                                displayValidationErrors(editForm, body.errors);
                            } else {
                                showToast(body.message || 'Une erreur est survenue.', true);
                            }
                        })
                        .catch(() => showToast('Erreur de connexion.', true))
                        .finally(() => {
                            submitBtn.disabled = false;
                        });
                });
            }

            // DELETE
            const deleteBtn = document.getElementById('deleteBranchBtn');
            if (deleteBtn) {
                deleteBtn.addEventListener('click', function() {
                    const branchId = document.getElementById('editBranchIdInput').value;
                    const branchName = document.getElementById('editBranchNameInput').value;

                    if (!branchId) return;

                    if (confirm(`Supprimer la branche "${branchName}" ? Cette action est irréversible.`)) {
                        fetch(`/branches/${branchId}`, {
                                method: 'DELETE',
                                headers: {
                                    'Accept': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                }
                            })
                            .then(r => r.json().then(body => ({
                                status: r.status,
                                body
                            })))
                            .then(({
                                status,
                                body
                            }) => {
                                if (status === 200) {
                                    showToast(body.message || 'Supprimée avec succès.');
                                    // Retirer la carte du DOM
                                    const card = document.getElementById(`branch-card-${branchId}`);
                                    if (card) card.remove();
                                    // Fermer
                                    bootstrap.Offcanvas.getInstance(branchDetailOffcanvasElement)
                                .hide();
                                } else if (status === 409) {
                                    showToast(body.message || 'Suppression impossible : éléments liés.',
                                        true);
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
