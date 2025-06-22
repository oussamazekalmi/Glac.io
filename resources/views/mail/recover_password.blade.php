
<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation de votre mot de passe</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('img/phase_two.png') }}" type="image/x-icon">
    <style>
        .container {
            font-family: Nunito, 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: larger;
            max-width: 50%;
            margin: auto;
            color: #333;
            padding: 20px;
            background-color: #fff;
            cursor: default;
            letter-spacing: 0.75px;
        }
        a.btn {
            display: block;
            width: fit-content;
            margin: 30px auto;
            cursor: pointer;
            background-color: #344264;
            color: #fff;
            padding: 8px 12px;
            border-radius: 6px;
            text-decoration: none;
        }
        h2 {
            color: #344264;
            margin: 25px auto;
            font-weight: 400;
        }
        a.btn:hover {
            background-color: #2c3755;
        }
        .support {
            color: #344264 !important;
            cursor: pointer;
            text-decoration: none;
        }
        .support:hover {
            color: #2c3755;
        }
        img {
            width: 25%;
            height: 25%;
            position: relative;
            border-radius: 50%;
            margin-bottom: 16px;

        }
        .hr {
            width: 100%;
            height: 3px;
            background-color: #344264;
        }
        .hashed {
            display: block;
            width: fit-content;
            margin: 12px;
            padding: 6px 12px;
            background-color: whitesmoke !important;
            color: #344264 !important;
            font-size: large;
            font-weight: 500;
            letter-spacing: 8px;
        }
    </style>
</head>
<body>
    <div class="container text-center pt-3 pb-1">
        <header class="d-flex justify-content-start p-0">
            <img src="https://static.vecteezy.com/system/resources/previews/001/750/172/non_2x/cute-penguin-dabbing-on-an-ice-floe-vector.jpg" alt="">
        </header>
        <div class="hr"></div>
        <h2>Réinitialisation de votre mot de passe</h2>
        <p>Nous avons reçu une demande de réinitialisation de votre mot de passe pour votre compte</p>
        <p>Pour réinitialiser votre mot de passe, veuillez cliquer sur le bouton ci-dessous :</p>
        <p>Conservez cette chaîne pour une utilisation ultérieure : <span class="hashed">{{ $hash }}</span></p>
        <a href="{{ $link }}" class="btn">Réinitialiser votre mot de passe</a>
        <p>Si vous n'avez pas demandé de réinitialisation de mot de passe, vous pouvez ignorer cet email en toute sécurité.</p>
        <span>Nous vous remercions.</span>
        <footer>
            <hr  />
            <p>Pour toute assistance, veuillez nous contacter à <a class="support" href="mailto:support.friouato@gmail.com">support.friouato@gmail.com</a></p>
        </footer>
    </div>
</body>
</html>
