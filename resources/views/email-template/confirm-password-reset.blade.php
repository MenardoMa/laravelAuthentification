<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de changement de mot de passe</title>

    <style>
        body {
            background-color: #f5f6fa;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .email-container {
            max-width: 600px;
            background: #ffffff;
            margin: 40px auto;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }

        .title {
            color: #2563eb;
            font-size: 20px;
            margin-bottom: 20px;
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
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <h2 class="title">Confirmation de changement de mot de passe</h2>

        <p>Bonjour <strong>{{ $user->name }}</strong>,</p>

        <p>Nous vous informons que votre mot de passe a été modifié avec succès.</p>

        <p>Si cette action ne vient pas de vous, nous vous recommandons de :</p>

        <ul>
            <li>réinitialiser immédiatement votre mot de passe,</li>
            <li>vérifier si quelqu’un d’autre a accès à votre compte,</li>
            <li>contacter notre support en cas de doute.</li>
        </ul>

        <p>Pour continuer, vous pouvez vous connecter à votre compte en cliquant ci-dessous :</p>

        <a href="{{ $actionLink }}" class="btn">Se connecter</a>

        <p>Pour votre sécurité, ne partagez jamais votre mot de passe ou vos codes d’accès.</p>

        <div class="footer">
            © {{ date('Y') }} Larablog – Tous droits réservés.
        </div>
    </div>
</body>

</html>