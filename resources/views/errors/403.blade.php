<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Glaçons Friouato - 404</title>
    <link rel="shortcut icon" href="{{ asset('img/logo.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}">

    <style>
        body {
            margin: 0;
            background: linear-gradient(to bottom, white 5%, #0aa2c0 95%);
            height: 100vh;
            overflow: hidden;
            position: relative;
        }

        .not-found-image {
            position: absolute;
            top: 24%;
            right: 30%;
            width: 250px;
            max-width: 90%;
            transform: translate(-50%, -50%);
        }

        .error-box {
            position: fixed;
            z-index: 999;
            right: 30%;
            bottom: 16%;
            width: 500px;
            max-width: 90%;
            background: rgba(255, 255, 255, .7);
            padding: 20px 20px;
            text-align: right;
        }

        .error-box h1 {
            font-size: 72px;
            margin-bottom: 10px;
        }

        h4 {
            font-weight: 500;
            font-size: 19px;
            padding: 0 16px;
        }
    </style>
</head>

<body>
    <div class="error-box rounded-4 shadow-sm">
        <h2 class="text-center mb-5" style="font-weight: 400; color: #0aa2c0;">403</h2>
        <h4 class="text-start mb-3" style="color: #0aa2c0;">Accès refusé !</h4>
        <h4 class="text-start text-white">Vous n'êtes pas autorisé à accéder à cette page.</h4>
        <a href="{{ route('users.profile', auth()->id()) }}" class="btn text-white mt-3 px-4 py-2" style="font-size: 18px; font-weight: 500; background-color: #0aa2c0;">Retour</a>
    </div>

    <img class="not-found-image rounded-top-4" src="{{ asset('img/unauthorised-page.jpg') }}" alt="Logo Not Found">

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
