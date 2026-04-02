<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Mes Films Préférés') • Mes Films Préférés</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🎬</text></svg>">
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body>
    <div class="curtain" aria-hidden="true"></div>

    @include('templates.menu')

    <main class="container">
        @if (session('success'))
            <div class="alert alert--ok" role="status">{{ session('success') }}</div>
            <div style="height:12px"></div>
        @endif

        @if ($errors->any())
            <div class="alert alert--err" role="alert">
                <strong>Oups.</strong> Merci de corriger les champs en erreur.
                <ul style="margin:8px 0 0; padding-left:18px">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <div style="height:12px"></div>
        @endif

        @yield('content')

        <footer class="footer small">Projet Laravel • TMDB • Mes Films Préférés</footer>
    </main>
</body>
</html>
