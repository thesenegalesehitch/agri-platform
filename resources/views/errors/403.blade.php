<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>403 - Accès Refusé</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(180deg, #faf7f2 0%, #edf6f0 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 2rem;
        }
        .error-container {
            text-align: center;
            max-width: 600px;
            background: white;
            padding: 3rem;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        h1 { font-size: 4rem; color: #5c4033; margin-bottom: 1rem; }
        h2 { font-size: 1.5rem; color: #55493f; margin-bottom: 1rem; }
        p { color: #55493f; margin-bottom: 2rem; line-height: 1.6; }
        .btn {
            display: inline-block;
            padding: 0.75rem 2rem;
            background: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 500;
            transition: background 0.3s;
            margin: 0.5rem;
        }
        .btn:hover { background: #45a049; }
        .btn-secondary {
            background: #d0c9c0;
        }
        .btn-secondary:hover { background: #b8b0a7; }
    </style>
</head>
<body>
    <div class="error-container">
        <h1>403</h1>
        <h2>Accès Refusé</h2>
        <p>
            @if(isset($exception) && $exception->getMessage())
                {{ $exception->getMessage() }}
            @else
                Vous n'avez pas les permissions nécessaires pour accéder à cette page.
            @endif
        </p>
        <p style="font-size: 0.9rem; color: #888;">
            Si vous pensez que c'est une erreur, vérifiez que vous avez le bon rôle assigné à votre compte.
        </p>
        <div style="margin-top: 2rem;">
            <a href="{{ url()->previous() ?: route('dashboard') }}" class="btn btn-secondary">← Retour</a>
            @auth
                <a href="{{ route('dashboard') }}" class="btn">Aller au Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="btn">Se connecter</a>
            @endauth
        </div>
    </div>
</body>
</html>
