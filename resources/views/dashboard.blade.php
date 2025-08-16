@extends('layouts.app')

@section('title', 'Mon Tableau de bord')

@section('content')
<div class="page-wrapper">
    <div class="page-content">

        <!-- LIGNE DES INDICATEURS CLÉS (KPIs) -->
        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
            <div class="col">
                <div class="card radius-10 border-start border-0 border-4 border-success">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-secondary">Total de tickets</p>
                                <h4 class="my-1 text-success">12,546</h4>
                                <p class="mb-0 font-13">+3.2% vs semaine passée</p>
                            </div>
                            <div class="widgets-icons-2 rounded-circle bg-gradient-ohhappiness text-white ms-auto">
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
                                <h4 class="my-1 text-danger">212</h4>
                                <p class="mb-0 font-13">+1.4% vs semaine passée</p>
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
                                <h4 class="my-1 text-info">1,895</h4>
                                <p class="mb-0 font-13">+8.4% vs semaine passée</p>
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
                                <h4 class="my-1 text-warning">152</h4>
                                <p class="mb-0 font-13">-2.1% vs semaine passée</p>
                            </div>
                            <div class="widgets-icons-2 rounded-circle bg-gradient-orange text-white ms-auto">
                                <i class='bx bxs-dislike'></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           
        </div><!--end row-->

        <div class="row">
            <!-- GRAPHIQUE PRINCIPAL -->
            <div class="col-12 col-lg-8 d-flex">
                <div class="card radius-10 w-100">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div>
                                <h6 class="mb-0">Vue d'Ensemble des Performances</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center ms-auto font-13 gap-2 mb-3">
                            <span class="border px-1 rounded cursor-pointer"><i class="bx bxs-circle me-1" style="color: #f8af07"></i>Réponses défavorables</span>
                            <span class="border px-1 rounded cursor-pointer"><i class="bx bxs-circle me-1" style="color: #14abef"></i>Réponses favorables</span>
                        </div>
                        <div class="chart-container-1">
                            <canvas id="chart1"></canvas>
                        </div>
                    </div>
                    <div class="row row-cols-1 row-cols-md-3 row-cols-xl-3 g-0 row-group text-center border-top">
                        <div class="col">
                            <div class="p-3">
                                <h5 class="mb-0">€6.72</h5>
                                <small class="mb-0">Panier Moyen <span> <i class="bx bx-up-arrow-alt align-middle"></i> 1.2%</span></small>
                            </div>
                        </div>
                        <div class="col">
                            <div class="p-3">
                                <h5 class="mb-0">14.5</h5>
                                <small class="mb-0">Transactions / Agent <span> <i class="bx bx-up-arrow-alt align-middle"></i> 2.1%</span></small>
                            </div>
                        </div>
                        <div class="col">
                            <div class="p-3">
                                <h5 class="mb-0">210</h5>
                                <small class="mb-0">Clients / Branche <span> <i class="bx bx-down-arrow-alt align-middle"></i> 0.5%</span></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- GRAPHIQUE SECONDAIRE - SERVICES -->
            <div class="col-12 col-lg-4 d-flex">
                <div class="card radius-10 w-100">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <div>
                                <h6 class="mb-0">Répartition des tickets par services</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart-container-2">
                            <canvas id="chart2"></canvas>
                        </div>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center border-top">
                            Création Caisses <span class="badge bg-success rounded-pill">450</span>
                        </li>
                        <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
                            Gestion de Compte <span class="badge bg-primary rounded-pill">210</span>
                        </li>
                        <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
                            Conseil Financier <span class="badge bg-danger rounded-pill">102</span>
                        </li>
                        <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
                            Autres Services <span class="badge bg-warning text-dark rounded-pill">85</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div><!--end row-->
        
        <!-- NOUVEAU : TABLEAUX DE PERFORMANCE -->
        <div class="row">
            <div class="col-12 col-lg-7 d-flex">
                 <div class="card radius-10 w-100">
                    <div class="card-header">
                        <h5 class="mb-0">Performance des Branches</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Branche</th>
                                        <th>Chiffre d'Affaires</th>
                                        <th>Transactions</th>
                                        <th>Nouveaux Clients</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Paris Centre</td>
                                        <td>€25,450</td>
                                        <td>3,210</td>
                                        <td>58</td>
                                    </tr>
                                    <tr>
                                        <td>Lyon Part-Dieu</td>
                                        <td>€18,800</td>
                                        <td>2,500</td>
                                        <td>45</td>
                                    </tr>
                                     <tr>
                                        <td>Marseille Vieux-Port</td>
                                        <td>€15,200</td>
                                        <td>1,980</td>
                                        <td>32</td>
                                    </tr>
                                    <tr>
                                        <td>Lille Grand-Place</td>
                                        <td>€12,500</td>
                                        <td>1,850</td>
                                        <td>30</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                 </div>
            </div>
            <div class="col-12 col-lg-5 d-flex">
                 <div class="card radius-10 w-100">
                    <div class="card-header">
                        <h5 class="mb-0">Top 5 Agents</h5>
                    </div>
                    <div class="card-body">
                         <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Agent</th>
                                        <th>Branche</th>
                                        <th>Transactions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Marie Dubois</td>
                                        <td>Paris Centre</td>
                                        <td>450</td>
                                    </tr>
                                    <tr>
                                        <td>Paul Martin</td>
                                        <td>Lyon Part-Dieu</td>
                                        <td>410</td>
                                    </tr>
                                     <tr>
                                        <td>Sophie Leroy</td>
                                        <td>Paris Centre</td>
                                        <td>380</td>
                                    </tr>
                                    <tr>
                                        <td>Julien Petit</td>
                                        <td>Marseille Vieux-Port</td>
                                        <td>350</td>
                                    </tr>
                                     <tr>
                                        <td>Lucas Bernard</td>
                                        <td>Lyon Part-Dieu</td>
                                        <td>320</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                 </div>
            </div>
        </div><!--end row-->


    </div>
</div>
@endsection
