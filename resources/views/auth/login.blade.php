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
    <!-- loader-->
    <link href="{{ asset('assets/css/pace.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('assets/js/pace.min.js') }}"></script>
    <!-- Bootstrap CSS -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/bootstrap-extended.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet">
    <title>GFA-GA</title>
</head>

<body class="">
    <!--wrapper-->
    <div class="wrapper">
        <div class="section-authentication-cover">
            <div class="">
                <div class="row g-0">

                    <div
                        class="col-12 col-xl-7 col-xxl-8 auth-cover-left align-items-center justify-content-center d-none d-xl-flex">
                        <div class="card shadow-none bg-transparent shadow-none rounded-0 mb-0">
                            <div class="card-body">
                                <img src="{{ asset('assets/images/login-images/login-cover.svg') }}"
                                    class="img-fluid auth-img-cover-login" width="650" alt="" />
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-xl-5 col-xxl-4 auth-cover-right align-items-center justify-content-center">
                        <div class="card rounded-0 m-3 shadow-none bg-transparent mb-0">
                            <div class="card-body p-sm-5">
                                <div class="">
                                    <div class="mb-3 text-center">
                                        <img src="{{ asset('assets/images/logo-icon.png') }}" width="60"
                                            alt="">
                                    </div>
                                    <div class="text-center mb-4">
                                        <h5 class="">Espace Proprietaire</h5>
                                        <p class="mb-0">Veuillez vous connecter à votre compte</p>
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
                                        <form method="POST" {{ route('login') }}
                                            class="row g-3 app-form needs-validation" novalidate
                                            onsubmit="return validateForm(event)">
                                            @csrf
                                            <div class="col-12">
                                                <label for="inputCode" class="form-label">Code structure</label>
                                                {{-- Le name 'codeEntreprise' est bon --}}
                                                <input type="text" class="form-control shadow-sm @error('codeEntreprise') is-invalid @enderror" id="inputCode"
                                                    placeholder="Entrez votre code structure" name="codeEntreprise" value="{{ old('codeEntreprise') }}" required>
                                                @error('codeEntreprise')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-12">
                                                <label for="inputidentifiant" class="form-label">Identifiant</label>
                                                {{-- Renommé 'identifiant' pour la clarté --}}
                                                <input type="text"
                                                    class="form-control shadow-sm @error('identifiant') is-invalid @enderror"
                                                    id="inputidentifiant" placeholder="Nom d'utilisateur ou e-mail"
                                                    name="identifiant" value="{{ old('identifiant') }}" required>
                                                
                                            </div>
                                            <div class="col-12">
                                                <label for="inputChoosePassword" class="form-label">Mot de passe</label>
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
                                            <div class="col-md-6">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="remember"
                                                        id="flexSwitchCheckChecked">
                                                    <label class="form-check-label" for="flexSwitchCheckChecked">Se
                                                        souvenir de moi</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 text-end"> <a
                                                    href="authentication-forgot-password.html">Mot de passe oublié
                                                    ?</a>
                                            </div>
                                            <div class="col-12">
                                                <div class="d-grid">
                                                    <button type="submit" class="btn btn-primary shadow-sm"
                                                        id="submitBtn" onclick="handleSubmit(event)">Se
                                                        connecter</button>
                                                    <button type="button" id="btnLoading"
                                                        class="btn btn-dark w-100 fw-bold d-none" disabled>
                                                        <span class="spinner-border spinner-border-sm me-2"
                                                            role="status" aria-hidden="true"></span>
                                                        Connexion en cours...
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="text-center ">
                                                    <p class="mb-0">Vous n'avez pas encore de compte ? <a
                                                            href="{{ route('register') }}">Inscrivez-vous ici.</a>
                                                    </p>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    {{-- <div class="login-separater text-center mb-5"> <span>OR SIGN IN WITH</span>
                                        <hr>
                                    </div>
                                    <div class="list-inline contacts-social text-center">
                                        <a href="javascript:;" class="list-inline-item bg-facebook text-white border-0 rounded-3"><i class="bx bxl-facebook"></i></a>
                                        <a href="javascript:;" class="list-inline-item bg-twitter text-white border-0 rounded-3"><i class="bx bxl-twitter"></i></a>
                                        <a href="javascript:;" class="list-inline-item bg-google text-white border-0 rounded-3"><i class="bx bxl-google"></i></a>
                                        <a href="javascript:;" class="list-inline-item bg-linkedin text-white border-0 rounded-3"><i class="bx bxl-linkedin"></i></a>
                                    </div> --}}

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!--end row-->
            </div>
        </div>
    </div>
    <!--end wrapper-->
    <!-- Bootstrap JS -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <!--plugins-->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
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
        function handleSubmit(event) {
            event.preventDefault();

            const form = event.target.closest('form');
            if (!form.checkValidity()) {
                form.classList.add('was-validated');
                return false;
            }

            const btnSubmit = document.getElementById('submitBtn');
            const btnLoading = document.getElementById('btnLoading');

            // Masquer le bouton principal, afficher le bouton loading
            btnSubmit.classList.add('d-none');
            btnLoading.classList.remove('d-none');

            // Soumettre après une courte pause
            setTimeout(() => {
                form.submit();
            }, 500);

            return true;
        }
    </script>
    <!--app JS-->
    <script src="{{ asset('assets/js/app.js') }}"></script>
</body>

</html>
