<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Réinitialisation de mot de passe</title>
        <link rel="shortcut icon" href="{{ asset('img/logo.png') }}" type="image/x-icon">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}">
        <style>
            .form-control {
                padding: 12px;
            }
            .form-control:focus {
                border-color: initial;
                box-shadow: none;
                outline: none;
            }
            .divider:after,
            .divider:before {
                content: "";
                flex: 1;
                height: 1px;
                background: #eee;
            }
            .h-custom {
                height: calc(100% - 73px);
            }
            @media (max-width: 450px) {
                .h-custom {
                    height: 100%;
                }
            }
        </style>
    </head>
    <body>
        <section class="vh-100">
            <div class="container-fluid h-custom pt-4">
                <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1 mx-auto rounded-0 px-4 py-3 shadow-sm bg-light mt-5">
                    <div class="border-0 text-dark text-center py-2 mb-4 w-100 rounded-0" style="color: #344264 !important;">
                        <i class="fas fa-lock me-3"></i>
                        réinitialisation de mot de passe
                    </div>
                    <form action="{{ route('confirm.password') }}" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{ $id }}"/>
                        <input type="hidden" name="hashedChain" value="{{ $hashedChain }}"/>
                        <div class="mx-auto my-4">
                            <input type="text" name="randomType" class="form-control text-secondary ps-4 py-3 border-0 rounded-0 rounded-top-4" placeholder="Saisir la chaîne aléatoire" value="{{ old('randomType') }}" autocomplete="off"/>
                        </div>
                        <div class="divider d-flex align-items-center my-4">
                            <p class="text-center text-secondary mx-3 mb-0">Glaçons Friouato</p>
                        </div>

                        <div class="my-4">
                            <label class="text-secondary">nouveau mot de passe</label>
                            <div class="form-input position-relative">
                                <input type="password" name="password" id="password" class="form-control text-secondary mt-2 border-0 rounded-0" value="{{ old('password') }}" autocomplete="off"/>
                                <i class="fa-solid fa-eye toggle-password" id="togglePassword" style="color:#344264; position:absolute; top:50%; right:15px; transform:translateY(-50%); cursor:pointer;"></i>
                            </div>
                        </div>

                        <div class="my-4">
                            <label class="text-secondary">confirmer le mot de passe</label>
                            <div class="form-input position-relative">
                                <input type="password" name="confirm_password" id="confirm_password" class="form-control text-secondary mt-2 border-0 rounded-0" value="{{ old('confirm_password') }}" autocomplete="off"/>
                                <i class="fa-solid fa-eye toggle-password" id="toggleConfirmPassword" style="color:#344264; position:absolute; top:50%; right:15px; transform:translateY(-50%); cursor:pointer;"></i>
                            </div>
                        </div>

                        <div class="text-center d-flex justify-content-end mt-4 py-3">
                            <button type="submit" class="btn text-white px-5 rounded-5" style="background-color: #344264;">Confirmer</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <script>
            document.getElementById('togglePassword').addEventListener('click', function () {
                const passwordInput = document.getElementById('password');
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });

            document.getElementById('toggleConfirmPassword').addEventListener('click', function () {
                const confirmInput = document.getElementById('confirm_password');
                const type = confirmInput.getAttribute('type') === 'password' ? 'text' : 'password';
                confirmInput.setAttribute('type', type);
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });
        </script>

        <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    </body>
</html>
