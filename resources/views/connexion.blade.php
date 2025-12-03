<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="/styles.css">
</head>
<body>
    <div>
        <h1>Connectez-vous</h1>

        <form action="{{ url('Connexion') }}" method="post">
            <p>
                <label for="email">Adresse e‑mail :</label><br>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required>
            </p>

            <p>
                <label for="password">Mot de passe :</label><br>
                <input type="password" name="password" id="password" required>
            </p>

            <p>
                <label>
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    Se souvenir de moi
                </label>
            </p>

            <p>
                <button type="submit">Se connecter</button>
            </p>
        </form>
    </div>
</body>
</html>