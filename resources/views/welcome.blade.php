<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Agri-Platform') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

                * {
                    margin: 0;
                    padding: 0;
                    box-sizing: border-box;
                }

                body {
                    font-family: 'Inter', sans-serif;
                    background: #f8f9fa;
                    color: #333;
                    overflow-x: hidden;
                }

                /* Hero Section */
                .hero {
                    position: relative;
                    height: 100vh;
                    background: linear-gradient(135deg, #4CAF50 0%, #2E7D32 100%);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    text-align: center;
                    color: white;
                    overflow: hidden;
                }

                .hero::before {
                    content: '';
                    position: absolute;
                    top: 0;
                    left: 0;
                    right: 0;
                    bottom: 0;
                    background: rgba(0, 0, 0, 0.4);
                    z-index: 1;
                }

                .hero-content {
                    position: relative;
                    z-index: 3;
                    max-width: 1200px;
                    padding: 0 2rem;
                }

                .hero-title {
                    font-size: clamp(2.5rem, 5vw, 4rem);
                    font-weight: 700;
                    margin-bottom: 1rem;
                    text-shadow: 0 2px 4px rgba(0,0,0,0.5);
                    animation: fadeInUp 1s ease-out;
                }

                .hero-subtitle {
                    font-size: clamp(1rem, 2vw, 1.5rem);
                    margin-bottom: 2rem;
                    opacity: 0.9;
                    animation: fadeInUp 1s ease-out 0.2s both;
                }

                .hero-buttons {
                    display: flex;
                    gap: 1rem;
                    justify-content: center;
                    flex-wrap: wrap;
                    animation: fadeInUp 1s ease-out 0.4s both;
                }


                /* Features Section */
                .features {
                    padding: 5rem 2rem;
                    background: white;
                    text-align: center;
                }

                .features h2 {
                    font-size: 2.5rem;
                    color: #2E7D32;
                    margin-bottom: 3rem;
                    font-weight: 600;
                }

                .features-grid {
                    display: grid;
                    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
                    gap: 2rem;
                    max-width: 1200px;
                    margin: 0 auto;
                }

                .feature-card {
                    background: #f8f9fa;
                    padding: 2rem;
                    border-radius: 15px;
                    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
                    transition: transform 0.3s ease, box-shadow 0.3s ease;
                    border: 2px solid transparent;
                }

                .feature-card:hover {
                    transform: translateY(-10px);
                    box-shadow: 0 15px 30px rgba(0,0,0,0.2);
                    border-color: #4CAF50;
                }

                .feature-icon {
                    font-size: 3rem;
                    margin-bottom: 1rem;
                    display: block;
                }

                .feature-title {
                    font-size: 1.5rem;
                    font-weight: 600;
                    color: #2E7D32;
                    margin-bottom: 1rem;
                }

                .feature-desc {
                    color: #666;
                    line-height: 1.6;
                }

                /* Stats Section */
                .stats {
                    padding: 4rem 2rem;
                    background: linear-gradient(135deg, #4CAF50 0%, #2E7D32 100%);
                    color: white;
                    text-align: center;
                }

                .stats-grid {
                    display: grid;
                    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                    gap: 2rem;
                    max-width: 1000px;
                    margin: 0 auto;
                }

                .stat-item {
                    padding: 2rem;
                }

                .stat-number {
                    font-size: 3rem;
                    font-weight: 700;
                    margin-bottom: 0.5rem;
                    display: block;
                }

                .stat-label {
                    font-size: 1.1rem;
                    opacity: 0.9;
                }

                /* CTA Section */
                .cta {
                    padding: 5rem 2rem;
                    background: #f8f9fa;
                    text-align: center;
                }

                .cta h2 {
                    font-size: 2.5rem;
                    color: #2E7D32;
                    margin-bottom: 1rem;
                }

                .cta p {
                    font-size: 1.2rem;
                    color: #666;
                    margin-bottom: 2rem;
                    max-width: 600px;
                    margin-left: auto;
                    margin-right: auto;
                }

                /* Buttons */
                .btn {
                    display: inline-block;
                    padding: 1rem 2rem;
                    border: none;
                    border-radius: 50px;
                    font-size: 1.1rem;
                    font-weight: 600;
                    text-decoration: none;
                    cursor: pointer;
                    transition: all 0.3s ease;
                    box-shadow: 0 4px 15px rgba(76, 175, 80, 0.3);
                }

                .btn-primary {
                    background: #4CAF50;
                    color: white;
                }

                .btn-primary:hover {
                    background: #45a049;
                    transform: translateY(-3px);
                    box-shadow: 0 8px 25px rgba(76, 175, 80, 0.4);
                }

                .btn-secondary {
                    background: white;
                    color: #4CAF50;
                    border: 2px solid #4CAF50;
                }

                .btn-secondary:hover {
                    background: #4CAF50;
                    color: white;
                    transform: translateY(-3px);
                }

                /* Animations */
                @keyframes fadeInUp {
                    from {
                        opacity: 0;
                        transform: translateY(30px);
                    }
                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }

                /* Responsive */
                @media (max-width: 768px) {
                    .hero {
                        padding: 2rem 1rem;
                    }

                    .hero-title {
                        font-size: 2rem;
                    }

                    .hero-subtitle {
                        font-size: 1rem;
                    }

                    .hero-buttons {
                        flex-direction: column;
                        align-items: center;
                    }

                    .features {
                        padding: 3rem 1rem;
                    }

                    .features h2 {
                        font-size: 2rem;
                    }

                    .features-grid {
                        grid-template-columns: 1fr;
                    }

                    .stats-grid {
                        grid-template-columns: repeat(2, 1fr);
                    }

                    .stat-number {
                        font-size: 2rem;
                    }
                }

                @media (max-width: 480px) {
                    .stats-grid {
                        grid-template-columns: 1fr;
                    }

                    .hero-buttons .btn {
                        width: 100%;
                        max-width: 300px;
                    }
                }
            </style>
        @endif
    </head>
    <body>
        <!-- Hero Section -->
        <section class="hero">
            <div class="hero-content">
                <h1 class="hero-title">🌾 Agri-Platform Sénégal</h1>
                <p class="hero-subtitle">Connectez-vous avec l'agriculture moderne du Sénégal. Achetez, vendez et louez des équipements agricoles.</p>
                <div class="hero-buttons">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-primary">Accéder à mon Espace</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary">Se Connecter</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-secondary">Créer un Compte</a>
                        @endif
                    @endauth
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="features">
            <h2>Nos Services</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <span class="feature-icon">🌱</span>
                    <h3 class="feature-title">Pour les Agriculteurs</h3>
                    <p class="feature-desc">Vendez vos produits frais directement aux consommateurs et aux acheteurs professionnels. Accédez à un marché plus large et maximisez vos revenus.</p>
                </div>

                <div class="feature-card">
                    <span class="feature-icon">🛒</span>
                    <h3 class="feature-title">Pour les Acheteurs</h3>
                    <p class="feature-desc">Découvrez une variété de produits agricoles locaux et frais. Achetez directement auprès des producteurs et soutenez l'agriculture sénégalaise.</p>
                </div>

                <div class="feature-card">
                    <span class="feature-icon">🚜</span>
                    <h3 class="feature-title">Location d'Équipements</h3>
                    <p class="feature-desc">Louez des équipements agricoles modernes et bien entretenus. Accédez à la technologie sans investir dans l'achat.</p>
                </div>

                <div class="feature-card">
                    <span class="feature-icon">📊</span>
                    <h3 class="feature-title">Suivi & Transparence</h3>
                    <p class="feature-desc">Suivez vos transactions en temps réel. Profitez d'une plateforme sécurisée avec des paiements transparents et des garanties.</p>
                </div>
            </div>
        </section>

        <!-- Stats Section -->
        <section class="stats">
            <div class="stats-grid">
                <div class="stat-item">
                    <span class="stat-number">500+</span>
                    <span class="stat-label">Agriculteurs Actifs</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">1000+</span>
                    <span class="stat-label">Produits Disponibles</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">200+</span>
                    <span class="stat-label">Équipements à Louer</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">98%</span>
                    <span class="stat-label">Satisfaction Client</span>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="cta">
            <h2>Rejoignez la Révolution Agricole</h2>
            <p>Commencez dès aujourd'hui à transformer votre façon de faire de l'agriculture au Sénégal.</p>
            @auth
                <a href="{{ url('/dashboard') }}" class="btn btn-primary">Accéder au Dashboard</a>
            @else
                <a href="{{ route('register') }}" class="btn btn-primary">Créer mon Compte</a>
            @endauth
        </section>

        <script>
            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                });
            });
        </script>
    </body>
</html>