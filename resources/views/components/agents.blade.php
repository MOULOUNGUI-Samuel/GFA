@extends('layouts.app')

@section('title', 'Branches')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Agents</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Liste des agents</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <button type="button"
                        class="btn btn-light bg-light radius-30 shadow d-flex align-items-center justify-content-center"
                        data-bs-toggle="offcanvas" data-bs-target="#createAgentOffcanvas">
                        <i class='lni lni-circle-plus mr-1'></i>
                        <span>Nouveau agent</span>
                    </button>
                </div>
            </div>

            {{-- ========================================================================= --}}
            {{--   BLOC 1 : MESSAGES ET EN-TÊTE DE PAGE                                  --}}
            {{-- ========================================================================= --}}

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
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Erreur de validation !</strong> Veuillez corriger les champs dans le formulaire.
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example2" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Nom Complet</th>
                                    <th>Nom d'utilisateur</th>
                                    <th>Email</th>
                                    <th>Téléphone</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($agents as $agent)
                                    <tr>
                                        <td>{{ $agent->name }}</td>
                                        <td>{{ $agent->username }}</td>
                                        <td>{{ $agent->email }}</td>
                                        <td>{{ $agent->phone_number }}</td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-info">Modifier</a>
                                            {{-- Le formulaire de suppression irait ici --}}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Aucun agent n'a été créé pour le moment.</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {{-- OFFCANVAS CRÉATION --}}
            <div class="offcanvas offcanvas-end" tabindex="-1" id="createAgentOffcanvas"
                aria-labelledby="createAgentOffcanvasLabel" data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="createAgentOffcanvasLabel">Nouvel agent</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>

                <div class="offcanvas-body">
                    <form id="newAgentForm" method="POST" action="{{ route('agents.store') }}">
                        @csrf
                        <div class="row g-3">
                            <!-- Nom complet -->
                            <div class="col-12 ">
                                <label for="InputName" class="form-label">Nom
                                    complet <span class="text-danger">*</span></label>
                                <input type="text" class="form-control shadow-sm @error('name') is-invalid @enderror"
                                    id="InputName" name="name" placeholder="Ex: Jean Dupont" value="{{ old('name') }}"
                                    required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <!-- Nom complet -->
                            <div class="col-12 ">
                                <label for="InputUsername" class="form-label">Nom
                                    d'utilisateur <span class="text-danger">*</span></label>
                                <input type="text" class="form-control shadow-sm @error('username') is-invalid @enderror"
                                    id="InputUsername" name="username" placeholder="Nom d'utilisateur"
                                    value="{{ old('username') }}" required>
                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="col-12 ">
                                <label for="InputEmail" class="form-label">Adresse
                                    e-mail <span class="text-danger">*</span></label>
                                <input type="email" class="form-control shadow-sm @error('email') is-invalid @enderror"
                                    id="InputEmail" name="email" placeholder="exemple@xyz.com" value="{{ old('email') }}"
                                    required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Téléphone utilisateur -->
                            <div class="col-12 ">
                                <label for="InputPhoneNumber" class="form-label">Votre contact <span
                                        class="text-danger">*</span></label>
                                <input type="text"
                                    class="form-control shadow-sm @error('phone_number') is-invalid @enderror"
                                    id="InputPhoneNumber" name="phone_number" placeholder="Votre contact"
                                    value="{{ old('phone_number') }}" required>
                                @error('phone_number')
                                    <div class="invalid-feedback">{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Mot de passe -->
                            <!-- Votre mot de passe -->
                            <div class="col-12">
                                <label for="InputPassword" class="form-label">Votre mot de passe <span class="text-danger">*</span></label>
                                <div class="input-group" id="show_hide_password">
                                    <input type="password"
                                        class="form-control shadow-sm @error('password') is-invalid @enderror"
                                        id="inputChoosePassword" placeholder="Votre mot de passe"
                                        name="password" required>
                                    <a href="javascript:;"
                                        class="input-group-text bg-transparent shadow-sm"><i
                                            class="bx bx-hide"></i></a>
                                </div>
                            </div>

                        </div>

                        <div class="mt-4 pt-3 border-top d-flex justify-content-end">
                            <button type="button" class="btn btn-secondary me-2 radius-30 shadow"
                                data-bs-dismiss="offcanvas">Annuler</button>
                            <button type="submit" class="btn btn-primary radius-30 shadow"
                                data-loader-target="enregistre"><i class='bx bx-save me-1'></i>Enregistrer</button>
                            <button type="submit" class="btn btn-primary radius-30 shadow" style="display: none;"
                                disabled id="enregistre">
                                <span class="spinner-border spinner-border-sm me-2" role="status"
                                    aria-hidden="true"></span>
                                Enregistrement en cours...
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $("#show_hide_password a").on('click', function(event) {
                event.preventDefault();
                if ($('#show_hide_password input').attr("type") == "text") {
                    $('#show_hide_password input').attr('type', 'password');
                    $('#show_hide_password i').addClass("bx-hide");
                    $('#show_hide_password i').removeClass("bx-show");
                } else if ($('#show_hide_password input').attr("type") == "password") {
                    $('#show_hide_password input').attr('type', 'text');
                    $('#show_hide_password i').removeClass("bx-hide");
                    $('#show_hide_password i').addClass("bx-show");
                }
            });
        });
    </script>
@endsection
