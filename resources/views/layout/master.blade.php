<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Glaçons Friouato</title>
        <link rel="shortcut icon" href="{{ asset('img/logo.png') }}" type="image/x-icon">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}">
    </head>

    <body>
        <div class="d-flex">
            @include('layout.include.header')
            <div class="container-fluid" style="z-index: 999;">
                <div style="width: 50%;">

                    @if(session('success'))
                        <div class="alert alert-dismissible text-secondary fade show auto-dismiss" role="alert" style="position: fixed; bottom: -1%; left: 20%; min-width: 400px; background-color: #FAFAFA;">
                            <span style="font-weight: 500;">{{ session('success') }}</span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="border: none; outline: none; box-shadow: none; font-size: 12px;"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-dismissible text-secondary fade show auto-dismiss" role="alert" style="position: fixed; bottom: -1%; left: 20%; min-width: 400px; background-color: #FAFAFA;">
                            <span style="font-weight: 500;">{{ session('error') }}</span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="border: none; outline: none; box-shadow: none; font-size: 12px;"></button>
                        </div>
                    @endif
                </div>

                @yield('content')
            </div>
        </div>

        <script>
            document.querySelector('.toggle-btn').addEventListener('click', function () {
                this.classList.toggle('flipped');
            });
        </script>

        <script src="{{ asset('js/script.js') }}"></script>
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
