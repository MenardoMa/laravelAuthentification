<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta charset="UTF-8">

    <!-- Compatibilité Outlook -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- Responsive mobile -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Désactive le mode sombre forçé sur certains clients -->
    <meta name="color-scheme" content="light only">
    <meta name="supported-color-schemes" content="light only">

    <title>Réinitialisation du mot de passe</title>

    <style>
        body {
            background-color: #f5f6fa;
            font-family: Arial, sans-serif;
            padding: 0;
            margin: 0;
        }

        .container {
            max-width: 600px;
            background: #ffffff;
            margin: 40px auto;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }

        .btn {
            display: inline-block;
            background: #2563eb;
            color: #ffffff !important;
            padding: 12px 25px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 14px;
            margin: 20px 0;
        }

        .footer {
            font-size: 12px;
            color: #777;
            margin-top: 30px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 style="color:#2563eb;">Réinitialisation du mot de passe</h2>

        <p>Bonjour, <strong>{{ $user->name }}</strong> </p>

        <p>Vous avez demandé à réinitialiser votre mot de passe.
            Pour continuer, veuillez cliquer sur le bouton ci-dessous :</p>

        <a href="{{ $actionLink }}" class="btn">Réinitialiser mon mot de passe</a>

        <p>Si le bouton ne fonctionne pas, copiez-collez ce lien dans votre navigateur :</p>
        <p style="word-break: break-all; color:#2563eb;">{{ $actionLink }}</p>

        <p>Si vous n’êtes pas à l’origine de cette demande, vous pouvez ignorer cet email.</p>

        <div class="footer">
            © {{ date('y') }} Larablog – Tous droits réservés.
        </div>
    </div>
</body>

</html>