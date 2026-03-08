<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ isset($title) ? $title.' • Mes Films Préférés' : 'Mes Films Préférés' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen">

    {{-- Rideau cinéma à l'ouverture --}}
    <div class="curtain" aria-hidden="true"></div>

    @include('templates.menu')

    <main class="max-w-6xl mx-auto px-6 py-8">

        @if (session('success'))
            <div class="alert alert--ok" role="status">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert--err" role="alert">
                <strong>Oups !</strong> Merci de corriger les champs indiqués.
            </div>
        @endif

        @yield('content')

        <div class="footer">Mes Films Préférés &bull; Laravel &bull; TMDB</div>
    </main>

</body>
</html>
