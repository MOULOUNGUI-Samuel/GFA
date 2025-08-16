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
                <div class="breadcrumb-title pe-3">Caisses</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Liste des caisses</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <button type="button"
                        class="btn btn-light bg-light radius-30 shadow d-flex align-items-center justify-content-center"
                        style="cursor: pointer;" data-bs-toggle="offcanvas" data-bs-target="#monOffcanvasSimple"
                        aria-controls="monOffcanvasSimple">
                        <i class='lni lni-circle-plus mr-1'></i>
                        <span>Nouvelle caisse</span>
                    </button>
                </div>
            </div>

            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 row-cols-xl-4 g-3">
                <!-- Exemple pour une carte de branche, avec les nouveaux data-* attributs -->
                <div class="col">
                    <div class="d-flex align-items-center p-3 shadow-sm rounded cursor-pointer caisse-card bg-light"
                        role="button"
                        data-id="101"
                        data-name="Caisse Principale"
                        data-branch-id="1"
                        data-stat-total-agents="4"
                        data-stat-total-agents-trend="+1"
                        data-stat-total-services="12"
                        data-stat-total-services-trend="+2"
                        data-stat-total-tickets="1,250"
                        data-stat-total-tickets-trend="+4.1%"
                        data-stat-cancelled-tickets="32"
                        data-stat-cancelled-tickets-trend="-1.2%"
                        data-stat-favorable-responses="980"
                        data-stat-favorable-responses-trend="+5.5%"
                        data-stat-unfavorable-responses="45"
                        data-stat-unfavorable-responses-trend="+0.5%">

                        <div class="font-22 text-primary">
                            <i class='bx bx-desktop'></i> <!-- Icône changée -->
                        </div>
                        <div class="ms-3">
                            <h6 class="mb-0">Caisse Principale</h6> <!-- Nom de la Caisse -->
                            <small class="text-secondary">Agence Paris Centre</small> <!-- Branche parente -->
                        </div>
                    </div>
                </div>

                <!-- Caisse 2 -->
                <div class="col">
                    <div class="d-flex align-items-center p-3 shadow-sm rounded cursor-pointer caisse-card bg-light"
                        role="button" data-id="102" data-name="Caisse Drive" data-branch-id="1" data-stat-total-agents="2"
                        data-stat-total-agents-trend="0" data-stat-total-services="5" data-stat-total-services-trend="+1"
                        data-stat-total-tickets="840" data-stat-total-tickets-trend="+2.8%" data-stat-cancelled-tickets="15"
                        data-stat-cancelled-tickets-trend="+0.9%" data-stat-favorable-responses="710"
                        data-stat-favorable-responses-trend="+3.1%" data-stat-unfavorable-responses="21"
                        data-stat-unfavorable-responses-trend="-1.1%">

                        <div class="font-22 text-success">
                            <i class='bx bx-desktop'></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="mb-0">Caisse Drive</h6>
                            <small class="text-secondary">Agence Paris Centre</small>
                        </div>
                    </div>
                </div>

                <!-- Branche 2 -->

                <!-- Offcanvas pour les détails de la CAISSE -->
                <div class="offcanvas offcanvas-top" tabindex="-1" id="caisseOffcanvas"
                    aria-labelledby="caisseOffcanvasLabel">

                    <div class="offcanvas-header border-bottom">
                        <h5 class="offcanvas-title" id="caisseOffcanvasLabel">Détails de la Caisse</h5>
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
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                aria-label="Close"></button>
                        </div>
                    </div>

                    <div class="offcanvas-body">
                        <div class="row">
                            <!-- COLONNE 1 : FORMULAIRE DE MODIFICATION ET INFOS GÉNÉRALES -->
                            <div class="col-md-4 border-end">
                                <!-- Formulaire de modification -->
                                <h6><i class="bx bx-edit-alt me-1"></i>Modifier la Caisse</h6>
                                <form id="caisseEditForm">
                                    <input type="hidden" id="caisseIdInput" name="caisse_id">
                                    <div class="mb-3">
                                        <label for="caisseNameInput" class="form-label">Nom de la caisse</label>
                                        <input type="text" class="form-control" id="caisseNameInput"
                                            name="caisse_name" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary mb-4">Enregistrer</button>
                                </form>

                                <!-- Infos générales -->
                                <h6><i class="bx bx-info-circle me-1"></i>Infos Générales</h6>
                                <div class="row row-cols-1">
                                    <div class="col">
                                        <div class="card radius-10 border-start border-0 border-4 border-dark">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <p class="mb-0 text-secondary">Agents assignés</p>
                                                        <h4 class="my-1 text-dark" id="statTotalAgents">0</h4>
                                                        <p class="mb-0 font-13" id="statTotalAgentsTrend">+0</p>
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
                                                        <p class="mb-0 text-secondary">Services disponibles</p>
                                                        <h4 class="my-1 text-secondary" id="statTotalServices">0</h4>
                                                        <p class="mb-0 font-13" id="statTotalServicesTrend">+0</p>
                                                    </div>
                                                    <div
                                                        class="widgets-icons-2 rounded-circle bg-secondary text-white ms-auto">
                                                        <i class='bx bxs-briefcase-alt-2'></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- COLONNE 2 : STATISTIQUES DES TICKETS -->
                            <div class="col-md-8">
                                <h6><i class="bx bx-bar-chart-alt-2 me-1"></i>Activité des Tickets</h6>
                                <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
                                    <div class="col">
                                        <div class="card radius-10 border-start border-0 border-4 border-success">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <p class="mb-0 text-secondary">Total tickets</p>
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
                                                        <p class="mb-0 text-secondary">Tickets annulés</p>
                                                        <h4 class="my-1 text-danger" id="statCancelledTickets">0</h4>
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
                                                        <p class="mb-0 text-secondary">Réponses OK</p>
                                                        <h4 class="my-1 text-info" id="statFavorableResponses">0</h4>
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
                                                        <p class="mb-0 text-secondary">Réponses NOK</p>
                                                        <h4 class="my-1 text-warning" id="statUnfavorableResponses">0</h4>
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
                                </div>
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
                    <!-- Formulaire d'enregistrement -->
                    <form id="newBranchForm">

                        <div class="mb-3">
                            <label for="newBranchName" class="form-label">Nom de la branche <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control shadow-sm" id="newBranchName" name="branch_name"
                                placeholder="Ex: Agence Lille Centre" required>
                        </div>

                        <div class="mb-3">
                            <label for="newBranchDescription" class="form-label">Description</label>
                            <textarea class="form-control shadow-sm" id="newBranchDescription" name="branch_description" rows="4"
                                placeholder="Ajoutez une brève description de la branche..."></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="newBranchLocation" class="form-label">Localisation (Ville)</label>
                            <input type="text" class="form-control shadow-sm" id="newBranchLocation"
                                name="branch_location" placeholder="Ex: Lille">
                        </div>

                        <!-- Boutons d'action du formulaire -->
                        <div class="mt-4 pt-3 border-top d-flex justify-content-between">
                            <button type="button" class="btn btn-secondary ms-2 radius-30 shadow"
                                data-bs-dismiss="offcanvas">Annuler</button>
                            <button type="submit" class="btn btn-primary radius-30 shadow"><i
                                    class='bx bx-save me-1'></i>Enregistrer</button>
                            <button type="button" class="btn btn-primary radius-30 shadow d-none" id="btnLoading">
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

            // MISE À JOUR : On cible l'Offcanvas de la caisse
            const offcanvasElement = document.getElementById('caisseOffcanvas');
            const bsOffcanvas = new bootstrap.Offcanvas(offcanvasElement);

            // MISE À JOUR : On sélectionne les cartes de caisses
            const caisseCards = document.querySelectorAll('.caisse-card');

            caisseCards.forEach(card => {
                card.addEventListener('click', function() {

                    // RÉCUPÉRATION DES DONNÉES DE LA CAISSE
                    const caisseId = this.dataset.id;
                    const caisseName = this.dataset.name;

                    // Récupération des statistiques
                    const statTotalAgents = this.dataset.statTotalAgents;
                    const statTotalAgentsTrend = this.dataset.statTotalAgentsTrend;
                    const statTotalServices = this.dataset.statTotalServices;
                    const statTotalServicesTrend = this.dataset.statTotalServicesTrend;
                    const totalTickets = this.dataset.statTotalTickets;
                    const totalTicketsTrend = this.dataset.statTotalTicketsTrend;
                    const cancelledTickets = this.dataset.statCancelledTickets;
                    const cancelledTicketsTrend = this.dataset.statCancelledTicketsTrend;
                    const favorableResponses = this.dataset.statFavorableResponses;
                    const favorableResponsesTrend = this.dataset.statFavorableResponsesTrend;
                    const unfavorableResponses = this.dataset.statUnfavorableResponses;
                    const unfavorableResponsesTrend = this.dataset.statUnfavorableResponsesTrend;

                    // MISE À JOUR DU FORMULAIRE
                    document.getElementById('caisseIdInput').value = caisseId;
                    document.getElementById('caisseNameInput').value = caisseName;

                    // MISE À JOUR DE L'AFFICHAGE
                    document.getElementById('caisseOffcanvasLabel').textContent =
                        `Détails de : ${caisseName}`;

                    // Mise à jour des stats Agents et Services
                    document.getElementById('statTotalAgents').textContent = statTotalAgents;
                    document.getElementById('statTotalAgentsTrend').textContent =
                        statTotalAgentsTrend;
                    document.getElementById('statTotalServices').textContent = statTotalServices;
                    document.getElementById('statTotalServicesTrend').textContent =
                        statTotalServicesTrend;

                    // Mise à jour des stats Tickets
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

                    bsOffcanvas.show();
                });
            });

            // Gérer la soumission du formulaire de modification de la caisse
            const editForm = document.getElementById('caisseEditForm');
            editForm.addEventListener('submit', function(event) {
                event.preventDefault();
                const formData = new FormData(editForm);

                console.log('Formulaire soumis pour la caisse ID:', formData.get('caisse_id'));
                console.log('Nouveau nom:', formData.get('caisse_name'));

                alert(
                    `Modifications pour la caisse ${formData.get('caisse_name')} enregistrées (simulation) !`);
                bsOffcanvas.hide();
            });
        });
    </script>
@endsection
