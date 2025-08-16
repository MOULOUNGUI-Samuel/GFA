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
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Branches</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Liste des branches</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <button type="button"
                        class="btn btn-light bg-light radius-30 shadow d-flex align-items-center justify-content-center"
                        style="cursor: pointer;" data-bs-toggle="offcanvas" data-bs-target="#monOffcanvasSimple"
                        aria-controls="monOffcanvasSimple">
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
            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 row-cols-xl-4 g-3">
                <!-- Exemple pour une carte de branche, avec les nouveaux data-* attributs -->
                <div class="col">
                    <div class="d-flex align-items-center p-3 shadow-sm rounded cursor-pointer branch-card bg-light"
                        role="button" data-id="1" data-name="Agence Paris Centre"
                        data-description="L'agence principale." data-stat-total-tickets="12,546"
                        data-stat-total-tickets-trend="+3.2% vs semaine passée" data-stat-cancelled-tickets="212"
                        data-stat-cancelled-tickets-trend="+1.4% vs semaine passée" data-stat-favorable-responses="1,895"
                        data-stat-favorable-responses-trend="+8.4% vs semaine passée" data-stat-unfavorable-responses="152"
                        data-stat-unfavorable-responses-trend="-2.1% vs semaine passée">

                        <div class="font-22 text-primary">
                            <i class='bx bx-buildings'></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="mb-0">Agence Paris Centre</h6>
                            <small class="text-secondary">Cliquez pour gérer</small>
                        </div>
                    </div>
                </div>

                <!-- Branche 2 -->

                <!-- C'est cette classe qui positionne le panneau en haut -->
                <div class="offcanvas offcanvas-top" tabindex="-1" id="branchOffcanvas"
                    aria-labelledby="branchOffcanvasLabel">

                    <div class="offcanvas-header border-bottom">
                        <h5 class="offcanvas-title" id="branchOffcanvasLabel">Détails de la Branche</h5>
                        <div class="d-flex align-items-center">

                            <div class="dropdown me-2">
                                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">Aujourd'hui</button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Aujourd'hui</a>
                                    </li>
                                    <li><a class="dropdown-item" href="#">hier</a>
                                    </li>
                                    <li><a class="dropdown-item" href="#">Semaine</a>
                                    </li>
                                    <li><a class="dropdown-item" href="#">Mois</a>
                                    <li><a class="dropdown-item" href="#">Année</a>
                                    </li>
                                </ul>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                aria-label="Close"></button>

                        </div>
                    </div>

                    <div class="offcanvas-body">
                        <div class="row">
                            <div class="col-md-3 border-end">
                                <h6><i class="bx bx-info-circle mb-3"></i>Agences & services</h6>

                                <div class="row row-cols-1 row-cols-md-1">
                                    <div class="col">
                                        <div class="card radius-10 border-start border-0 border-4 border-dark">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <p class="mb-0 text-secondary">Total d'Agents</p>
                                                        <!-- ID mis à jour pour correspondre au contenu -->
                                                        <h4 class="my-1 text-dark" id="statTotalAgents">0</h4>
                                                        <p class="mb-0 font-13" id="statTotalAgentsTrend">+0.0%</p>
                                                    </div>
                                                    <div class="widgets-icons-2 rounded-circle bg-dark text-white ms-auto">
                                                        <!-- Icône changée pour "Agents" -->
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
                                                        <!-- ID mis à jour pour correspondre au contenu -->
                                                        <h4 class="my-1 text-secondary" id="statTotalServices">0</h4>
                                                        <p class="mb-0 font-13" id="statTotalServicesTrend">+0.0%</p>
                                                    </div>
                                                    <div
                                                        class="widgets-icons-2 rounded-circle bg-secondary text-white ms-auto">
                                                        <!-- Icône changée pour "Services" -->
                                                        <i class='bx bxs-briefcase-alt-2'></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- PARTIE DROITE : STATISTIQUES -->
                            <div class="col-md-5">
                                <h6><i class="bx bx-bar-chart-alt-2 mb-3"></i>Statistiques Clés</h6>
                                <div class="row row-cols-1 row-cols-md-2">
                                    <div class="col">
                                        <div class="card radius-10 border-start border-0 border-4 border-success">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <p class="mb-0 text-secondary">Total de tickets</p>
                                                        <!-- ID ajouté ici -->
                                                        <h4 class="my-1 text-success" id="statTotalTickets">0</h4>
                                                        <!-- ID ajouté ici -->
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
                                                        <p class="mb-0 text-secondary">Total de tickets annulé</p>
                                                        <!-- ID ajouté ici -->
                                                        <h4 class="my-1 text-danger" id="statCancelledTickets">0</h4>
                                                        <!-- ID ajouté ici -->
                                                        <p class="mb-0 font-13" id="statCancelledTicketsTrend">+0.0%</p>
                                                    </div>
                                                    <div
                                                        class="widgets-icons-2 rounded-circle bg-gradient-burning text-white ms-auto">
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
                                                        <!-- ID ajouté ici -->
                                                        <h4 class="my-1 text-info" id="statFavorableResponses">0</h4>
                                                        <!-- ID ajouté ici -->
                                                        <p class="mb-0 font-13" id="statFavorableResponsesTrend">+0.0%</p>
                                                    </div>
                                                    <div
                                                        class="widgets-icons-2 rounded-circle bg-gradient-blues text-white ms-auto">
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
                                                        <!-- ID ajouté ici -->
                                                        <h4 class="my-1 text-warning" id="statUnfavorableResponses">0</h4>
                                                        <!-- ID ajouté ici -->
                                                        <p class="mb-0 font-13" id="statUnfavorableResponsesTrend">-0.0%
                                                        </p>
                                                    </div>
                                                    <div
                                                        class="widgets-icons-2 rounded-circle bg-gradient-orange text-white ms-auto">
                                                        <i class='bx bxs-dislike'></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!--end row-->
                            </div>
                            <!-- PARTIE GAUCHE : FORMULAIRE DE MODIFICATION -->
                            <div class="col-md-4 border-end">
                                <h6><i class="bx bx-edit-alt me-1"></i>Modifier les informations</h6>
                                <form id="branchEditForm">
                                    <!-- Champ caché pour stocker l'ID de la branche, essentiel pour la soumission du formulaire -->
                                    <input type="hidden" id="branchIdInput" name="branch_id">

                                    <div class="mb-3">
                                        <label for="branchNameInput" class="form-label">Nom de la branche</label>
                                        <input type="text" class="form-control" id="branchNameInput"
                                            name="branch_name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="branchDescriptionInput" class="form-label">Description</label>
                                        <textarea class="form-control" id="branchDescriptionInput" name="branch_description" rows="3"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary mb-2">Enregistrer les
                                        modifications</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="offcanvas offcanvas-end" tabindex="-1" id="monOffcanvasSimple"
                aria-labelledby="monOffcanvasSimpleLabel" data-bs-backdrop="static" data-bs-keyboard="false">

                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="monOffcanvasSimpleLabel">Nouvelle branche</h5>

                    <!-- Ce bouton ferme l'Offcanvas grâce à data-bs-dismiss -->
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>

                <div class="offcanvas-body">
                    @php
    // On récupère le PREMIER objet Structure associé à l'utilisateur connecté.
    $userStructure = Auth::user()->structures()->first();
@endphp
                    <!-- Formulaire d'enregistrement -->
                    <form id="newBranchForm" method="POST" action="{{ route('branches.store', ['structure' => $userStructure]) }}">
                        @csrf

                        <div class="mb-3">
                            <label for="newBranchName" class="form-label">Nom de la branche <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control shadow-sm" id="newBranchName" name="branch_name"
                                placeholder="Ex: Agence Lille Centre" required>
                            <!-- Le message d'erreur de validation s'affichera ici -->
                        </div>

                        <div class="mb-3">
                            <label for="newBranchDescription" class="form-label">Description</label>
                            <textarea class="form-control shadow-sm" id="newBranchDescription" name="branch_description" rows="4"
                                placeholder="Ajoutez une brève description de la branche..."></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="newBranchLocation" class="form-label">Localisation</label>
                            <input type="text" class="form-control shadow-sm" id="newBranchLocation"
                                name="branch_location" placeholder="Ex: Lille">
                        </div>

                        <!-- ... Vos boutons ... -->
                        <div class="mt-4 pt-3 border-top d-flex justify-content-end"> <!-- J'ai simplifié le justify -->
                            <button type="button" class="btn btn-secondary me-2 radius-30 shadow"
                                data-bs-dismiss="offcanvas">Annuler</button>
                            <button type="submit" class="btn btn-primary radius-30 shadow"><i
                                    class='bx bx-save me-1'></i>Enregistrer</button>
                            <button type="button" class="btn btn-primary radius-30 shadow d-none" id="btnLoading"
                                disabled>
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                Enregistrement...
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // 1. Récupérer l'élément Offcanvas de la page
            const offcanvasElement = document.getElementById('branchOffcanvas');
            // 2. Créer une instance Bootstrap de l'Offcanvas pour pouvoir le contrôler en JS
            const bsOffcanvas = new bootstrap.Offcanvas(offcanvasElement);

            // 3. Sélectionner toutes les cartes de branches
            const branchCards = document.querySelectorAll('.branch-card');

            // 4. Ajouter un écouteur d'événement sur chaque carte
            branchCards.forEach(card => {
                card.addEventListener('click', function() {

                    // ======================================================
                    // 5. RÉCUPÉRATION DES DONNÉES (MISE À JOUR)
                    // ======================================================
                    const branchId = this.dataset.id;
                    const branchName = this.dataset.name;
                    const branchDescription = this.dataset.description;

                    // Récupération des nouvelles statistiques
                    const totalTickets = this.dataset.statTotalTickets;
                    const totalTicketsTrend = this.dataset.statTotalTicketsTrend;
                    const cancelledTickets = this.dataset.statCancelledTickets;
                    const cancelledTicketsTrend = this.dataset.statCancelledTicketsTrend;
                    const favorableResponses = this.dataset.statFavorableResponses;
                    const favorableResponsesTrend = this.dataset.statFavorableResponsesTrend;
                    const unfavorableResponses = this.dataset.statUnfavorableResponses;
                    const unfavorableResponsesTrend = this.dataset.statUnfavorableResponsesTrend;


                    // ======================================================
                    // 6. MISE À JOUR DU FORMULAIRE (INCHANGÉ)
                    // ======================================================
                    document.getElementById('branchIdInput').value = branchId;
                    document.getElementById('branchNameInput').value = branchName;
                    document.getElementById('branchDescriptionInput').value = branchDescription;


                    // ======================================================
                    // 7. MISE À JOUR DE L'AFFICHAGE (MISE À JOUR)
                    // ======================================================
                    // Titre de l'offcanvas
                    document.getElementById('branchOffcanvasLabel').textContent =
                        `Statistiques de : ${branchName}`;

                    // Mise à jour des nouvelles cartes de statistiques
                    document.getElementById('statTotalTickets').textContent = totalTickets;
                    document.getElementById('statTotalTicketsTrend').textContent =
                        totalTicketsTrend;
                    document.getElementById('statCancelledTickets').textContent = cancelledTickets;
                    document.getElementById('statCancelledTicketsTrend').textContent =
                        cancelledTicketsTrend;
                    document.getElementById('statFavorableResponses').textContent =
                        favorableResponses;
                    document.getElementById('statFavorableResponsesTrend').textContent =
                        favorableResponsesTrend;
                    document.getElementById('statUnfavorableResponses').textContent =
                        unfavorableResponses;
                    document.getElementById('statUnfavorableResponsesTrend').textContent =
                        unfavorableResponsesTrend;


                    // 8. Afficher l'Offcanvas (INCHANGÉ)
                    bsOffcanvas.show();
                });
            });

            // Optionnel : Gérer la soumission du formulaire (INCHANGÉ)
            const editForm = document.getElementById('branchEditForm');
            editForm.addEventListener('submit', function(event) {
                event.preventDefault();
                const formData = new FormData(editForm);
                console.log('Formulaire soumis pour la branche ID:', formData.get('branch_id'));
                console.log('Nouveau nom:', formData.get('branch_name'));
                console.log('Nouvelle description:', formData.get('branch_description'));

                alert(
                    `Modifications pour la branche ${formData.get('branch_name')} enregistrées (simulation) !`
                );

                bsOffcanvas.hide();
            });

        });
    </script>
@endsection
