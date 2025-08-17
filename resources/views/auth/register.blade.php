<!doctype html>
<html lang="fr">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="GFA-GA - Gestion des  - ">
    <meta name="keywords" content="GFA-GA, Gestion des , , Espace Proprietaire">
    <meta name="author" content="GFA-GA Team">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--favicon-->
    <link rel="icon" href="{{ asset('assets/images/favicon-32x32.png') }}" type="image/png" />
    <!--plugins-->
    <link href="{{ asset('assets/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/bs-stepper/css/bs-stepper.css') }}" rel="stylesheet" />
    <!-- loader-->
    <link href="{{ asset('assets/css/pace.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('assets/js/pace.min.js') }}"></script>
    <!-- Bootstrap CSS -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/bootstrap-extended.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet">
    <!-- Theme Style CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/dark-theme.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/semi-dark.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/header-colors.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>GFA-GA</title>
</head>
<style>
    /*
 * Style du Composant d'Upload d'Image
 * Utilise les variables de la palette de couleurs recommandée
 */
    :root {
        --color-primary: #2B6CB0;
        /* Bleu Confiance */
        --color-text: #2D3748;
        /* Gris Profond */
        --color-background: #F7FAFC;
        /* Gris Clair */
        --color-border: #E2E8F0;
        /* Gris Bordure */
        --color-danger: #C53030;
        /* Rouge Erreur */
    }

    .image-uploader {
        position: relative;
        border: 2px dashed var(--color-border);
        border-radius: 8px;
        background-color: var(--color-background);
        transition: all 0.3s ease;
        overflow: hidden;
        /* Important pour les coins arrondis */
    }

    .image-uploader:hover {
        border-color: var(--color-primary);
        background-color: #fff;
    }

    /* On cache l'input par défaut */
    .image-uploader input[type="file"] {
        display: none;
    }

    /* Style de la zone de clic */
    .image-uploader .uploader-content {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 2rem;
        cursor: pointer;
        color: var(--color-text);
        text-align: center;
    }

    .image-uploader .uploader-content svg {
        width: 40px;
        height: 40px;
        stroke: var(--color-primary);
        margin-bottom: 0.75rem;
    }

    .image-uploader .uploader-content span {
        font-size: 1rem;
    }

    .image-uploader .uploader-content strong {
        color: var(--color-primary);
        font-weight: 600;
    }

    .image-uploader .uploader-content .uploader-constraints {
        font-size: 0.8rem;
        color: #718096;
        /* Gris moyen */
        margin-top: 0.25rem;
    }

    /* Style de la zone de prévisualisation */
    .image-uploader .image-preview-container {
        position: relative;
        /* Contexte pour le bouton de suppression */
        display: none;
        /* Caché par défaut */
        width: 100%;
        height: 80px;
        padding: 0.5rem;
        /* Petite marge intérieure */
    }

    .image-uploader .image-preview {
        width: 100%;
        height: 80px;
        max-height: 80px;
        /* Limite la hauteur de l'aperçu */
        object-fit: contain;
        /* Assure que le logo est visible entièrement */
        border-radius: 4px;
    }

    /* Style du bouton de suppression */
    .image-uploader .delete-image-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        width: 28px;
        height: 28px;
        background-color: rgba(0, 0, 0, 0.6);
        color: white;
        border: none;
        border-radius: 50%;
        font-size: 18px;
        font-weight: bold;
        line-height: 28px;
        /* Centre la croix verticalement */
        text-align: center;
        cursor: pointer;
        transition: all 0.2s ease;
        padding: 0;
    }

    .image-uploader .delete-image-btn:hover {
        background-color: var(--color-danger);
        transform: scale(1.1);
    }
</style>

<body class="">
    <!--wrapper-->
    <div class="wrapper">
        <div class="section-authentication-cover">
            <div class="">
                <div class="row g-0">

                    <div
                        class="col-12 col-xl-7 col-xxl-7 auth-cover-left align-items-center justify-content-center d-none d-xl-flex">
                        <div class="card shadow-none bg-transparent shadow-none rounded-0 mb-0">
                            <div class="card-body">
                                <img src="{{ asset('assets/images/login-images/register-cover.svg') }}"
                                    class="img-fluid auth-img-cover-login" width="650" alt="" />
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-xl-5 col-xxl-5 auth-cover-right align-items-center justify-content-center">
                        <div class="card rounded-0 m-3 shadow-none bg-transparent mb-0">
                            <div class="card-body">
                                <div class="">
                                    <div class="mb-2 text-center">
                                        <img src="{{ asset('assets/images/logo-icon.png') }}" width="60"
                                            alt="">
                                    </div>
                                    <div class="text-center mb-2">
                                        <h5 class="">Création du compte proprietaire</h5>
                                    </div>
                                    <div class="form-body">
                                        @if ($errors->any())
                                            <div class="alert alert-light-border-danger d-flex align-items-center justify-content-between"
                                                role="alert">
                                                <p class="mb-0 text-danger">
                                                    <i class="ti ti-alert-circle f-s-18 me-2"></i>
                                                    {{ $errors->first() }}
                                                </p>
                                                <i class="ti ti-x" data-bs-dismiss="alert"></i>
                                            </div>
                                        @endif
                                        @if (session('success'))
                                            <div
                                                class="alert alert-light-border-success d-flex align-items-center justify-content-between">
                                                <p class="mb-0 text-success">
                                                    <i class="ti ti-circle-check f-s-18 me-2"></i>
                                                    {{ session('success') }}
                                                </p>
                                                <i class="ti ti-x" data-bs-dismiss="alert"></i>
                                            </div>
                                        @endif
                                        <div id="stepper1" class="bs-stepper">
                                            <div class="card-header">
                                                <div class="d-lg-flex flex-lg-row align-items-lg-center justify-content-lg-between"
                                                    role="tablist">
                                                    <div class="step" data-target="#test-l-1">
                                                        <div class="step-trigger" role="tab" id="stepper1trigger1"
                                                            aria-controls="test-l-1">
                                                            <div class="bs-stepper-circle">1</div>
                                                            <div class="">
                                                                <h5 class="mb-0 steper-title">Structure</h5>
                                                                <p class="mb-0 steper-sub-title">Détails de la structure
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="bs-stepper-line"></div>
                                                    <div class="step" data-target="#test-l-2">
                                                        <div class="step-trigger" role="tab" id="stepper1trigger2"
                                                            aria-controls="test-l-2">
                                                            <div class="bs-stepper-circle">2</div>
                                                            <div class="">
                                                                <h5 class="mb-0 steper-title">Propriétaire</h5>
                                                                <p class="mb-0 steper-sub-title">Détails du compte</p>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body">

                                                <div class="bs-stepper-content">
                                                    <!-- La route 'register.store' sera créée à l'étape 4 -->
                                                    <form method="POST" action="{{ route('register') }}"
                                                        enctype="multipart/form-data"
                                                        class="row g-3 app-form needs-validation">
                                                        @csrf

                                                        <!-- =============================================================== -->
                                                        <!--                       ÉTAPE 1 : STRUCTURE                       -->
                                                        <!-- =============================================================== -->
                                                        <div id="test-l-1" role="tabpanel"
                                                            class="bs-stepper-pane active"
                                                            aria-labelledby="stepper1trigger1">
                                                            <h5 class="mb-1">Informations de la structure</h5>
                                                            <p class="mb-4">Veuillez renseigner les informations de
                                                                votre structure</p>

                                                            <div class="row g-3">
                                                                <!-- Nom de la structure -->
                                                                <div class="col-12 col-lg-6">
                                                                    <label for="StructureName" class="form-label">Nom
                                                                        de la structure <span
                                                                            class="text-danger">*</span></label>
                                                                    <input type="text"
                                                                        class="form-control shadow-sm @error('nom') is-invalid @enderror"
                                                                        id="StructureName" name="nom"
                                                                        placeholder="Nom de la structure"
                                                                        value="{{ old('nom') }}" required>
                                                                    @error('nom')
                                                                        <div class="invalid-feedback">{{ $message }}
                                                                        </div>
                                                                    @enderror
                                                                </div>

                                                                <!-- Type de structure -->
                                                                <div class="col-12 col-lg-6">
                                                                    <label for="StructureType" class="form-label">Type
                                                                        de structure <span
                                                                            class="text-danger">*</span></label>
                                                                    <select
                                                                        class="form-select shadow-sm @error('type') is-invalid @enderror"
                                                                        id="StructureType" name="type" required>
                                                                        <option value="" selected>---</option>
                                                                        <option value="Entreprise"
                                                                            @if (old('type') == 'Entreprise') selected @endif>
                                                                            Entreprise</option>
                                                                        <option value="Association"
                                                                            @if (old('type') == 'Association') selected @endif>
                                                                            Association</option>
                                                                        <option value="Organisation"
                                                                            @if (old('type') == 'Organisation') selected @endif>
                                                                            Organisation</option>
                                                                    </select>
                                                                    @error('type')
                                                                        <div class="invalid-feedback">{{ $message }}
                                                                        </div>
                                                                    @enderror
                                                                </div>

                                                                <!-- Adresse -->
                                                                <div class="col-12 col-lg-6">
                                                                    <label for="StructureAddress"
                                                                        class="form-label">Adresse <span
                                                                            class="text-danger">*</span></label>
                                                                    <input type="text"
                                                                        class="form-control shadow-sm @error('adresse') is-invalid @enderror"
                                                                        id="StructureAddress" name="adresse"
                                                                        placeholder="Adresse"
                                                                        value="{{ old('adresse') }}" required>
                                                                    @error('adresse')
                                                                        <div class="invalid-feedback">{{ $message }}
                                                                        </div>
                                                                    @enderror
                                                                </div>

                                                                <!-- Ville -->
                                                                <div class="col-12 col-lg-6">
                                                                    <label for="StructureCity"
                                                                        class="form-label">Ville <span
                                                                            class="text-danger">*</span></label>
                                                                    <input type="text"
                                                                        class="form-control shadow-sm @error('ville') is-invalid @enderror"
                                                                        id="StructureCity" name="ville"
                                                                        placeholder="Ville"
                                                                        value="{{ old('ville') }}" required>
                                                                    @error('ville')
                                                                        <div class="invalid-feedback">{{ $message }}
                                                                        </div>
                                                                    @enderror
                                                                </div>

                                                                <!-- Pays -->
                                                                <div class="col-12 col-lg-6">
                                                                    <label for="StructureCountry"
                                                                        class="form-label">Pays <span
                                                                            class="text-danger">*</span></label>
                                                                    <select
                                                                        class="form-select shadow-sm @error('pays') is-invalid @enderror"
                                                                        id="StructureCountry" name="pays" required>
                                                                        <option value="" selected>---</option>
                                                                        <option value="France"
                                                                            @if (old('pays') == 'France') selected @endif>
                                                                            France</option>
                                                                        <option value="Belgique"
                                                                            @if (old('pays') == 'Belgique') selected @endif>
                                                                            Belgique</option>
                                                                        <option value="Suisse"
                                                                            @if (old('pays') == 'Suisse') selected @endif>
                                                                            Suisse</option>
                                                                    </select>
                                                                    @error('pays')
                                                                        <div class="invalid-feedback">{{ $message }}
                                                                        </div>
                                                                    @enderror
                                                                </div>

                                                                <!-- Téléphone -->
                                                                <div class="col-12 col-lg-6">
                                                                    <label for="StructurePhone"
                                                                        class="form-label">Numéro de téléphone <span
                                                                            class="text-danger">*</span></label>
                                                                    <input type="text"
                                                                        class="form-control shadow-sm @error('telephone') is-invalid @enderror"
                                                                        id="StructurePhone" name="telephone"
                                                                        placeholder="Numéro de téléphone"
                                                                        value="{{ old('telephone') }}" required>
                                                                    @error('telephone')
                                                                        <div class="invalid-feedback">{{ $message }}
                                                                        </div>
                                                                    @enderror
                                                                </div>

                                                                <!-- Logo -->
                                                                <div class="col-12">
                                                                    <label class="form-label">Votre logo</label>
                                                                    <div id="image-uploader" class="image-uploader">
                                                                        <input id="logo-upload" type="file"
                                                                            name="logo" accept=".png, .jpg, .jpeg"
                                                                            class="@error('logo') is-invalid @enderror">
                                                                        <!-- ... le reste de votre uploader ... -->

                                                                        <!-- 2. Le contenu de l'état initial (zone de clic) -->
                                                                        <label for="logo-upload"
                                                                            class="uploader-content">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                width="32" height="32"
                                                                                viewBox="0 0 24 24" fill="none"
                                                                                stroke="currentColor" stroke-width="2"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                                class="feather feather-upload-cloud">
                                                                                <path
                                                                                    d="M18 10h-1.26A8 8 0 1 0 9 20h9a5 5 0 0 0 0-10z">
                                                                                </path>
                                                                                <polyline points="16 16 12 12 8 16">
                                                                                </polyline>
                                                                                <line x1="12" y1="12"
                                                                                    x2="12" y2="21">
                                                                                </line>
                                                                            </svg>
                                                                            <span>Glissez-déposez ou <strong>cliquez
                                                                                    ici</strong></span>
                                                                            <span class="uploader-constraints">PNG, JPG
                                                                                ou JPEG - Max 2Mo</span>
                                                                        </label>
                                                                        <!-- 3. La zone de prévisualisation de l'image -->
                                                                        <div class="image-preview-container">
                                                                            <img id="image-preview" src="#"
                                                                                alt="Aperçu du logo"
                                                                                class="image-preview">
                                                                            <button type="button"
                                                                                id="delete-image-btn"
                                                                                class="delete-image-btn"
                                                                                aria-label="Supprimer l'image">×</button>
                                                                        </div>
                                                                        @error('logo')
                                                                            <div class="invalid-feedback d-block">
                                                                                {{ $message }}</div>
                                                                        @enderror
                                                                    </div>
                                                                </div>

                                                                <!-- Bouton Suivant -->
                                                                <div class="col-12 col-lg-6">
                                                                    <button class="btn btn-primary px-4"
                                                                        id="nextButton" disabled
                                                                        onclick="stepper1.next()">Suivant<i
                                                                            class='bx bx-right-arrow-alt ms-2'></i></button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <script>
                                                            document.addEventListener('input', function() {
                                                                const fields = [
                                                                    document.getElementById('StructureName'),
                                                                    document.getElementById('StructureType'),
                                                                    document.getElementById('StructureAddress'),
                                                                    document.getElementById('StructureCity'),
                                                                    document.getElementById('StructureCountry'),
                                                                    document.getElementById('StructurePhone')
                                                                ];

                                                                const allFilled = fields.every(field => field.value.trim() !== '');
                                                                document.getElementById('nextButton').disabled = !allFilled;
                                                            });
                                                        </script>
                                                        <!-- =============================================================== -->
                                                        <!--                        ÉTAPE 2 : UTILISATEUR                    -->
                                                        <!-- =============================================================== -->
                                                        <div id="test-l-2" role="tabpanel" class="bs-stepper-pane"
                                                            aria-labelledby="stepper1trigger2">
                                                            <h5 class="mb-1">Détails du compte Administrateur</h5>
                                                            <p class="mb-4">Entrez les détails de votre compte.</p>

                                                            <div class="row g-3">
                                                                <!-- Nom complet -->
                                                                <div class="col-12 col-lg-6">
                                                                    <label for="InputName" class="form-label">Nom
                                                                        complet <span
                                                                            class="text-danger">*</span></label>
                                                                    <input type="text"
                                                                        class="form-control shadow-sm @error('name') is-invalid @enderror"
                                                                        id="InputName" name="name"
                                                                        placeholder="Ex: Jean Dupont"
                                                                        value="{{ old('name') }}" required>
                                                                    @error('name')
                                                                        <div class="invalid-feedback">{{ $message }}
                                                                        </div>
                                                                    @enderror
                                                                </div>

                                                                <!-- Nom d'utilisateur -->
                                                                <div class="col-12 col-lg-6">
                                                                    <label for="InputUsername" class="form-label">Nom
                                                                        d'utilisateur <span
                                                                            class="text-danger">*</span></label>
                                                                    <input type="text"
                                                                        class="form-control shadow-sm @error('username') is-invalid @enderror"
                                                                        id="InputUsername" name="username"
                                                                        placeholder="Nom d'utilisateur"
                                                                        value="{{ old('username') }}" required>
                                                                    @error('username')
                                                                        <div class="invalid-feedback">{{ $message }}
                                                                        </div>
                                                                    @enderror
                                                                </div>

                                                                <!-- Email -->
                                                                <div class="col-12 col-lg-6">
                                                                    <label for="InputEmail" class="form-label">Adresse
                                                                        e-mail <span
                                                                            class="text-danger">*</span></label>
                                                                    <input type="email"
                                                                        class="form-control shadow-sm @error('email') is-invalid @enderror"
                                                                        id="InputEmail" name="email"
                                                                        placeholder="exemple@xyz.com"
                                                                        value="{{ old('email') }}" required>
                                                                    @error('email')
                                                                        <div class="invalid-feedback">{{ $message }}
                                                                        </div>
                                                                    @enderror
                                                                </div>

                                                                <!-- Téléphone utilisateur -->
                                                                <div class="col-12 col-lg-6">
                                                                    <label for="InputPhoneNumber"
                                                                        class="form-label">Votre contact <span
                                                                            class="text-danger">*</span></label>
                                                                    <input type="text"
                                                                        class="form-control shadow-sm @error('phone_number') is-invalid @enderror"
                                                                        id="InputPhoneNumber" name="phone_number"
                                                                        placeholder="Votre contact"
                                                                        value="{{ old('phone_number') }}" required>
                                                                    @error('phone_number')
                                                                        <div class="invalid-feedback">{{ $message }}
                                                                        </div>
                                                                    @enderror
                                                                </div>

                                                                <!-- Mot de passe -->
                                                                <!-- Votre mot de passe -->
                                                                <div class="col-12 col-lg-6">
                                                                    <label for="InputPassword"
                                                                        class="form-label">Votre mot de passe <span
                                                                            class="text-danger">*</span></label>
                                                                    <div class="input-group">
                                                                        <input type="password"
                                                                            class="form-control shadow-sm @error('password') is-invalid @enderror"
                                                                            id="InputPassword" name="password"
                                                                            placeholder="Votre mot de passe" required>
                                                                        <button class="btn btn-outline-secondary"
                                                                            type="button" id="togglePassword">
                                                                            <i class="bi bi-eye-slash"></i>
                                                                        </button>
                                                                        @error('password')
                                                                            <div class="invalid-feedback">
                                                                                {{ $message }}</div>
                                                                        @enderror
                                                                    </div>
                                                                </div>

                                                                <!-- Confirmation Mot de passe -->
                                                                <div class="col-12 col-lg-6">
                                                                    <label for="InputConfirmPassword"
                                                                        class="form-label">Confirmer le mot de passe
                                                                        <span class="text-danger">*</span></label>
                                                                    <div class="input-group">
                                                                        <input type="password"
                                                                            class="form-control shadow-sm"
                                                                            id="InputConfirmPassword"
                                                                            name="password_confirmation"
                                                                            placeholder="Confirmer le mot de passe"
                                                                            required>
                                                                        <button class="btn btn-outline-secondary"
                                                                            type="button" id="toggleConfirmPassword">
                                                                            <i class="bi bi-eye-slash"></i>
                                                                        </button>
                                                                        <!-- Ce div sera géré par JavaScript pour la validation en direct -->
                                                                        <div id="password-feedback"></div>
                                                                    </div>
                                                                </div>

                                                                <!-- Conditions générales -->
                                                                <div class="col-12">
                                                                    <div class="form-check form-switch">
                                                                        <input
                                                                            class="form-check-input @error('terms') is-invalid @enderror"
                                                                            type="checkbox" name="terms"
                                                                            id="flexSwitchCheckChecked" required>
                                                                        <label class="form-check-label"
                                                                            for="flexSwitchCheckChecked">J'ai lu et
                                                                            j'accepte les <a href="#">conditions
                                                                                générales</a></label>
                                                                        @error('terms')
                                                                            <div class="invalid-feedback">
                                                                                {{ $message }}</div>
                                                                        @enderror
                                                                    </div>
                                                                </div>

                                                                <!-- Boutons de navigation/soumission -->
                                                                <div class="col-12">
                                                                    <div
                                                                        class="d-flex align-items-center justify-content-between">
                                                                        <button type="button"
                                                                            class="btn btn-outline-secondary px-4"
                                                                            onclick="stepper1.previous()"><i
                                                                                class='bx bx-left-arrow-alt me-2'></i>Précédent</button>
                                                                        <!-- Le bouton de soumission final -->
                                                                        <button type="submit"
                                                                            class="btn btn-primary px-4 shadow-sm"
                                                                            data-loader-target="btnLoading"><i
                                                                                class='bx bx-check-circle ms-2'></i>
                                                                            Valider l'inscription</button>
                                                                        <button type="button" id="btnLoading"
                                                                            class="btn btn-dark fw-bold"
                                                                            style="display: none;" disabled>
                                                                            <span
                                                                                class="spinner-border spinner-border-sm me-2"
                                                                                role="status"
                                                                                aria-hidden="true"></span>
                                                                            Inscription en cours...
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="text-center ">
                                            <p class="mb-0">Vous avez déjà un compte ? <a
                                                    href="{{ route('login') }}"> Connectez-vous ici </a>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!--end row-->
        </div>
    </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- GESTION DE LA VISIBILITÉ DU MOT DE PASSE ---

            const passwordInput = document.getElementById('InputPassword');
            const togglePasswordBtn = document.getElementById('togglePassword');

            const confirmPasswordInput = document.getElementById('InputConfirmPassword');
            const toggleConfirmPasswordBtn = document.getElementById('toggleConfirmPassword');

            function toggleVisibility(input, button) {
                const icon = button.querySelector('i');
                // Basculer le type de l'input
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('bi-eye-slash');
                    icon.classList.add('bi-eye');
                } else {
                    input.type = 'password';
                    icon.classList.remove('bi-eye');
                    icon.classList.add('bi-eye-slash');
                }
            }

            if (togglePasswordBtn) {
                togglePasswordBtn.addEventListener('click', () => toggleVisibility(passwordInput,
                    togglePasswordBtn));
            }
            if (toggleConfirmPasswordBtn) {
                toggleConfirmPasswordBtn.addEventListener('click', () => toggleVisibility(confirmPasswordInput,
                    toggleConfirmPasswordBtn));
            }


            // --- GESTION DE LA CORRESPONDANCE DES MOTS DE PASSE ---

            const feedbackDiv = document.getElementById('password-feedback');

            function checkPasswordMatch() {
                const password = passwordInput.value;
                const confirmPassword = confirmPasswordInput.value;

                // Si le champ de confirmation est vide, on ne montre rien
                if (confirmPassword === '') {
                    confirmPasswordInput.classList.remove('is-valid', 'is-invalid');
                    feedbackDiv.innerHTML = '';
                    return;
                }

                // Si les mots de passe correspondent
                if (password === confirmPassword) {
                    confirmPasswordInput.classList.remove('is-invalid');
                    confirmPasswordInput.classList.add('is-valid');
                    // Utilise les classes de feedback de Bootstrap pour le style
                    feedbackDiv.className = 'valid-feedback d-block';
                    feedbackDiv.textContent = 'Les mots de passe correspondent.';
                } else {
                    // S'ils ne correspondent pas
                    confirmPasswordInput.classList.remove('is-valid');
                    confirmPasswordInput.classList.add('is-invalid');
                    feedbackDiv.className = 'invalid-feedback d-block';
                    feedbackDiv.textContent = 'Les mots de passe ne correspondent pas.';
                }
            }

            // On vérifie à chaque fois que l'utilisateur tape dans l'un des deux champs
            if (passwordInput && confirmPasswordInput) {
                passwordInput.addEventListener('input', checkPasswordMatch);
                confirmPasswordInput.addEventListener('input', checkPasswordMatch);
            }
        });
    </script>
    <!--end wrapper-->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Sélection des éléments du DOM
            const uploader = document.getElementById('image-uploader');
            const fileInput = document.getElementById('logo-upload');
            const previewContainer = document.querySelector('.image-preview-container');
            const previewImage = document.getElementById('image-preview');
            const uploaderContent = document.querySelector('.uploader-content');
            const deleteBtn = document.getElementById('delete-image-btn');

            // Fonction pour afficher l'aperçu de l'image
            const showPreview = (file) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    uploaderContent.style.display = 'none'; // Cache la zone d'upload
                    previewContainer.style.display = 'block'; // Affiche l'aperçu
                };
                reader.readAsDataURL(file);
            };

            // Fonction pour réinitialiser l'uploader
            const resetUploader = () => {
                fileInput.value = ''; // Important pour pouvoir re-sélectionner le même fichier
                previewImage.src = '#';
                uploaderContent.style.display = 'flex'; // Réaffiche la zone d'upload
                previewContainer.style.display = 'none'; // Cache l'aperçu
            };

            // Événement lorsqu'un fichier est sélectionné
            fileInput.addEventListener('change', (event) => {
                const file = event.target.files[0];
                if (file) {
                    showPreview(file);
                }
            });

            // Gérer le glisser-déposer (Drag & Drop) - Bonus !
            uploader.addEventListener('dragover', (e) => {
                e.preventDefault();
                uploader.style.borderColor = 'var(--color-primary)';
            });

            uploader.addEventListener('dragleave', (e) => {
                e.preventDefault();
                uploader.style.borderColor = 'var(--color-border)';
            });

            uploader.addEventListener('drop', (e) => {
                e.preventDefault();
                uploader.style.borderColor = 'var(--color-border)';
                const file = e.dataTransfer.files[0];
                if (file) {
                    fileInput.files = e.dataTransfer.files; // Assigne le fichier à l'input
                    showPreview(file);
                }
            });

            // Événement pour le bouton de suppression
            deleteBtn.addEventListener('click', () => {
                resetUploader();
            });
        });
    </script>
    <!-- Bootstrap JS -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/plugins/bs-stepper/js/bs-stepper.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bs-stepper/js/main.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <!--Password show & hide js -->
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
    <!--app JS-->
    <script src="{{ asset('assets/js/app.js') }}"></script>
</body>

</html>
