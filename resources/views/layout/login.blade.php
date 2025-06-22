<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Connexion</title>
        <link rel="shortcut icon" href="{{ asset('img/logo.png') }}" type="image/x-icon">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}">
        <style>
            #cr1{
                position: fixed;
                top: -12%;
                right: -12%;
                width: 22%;
                height: 44%;
                transform: scale(-1, -1);
            }
            #cr2{
                position: fixed;
                bottom: -12%;
                left: -12%;
                width: 22%;
                height: 44%;
            }
            .form-control {
                border: 1px solid #f9f9f9 !important;
                padding: 10px !important;
            }
            .form-control:focus {
                border-color: initial;
                box-shadow: none;
                outline: none;
            }
        </style>
    </head>
    <body>

        @if(session('success'))
            <div class="alert alert-dismissible text-white fade show auto-dismiss" role="alert" style="position: fixed; top: 1%; left: 30%; min-width: 400px; background-color: lightblue;">
                <span style="font-weight: 500;">{{ session('success') }}</span>
            </div>
        @endif

        <img class="image1" src="{{ asset('img/crystal.png') }}" alt="" id="cr1"/>
        <img class="image2" src="{{ asset('img/crystal.png') }}" alt="" id="cr2"/>
        <div class="container">
            <div class="row justify-content-center py-4">

                <div class="col-md-5" style="max-width: 400px !important;">
                    <div class="row justify-content-center">
                        <div class="col-md-4 text-center">
                            <img class="logo" src="{{ asset('img/login-logo.png') }}" alt="" width="125%"/>
                        </div>
                    </div>
                    <div class="form-container border py-4 px-4 border-0 shadow-sm" style="background-color: #FCFCFC !important;">
                        <h3 class="mb-3 text-center" style="color: #344264; font-weight: 400 !important;">Connexion</h3>
                        <br />
                        <form action="{{ route('auth') }}" method="post">
                            @csrf
                            <div>
                                <label class="mb-1 text-secondary">adresse e-mail ou nom d'utilisateur</label>
                                <input type="text" name="login" class="form-control text-secondary border-0 rounded-0" autocomplete="off" />
                            </div>
                            @error('login')
                                <div class="text-danger mb-3">{{ $message }}</div>
                            @enderror
                            <div class="mt-4">
                                <label class="mb-1 text-secondary">mot de passe</label>
                                <div class="form-input position-relative">
                                    <input type="password" name="password" id="password" class="form-control text-secondary border-0 rounded-0" autocomplete="off" />
                                    <i class="fa-solid fa-eye toggle-password" id="togglePassword" style="color:#344264; position:absolute; top:50%; right:15px; transform:translateY(-50%); cursor:pointer;"></i>
                                </div>
                            </div>
                            <div class="mt-2 mb-4 text-end">
                                <a class="link-secondary link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover" href="{{ route('forget.password') }}">mot de passe oublié</a>
                            </div>
                            <br />
                            <button type="submit" class="btn btn-block text-white w-100 py-2 rounded-5" style="background-color: #344264;">Se connecter</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.getElementById('togglePassword').addEventListener('click', function () {
                const passwordInput = document.getElementById('password');
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);

                if (type === 'text') {
                    this.classList.remove('fa-eye');
                    this.classList.add('fa-eye-slash');
                } else {
                    this.classList.remove('fa-eye-slash');
                    this.classList.add('fa-eye');
                }
            });
        </script>

        <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

        <script>
            setTimeout(() => {
                document.querySelectorAll('.auto-dismiss').forEach(alert => {
                    alert.classList.remove('show');
                    setTimeout(() => alert.remove(), 2000);
                });
            }, 4000);
        </script>
    </body>
</html>
