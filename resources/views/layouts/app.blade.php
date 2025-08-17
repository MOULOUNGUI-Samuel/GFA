<!doctype html>
<html lang="fr">


<!-- Mirrored from codervent.com/rocker/demo/vertical/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 02 Jul 2025 22:52:56 GMT -->

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/images/favicon-32x32.png') }}" type="image/png" />
    
    <!-- Plugins CSS -->
    <link href="{{ asset('assets/plugins/vectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    
    <!-- Loader -->
    <link href="{{ asset('assets/css/pace.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('assets/js/pace.min.js') }}"></script>
    
    <!-- Bootstrap CSS -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/bootstrap-extended.css') }}" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    
    <!-- App CSS -->
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet">
    
    <!-- Theme Styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/dark-theme.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/semi-dark.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/header-colors.css') }}" />
    
	<meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        @yield('title', 'Mon Tableau de bord')
    </title>
</head>

<body>
    <!--wrapper-->
    <div class="wrapper">
        <!--sidebar wrapper -->
        <div class="sidebar-wrapper" data-simplebar="true">
            <!-- MODIFIÉ : Logo et nom de l'application -->
            <div class="sidebar-header">
                <div>
                    @if (isset(Auth::user()->structure->logo_url))
                        <img src="{{ asset('storage/' . Auth::user()->structure->logo_url) }}" class="logo-icon"
                            alt="Logo de {{ Auth::user()->structure->nom }}">
                    @else
                        <!-- Afficher une image par défaut si aucun logo n'a été uploadé -->
                        <img src="{{ asset('assets/images/logo-icon.png') }}" class="logo-icon" alt="Logo par défaut">
                    @endif
                </div>
                <div class="toggle-icon ms-auto"><i class='bx bx-arrow-back'></i>
                </div>
            </div>

            <!--navigation-->
            <ul class="metismenu" id="menu">

                <!-- Tableau de Bord (lien principal) -->
                <li>
                    <a href="{{ route('dashboard') }}">
                        <div class="parent-icon"><i class='bx bx-home-alt'></i></div>
                        <div class="menu-title">Tableau de Bord</div>
                    </a>
                </li>

                <li class="menu-label">OPÉRATIONS COURANTES</li>

                <!-- Gestion des Caisses -->
                <li class="">
                    <a href="{{ route('caisse.index') }}">
                        <div class="parent-icon"><i class='bx bx-dollar-circle'></i></div>
                        <div class="menu-title">Caisses</div>
                    </a>
                </li>

                <!-- Gestion des Clients -->
                {{-- <li>
                    <a href="#">
                        <div class="parent-icon"><i class='bx bx-user-circle'></i></div>
                        <div class="menu-title">Clients</div>
                    </a>
                </li> --}}

                <li class="menu-label">PILOTAGE & GESTION</li>

                <!-- Gestion des Branches / Agences -->
                <li class="@if (request()->routeIs('branche.index')) active @endif">
                    <a href="{{ route('branche.index') }}">
                        <div class="parent-icon"><i class="bx bx-buildings"></i></div>
                        <div class="menu-title">Branches</div>
                    </a>
                </li>

                <!-- Gestion des Agents -->
                <li>
                    <a href="{{route('agent.index')}}">
                        <div class="parent-icon"><i class="bx bx-group"></i></div>
                        <div class="menu-title">Agents</div>
                    </a>
                </li>

                <!-- Gestion des Services -->
                <li class="@if (request()->routeIs('service.index')) active @endif">
                    <a href="{{ route('service.index') }}">
                        <div class="parent-icon"><i class='bx bx-briefcase-alt-2'></i></div>
                        <div class="menu-title">Services</div>
                    </a>
                </li>

                <li class="menu-label">ANALYSE & CONFIGURATION</li>

                <!-- Rapports -->
                <li>
                    <a href="#">
                        <div class="parent-icon"><i class="bx bx-bar-chart-alt-2"></i></div>
                        <div class="menu-title">Rapports</div>
                    </a>
                </li>

                <!-- Paramètres de l'application -->
                <li>
                    <a class="has-arrow" href="javascript:;">
                        <div class="parent-icon"><i class="bx bx-cog"></i></div>
                        <div class="menu-title">Paramètres</div>
                    </a>
                    <ul>
                        <li><a href="parametres-utilisateurs.html"><i class='bx bx-user'></i>Gestion Utilisateurs</a>
                        </li>
                        <li><a href="parametres-generaux.html"><i class='bx bx-slider-alt'></i>Paramètres Généraux</a>
                        </li>
                    </ul>
                </li>

                <!-- Aide & Support -->
                <li>
                    <a href="page-aide.html">
                        <div class="parent-icon"><i class="bx bx-help-circle"></i></div>
                        <div class="menu-title">Aide & Support</div>
                    </a>
                </li>

            </ul>
            <!--end navigation-->
        </div>

        <!--end sidebar wrapper -->
        <!--start header -->
        {{-- <header>
            <div class="topbar d-flex align-items-center">
                <nav class="navbar navbar-expand gap-3">
                    <div class="mobile-toggle-menu"><i class='bx bx-menu'></i>
                    </div>

                    <!-- MODIFIÉ : Barre de recherche plus contextuelle -->
                    <div class="search-bar d-lg-block d-none" data-bs-toggle="modal" data-bs-target="#SearchModal">
                        <a href="javascript:;" class="btn d-flex align-items-center"><i
                                class='bx bx-search'></i>Rechercher un client, une caisse...</a>
                    </div>

                    <div class="top-menu ms-auto">
                        <ul class="navbar-nav align-items-center gap-1">
                            <li class="nav-item mobile-search-icon d-flex d-lg-none" data-bs-toggle="modal"
                                data-bs-target="#SearchModal">
                                <a class="nav-link" href="javascript:;"><i class='bx bx-search'></i>
                                </a>
                            </li>
                            <!-- MODIFIÉ : Sélecteur de langue simplifié et drapeau français par défaut -->
                            <li class="nav-item dropdown dropdown-laungauge d-none d-sm-flex">
                                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="javascript:;"
                                    data-bs-toggle="dropdown"><img src="assets/images/county/03.png" width="22"
                                        alt="Français">
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item d-flex align-items-center py-2"
                                            href="javascript:;"><img src="assets/images/county/03.png" width="20"
                                                alt=""><span class="ms-2">Français</span></a>
                                    </li>
                                    <li><a class="dropdown-item d-flex align-items-center py-2"
                                            href="javascript:;"><img src="assets/images/county/01.png" width="20"
                                                alt=""><span class="ms-2">English</span></a>
                                    </li>
                                    <li><a class="dropdown-item d-flex align-items-center py-2"
                                            href="javascript:;"><img src="assets/images/county/06.png" width="20"
                                                alt=""><span class="ms-2">Español</span></a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item dark-mode d-none d-sm-flex">
                                <a class="nav-link dark-mode-icon" href="javascript:;"><i class='bx bx-moon'></i>
                                </a>
                            </li>

                            <!-- MODIFIÉ : Raccourcis vers des applications métier pertinentes -->
                            <li class="nav-item dropdown dropdown-app">
                                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" data-bs-toggle="dropdown"
                                    href="javascript:;"><i class='bx bx-grid-alt'></i></a>
                                <div class="dropdown-menu dropdown-menu-end p-0">
                                    <div class="app-container p-2 my-2">
                                        <div class="row gx-0 gy-2 row-cols-3 justify-content-center p-2">
                                            <div class="col">
                                                <a href="javascript:;">
                                                    <div class="app-box text-center">
                                                        <div class="app-icon"><i class="bx bx-user-circle fs-2"></i>
                                                        </div>
                                                        <div class="app-name">
                                                            <p class="mb-0 mt-1">Clients (CRM)</p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col">
                                                <a href="javascript:;">
                                                    <div class="app-box text-center">
                                                        <div class="app-icon"><i class="bx bx-calendar fs-2"></i>
                                                        </div>
                                                        <div class="app-name">
                                                            <p class="mb-0 mt-1">Calendrier</p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col">
                                                <a href="javascript:;">
                                                    <div class="app-box text-center">
                                                        <div class="app-icon"><i class="bx bx-chat fs-2"></i></div>
                                                        <div class="app-name">
                                                            <p class="mb-0 mt-1">Messagerie</p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col">
                                                <a href="javascript:;">
                                                    <div class="app-box text-center">
                                                        <div class="app-icon"><i class="bx bx-file fs-2"></i></div>
                                                        <div class="app-name">
                                                            <p class="mb-0 mt-1">Rapports</p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col">
                                                <a href="javascript:;">
                                                    <div class="app-box text-center">
                                                        <div class="app-icon"><i class="bx bx-book-content fs-2"></i>
                                                        </div>
                                                        <div class="app-name">
                                                            <p class="mb-0 mt-1">Aide</p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col">
                                                <a href="javascript:;">
                                                    <div class="app-box text-center">
                                                        <div class="app-icon"><i class="bx bx-sitemap fs-2"></i></div>
                                                        <div class="app-name">
                                                            <p class="mb-0 mt-1">Portail RH</p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div><!--end row-->
                                    </div>
                                </div>
                            </li>

                            <!-- MODIFIÉ : Notifications métier -->
                            <li class="nav-item dropdown dropdown-large">
                                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative"
                                    href="#" data-bs-toggle="dropdown"><span class="alert-count">4</span>
                                    <i class='bx bx-bell'></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="javascript:;">
                                        <div class="msg-header">
                                            <p class="msg-header-title">Notifications</p>
                                            <p class="msg-header-badge">4 Nouvelles</p>
                                        </div>
                                    </a>
                                    <div class="header-notifications-list">
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center">
                                                <div class="notify bg-light-success text-success"><i
                                                        class='bx bx-check-double'></i></div>
                                                <div class="flex-grow-1">
                                                    <h6 class="msg-name">Dossier Validé<span
                                                            class="msg-time float-end">Il y a 5 min</span></h6>
                                                    <p class="msg-info">Le dossier de Jean Dupont a été validé.</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center">
                                                <div class="notify bg-light-primary text-primary"><i
                                                        class='bx bx-user-plus'></i></div>
                                                <div class="flex-grow-1">
                                                    <h6 class="msg-name">Nouvelle Caisse Créée<span
                                                            class="msg-time float-end">Il y a 28 min</span></h6>
                                                    <p class="msg-info">Sophie Lambert a créé une nouvelle caisse.</p>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center">
                                                <div class="notify bg-light-warning text-warning"><i
                                                        class='bx bx-error'></i></div>
                                                <div class="flex-grow-1">
                                                    <h6 class="msg-name">Alerte Transaction <span
                                                            class="msg-time float-end">Il y a 2h</span></h6>
                                                    <p class="msg-info">Transaction > 5000€ en attente d'approbation.
                                                    </p>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center">
                                                <div class="notify bg-light-info text-info"><i
                                                        class='bx bx-calendar-event'></i></div>
                                                <div class="flex-grow-1">
                                                    <h6 class="msg-name">Rappel de RDV<span
                                                            class="msg-time float-end">Demain à 9h</span></h6>
                                                    <p class="msg-info">Rendez-vous avec l'agence de Lyon.</p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <a href="javascript:;">
                                        <div class="text-center msg-footer">
                                            <button class="btn btn-primary w-100">Voir toutes les
                                                notifications</button>
                                        </div>
                                    </a>
                                </div>
                            </li>

                            <!-- SUPPRIMÉ : Le panier d'achat n'est pas pertinent pour ce type d'application -->

                        </ul>
                    </div>

                    <!-- MODIFIÉ : Profil utilisateur avec un rôle pertinent -->
                    <div class="user-box dropdown px-3">
                        <a class="d-flex align-items-center nav-link dropdown-toggle gap-3 dropdown-toggle-nocaret"
                            href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="assets/images/avatars/avatar-2.png" class="user-img" alt="user avatar">
                            <div class="user-info">
                                <p class="user-name mb-0">Alain Martin</p>
                                <p class="designattion mb-0">Directeur d'Agence</p>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                        class="bx bx-user fs-5"></i><span>Mon Profil</span></a>
                            </li>
                            <li><a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                        class="bx bx-cog fs-5"></i><span>Paramètres</span></a>
                            </li>
                            <li><a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                        class="bx bx-home-circle fs-5"></i><span>Tableau de Bord</span></a>
                            </li>
                            <li><a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                        class="bx bx-dollar-circle fs-5"></i><span>Mes Commissions</span></a>
                            </li>
                            <li>
                                <div class="dropdown-divider mb-0"></div>
                            </li>
                            <li><a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                        class="bx bx-log-out-circle"></i><span>Déconnexion</span></a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </header> --}}
        <header>
            <div class="topbar d-flex align-items-center">
                <nav class="navbar navbar-expand gap-3">
                    <div class="mobile-toggle-menu"><i class='bx bx-menu'></i>
                    </div>

                    <div class="search-bar d-lg-block d-none" data-bs-toggle="modal" data-bs-target="#SearchModal">
                        <a href="avascript:;" class="btn d-flex align-items-center"><i
                                class='bx bx-search'></i>Search</a>
                    </div>

                    <div class="top-menu ms-auto">
                        <ul class="navbar-nav align-items-center gap-1">
                            <li class="nav-item mobile-search-icon d-flex d-lg-none" data-bs-toggle="modal"
                                data-bs-target="#SearchModal">
                                <a class="nav-link" href="avascript:;"><i class='bx bx-search'></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="user-box dropdown px-3">
                        <a class="d-flex align-items-center nav-link dropdown-toggle gap-3 dropdown-toggle-nocaret"
                            href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="assets/images/avatars/avatar-2.png" class="user-img" alt="user avatar">
                            <div class="user-info">
                                <p class="user-name mb-0">Pauline Seitz</p>
                                <p class="designattion mb-0">Web Designer</p>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                        class="bx bx-user fs-5"></i><span>Profile</span></a>
                            </li>
                            <li>
                                <div class="dropdown-divider mb-0"></div>
                            </li>
                            <li>
                                <!-- 1. On crée un formulaire qui pointe vers la route de déconnexion -->
                                <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                    @csrf
                                </form>
                                
                                <!-- 2. Votre lien ne soumet plus, il déclenche le formulaire via JavaScript -->
                                <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}" 
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="bx bx-log-out-circle"></i>
                                    <span>Déconnexion</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </header>
        <!--end header -->
        <!--start page wrapper -->
        @yield('content')
        <!--end page wrapper -->
        <!--start overlay-->
        <div class="overlay toggle-icon"></div>
        <!--end overlay-->
        <!--Start Back To Top Button-->
        <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
        <!--End Back To Top Button-->
        <footer class="page-footer">
            <p class="mb-0">Copyright © 2022. All right reserved.</p>
        </footer>
    </div>
    <!--end wrapper-->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Cible tous les boutons ayant l'attribut data-loader-target
            document.querySelectorAll('[data-loader-target]').forEach(function(btn) { // Simplification du sélecteur
                btn.addEventListener('click', function(event) {
                    const targetId = btn.getAttribute('data-loader-target');
                    const loaderBtn = document.getElementById(targetId);
    
                    if (btn.type === 'submit') {
                        const form = btn.closest('form');
                        if (form && !form.checkValidity()) {
                            // Si le formulaire n'est pas valide, empêche l'action par défaut
                            event.preventDefault();
                            event.stopPropagation();
                            form.classList.add('was-validated'); // Ajoute la classe Bootstrap pour afficher les erreurs
                            return;
                        }
                    }
    
                    if (loaderBtn) {
                        btn.style.display = 'none';
                        loaderBtn.style.display = 'inline-block';
                    }
                });
            });
        });
    </script>
    <!--end switcher-->
    <!-- Bootstrap JS -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <!--plugins-->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
    <script src="{{ asset('assets/plugins/chartjs/js/chart.js') }}"></script>
    <script src="{{ asset('assets/js/index.js') }}"></script>

	<script src="{{asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
	<script src="{{asset('assets/plugins/datatable/js/dataTables.bootstrap5.min.js')}}"></script>
	<script>
		$(document).ready(function() {
			$('#example').DataTable();
		  } );
	</script>
	<script>
		$(document).ready(function() {
			var table = $('#example2').DataTable( {
				lengthChange: false,
				buttons: [ 'copy', 'excel', 'pdf', 'print']
			} );
		 
			table.buttons().container()
				.appendTo( '#example2_wrapper .col-md-6:eq(0)' );
		} );
	</script>
    <!--app JS-->
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script>
        new PerfectScrollbar(".app-container")
    </script>
</body>

<script>
    'undefined' === typeof _trfq || (window._trfq = []);
    'undefined' === typeof _trfd && (window._trfd = []), _trfd.push({
        'tccl.baseHost': 'secureserver.net'
    }, {
        'ap': 'cpsh-oh'
    }, {
        'server': 'p3plzcpnl509132'
    }, {
        'dcenter': 'p3'
    }, {
        'cp_id': '10399385'
    }, {
        'cp_cl': '8'
    }) // Monitoring performance to make your website faster. If you want to opt-out, please contact web hosting support.
</script>
<script src='../../../../img1.wsimg.com/signals/js/clients/scc-c2/scc-c2.min.js'></script>
<!-- Mirrored from codervent.com/rocker/demo/vertical/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 02 Jul 2025 22:54:02 GMT -->

</html>
