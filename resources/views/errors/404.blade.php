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
            background: linear-gradient(to bottom, white 5%, rgb(67, 221, 221) 95%);
            height: 100vh;
            overflow: hidden;
            position: relative;
        }

        .not-found-image {
            position: absolute;
            top: 40%;
            left: 43.5%;
            width: 650px;
            max-width: 90%;
            transform: translate(-50%, -50%);
        }

        .error-box {
            position: fixed;
            right: 20px;
            bottom: 30px;
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
            padding: 0 60px;
        }
    </style>
</head>

<body>
    <img class="not-found-image rounded-4" src="{{ asset('img/not-found-logo.jpg') }}" alt="Logo Not Found">

    <div class="error-box rounded-4 shadow-sm">
        <h2 class="text-center mb-5" style="font-weight: 400; color: rgb(67, 221, 221);">404</h2>
        <h4 class="text-start text-white">Oops! Page non trouvée</h4>
        <h4 class="text-start text-white">La page demandée n'existe pas.</h4>
        <a href="{{ route('users.profile', auth()->id()) }}" class="btn text-white mt-3 px-4 py-2" style="font-size: 18px; font-weight: 500; background-color: rgb(67, 221, 221);">Retour</a>
    </div>

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
