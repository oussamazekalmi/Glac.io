@extends('layout.master')

<style>
    .form-control {
        padding: 14px !important;
    }
    .times {
        background-color: #FCFCFC;
        padding: 14px 16px;
        border-radius: 25px;
        color: #6c757d !important;
        font-weight: 500 !important;
    }
    #old_password {
        width: 88%;
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

@section('content')
    <main class="container-fluid h-custom pt-4">
        <div class="position-relative col-md-8 col-lg-8 col-xl-5 offset-xl-1 mx-auto rounded-4 px-4 pb-2 pt-5 shadow-sm" style="background-color: #FAFAFA !important;">

            <a href="{{ url()->previous() }}" class="plus-times"><i class="fas fa-times"></i></a>

            <form action="{{ route('users.reset-password', $user->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="my-4 mx-auto">
                    <input type="password" name="old_password" class="form-control text-secondary ps-4 border-0 rounded-3" id="old_password" placeholder="mot de passe actuel"  value="{{ old('old_password') }}"/>
                </div>
                <div class="divider d-flex align-items-center my-5">
                    <p class="text-center text-secondary mx-3 mb-0" style="letter-spacing: 1px;">réinitialisation de mot de passe</p>
                </div>

                <div class="my-4">
                    <label class="text-secondary">Nouveau mot de passe</label>
                    <div class="form-input position-relative">
                        <input type="password" name="password" id="password" class="form-control text-secondary mt-2 border-0 rounded-3" value="{{ old('password') }}" autocomplete="off"/>
                        <i class="fa-solid fa-eye toggle-password" id="togglePassword" style="color:#344264; position:absolute; top:50%; right:15px; transform:translateY(-50%); cursor:pointer;"></i>
                    </div>
                </div>

                <div class="my-4">
                    <label class="text-secondary">Confirmer le mot de passe</label>
                    <div class="form-input position-relative">
                        <input type="password" name="confirm_password" id="confirm_password" class="form-control text-secondary mt-2 border-0 rounded-3" value="{{ old('confirm_password') }}" autocomplete="off"/>
                        <i class="fa-solid fa-eye toggle-password" id="toggleConfirmPassword" style="color:#344264; position:absolute; top:50%; right:15px; transform:translateY(-50%); cursor:pointer;"></i>
                    </div>
                </div>

                <div class="text-start mt-4 pt-3">
                    <button type="submit" class="btn text-white px-5 py-2" style="background-color:#344264;">Réinitialiser</button>
                </div>
            </form>
        </div>
    </main>
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
@endsection


