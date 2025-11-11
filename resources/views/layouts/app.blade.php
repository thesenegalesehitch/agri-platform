<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>{{ config('app.name', 'AgriLink') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            /* 🌾 Thème Agricole Global */
            * {
                box-sizing: border-box;
            }

            body {
                font-family: 'Poppins', sans-serif;
                background: linear-gradient(180deg, #faf7f2 0%, #edf6f0 100%);
                color: #3b2f2f;
                min-height: 100vh;
                line-height: 1.6;
            }

            /* Navigation */
            .nav-header {
                background: #5c4033;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
                position: relative;
                z-index: 100;
            }

            /* Page Content */
            .page-content {
                min-height: calc(100vh - 200px);
                padding: 2rem 0;
            }

            /* Cards */
            .content-card {
                background: white;
                border-radius: 12px;
                padding: 2rem;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                margin-bottom: 2rem;
                animation: fadeIn 0.5s ease-out;
            }

            /* Buttons */
            .btn-primary-agri {
                background: #4CAF50;
                color: white;
                padding: 0.75rem 1.5rem;
                border-radius: 6px;
                font-weight: 600;
                font-size: 0.95rem;
                border: none;
                cursor: pointer;
                transition: all 0.3s ease;
                text-decoration: none;
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
            }

            .btn-primary-agri:hover {
                background: #81C784;
                transform: translateY(-1px);
                box-shadow: 0 4px 12px rgba(76, 175, 80, 0.3);
                color: white;
            }

            .btn-secondary-agri {
                background: white;
                color: #5c4033;
                padding: 0.75rem 1.5rem;
                border-radius: 6px;
                font-weight: 600;
                font-size: 0.95rem;
                border: 2px solid #4CAF50;
                cursor: pointer;
                transition: all 0.3s ease;
                text-decoration: none;
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
            }

            .btn-secondary-agri:hover {
                background: #f0f9f0;
                border-color: #81C784;
                color: #5c4033;
            }

            .btn-danger-agri {
                background: #d9534f;
                color: white;
                padding: 0.75rem 1.5rem;
                border-radius: 6px;
                font-weight: 600;
                font-size: 0.95rem;
                border: none;
                cursor: pointer;
                transition: all 0.3s ease;
            }

            .btn-danger-agri:hover {
                background: #c9302c;
                transform: translateY(-1px);
            }

            /* Forms */
            .form-input-agri,
            .form-select-agri,
            .form-textarea-agri {
                width: 100%;
                padding: 12px;
                border: 1px solid #d0c9c0;
                border-radius: 6px;
                font-family: 'Poppins', sans-serif;
                font-size: 0.95rem;
                background: #fff;
                color: #3b2f2f;
                transition: all 0.3s ease;
            }

            .form-input-agri:focus,
            .form-select-agri:focus,
            .form-textarea-agri:focus {
                outline: none;
                border-color: #4CAF50;
                box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
            }

            .form-label-agri {
                display: block;
                color: #5c4033;
                font-weight: 600;
                font-size: 0.95rem;
                margin-bottom: 0.5rem;
            }

            .form-error-agri {
                color: #d9534f;
                font-size: 0.9rem;
                margin-top: 0.5rem;
                display: block;
            }

            /* Page Titles */
            .page-title-agri {
                color: #5c4033;
                font-weight: 700;
                font-size: 2rem;
                margin-bottom: 1rem;
            }

            .section-title-agri {
                color: #5c4033;
                font-weight: 700;
                font-size: 1.5rem;
                margin-bottom: 1.5rem;
            }

            /* Alerts */
            .alert-agri {
                padding: 1rem;
                border-radius: 6px;
                margin-bottom: 1rem;
                animation: fadeIn 0.3s ease-out;
            }

            .alert-success-agri {
                background: #d4edda;
                color: #155724;
                border: 1px solid #c3e6cb;
            }

            .alert-error-agri {
                background: #f8d7da;
                color: #721c24;
                border: 1px solid #f5c6cb;
            }

            /* Footer */
            .footer-agri {
                background: #4a3327;
                color: #fffdf8;
                padding: 2rem 1rem;
                text-align: center;
                font-weight: 500;
                letter-spacing: 0.5px;
                margin-top: 3rem;
            }

            /* Animations - Optimisées */
            @keyframes fadeIn {
                from {
                    opacity: 0;
                }
                to {
                    opacity: 1;
                }
            }

            .fade-in {
                animation: fadeIn 0.3s ease-out;
                will-change: opacity;
            }

            /* Optimisations de performance */
            * {
                -webkit-font-smoothing: antialiased;
                -moz-osx-font-smoothing: grayscale;
            }

            img {
                content-visibility: auto;
            }

            /* Dropdown menu */
            [x-cloak] {
                display: none !important;
            }

            /* Table Styles */
            .table-agri {
                width: 100%;
                background: white;
                border-radius: 12px;
                overflow: hidden;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            }

            .table-agri thead {
                background: #5c4033;
                color: white;
            }

            .table-agri th {
                padding: 1rem;
                text-align: left;
                font-weight: 600;
            }

            .table-agri td {
                padding: 1rem;
                border-top: 1px solid #e0dcd6;
            }

            .table-agri tbody tr:hover {
                background: #f8f6f3;
            }
        </style>
    </head>
    <body>
        <div class="min-h-screen">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow-sm">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="page-content">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    @if(session('status'))
                        <div class="alert-agri alert-success-agri fade-in">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert-agri alert-error-agri fade-in">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{ $slot }}
                </div>
            </main>

            <footer class="footer-agri">
                <div class="max-w-7xl mx-auto">
                    <p>&copy; {{ date('Y') }} {{ config('app.name') }} — Tous droits réservés</p>
                </div>
            </footer>
        </div>
    </body>
</html>
