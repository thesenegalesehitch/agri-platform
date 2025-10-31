<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Agri-Platform') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* 🌿 Fond naturel avec un léger dégradé terre et vert clair */
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(180deg, #faf7f2 0%, #edf6f0 100%);
            color: #3b2f2f;
            overflow-x: hidden;
        }

        /* 🌾 Navbar marron terre élégante */
        .nav {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: #5c4033;
            z-index: 1000;
            padding: 1rem 0;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .nav-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .nav-logo {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            text-decoration: none;
            color: #f8f8f8;
            font-size: 1.6rem;
            font-weight: 700;
        }

        .nav-logo-icon {
            font-size: 2rem;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .nav-link {
            color: #f5f5f5;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: #c2e0b6; /* vert doux */
        }

        .nav-welcome {
            color: #f0f0f0;
            font-size: 0.95rem;
            font-weight: 500;
        }

        /* 🍃 Boutons nature */
        .nav-button {
            background: #4CAF50;
            color: #fff;
            padding: 0.6rem 1.5rem;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .nav-button:hover {
            background: #81C784;
            transform: translateY(-1px);
        }

        /* 🌻 Section d’accueil avec image principale */
        .hero-section {
            margin-top: 70px;
            width: 100%;
            position: relative;
            height: 75vh;
            min-height: 600px;
            overflow: hidden;
        }

        .hero-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: brightness(0.9);
        }

        .hero-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(92, 64, 51, 0.95) 0%, rgba(92, 64, 51, 0.3) 50%, transparent 100%);
            padding: 4rem 2rem 3rem;
            color: #fffdf8;
        }

        .hero-title {
            font-size: clamp(2.5rem, 5vw, 4rem);
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .hero-subtitle {
            font-size: clamp(1.1rem, 2vw, 1.5rem);
            margin-bottom: 2.5rem;
            opacity: 0.95;
        }

        /* 🌱 Boutons de la section Hero */
        .hero-buttons {
            display: flex;
            gap: 1.5rem;
            flex-wrap: wrap;
        }

        .hero-btn {
            padding: 1rem 2.5rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .hero-btn-primary {
            background: #4CAF50;
            color: #fff;
        }

        .hero-btn-primary:hover {
            background: #81C784;
            transform: translateY(-2px);
        }

        .hero-btn-secondary {
            background: #fff;
            color: #5c4033;
        }

        .hero-btn-secondary:hover {
            background: #f5f0eb;
            transform: translateY(-2px);
        }

        /* 🌿 Section des images */
        .images-section {
            padding: 4rem 2rem;
            background: #f8f6f3;
        }

        .section-title {
            font-size: clamp(2rem, 4vw, 2.8rem);
            font-weight: 700;
            color: #5c4033;
            margin-bottom: 3rem;
            text-align: center;
        }

        .images-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .image-card {
            position: relative;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            aspect-ratio: 4/3;
        }

        .image-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 30px rgba(92, 64, 51, 0.25);
        }

        .image-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* 🌾 Section des services */
        .actions-section {
            padding: 4rem 2rem;
            background: #fff;
        }

        .action-buttons {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .action-button {
            background: #fff;
            border: 2px solid #e0dcd6;
            padding: 2.5rem;
            border-radius: 12px;
            text-decoration: none;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .action-button:hover {
            border-color: #4CAF50;
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(92, 64, 51, 0.15);
        }

        .action-icon {
            font-size: 3.5rem;
            margin-bottom: 1.5rem;
            display: block;
        }

        .action-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #5c4033;
            margin-bottom: 1rem;
        }

        .action-desc {
            color: #55493f;
            font-size: 1rem;
            line-height: 1.6;
        }

        /* 🌾 Footer nature */
        footer {
            background: #4a3327;
            color: #fffdf8;
            padding: 2rem 1rem;
            text-align: center;
            font-weight: 500;
            letter-spacing: 0.5px;
        }

        /* 📱 Responsive */
        @media (max-width: 968px) {
            .nav-links { gap: 1rem; }
            .hero-section { height: 60vh; min-height: 500px; }
            .hero-buttons { flex-direction: column; }
            .hero-btn { width: 100%; justify-content: center; }
        }

        @media (max-width: 640px) {
            .nav-container { padding: 0 1rem; }
            .hero-section { height: 50vh; min-height: 400px; }
            .images-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>

<body>
    <!-- 🌿 Navbar -->
    <nav class="nav">
        <div class="nav-container">
            <a href="{{ url('/') }}" class="nav-logo">
                <span class="nav-logo-icon">🌾</span>
                <span>AgriPlatform</span>
            </a>
            <div class="nav-links">
                <a href="{{ route('products.index') }}" class="nav-link">Produits</a>
                <a href="{{ route('equipment.index') }}" class="nav-link">Équipements</a>
                <a href="{{ route('about') }}" class="nav-link">À propos</a>
                <a href="{{ route('contact') }}" class="nav-link">Contact</a>
                @auth
                    <span class="nav-welcome">Bienvenue, {{ Auth::user()->name }} !</span>
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="nav-button">LOG OUT</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="nav-link">Connexion</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="nav-button">Inscription</a>
                    @endif
                @endauth
            </div>
        </div>
    </nav>

    <!-- 🌻 Hero Section -->
    <section class="hero-section">
        <div class="hero-image-container">
            @php $mainImage = 'pexels-enginakyurt-1435904.jpg'; @endphp
            <img 
                src="{{ asset('images/' . $mainImage) }}" 
                alt="Agriculture moderne" 
                class="hero-image"
                loading="eager"
                decoding="async"
                width="1920"
                height="1080"
            >
            <div class="hero-overlay">
                <h1 class="hero-title">Bienvenue sur AgriPlatform</h1>
                <p class="hero-subtitle">La plateforme agricole moderne qui connecte producteurs, acheteurs et propriétaires d'équipements au Sénégal.</p>
                <div class="hero-buttons">
                    <a href="{{ route('products.index') }}" class="hero-btn hero-btn-primary">Découvrir les Produits</a>
                    <a href="{{ route('equipment.index') }}" class="hero-btn hero-btn-secondary">Voir les Équipements</a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="hero-btn hero-btn-primary">Mon Dashboard</a>
                    @else
                        <a href="{{ route('register') }}" class="hero-btn hero-btn-secondary">Créer un Compte</a>
                    @endauth
                </div>
            </div>
        </div>
    </section>

    <!-- 🌾 Images Grid -->
    <section class="images-section">
        <div class="section-container">
            <h2 class="section-title">Notre Univers Agricole</h2>
            <div class="images-grid">
                @php
                    $images = [
                        'pexels-binyaminmellish-169523.jpg',
                        'pexels-deneen-l-treble-390196-1058401.jpg',
                        'pexels-kelly-2382665.jpg',
                        'pexels-markusspiske-1268101.jpg',
                        'pexels-nc-farm-bureau-mark-2255801.jpg',
                        'pexels-picjumbo-com-55570-196643.jpg',
                        'pexels-rodolfoclix-1615785.jpg',
                        'pexels-tomfisk-1595108.jpg',
                    ];
                @endphp

                @foreach($images as $index => $image)
                    <div class="image-card">
                        <img 
                            src="{{ asset('images/' . $image) }}" 
                            alt="Image agricole {{ $index + 1 }}"
                            loading="lazy"
                            decoding="async"
                            width="400"
                            height="300"
                        >
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- 🌿 Services -->
    <section class="actions-section">
        <div class="section-container">
            <h2 class="section-title">Nos Services</h2>
            <div class="action-buttons">
                <a href="{{ route('products.index') }}" class="action-button">
                    <span class="action-icon">🌾</span>
                    <div class="action-title">Produits Agricoles</div>
                    <div class="action-desc">Découvrez une large gamme de produits frais directement des producteurs locaux.</div>
                </a>
                <a href="{{ route('equipment.index') }}" class="action-button">
                    <span class="action-icon">🚜</span>
                    <div class="action-title">Location d'Équipements</div>
                    <div class="action-desc">Accédez à du matériel agricole moderne sans investir dans l'achat.</div>
                </a>
                @auth
                    <a href="{{ route('dashboard') }}" class="action-button">
                        <span class="action-icon">📊</span>
                        <div class="action-title">Tableau de Bord</div>
                        <div class="action-desc">Gérez vos produits, équipements et transactions en toute simplicité.</div>
                    </a>
                @else
                    <a href="{{ route('register') }}" class="action-button">
                        <span class="action-icon">✨</span>
                        <div class="action-title">Rejoignez-nous</div>
                        <div class="action-desc">Créez votre compte et commencez à utiliser toutes les fonctionnalités.</div>
                    </a>
                @endauth
            </div>
        </div>
    </section>

    <!-- 🌾 Footer -->
    <footer>
        Bienvenue sur AgriPlatform — Votre partenaire agricole au Sénégal
    </footer>
</body>
</html>
