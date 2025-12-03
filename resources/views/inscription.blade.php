<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="/styles.css">
</head>
<body>
    <div>
        <h1>Inscrivez-vous</h1>

        <form action="{{ url('Inscription') }}" method="post">
            <p>
                <label for="prenom">Prenom :</label><br>
                <input type="prenom" name="prenom" id="prenom" value="{{ old('prenom') }}" required>
            </p>
            <p>
                <label for="nom">Nom :</label><br>
                <input type="nom" name="nom" id="nom" value="{{ old('nom') }}" required>
            </p>
            <p>
                <label for="email">Adresse e‑mail :</label><br>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required>
                @error('email')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </p>

            <!-- Confirmation de l'email -->
            <p>
                <label for="email_confirmation">Confirmez votre Email :</label><br>
                <input type="email" name="email_confirmation" value="{{ old('email_confirmation') }}" required>
                @error('email_confirmation')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
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