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
                <div class="breadcrumb-title pe-3">Services</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Liste des services</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <button type="button"
                        class="btn btn-light bg-light radius-30 shadow d-flex align-items-center justify-content-center"
                        style="cursor: pointer;" data-bs-toggle="offcanvas" data-bs-target="#addCaisseOffcanvas"
                        aria-controls="addCaisseOffcanvas">
                        <i class='lni lni-circle-plus mr-1'></i>
                        <span>Nouveau service</span>
                    </button>
                </div>
            </div>
            @if (session('success'))
                <div class="alert alert-success border-0 bg-success alert-dismissible fade show py-2">
                    <div class="d-flex align-items-center">
                        <div class="font-35 text-white"><i class='bx bxs-check-circle'></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="mb-0 text-white">{{ session('success') }}</h6>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger border-0 bg-danger alert-dismissible fade show py-2">
                    <div class="d-flex align-items-center">
                        <div class="font-35 text-white"><i class='bx bxs-message-square-x'></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="mb-0 text-white">{{ session('error') }}</h6>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 row-cols-xl-4 g-3">

                @forelse ($services as $service)
                    <div class="col">
                        {{-- 
                            Chaque carte est un bouton qui stocke ses informations uniques dans des attributs "data-*".
                            - data-bs-toggle et data-bs-target sont des commandes Bootstrap pour ouvrir l'offcanvas.
                        --}}
                        <div class="d-flex align-items-center p-3 shadow-sm rounded cursor-pointer service-card bg-light"
                            role="button" data-bs-toggle="offcanvas" data-bs-target="#serviceDetailOffcanvas"
                            {{-- Données du service --}} data-id="{{ $service->id }}" data-name="{{ $service->nom }}"
                            data-branch-name="{{ $service->branche->nom }}" {{-- Données statistiques (ce sont des exemples à remplacer par vos vrais calculs) --}} data-stat-total-agents="5"
                            data-stat-total-agents-trend="+1" data-stat-total-tickets="1,250"
                            data-stat-total-tickets-trend="+4.1%" data-stat-cancelled-tickets="32"
                            data-stat-cancelled-tickets-trend="-1.2%" data-stat-favorable-responses="980"
                            data-stat-favorable-responses-trend="+5.5%" data-stat-unfavorable-responses="45"
                            data-stat-unfavorable-responses-trend="+0.5%">

                            <div class="font-22 text-primary">
                                <i class='bx bx-desktop'></i>
                            </div>
                            <div class="ms-3">
                                <h6 class="mb-0">{{ $service->nom }}</h6>
                                <small class="text-secondary">{{ $service->branche->nom }}</small>
                            </div>
                        </div>
                    </div>
                @empty
                    {{-- Ce message s'affiche si la variable $services est vide --}}
                    <div class="col-12">
                        <div class="alert alert-info">Aucun service n'a encore été créé pour cette structure.</div>
                    </div>
                @endforelse

            </div> {{-- Fin de la div .row --}}



            {{-- ========================================================================= --}}
            {{--   PARTIE 2 : L'OFFCANVAS (Défini UNE SEULE FOIS, HORS de la boucle)       --}}
            {{-- ========================================================================= --}}
            <div class="offcanvas offcanvas-top" tabindex="-1" id="serviceDetailOffcanvas"
                aria-labelledby="serviceDetailOffcanvasLabel">

                <div class="offcanvas-header border-bottom">
                    <h5 class="offcanvas-title" id="serviceDetailOffcanvasLabel">Détails du service</h5>
                    <div class="d-flex align-items-center">
                        <div class="dropdown me-2">
                            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false">Aujourd'hui</button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Aujourd'hui</a></li>
                                <li><a class="dropdown-item" href="#">Hier</a></li>
                                <li><a class="dropdown-item" href="#">Cette semaine</a></li>
                                <li><a class="dropdown-item" href="#">Ce mois-ci</a></li>
                                <li><a class="dropdown-item" href="#">Cette année</a></li>
                            </ul>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                            aria-label="Close"></button>
                    </div>
                </div>

                <div class="offcanvas-body">
                    <div class="row">
                        <!-- COLONNE 1 : FORMULAIRE ET INFOS -->
                        <div class="col-md-4 border-end">
                            <h6><i class="bx bx-edit-alt me-1"></i>Modifier le service</h6>
                            <form id="serviceEditForm">
                                <input type="hidden" id="editServiceIdInput" name="service_id">

                                <div class="mb-3">
                                    <label for="editServiceNameInput" class="form-label">Nom du service</label>
                                    <input type="text" class="form-control" id="editServiceNameInput"
                                        name="service_name" required>
                                    <div class="invalid-feedback" id="edit-service_name-error"></div>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                                    <button type="button" class="btn btn-danger"
                                        id="deleteServiceBtn">Supprimer</button>
                                </div>
                            </form>

                            <h6 class="mt-3"><i class="bx bx-info-circle me-1"></i>Infos Générales</h6>
                            <div class="card radius-10 border-start border-0 border-4 border-dark">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <p class="mb-0 text-secondary">Agents assignés</p>
                                            <h4 class="my-1 text-dark" id="offcanvasStatTotalAgents">0</h4>
                                            <p class="mb-0 font-13" id="offcanvasStatTotalAgentsTrend">+0</p>
                                        </div>
                                        <div class="widgets-icons-2 rounded-circle bg-dark text-white ms-auto"><i
                                                class='bx bxs-group'></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- COLONNE 2 : STATS DES TICKETS -->
                        <div class="col-md-8">
                            <h6><i class="bx bx-bar-chart-alt-2 me-1"></i>Activité des Tickets</h6>
                            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
                                <div class="col">
                                    <div class="card radius-10 border-start border-0 border-4 border-success">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <p class="mb-0 text-secondary">Total tickets</p>
                                                    <h4 class="my-1 text-success" id="offcanvasStatTotalTickets">0</h4>
                                                    <p class="mb-0 font-13" id="offcanvasStatTotalTicketsTrend">+0.0%</p>
                                                </div>
                                                <div
                                                    class="widgets-icons-2 rounded-circle bg-gradient-ohhappiness text-white ms-auto">
                                                    <i class='bx bxs-purchase-tag-alt'></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card radius-10 border-start border-0 border-4 border-danger">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <p class="mb-0 text-secondary">Tickets annulés</p>
                                                    <h4 class="my-1 text-danger" id="offcanvasStatCancelledTickets">0</h4>
                                                    <p class="mb-0 font-13" id="offcanvasStatCancelledTicketsTrend">+0.0%
                                                    </p>
                                                </div>
                                                <div
                                                    class="widgets-icons-2 rounded-circle bg-gradient-burning text-white ms-auto">
                                                    <i class='bx bxs-x-circle'></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card radius-10 border-start border-0 border-4 border-info">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <p class="mb-0 text-secondary">Réponses OK</p>
                                                    <h4 class="my-1 text-info" id="offcanvasStatFavorableResponses">0</h4>
                                                    <p class="mb-0 font-13" id="offcanvasStatFavorableResponsesTrend">
                                                        +0.0%</p>
                                                </div>
                                                <div
                                                    class="widgets-icons-2 rounded-circle bg-gradient-blues text-white ms-auto">
                                                    <i class='bx bxs-like'></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card radius-10 border-start border-0 border-4 border-warning">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <p class="mb-0 text-secondary">Réponses NOK</p>
                                                    <h4 class="my-1 text-warning" id="offcanvasStatUnfavorableResponses">0
                                                    </h4>
                                                    <p class="mb-0 font-13" id="offcanvasStatUnfavorableResponsesTrend">
                                                        -0.0%</p>
                                                </div>
                                                <div
                                                    class="widgets-icons-2 rounded-circle bg-gradient-orange text-white ms-auto">
                                                    <i class='bx bxs-dislike'></i></div>
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
        <!-- Offcanvas pour l'ajout d'une NOUVELLE CAISSE -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="addCaisseOffcanvas"
            aria-labelledby="addCaisseOffcanvasLabel" data-bs-backdrop="static" data-bs-keyboard="false">

            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="addCaisseOffcanvasLabel">Nouveau service</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>

            <div class="offcanvas-body">
                <!-- Formulaire d'enregistrement de la caisse -->
                <!-- J'ai renommé le form id en 'newServiceForm' pour plus de clarté -->
                {{-- Le formulaire pour une soumission classique --}}
                <form id="newServiceForm" method="POST" action="{{ route('services.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="newServiceName" class="form-label">Nom du service<span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control shadow-sm @error('nom') is-invalid @enderror"
                            id="newServiceName" name="nom" value="{{ old('nom') }}"
                            placeholder="Ex: Retrait, Dépôt, Conseiller..." required>
                        @error('nom')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="serviceBrancheSelect" class="form-label">Branche de rattachement <span
                                class="text-danger">*</span></label>
                        <select class="form-select shadow-sm @error('branche_id') is-invalid @enderror"
                            id="serviceBrancheSelect" name="branche_id" required>
                            <option selected disabled value="">Choisir une branche...</option>

                            {{-- La variable $branches doit être passée à la vue --}}
                            @foreach ($branches as $branche)
                                <option value="{{ $branche->id }}" @if (old('branche_id') == $branche->id) selected @endif>
                                    {{ $branche->nom }} ({{ $branche->structure->nom }})
                                </option>
                            @endforeach
                        </select>
                        @error('branche_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="newServiceTemps" class="form-label">Temps moyen estimé (minutes)</label>
                        <input type="number"
                            class="form-control shadow-sm @error('temps_moyen_estime') is-invalid @enderror"
                            id="newServiceTemps" name="temps_moyen_estime" value="{{ old('temps_moyen_estime') }}"
                            placeholder="Ex: 15" min="1">
                        @error('temps_moyen_estime')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- Boutons d'action du formulaire -->
                    <div class="mt-4 pt-3 border-top d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary me-2 radius-30 shadow"
                            data-bs-dismiss="offcanvas">Annuler</button>
                        <button type="submit" class="btn btn-primary radius-30 shadow" data-loader-target="service"
                            id="btnSaveService"><i class='bx bx-save me-1'></i>Enregistrer</button>
                        <button type="button" class="btn btn-primary radius-30 shadow" id="service"
                            style="display: none;" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Enregistrement...
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
    </div>
    {{-- ========================================================================= --}}
    {{--   PARTIE 3 : LE JAVASCRIPT (Gère l'interaction)                         --}}
    {{-- ========================================================================= --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const serviceDetailOffcanvasElement = document.getElementById('serviceDetailOffcanvas');
            const notificationToastElement = document.getElementById('notification-toast');
            const notificationToast = new bootstrap.Toast(notificationToastElement);

            // --- Helpers
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

            // --- Remplissage dynamique à l'ouverture
            if (serviceDetailOffcanvasElement) {
                serviceDetailOffcanvasElement.addEventListener('show.bs.offcanvas', function(event) {
                    const serviceCard = event.relatedTarget;
                    const offcanvas = this;

                    clearValidationErrors(offcanvas.querySelector('#serviceEditForm'));

                    // Titre + formulaire
                    offcanvas.querySelector('#serviceDetailOffcanvasLabel').textContent =
                        `Détails : ${serviceCard.dataset.name} (${serviceCard.dataset.branchName})`;

                    offcanvas.querySelector('#editServiceIdInput').value = serviceCard.dataset.id;
                    offcanvas.querySelector('#editServiceNameInput').value = serviceCard.dataset.name || '';

                    // Stats
                    offcanvas.querySelector('#offcanvasStatTotalAgents').textContent = serviceCard.dataset
                        .statTotalAgents || '0';
                    offcanvas.querySelector('#offcanvasStatTotalAgentsTrend').textContent = serviceCard
                        .dataset.statTotalAgentsTrend || '+0';
                    offcanvas.querySelector('#offcanvasStatTotalTickets').textContent = serviceCard.dataset
                        .statTotalTickets || '0';
                    offcanvas.querySelector('#offcanvasStatTotalTicketsTrend').textContent = serviceCard
                        .dataset.statTotalTicketsTrend || '+0.0%';
                    offcanvas.querySelector('#offcanvasStatCancelledTickets').textContent = serviceCard
                        .dataset.statCancelledTickets || '0';
                    offcanvas.querySelector('#offcanvasStatCancelledTicketsTrend').textContent = serviceCard
                        .dataset.statCancelledTicketsTrend || '+0.0%';
                    offcanvas.querySelector('#offcanvasStatFavorableResponses').textContent = serviceCard
                        .dataset.statFavorableResponses || '0';
                    offcanvas.querySelector('#offcanvasStatFavorableResponsesTrend').textContent =
                        serviceCard.dataset.statFavorableResponsesTrend || '+0.0%';
                    offcanvas.querySelector('#offcanvasStatUnfavorableResponses').textContent = serviceCard
                        .dataset.statUnfavorableResponses || '0';
                    offcanvas.querySelector('#offcanvasStatUnfavorableResponsesTrend').textContent =
                        serviceCard.dataset.statUnfavorableResponsesTrend || '-0.0%';
                });
            }

            // --- PATCH (édition)
            const editForm = document.getElementById('serviceEditForm');
            if (editForm) {
                editForm.addEventListener('submit', function(event) {
                    event.preventDefault();

                    const serviceId = document.getElementById('editServiceIdInput').value;
                    const formData = new FormData(editForm);
                    const data = Object.fromEntries(formData.entries());

                    const submitBtn = editForm.querySelector('button[type="submit"]');
                    submitBtn.disabled = true;

                    fetch(`/services/${serviceId}`, {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                service_name: data.service_name
                                // Ajoute ici d'autres champs si tu en as (ex: temps_moyen_estime)
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
                                showToast(body.message || 'Service modifié avec succès.');
                                // MAJ du nom sur la carte
                                const cardName = document.querySelector(
                                    `#service-card-${serviceId} .service-name-display`);
                                // Ou fallback: cherche la carte avec [data-id="..."]
                                if (!cardName) {
                                    const card = document.querySelector(
                                        `.service-card[data-id="${serviceId}"]`);
                                    if (card) {
                                        const title = card.querySelector('h6');
                                        if (title && body.service?.nom) title.textContent = body.service
                                            .nom;
                                    }
                                } else if (body.service?.nom) {
                                    cardName.textContent = body.service.nom;
                                }
                                // Fermer
                                bootstrap.Offcanvas.getInstance(serviceDetailOffcanvasElement).hide();
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

            // --- DELETE (suppression)
            const deleteBtn = document.getElementById('deleteServiceBtn');
            if (deleteBtn) {
                deleteBtn.addEventListener('click', function() {
                    const serviceId = document.getElementById('editServiceIdInput').value;
                    const serviceName = document.getElementById('editServiceNameInput').value;

                    if (!serviceId) return;

                    if (confirm(`Supprimer le service "${serviceName}" ? Cette action est irréversible.`)) {
                        fetch(`/services/${serviceId}`, {
                                method: 'DELETE',
                                headers: {
                                    'Accept': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
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
                                    showToast(body.message || 'Service supprimé avec succès.');
                                    // Retire la carte du DOM
                                    const cardWrapper = document.querySelector(
                                            `.col #service-card-${serviceId}`) ||
                                        document.querySelector(`.service-card[data-id="${serviceId}"]`)
                                        ?.closest('.col');
                                    if (cardWrapper) cardWrapper.remove();

                                    bootstrap.Offcanvas.getInstance(serviceDetailOffcanvasElement)
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
