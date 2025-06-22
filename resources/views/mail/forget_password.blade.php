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
                max-width: 95%;
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
            <div class="container-fluid h-custom pt-5">
                <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1 mx-auto rounded-0 px-4 shadow-sm bg-light mt-5">
                <div class="border-0 text-dark py-5 mb-4 w-100 rounded-0 text-center" style="color: #344264 !important;">
                    <i class="fas fa-lock me-3"></i>
                    mot de passe oublier
                </div>
                    <a class="btn text-white me-2 rounded-1"  style="background-color: #344264;" href="{{ route('login') }}">
                        <i class="fa fa-unlock"></i>
                    </a>
                    <form action="{{ route('recover.password') }}" method="post">
                        @csrf

                        <div class="form-floating my-4 mx-auto">
                            <input type="text" name="email" class="form-control border-0 rounded-0 text-secondary" id="mail" placeholder="mail" value="{{ old('email') }}" autocomplete="off"/>
                            <label for="mail" class="text-secondary">E-mail</label>
                        </div>

                        <div class="divider d-flex align-items-center my-4">
                            <p class="text-center text-secondary mx-3 mb-0">Glaçons Friouato</p>
                        </div>


                        <div class="text-center d-flex justify-content-center my-4 py-4">
                            <button type="submit" class="btn text-white px-4 py-2" style="background-color: #344264;">Soumettre</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>

        <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    </body>
</html>
