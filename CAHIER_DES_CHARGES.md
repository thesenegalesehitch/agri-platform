# CAHIER DES CHARGES - AGRI PLATFORM
## Plateforme de Gestion et d'Echange de Produits et Matériels Agricoles

---

## TABLE DES MATIERES

1. [Introduction et Contexte](#1-introduction-et-contexte)
2. [Objectifs du Projet](#2-objectifs-du-projet)
3. [Acteurs et Rôles](#3-acteurs-et-rôles)
4. [Architecture Technique](#4-architecture-technique)
5. [Communication Frontend-Backend](#5-communication-frontend-backend)
6. [Frameworks et Outils Utilisés](#6-frameworks-et-outils-utilisés)
7. [Fonctionnalités Détaillées](#7-fonctionnalités-détaillées)
8. [Modèle de Données](#8-modèle-de-données)
9. [Sécurité et Authentification](#9-sécurité-et-authentification)
10. [API REST et Documentation](#10-api-rest-et-documentation)
11. [Tests et Qualité](#11-tests-et-qualité)
12. [Déploiement et Production](#12-déploiement-et-production)
13. [Conclusion et Perspectives](#13-conclusion-et-perspectives)

---

## 1. INTRODUCTION ET CONTEXTE

### 1.1 Présentation du Projet

Agri Platform (AgriLink) est une plateforme web complète développée pour faciliter l'échange et la gestion de produits et matériels agricoles au Sénégal. Cette application répond aux besoins du secteur agricole en connectant les différents acteurs : producteurs, propriétaires de matériel agricole, acheteurs et administrateurs.

### 1.2 Problématique

Le secteur agricole sénégalais fait face à plusieurs défis :
- Difficulté de mise en relation entre producteurs et acheteurs
- Manque de visibilité pour les produits agricoles locaux
- Accès limité aux équipements agricoles pour les petits producteurs
- Absence de plateforme centralisée pour la gestion des transactions agricoles
- Nécessité de vérification et de confiance entre les acteurs

### 1.3 Solution Proposée

Agri Platform propose une solution intégrée permettant :
- La mise en ligne et la gestion de produits agricoles
- La location d'équipements agricoles
- Un système de commandes et de paiement
- Une gestion administrative complète avec vérification d'identité
- Une API REST pour l'intégration avec d'autres systèmes

---

## 2. OBJECTIFS DU PROJET

### 2.1 Objectifs Fonctionnels

- Permettre aux producteurs de publier, gérer et vendre leurs produits agricoles
- Faciliter la location d'équipements agricoles entre propriétaires et utilisateurs
- Offrir un système de panier et de commandes sécurisé
- Fournir un tableau de bord personnalisé pour chaque type d'utilisateur
- Assurer la vérification d'identité (CNI) pour renforcer la confiance
- Gérer les suspensions et réactivations de comptes
- Notifier les utilisateurs des événements importants

### 2.2 Objectifs Techniques

- Développer une application web moderne et responsive
- Implémenter une architecture RESTful avec API documentée
- Assurer la sécurité des données et des transactions
- Optimiser les performances et l'expérience utilisateur
- Mettre en place des tests automatisés
- Faciliter le déploiement en production

### 2.3 Objectifs Business

- Créer un écosystème numérique pour le secteur agricole
- Faciliter l'accès aux marchés pour les producteurs
- Réduire les coûts de transaction
- Améliorer la traçabilité des produits et équipements
- Contribuer au développement de l'agriculture numérique au Sénégal

---

## 3. ACTEURS ET ROLES

### 3.1 Administrateur (Admin)

**Description** : Gestionnaire principal de la plateforme avec accès complet.

**Responsabilités** :
- Gestion des utilisateurs (création, modification, suppression)
- Vérification des cartes d'identité nationales (CNI)
- Suspension et réactivation de comptes utilisateurs
- Gestion des demandes d'annulation de commandes
- Gestion des demandes de réactivation de comptes suspendus
- Consultation des statistiques globales de la plateforme
- Modération du contenu

**Permissions** :
- Accès au dashboard administrateur
- CRUD complet sur les utilisateurs
- Validation/rejet des CNI
- Approbation/rejet des annulations de commandes
- Approbation/rejet des demandes de réactivation

### 3.2 Producteur (Producer)

**Description** : Utilisateur qui vend des produits agricoles sur la plateforme.

**Responsabilités** :
- Création et gestion de ses produits agricoles
- Définition des prix et quantités disponibles
- Upload et gestion des images de produits
- Suivi des commandes reçues
- Mise à jour du stock disponible

**Permissions** :
- CRUD sur ses propres produits
- Upload jusqu'à 10 images par produit (fichiers ou URLs)
- Sélection de l'image principale
- Réorganisation des images par drag & drop
- Consultation de ses statistiques de vente

### 3.3 Propriétaire de Matériel (Equipment Owner)

**Description** : Utilisateur qui loue des équipements agricoles.

**Responsabilités** :
- Création et gestion de ses équipements agricoles
- Définition des tarifs de location journaliers
- Gestion des disponibilités
- Gestion des demandes de location (approbation/rejet)
- Suivi des locations actives

**Permissions** :
- CRUD sur ses propres équipements
- Upload jusqu'à 10 images par équipement
- Gestion des demandes de location
- Modification du statut des locations (pending, approved, rejected, completed)
- Consultation de ses statistiques de location

### 3.4 Acheteur (Buyer)

**Description** : Utilisateur qui achète des produits agricoles et loue des équipements.

**Responsabilités** :
- Consultation du catalogue de produits et équipements
- Ajout de produits au panier
- Passage de commandes
- Paiement des commandes
- Demande de location d'équipements
- Suivi de ses commandes et locations

**Permissions** :
- Consultation publique des produits et équipements
- Gestion du panier (ajout, suppression)
- Création de commandes
- Paiement (en ligne ou espèces)
- Demande d'annulation de commandes
- Demande de location d'équipements
- Consultation de ses commandes et locations

### 3.5 Utilisateur Multi-Rôles

**Description** : Un utilisateur peut cumuler plusieurs rôles (ex: producteur + propriétaire de matériel).

**Avantages** :
- Accès aux fonctionnalités de tous ses rôles
- Interface unifiée pour gérer ses différentes activités
- Tableau de bord consolidé

---

## 4. ARCHITECTURE TECHNIQUE

### 4.1 Stack Technologique

**Backend** :
- PHP 8.2+
- Laravel 12.0 (Framework PHP)
- Base de données : SQLite (développement) / MySQL/PostgreSQL (production)

**Frontend** :
- Blade (moteur de templates Laravel)
- Tailwind CSS 3.1 (framework CSS)
- Alpine.js 3.4 (framework JavaScript léger)
- Vite 7.0 (build tool)

**Authentification et Autorisation** :
- Laravel Sanctum 4.2 (authentification API)
- Spatie Laravel Permission 6.22 (gestion des rôles et permissions)

**Services Externes** :
- Twilio SDK 8.8 (envoi de SMS)
- Laravel Mail (envoi d'emails)

**Documentation API** :
- L5-Swagger 9.0 (documentation Swagger/OpenAPI)

**Tests** :
- Pest PHP 4.1 (framework de tests)
- Pest Plugin Laravel 4.0

**Outils de Développement** :
- Laravel Breeze 2.3 (scaffolding d'authentification)
- Laravel Pint 1.24 (formatter de code)
- Laravel Sail 1.41 (environnement Docker)

### 4.2 Architecture Applicative

**Pattern Architectural** : MVC (Model-View-Controller)

**Structure des Dossiers** :
```
app/
├── Console/Commands/        # Commandes Artisan personnalisées
├── Http/
│   ├── Controllers/         # Contrôleurs (logique métier)
│   │   ├── Admin/          # Contrôleurs admin
│   │   └── Auth/           # Contrôleurs d'authentification
│   ├── Middleware/         # Middlewares (sécurité, rôles)
│   └── Requests/           # Form Requests (validation)
├── Models/                 # Modèles Eloquent (ORM)
├── Notifications/          # Classes de notifications
├── Policies/              # Policies (autorisations)
├── Providers/             # Service Providers
└── Services/              # Services métier (SMS, etc.)

database/
├── migrations/             # Migrations de base de données
├── seeders/               # Seeders (données de test)
└── factories/             # Factories (génération de données)

resources/
├── views/                 # Vues Blade
│   ├── admin/            # Vues admin
│   ├── auth/             # Vues authentification
│   ├── components/       # Composants réutilisables
│   └── layouts/          # Layouts de base
├── css/                  # Fichiers CSS
└── js/                   # Fichiers JavaScript

routes/
├── web.php               # Routes web
├── api.php              # Routes API
└── auth.php             # Routes d'authentification
```

### 4.3 Flux de Données

**Requête Web Typique** :
1. Route définie dans `routes/web.php`
2. Middleware vérifie l'authentification et les permissions
3. Contrôleur traite la requête
4. Modèle Eloquent interroge la base de données
5. Vue Blade génère le HTML
6. Réponse renvoyée au client

**Requête API Typique** :
1. Route définie dans `routes/api.php`
2. Middleware `auth:sanctum` vérifie le token
3. Contrôleur traite la requête
4. Modèle Eloquent interroge la base de données
5. Réponse JSON renvoyée

---

## 5. COMMUNICATION FRONTEND-BACKEND

### 5.1 Architecture de Communication

Agri Platform utilise une architecture hybride combinant :
- **Routes Web (Blade)** : Pour les pages HTML traditionnelles avec rendu serveur
- **Routes API (REST)** : Pour les endpoints JSON consommables par des clients externes
- **Requêtes AJAX** : Pour les interactions dynamiques sans rechargement de page

### 5.2 Types de Communication

#### 5.2.1 Communication Web Traditionnelle (Blade)

**Principe** : Le frontend envoie des formulaires HTML qui sont traités par le backend, puis une nouvelle page HTML est renvoyée.

**Flux Complet** :

1. **Requête Initiale (GET)**
   - Client envoie GET /products/create
   - Serveur : Contrôleur ProductController@create
   - Serveur : Vue Blade products/create.blade.php
   - Serveur : HTML complet renvoyé au client

2. **Soumission de Formulaire (POST/PUT/DELETE)**
   - Client envoie POST /products (avec données formulaire + token CSRF)
   - Serveur : Middleware vérifie CSRF token
   - Serveur : Middleware vérifie authentification (auth)
   - Serveur : Middleware vérifie rôle (role:producer)
   - Serveur : Contrôleur ProductController@store
   - Serveur : Validation des données (Form Request)
   - Serveur : Traitement métier (création produit)
   - Serveur : Redirection avec message flash
   - Client : Rechargement de page avec message de succès

**Exemple Concret - Création de Produit** :

```php
// Route dans web.php
Route::post('products', [ProductController::class, 'store'])
    ->middleware(['auth', 'suspended', 'role:producer'])
    ->name('products.store');

// Formulaire Blade
<form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
    @csrf
    <input type="text" name="title" required>
    <input type="number" name="price" required>
    <button type="submit">Créer</button>
</form>

// Contrôleur
public function store(Request $request)
{
    $validated = $request->validate([...]);
    $product = Product::create($validated);
    return redirect()->route('products.index')
        ->with('status', 'Produit créé avec succès');
}
```

**Avantages** :
- Simple et direct
- Pas besoin de JavaScript
- SEO-friendly (contenu dans le HTML)
- Gestion d'erreurs intégrée (validation Laravel)

**Inconvénients** :
- Rechargement de page à chaque action
- Moins interactif
- Plus de requêtes serveur

#### 5.2.2 Communication AJAX (Asynchrone)

**Principe** : Le frontend envoie des requêtes HTTP en arrière-plan via JavaScript, le backend répond en JSON, et le frontend met à jour l'interface sans recharger la page.

**Flux Complet** :

1. **Requête AJAX**
   - JavaScript envoie fetch('/api/search/products?q=riz')
   - Serveur : Route web ou API
   - Serveur : Contrôleur SearchController@autocompleteProducts
   - Serveur : Réponse JSON
   - JavaScript : Traitement de la réponse
   - JavaScript : Mise à jour du DOM

**Exemple Concret - Autocomplétion de Recherche** :

```javascript
// Frontend (Blade avec JavaScript)
const searchInput = document.getElementById('search');
const searchResults = document.getElementById('results');

searchInput.addEventListener('input', function() {
    const query = this.value.trim();
    
    if (query.length < 2) {
        searchResults.classList.add('hidden');
        return;
    }
    
    // Requête AJAX avec fetch API
    fetch(`{{ route('api.search.products') }}?q=${encodeURIComponent(query)}`)
        .then(response => response.json())  // Parse JSON
        .then(data => {
            // Mise à jour du DOM
            searchResults.innerHTML = '';
            data.forEach(item => {
                const div = document.createElement('div');
                div.textContent = item.title;
                searchResults.appendChild(div);
            });
            searchResults.classList.remove('hidden');
        })
        .catch(error => {
            console.error('Erreur:', error);
            searchResults.classList.add('hidden');
        });
});
```

```php
// Backend - Route dans web.php
Route::get('api/search/products', [SearchController::class, 'autocompleteProducts'])
    ->name('api.search.products');

// Contrôleur
public function autocompleteProducts(Request $request): JsonResponse
{
    $query = $request->input('q', '');
    $results = Product::where('title', 'like', "%{$query}%")
        ->limit(10)
        ->get()
        ->map(function ($product) {
            return [
                'id' => $product->id,
                'title' => $product->title,
                'price' => $product->price,
                'url' => route('products.show', $product),
            ];
        });
    
    return response()->json($results);
}
```

**Avantages** :
- Expérience utilisateur fluide (pas de rechargement)
- Mise à jour partielle de la page
- Interactions en temps réel
- Réduction de la charge serveur (pas de rendu HTML complet)

**Inconvénients** :
- Nécessite JavaScript
- Gestion d'erreurs plus complexe
- SEO limité pour le contenu dynamique

#### 5.2.3 Communication API REST

**Principe** : Le backend expose des endpoints JSON standardisés, consommables par n'importe quel client (web, mobile, tiers).

**Flux Complet** :

1. **Authentification**
   - Client envoie POST /api/login (email, password)
   - Serveur : Vérification credentials
   - Serveur : Génération token Sanctum
   - Serveur : Réponse JSON { token: "...", user: {...} }
   - Client : Stockage du token

2. **Requête Authentifiée**
   - Client envoie GET /api/products (Header: Authorization: Bearer {token})
   - Serveur : Middleware auth:sanctum vérifie le token
   - Serveur : Middleware role:producer vérifie le rôle
   - Serveur : Contrôleur ProductController@index
   - Serveur : Réponse JSON { data: [...] }

**Exemple Concret - API Produits** :

```php
// Route dans api.php
Route::middleware('auth:sanctum')->group(function () {
    Route::middleware('role:producer')->apiResource('products', ProductController::class);
});

// Contrôleur avec support API
public function index(Request $request)
{
    $products = Product::where('user_id', $request->user()->id)->get();
    
    // Détection du type de requête
    if ($request->wantsJson() || $request->is('api/*')) {
        return response()->json([
            'data' => $products,
            'count' => $products->count()
        ]);
    }
    
    // Sinon, rendu Blade classique
    return view('products.index', ['products' => $products]);
}
```

**Format de Réponse JSON** :

```json
{
  "data": [
    {
      "id": 1,
      "title": "Riz local",
      "price": 1500,
      "stock": 100,
      "created_at": "2025-11-04T10:00:00.000000Z"
    }
  ],
  "count": 1
}
```

**Format d'Erreur JSON** :

```json
{
  "message": "The given data was invalid.",
  "errors": {
    "title": ["The title field is required."],
    "price": ["The price must be a number."]
  }
}
```

### 5.3 Mécanismes d'Authentification

#### 5.3.1 Authentification Web (Session)

**Principe** : Utilisation de sessions PHP stockées côté serveur, identifiées par un cookie de session.

**Flux** :

1. **Connexion**
   - Client envoie POST /login (email, password)
   - Serveur : Vérification credentials
   - Serveur : Création session PHP
   - Serveur : Cookie de session envoyé au client
   - Serveur : Redirection vers /dashboard

2. **Requêtes Authentifiées**
   - Client envoie GET /products (Cookie: laravel_session=...)
   - Serveur : Middleware auth lit la session
   - Serveur : Récupération de l'utilisateur
   - Serveur : Traitement de la requête

**Configuration** :
- Driver de session : `file` ou `database` (config/session.php)
- Durée de session : 120 minutes (configurable)
- Cookie sécurisé : `httpOnly`, `secure` en production

#### 5.3.2 Authentification API (Token Sanctum)

**Principe** : Utilisation de tokens d'accès stockés en base de données, envoyés dans le header Authorization.

**Flux** :

1. **Génération de Token**
   ```php
   // Après connexion API
   $user = User::where('email', $request->email)->first();
   $token = $user->createToken('api-token')->plainTextToken;
   // Retourne: "1|randomTokenString..."
   ```

2. **Utilisation du Token**
   - Client envoie GET /api/products
   - Header: Authorization: Bearer 1|randomTokenString...
   - Serveur : Middleware auth:sanctum
   - Serveur : Recherche du token en base
   - Serveur : Vérification validité et expiration
   - Serveur : Récupération de l'utilisateur associé
   - Serveur : Traitement de la requête

**Stockage des Tokens** :
- Table : `personal_access_tokens`
- Champs : `tokenable_id`, `tokenable_type`, `name`, `token` (hashé), `abilities`, `last_used_at`, `expires_at`

### 5.4 Protection CSRF

#### 5.4.1 Principe

Le CSRF (Cross-Site Request Forgery) protège contre les attaques où un site malveillant fait exécuter des actions à un utilisateur authentifié.

#### 5.4.2 Implémentation

**Pour les Formulaires Web** :

```blade
<form method="POST" action="/products">
    @csrf  <!-- Génère un token CSRF -->
    <!-- Champs du formulaire -->
</form>
```

**Génération du Token** :
- Laravel génère un token unique par session
- Stocké en session : `_token`
- Inclus dans le formulaire : `<input type="hidden" name="_token" value="...">`

**Vérification** :
- Middleware `VerifyCsrfToken` vérifie automatiquement
- Compare le token de la requête avec celui de la session
- Rejette la requête si non valide

**Pour les Requêtes AJAX** :

```javascript
// Récupération du token depuis la meta tag
const token = document.querySelector('meta[name="csrf-token"]').content;

// Inclusion dans les headers
fetch('/products', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': token,
        'X-Requested-With': 'XMLHttpRequest'
    },
    body: JSON.stringify(data)
});
```

**Configuration** :
- Fichier : `app/Http/Middleware/VerifyCsrfToken.php`
- Exclusion possible pour certaines routes (API publiques)

### 5.5 Gestion des Erreurs et Validation

#### 5.5.1 Validation Côté Serveur

**Form Requests** :

```php
// app/Http/Requests/StoreProductRequest.php
class StoreProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
        ];
    }
    
    public function messages(): array
    {
        return [
            'title.required' => 'Le titre est obligatoire.',
            'price.numeric' => 'Le prix doit être un nombre.',
        ];
    }
}
```

**Utilisation dans le Contrôleur** :

```php
public function store(StoreProductRequest $request)
{
    // Les données sont déjà validées ici
    $validated = $request->validated();
    Product::create($validated);
    return redirect()->back()->with('status', 'Produit créé');
}
```

**Retour d'Erreurs pour Web** :

```php
// En cas d'erreur de validation
return redirect()->back()
    ->withErrors($validator)
    ->withInput();  // Pré-remplit les champs
```

**Affichage dans Blade** :

```blade
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<input type="text" name="title" value="{{ old('title') }}">
@error('title')
    <span class="error">{{ $message }}</span>
@enderror
```

**Retour d'Erreurs pour API** :

```php
// Réponse JSON standardisée
return response()->json([
    'message' => 'The given data was invalid.',
    'errors' => [
        'title' => ['The title field is required.'],
        'price' => ['The price must be a number.']
    ]
], 422);  // Code HTTP 422 Unprocessable Entity
```

#### 5.5.2 Validation Côté Client (JavaScript)

**Exemple avec Alpine.js** :

```html
<div x-data="{ title: '', errors: {} }">
    <input 
        type="text" 
        x-model="title"
        @blur="validateTitle()"
    >
    <span x-show="errors.title" x-text="errors.title"></span>
</div>

<script>
function validateTitle() {
    if (this.title.length < 3) {
        this.errors.title = 'Le titre doit faire au moins 3 caractères';
    } else {
        delete this.errors.title;
    }
}
</script>
```

### 5.6 Gestion des Fichiers (Upload)

#### 5.6.1 Upload via Formulaire Web

**Formulaire** :

```blade
<form method="POST" action="/images" enctype="multipart/form-data">
    @csrf
    <input type="file" name="images[]" multiple accept="image/*">
    <button type="submit">Uploader</button>
</form>
```

**Traitement Backend** :

```php
public function store(Request $request)
{
    $request->validate([
        'images' => ['required', 'array', 'max:10'],
        'images.*' => ['file', 'image', 'max:5120'],  // 5MB max
    ]);
    
    foreach ($request->file('images') as $file) {
        $path = $file->store('uploads', 'public');
        // $path = "uploads/filename.jpg"
        Image::create(['path' => $path]);
    }
    
    return back()->with('status', 'Images uploadées');
}
```

**Stockage** :
- Disque : `storage/app/public/uploads`
- Lien public : `storage/app/public` vers `public/storage` (symlink)
- URL accessible : `/storage/uploads/filename.jpg`

#### 5.6.2 Upload via AJAX (FormData)

**Frontend** :

```javascript
const formData = new FormData();
formData.append('images[]', fileInput.files[0]);
formData.append('imageable_type', 'product');
formData.append('imageable_id', productId);

fetch('/images', {
    method: 'POST',
    headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        'X-Requested-With': 'XMLHttpRequest'
        // Ne pas mettre 'Content-Type' pour FormData
    },
    body: formData
})
.then(response => response.json())
.then(data => {
    console.log('Images uploadées:', data);
})
.catch(error => {
    console.error('Erreur:', error);
});
```

**Backend** :

```php
public function store(Request $request)
{
    // Même traitement que pour le formulaire web
    // Laravel détecte automatiquement FormData
    $files = $request->file('images');
    // ...
    
    // Réponse JSON pour AJAX
    return response()->json([
        'message' => 'Images uploadées',
        'images' => $addedImages
    ]);
}
```

### 5.7 Sessions et Stockage Client

#### 5.7.1 Sessions Serveur (Laravel)

**Utilisation** :

```php
// Stockage
session(['cart' => $cart]);
// ou
$request->session()->put('cart', $cart);

// Récupération
$cart = session('cart');
// ou
$cart = $request->session()->get('cart');

// Suppression
session()->forget('cart');
// ou
$request->session()->forget('cart');
```

**Exemple - Panier** :

```php
// Ajout au panier
public function add(Product $product, Request $request)
{
    $cart = session('cart', []);
    $cart[$product->id] = ($cart[$product->id] ?? 0) + 1;
    session(['cart' => $cart]);
    return back();
}

// Affichage du panier
public function index()
{
    $cart = session('cart', []);
    $products = Product::whereIn('id', array_keys($cart))->get();
    return view('cart.index', compact('cart', 'products'));
}
```

#### 5.7.2 LocalStorage (JavaScript)

**Utilisation pour données temporaires** :

```javascript
// Stockage
localStorage.setItem('cart', JSON.stringify(cartData));

// Récupération
const cart = JSON.parse(localStorage.getItem('cart') || '{}');

// Suppression
localStorage.removeItem('cart');
```

### 5.8 Messages Flash et Notifications

#### 5.8.1 Messages Flash (Session)

**Backend** :

```php
return redirect()->route('products.index')
    ->with('status', 'Produit créé avec succès')
    ->with('error', 'Une erreur est survenue');
```

**Frontend (Blade)** :

```blade
@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
```

#### 5.8.2 Notifications en Temps Réel

**Système de Notifications Laravel** :

```php
// Création d'une notification
$user->notify(new OrderPaid($order));

// Envoi par email et stockage en base
class OrderPaid extends Notification
{
    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }
    
    public function toArray($notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'message' => 'Votre commande a été payée'
        ];
    }
}
```

**Affichage dans le Frontend** :

```php
// Contrôleur
$notifications = Auth::user()->unreadNotifications;

// Vue Blade
@foreach($notifications as $notification)
    <div class="notification">
        {{ $notification->data['message'] }}
    </div>
@endforeach
```

### 5.9 Middleware et Filtrage des Requêtes

#### 5.9.1 Chaîne de Middleware

**Ordre d'Exécution** :

1. TrustProxies (configuration proxy)
2. HandleCors (CORS pour API)
3. PreventRequestsDuringMaintenance (mode maintenance)
4. ValidatePostSize (taille POST)
5. TrimStrings (nettoyage strings)
6. ConvertEmptyStringsToNull
7. Authenticate (vérification auth)
8. CheckSuspended (vérification suspension)
9. RoleMiddleware (vérification rôle)
10. Contrôleur
11. Réponse HTTP

#### 5.9.2 Exemple de Middleware Personnalisé

```php
// app/Http/Middleware/CheckSuspended.php
class CheckSuspended
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->is_suspended) {
            Auth::logout();
            return redirect()->route('login')
                ->withErrors(['email' => 'Votre compte a été suspendu.']);
        }
        
        return $next($request);
    }
}
```

**Application** :

```php
// routes/web.php
Route::middleware(['auth', 'suspended'])->group(function () {
    // Routes protégées
});
```

### 5.10 Optimisations et Performance

#### 5.10.1 Eager Loading (Préchargement)

**Problème N+1** :

```php
// Mauvais : N+1 requêtes
$products = Product::all();
foreach ($products as $product) {
    echo $product->user->name;  // 1 requête par produit
    echo $product->category->name;  // 1 requête par produit
}
// Total : 1 + N + N = 2N+1 requêtes
```

**Solution Eager Loading** :

```php
// Bon : 3 requêtes seulement
$products = Product::with(['user', 'category', 'images'])->get();
foreach ($products as $product) {
    echo $product->user->name;  // Déjà chargé
    echo $product->category->name;  // Déjà chargé
}
// Total : 3 requêtes (1 produits + 1 users + 1 categories)
```

#### 5.10.2 Cache des Réponses

**Cache de Route** :

```php
// Contrôleur
public function index()
{
    $products = Cache::remember('products.index', 3600, function () {
        return Product::with('category')->get();
    });
    
    return view('products.index', compact('products'));
}
```

**Cache HTTP** :

```php
return response()->view('products.index', $data)
    ->header('Cache-Control', 'public, max-age=3600');
```

#### 5.10.3 Pagination

**Backend** :

```php
$products = Product::paginate(20);
// Retourne : LengthAwarePaginator avec méthodes links(), etc.
```

**Frontend (Blade)** :

```blade
@foreach($products as $product)
    <!-- Affichage produit -->
@endforeach

{{ $products->links() }}  <!-- Liens de pagination -->
```

**API** :

```php
$products = Product::paginate(20);
return response()->json($products);
// Retourne JSON avec meta (current_page, total, etc.)
```

### 5.11 Résumé des Mécanismes

**Communication Web (Blade)** :
- Formulaires HTML avec POST/PUT/DELETE
- Sessions PHP pour authentification
- Token CSRF pour sécurité
- Redirections avec messages flash
- Rendu HTML complet

**Communication AJAX** :
- fetch() API pour requêtes asynchrones
- Réponses JSON
- Mise à jour DOM sans rechargement
- Headers CSRF pour sécurité

**Communication API REST** :
- Endpoints JSON standardisés
- Tokens Sanctum pour authentification
- Format de réponse cohérent
- Codes HTTP appropriés
- Documentation Swagger

**Stockage** :
- Sessions serveur (panier, données temporaires)
- LocalStorage client (préférences)
- Base de données (données persistantes)
- Fichiers (uploads)

---

## 6. FRAMEWORKS ET OUTILS UTILISES

### 6.1 Laravel Framework 12.0

**Objectif** : Framework PHP principal pour le développement backend.

**Impact sur le Projet** :
- **Productivité** : Laravel fournit une structure solide et des outils intégrés (Eloquent ORM, migrations, seeders, queues, etc.)
- **Sécurité** : Protection intégrée contre les vulnérabilités courantes (CSRF, XSS, SQL injection)
- **Maintenabilité** : Architecture MVC claire, code organisé et conventions établies
- **Écosystème** : Large communauté et packages disponibles (Spatie, Sanctum, etc.)
- **Performance** : Cache intégré, optimisation des requêtes, lazy loading

**Fonctionnalités Utilisées** :
- Eloquent ORM pour les interactions base de données
- Migrations pour la gestion du schéma
- Seeders pour les données de test
- Queues pour les tâches asynchrones (notifications)
- Events et Listeners pour la découplage du code
- Validation intégrée avec Form Requests
- Middleware pour la sécurité et les permissions

### 6.2 Laravel Sanctum 4.2

**Objectif** : Authentification API légère et sécurisée.

**Impact sur le Projet** :
- **Sécurité API** : Génération et validation de tokens pour les requêtes API
- **Flexibilité** : Support de l'authentification par session (web) et par token (API)
- **Simplicité** : Configuration minimale, intégration native avec Laravel
- **Performance** : Plus léger que Passport, adapté aux SPAs et applications mobiles

**Utilisation** :
- Protection des routes API avec `auth:sanctum`
- Génération de tokens pour les clients API
- Révocation de tokens
- Support des capacités (scopes) si nécessaire

### 6.3 Spatie Laravel Permission 6.22

**Objectif** : Gestion avancée des rôles et permissions.

**Impact sur le Projet** :
- **Flexibilité** : Système de rôles et permissions granulaire
- **Sécurité** : Vérification des permissions au niveau middleware et contrôleur
- **Maintenabilité** : Gestion centralisée des rôles, facile à étendre
- **Performance** : Cache des permissions pour optimiser les vérifications

**Utilisation** :
- 4 rôles principaux : admin, producer, equipment_owner, buyer
- Middleware `role:` pour protéger les routes
- Policies pour l'autorisation au niveau des ressources
- Support des utilisateurs multi-rôles

### 6.4 Tailwind CSS 3.1

**Objectif** : Framework CSS utility-first pour le styling.

**Impact sur le Projet** :
- **Productivité** : Développement rapide avec classes utilitaires
- **Cohérence** : Design system unifié grâce aux utilitaires
- **Performance** : Purge CSS automatique, fichiers CSS optimisés
- **Maintenabilité** : Pas de CSS personnalisé dispersé, tout dans les classes
- **Responsive** : Classes responsive intégrées (sm:, md:, lg:, etc.)

**Configuration** :
- Thème personnalisé avec couleurs AgriLink (marron #5c4033, vert #4CAF50, beige #d0c9c0)
- Plugin @tailwindcss/forms pour les formulaires
- Purge CSS configuré pour optimiser la taille

### 6.5 Alpine.js 3.4

**Objectif** : Framework JavaScript léger pour l'interactivité.

**Impact sur le Projet** :
- **Légèreté** : Seulement 15KB minifié, pas de dépendances
- **Simplicité** : Syntaxe déclarative, intégration facile avec Blade
- **Performance** : Pas de virtual DOM, manipulation directe du DOM
- **Maintenabilité** : Code JavaScript minimal et lisible

**Utilisation** :
- Gestion d'état local dans les composants
- Interactions utilisateur (modales, dropdowns, formulaires dynamiques)
- Drag & drop pour la réorganisation d'images
- Validation côté client

### 6.6 Vite 7.0

**Objectif** : Build tool moderne pour les assets frontend.

**Impact sur le Projet** :
- **Performance** : HMR (Hot Module Replacement) ultra-rapide en développement
- **Optimisation** : Bundling et minification automatiques en production
- **Modernité** : Support natif d'ES modules, PostCSS, etc.
- **Intégration Laravel** : Plugin officiel Laravel Vite

**Configuration** :
- Compilation de CSS (Tailwind) et JavaScript (Alpine.js)
- Support des assets Laravel (Blade directives @vite)
- Configuration de build optimisée pour la production

### 6.7 L5-Swagger 9.0

**Objectif** : Génération automatique de documentation API Swagger/OpenAPI.

**Impact sur le Projet** :
- **Documentation** : Documentation API interactive et à jour
- **Développement** : Facilite l'intégration pour les développeurs tiers
- **Tests** : Interface Swagger UI pour tester les endpoints
- **Standardisation** : Format OpenAPI standard de l'industrie

**Utilisation** :
- Annotations dans les contrôleurs pour documenter les endpoints
- Génération automatique via `php artisan l5-swagger:generate`
- Interface accessible à `/api/documentation`

### 6.8 Twilio SDK 8.8

**Objectif** : Service d'envoi de SMS pour la vérification téléphone.

**Impact sur le Projet** :
- **Sécurité** : Vérification des numéros de téléphone par SMS
- **Fiabilité** : Service professionnel avec haute disponibilité
- **International** : Support des numéros internationaux (format +221 pour Sénégal)
- **Flexibilité** : Mode développement avec logging si non configuré

**Utilisation** :
- Service `SmsService` pour l'envoi de codes de vérification
- Formatage automatique des numéros sénégalais
- Gestion gracieuse des erreurs
- Logging en mode développement

### 6.9 Pest PHP 4.1

**Objectif** : Framework de tests moderne et expressif.

**Impact sur le Projet** :
- **Qualité** : Tests automatisés pour garantir le bon fonctionnement
- **Expressivité** : Syntaxe claire et lisible (it(), expect(), etc.)
- **Productivité** : Tests rapides à écrire et maintenir
- **Intégration** : Plugin Laravel pour faciliter les tests d'application

**Types de Tests** :
- Tests unitaires (modèles, services)
- Tests fonctionnels (routes, contrôleurs)
- Tests d'intégration (flux complets)

### 6.10 Laravel Breeze 2.3

**Objectif** : Scaffolding d'authentification minimaliste.

**Impact sur le Projet** :
- **Rapidité** : Authentification complète générée rapidement
- **Simplicité** : Code minimal, facile à personnaliser
- **Sécurité** : Implémentation sécurisée par défaut (hashage mots de passe, CSRF, etc.)
- **Flexibilité** : Support Blade (choisi) ou API/SPA

**Fonctionnalités Incluses** :
- Inscription, connexion, déconnexion
- Vérification d'email
- Réinitialisation de mot de passe
- Protection des routes

### 6.11 Docker et Laravel Sail 1.41

**Objectif** : Environnement de développement containerisé.

**Impact sur le Projet** :
- **Reproductibilité** : Environnement identique pour tous les développeurs
- **Simplicité** : Pas besoin d'installer PHP, MySQL, etc. localement
- **Isolation** : Pas de conflits avec les autres projets
- **Production** : Dockerfile.prod pour le déploiement

**Configuration** :
- `compose.yaml` pour le développement (Sail)
- `docker-compose.prod.yml` pour la production
- `Dockerfile.prod` pour l'image de production

---

## 6. FONCTIONNALITES DETAILLEES

### 6.1 Authentification et Gestion des Comptes

#### 6.1.1 Inscription
- Formulaire d'inscription avec validation
- Sélection du rôle (buyer, producer, equipment_owner)
- Vérification d'email obligatoire
- Attribution automatique du rôle sélectionné
- Connexion automatique après inscription

#### 6.1.2 Connexion
- Authentification par email/mot de passe
- Protection contre le brute force (rate limiting)
- Vérification du statut du compte (suspendu ou actif)
- Régénération de session pour sécurité
- "Se souvenir de moi" optionnel

#### 6.1.3 Vérification Email
- Envoi automatique d'email de vérification à l'inscription
- Lien de vérification unique et sécurisé
- Redirection vers page de vérification si email non vérifié
- Possibilité de renvoyer l'email de vérification

#### 6.1.4 Réinitialisation de Mot de Passe
- Demande de réinitialisation par email
- Lien sécurisé avec token temporaire
- Formulaire de nouveau mot de passe
- Validation de la force du mot de passe

#### 6.1.5 Profil Utilisateur
- Édition des informations personnelles
- Upload de photo de profil
- Vérification de téléphone par SMS (optionnel)
- Upload de CNI (recto et verso) pour vérification
- Gestion des adresses (région, ville, adresse complète)
- Informations spécifiques par rôle (nom de ferme, taille de flotte, etc.)

### 6.2 Gestion des Produits (Producteurs)

#### 6.2.1 Création de Produit
- Formulaire avec validation complète
- Sélection de catégorie
- Définition du titre, description, prix
- Gestion du stock disponible
- Unité de tarification (kg, tonne, sac, etc.)
- Activation/désactivation du produit

#### 6.2.2 Gestion des Images
- Upload de fichiers (jusqu'à 10 images)
- Ajout par URL (jusqu'à 10 images)
- Support mixte (fichiers + URLs)
- Sélection de l'image principale
- Réorganisation par drag & drop
- Suppression d'images
- Validation des formats (jpg, png, webp)
- Validation de la taille (max 5MB par fichier)

#### 6.2.3 Modification et Suppression
- Édition complète des informations
- Mise à jour des images
- Suppression avec confirmation
- Soft delete (récupération possible)

#### 6.2.4 Liste et Recherche
- Affichage de tous les produits du producteur
- Filtrage par catégorie
- Recherche par titre/description
- Pagination
- Tri par date, prix, stock

### 6.3 Gestion des Equipements (Propriétaires)

#### 6.3.1 Création d'Equipement
- Formulaire similaire aux produits
- Tarif journalier de location
- Localisation de l'équipement
- Statut de disponibilité
- Unité de tarification (jour, semaine, mois)
- Activation/désactivation

#### 6.3.2 Gestion des Images
- Même système que pour les produits
- Upload fichiers ou URLs
- Jusqu'à 10 images par équipement

#### 6.3.3 Gestion des Locations
- Consultation des demandes de location
- Approbation ou rejet des demandes
- Modification du statut (pending, approved, rejected, completed)
- Suivi des locations actives

### 6.4 Panier et Commandes (Acheteurs)

#### 6.4.1 Panier
- Ajout de produits au panier
- Affichage des produits avec quantités
- Modification des quantités
- Suppression de produits
- Calcul automatique du total
- Persistance en session

#### 6.4.2 Passage de Commande
- Validation du panier
- Création de la commande
- Calcul du total
- Statut initial : "pending"
- Génération d'un numéro de commande unique

#### 6.4.3 Paiement
- Choix du mode de paiement :
  - En ligne (simulé)
  - Espèces (avec détails de remise)
- Validation du paiement
- Mise à jour du statut : "paid"
- Notification au client
- Réduction du stock des produits

#### 6.4.4 Suivi des Commandes
- Liste de toutes les commandes de l'acheteur
- Détails de chaque commande
- Statuts : pending, paid, cancelled, completed
- Historique des paiements
- Demande d'annulation (si statut le permet)

#### 6.4.5 Annulation de Commande
- Demande d'annulation avec raison
- Statut : "cancellation_requested"
- Validation par l'administrateur
- Notification de l'approbation/rejet
- Remise en stock si annulation approuvée

### 6.5 Location d'Equipements (Acheteurs)

#### 6.5.1 Demande de Location
- Sélection d'un équipement disponible
- Choix des dates (début et fin)
- Calcul automatique du total
- Création de la demande
- Statut initial : "pending"
- Notification au propriétaire

#### 6.5.2 Gestion par le Propriétaire
- Consultation des demandes
- Approbation ou rejet
- Modification du statut
- Notification au locataire

#### 6.5.3 Suivi des Locations
- Liste des locations pour le locataire
- Détails de chaque location
- Statuts : pending, approved, rejected, completed
- Historique

### 6.6 Administration

#### 6.6.1 Dashboard Administrateur
- Statistiques globales :
  - Nombre total d'utilisateurs
  - Utilisateurs actifs/suspendus
  - CNI en attente de vérification
  - Demandes de réactivation
  - Commandes récentes
- Actions rapides
- Graphiques et indicateurs

#### 6.6.2 Gestion des Utilisateurs
- Liste de tous les utilisateurs avec pagination
- Recherche par nom ou email
- Filtres par rôle, statut
- Création d'utilisateurs
- Modification des informations
- Modification des rôles
- Suppression d'utilisateurs
- Suspension/réactivation de comptes

#### 6.6.3 Vérification CNI
- Liste des utilisateurs avec CNI uploadée
- Consultation des documents (recto et verso)
- Approbation avec notes optionnelles
- Rejet avec raison obligatoire
- Notification automatique à l'utilisateur
- Historique des vérifications

#### 6.6.4 Gestion des Suspensions
- Consultation des demandes de réactivation
- Approbation avec réponse personnalisée
- Rejet avec raison
- Notification automatique
- Historique

#### 6.6.5 Gestion des Annulations
- Liste des demandes d'annulation de commandes
- Consultation des détails et raison
- Approbation (remise en stock automatique)
- Rejet avec raison
- Notification au client
- Historique

### 6.7 Recherche et Navigation

#### 6.7.1 Recherche de Produits
- Recherche par titre, description
- Filtrage par catégorie
- Filtrage par prix
- Filtrage par localisation
- Tri par pertinence, prix, date
- Pagination des résultats

#### 6.7.2 Recherche d'Equipements
- Même système que pour les produits
- Filtrage par disponibilité
- Filtrage par tarif journalier
- Filtrage par localisation

#### 6.7.3 Autocomplétion
- API d'autocomplétion pour produits
- API d'autocomplétion pour équipements
- API d'autocomplétion pour localisations
- Utilisation dans les formulaires de recherche

### 6.8 Notifications

#### 6.8.1 Types de Notifications
- **OrderPaid** : Commande payée (acheteur)
- **RentalStatusChanged** : Statut de location modifié (locataire et propriétaire)
- **CniVerificationStatus** : Statut de vérification CNI (utilisateur)
- **SuspensionStatusChanged** : Statut de suspension modifié (utilisateur)
- **OrderCancellationApproved** : Annulation approuvée (acheteur)
- **OrderCancellationRejected** : Annulation rejetée (acheteur)
- **OrderCancellationRequested** : Demande d'annulation créée (admin)
- **CashPaymentRequested** : Paiement espèces demandé (admin)

#### 6.8.2 Canaux de Notification
- Email (toutes les notifications)
- Base de données (stockage pour affichage dans l'interface)
- SMS (optionnel, pour vérification téléphone)

#### 6.8.3 Gestion des Notifications
- Affichage dans le dashboard
- Marquage comme lu/non lu
- Suppression
- Historique complet

---

## 7. MODELE DE DONNEES

### 7.1 Entités Principales

#### 7.1.1 Users (Utilisateurs)
**Champs principaux** :
- id, name, email, password
- phone, phone_verified, phone_verification_code
- cni_number, cni_recto_path, cni_verso_path, cni_verified, cni_verified_at
- region, ville, address_line1, address_line2, postal_code, country
- farm_name, farm_type (pour producteurs)
- company_name, siret, fleet_size (pour propriétaires)
- is_suspended
- email_verified_at
- timestamps

**Relations** :
- hasMany : products, equipment, orders (buyer_id), rentals (renter_id)
- belongsToMany : roles (via Spatie Permission)

#### 7.1.2 Products (Produits)
**Champs principaux** :
- id, user_id, category_id
- title, description, price, stock
- pricing_unit (kg, tonne, sac, etc.)
- is_active
- deleted_at (soft delete)
- timestamps

**Relations** :
- belongsTo : user, category
- morphMany : images

#### 7.1.3 Equipment (Equipements)
**Champs principaux** :
- id, user_id, category_id
- title, description, daily_rate
- location
- pricing_unit
- is_available, is_active
- deleted_at (soft delete)
- timestamps

**Relations** :
- belongsTo : user, category
- morphMany : images
- hasMany : rentals

#### 7.1.4 Orders (Commandes)
**Champs principaux** :
- id, buyer_id
- status (pending, paid, cancelled, completed, pending_payment, pending_validation)
- total
- payment_method (online, cash)
- cash_payment_details
- paid_at
- cancellation_requested, cancellation_reason, cancellation_requested_at
- timestamps

**Relations** :
- belongsTo : buyer (User)
- hasMany : items

#### 7.1.5 OrderItems (Articles de Commande)
**Champs principaux** :
- id, order_id, product_id
- quantity, price, total
- variant (optionnel)
- timestamps

**Relations** :
- belongsTo : order, product

#### 7.1.6 Rentals (Locations)
**Champs principaux** :
- id, equipment_id, renter_id
- start_date, end_date
- status (pending, approved, rejected, completed)
- total
- timestamps

**Relations** :
- belongsTo : equipment, renter (User)

#### 7.1.7 Categories (Catégories)
**Champs principaux** :
- id, name, slug, type (product, equipment)
- parent_id (pour hiérarchie)
- timestamps

**Relations** :
- hasMany : products, equipment, children
- belongsTo : parent

#### 7.1.8 Images (Images)
**Champs principaux** :
- id, path, is_primary, sort_order
- source_type (file, url)
- imageable_id, imageable_type (polymorphique)
- timestamps

**Relations** :
- morphTo : imageable (Product ou Equipment)

#### 7.1.9 SuspensionRequests (Demandes de Suspension/Réactivation)
**Champs principaux** :
- id, user_id
- reason, status (pending, approved, rejected)
- admin_response
- timestamps

**Relations** :
- belongsTo : user

### 7.2 Tables Système

#### 7.2.1 Roles et Permissions (Spatie)
- roles : id, name, guard_name
- permissions : id, name, guard_name
- model_has_roles : role_id, model_id, model_type
- model_has_permissions : permission_id, model_id, model_type
- role_has_permissions : permission_id, role_id

#### 7.2.2 Notifications
- id (UUID), type, notifiable_id, notifiable_type
- data (JSON), read_at, timestamps

#### 7.2.3 Personal Access Tokens (Sanctum)
- id, tokenable_id, tokenable_type
- name, token, abilities, last_used_at, expires_at
- timestamps

#### 7.2.4 Jobs (Queues)
- id, queue, payload, attempts, reserved_at, available_at
- created_at

#### 7.2.5 Cache
- key, value, expiration

### 7.3 Diagramme de Relations

**Relations Principales** :
- User 1--N Products
- User 1--N Equipment
- User 1--N Orders (en tant que buyer)
- User 1--N Rentals (en tant que renter)
- Product N--1 Category
- Equipment N--1 Category
- Order 1--N OrderItems
- OrderItem N--1 Product
- Equipment 1--N Rentals
- Product/Equipment 1--N Images (polymorphique)
- User N--N Roles (via Spatie)

### 7.4 Contraintes et Intégrité Référentielle

**Clés Étrangères avec Cascade** :
- `products.user_id` vers `users.id` (CASCADE ON DELETE)
- `products.category_id` vers `categories.id` (NULL ON DELETE)
- `equipment.user_id` vers `users.id` (CASCADE ON DELETE)
- `equipment.category_id` vers `categories.id` (NULL ON DELETE)
- `orders.buyer_id` vers `users.id` (CASCADE ON DELETE)
- `order_items.order_id` vers `orders.id` (CASCADE ON DELETE)
- `order_items.product_id` vers `products.id` (CASCADE ON DELETE)
- `rentals.equipment_id` vers `equipment.id` (CASCADE ON DELETE)
- `rentals.renter_id` vers `users.id` (CASCADE ON DELETE)
- `categories.parent_id` vers `categories.id` (NULL ON DELETE)

**Index et Optimisations** :
- Index sur `users.email` (unique)
- Index sur `products.user_id`
- Index sur `products.category_id`
- Index sur `equipment.user_id`
- Index sur `orders.buyer_id`
- Index sur `order_items.order_id`
- Index sur `rentals.equipment_id`
- Index sur `rentals.renter_id`
- Index sur `images.imageable_id` et `imageable_type` (polymorphique)

**Soft Deletes** :
- Tables avec soft delete : `products`, `equipment`
- Permet la récupération des données supprimées
- Colonne `deleted_at` (timestamp nullable)

### 7.5 Types de Données et Contraintes

**Types de Colonnes Principaux** :
- `id` : BIGINT UNSIGNED (auto-increment, primary key)
- `user_id`, `category_id`, etc. : BIGINT UNSIGNED (foreign keys)
- `title`, `name` : VARCHAR(255)
- `description` : TEXT (nullable)
- `price`, `daily_rate`, `total` : DECIMAL(12, 2)
- `stock`, `quantity` : UNSIGNED INTEGER
- `is_active`, `is_available`, `is_suspended` : BOOLEAN (default false)
- `status` : ENUM (valeurs prédéfinies)
- `timestamps` : TIMESTAMP (created_at, updated_at)
- `deleted_at` : TIMESTAMP (nullable, pour soft deletes)

**Contraintes de Validation** :
- Prix et montants : DECIMAL(12, 2) pour précision financière
- Quantités : UNSIGNED INTEGER (pas de valeurs négatives)
- Dates : Validation des dates de location (start_date < end_date)
- Statuts : ENUM pour garantir les valeurs valides uniquement

---

## 8. SECURITE ET AUTHENTIFICATION

### 8.1 Authentification

#### 8.1.1 Web (Session)
- Authentification par session Laravel
- Protection CSRF sur tous les formulaires
- Régénération de session après connexion
- "Se souvenir de moi" avec cookie sécurisé
- Rate limiting sur les tentatives de connexion

#### 8.1.2 API (Token)
- Authentification par token Sanctum
- Génération de token à la connexion
- Révocation de tokens
- Expiration optionnelle des tokens
- Middleware `auth:sanctum` sur les routes API

### 8.2 Autorisation

#### 8.2.1 Rôles
- 4 rôles principaux : admin, producer, equipment_owner, buyer
- Attribution à l'inscription
- Modification par admin uniquement
- Support multi-rôles

#### 8.2.2 Middleware de Rôles
- `role:admin` : Accès administrateur
- `role:producer` : Accès producteur
- `role:equipment_owner` : Accès propriétaire
- `role:buyer` : Accès acheteur
- Vérification automatique sur les routes

#### 8.2.3 Policies
- **ProductPolicy** : Vérifie que le producteur modifie ses propres produits
- **EquipmentPolicy** : Vérifie que le propriétaire modifie ses propres équipements
- **OrderPolicy** : Vérifie que l'acheteur consulte ses propres commandes
- **RentalPolicy** : Vérifie les permissions sur les locations

#### 8.2.4 Protection des Comptes Suspendus
- Middleware `CheckSuspended`
- Blocage de l'accès aux routes authentifiées
- Déconnexion automatique
- Message d'erreur explicite

### 8.3 Validation et Sécurité des Données

#### 8.3.1 Form Requests
- Validation centralisée dans les Form Requests
- Règles de validation strictes
- Messages d'erreur personnalisés
- Sanitization des entrées

#### 8.3.2 Protection CSRF
- Token CSRF sur tous les formulaires
- Vérification automatique par Laravel
- Exclusion pour les routes API (utilisent tokens)

#### 8.3.3 Protection XSS
- Échappement automatique dans Blade
- Validation des URLs
- Sanitization des uploads

#### 8.3.4 Protection SQL Injection
- Eloquent ORM utilise les requêtes préparées
- Pas de requêtes SQL brutes
- Validation des paramètres

#### 8.3.5 Upload de Fichiers
- Validation des types MIME
- Limitation de taille (5MB par fichier)
- Stockage sécurisé (hors webroot pour fichiers sensibles)
- Noms de fichiers sécurisés
- Validation des URLs pour les images externes

### 8.4 Vérification d'Identité

#### 8.4.1 Vérification Email
- Obligatoire à l'inscription
- Lien unique et temporaire
- Expiration du lien après utilisation

#### 8.4.2 Vérification Téléphone (Optionnel)
- Envoi de code SMS via Twilio
- Code à 6 chiffres
- Expiration après 10 minutes
- Limitation des tentatives

#### 8.4.3 Vérification CNI
- Upload de recto et verso
- Validation par administrateur
- Notification de l'approbation/rejet
- Historique des vérifications

### 8.5 Sécurité des Mots de Passe

- Hashage avec bcrypt (par défaut Laravel)
- Validation de la force (min 8 caractères)
- Confirmation de mot de passe
- Pas de stockage en clair
- Réinitialisation sécurisée

---

## 9. API REST ET DOCUMENTATION

### 9.1 Architecture API

**Base URL** : `/api`

**Authentification** : Token Sanctum (header `Authorization: Bearer {token}`)

**Format** : JSON

**Versioning** : Non implémenté (peut être ajouté si nécessaire)

### 9.2 Endpoints Principaux

#### 9.2.1 Authentification
- `POST /api/login` : Connexion (retourne token)
- `POST /api/logout` : Déconnexion (révoque token)
- `GET /api/user` : Informations utilisateur connecté

#### 9.2.2 Produits (Producteurs)
- `GET /api/products` : Liste des produits du producteur
- `POST /api/products` : Créer un produit
- `GET /api/products/{id}` : Détails d'un produit
- `PUT /api/products/{id}` : Modifier un produit
- `DELETE /api/products/{id}` : Supprimer un produit

#### 9.2.3 Equipements (Propriétaires)
- `GET /api/equipment` : Liste des équipements du propriétaire
- `POST /api/equipment` : Créer un équipement
- `GET /api/equipment/{id}` : Détails d'un équipement
- `PUT /api/equipment/{id}` : Modifier un équipement
- `DELETE /api/equipment/{id}` : Supprimer un équipement

#### 9.2.4 Commandes (Acheteurs)
- `GET /api/orders` : Liste des commandes de l'acheteur
- `GET /api/orders/{id}` : Détails d'une commande

#### 9.2.5 Locations
- `POST /api/equipment/{id}/rent` : Demander une location
- `GET /api/rentals` : Liste des locations

#### 9.2.6 Demandes de Suspension
- `POST /api/suspension-requests` : Créer une demande

### 9.3 Documentation Swagger

**Accès** : `/api/documentation`

**Génération** :
```bash
php artisan l5-swagger:generate
```

**Fonctionnalités** :
- Documentation interactive
- Test des endpoints directement depuis l'interface
- Exemples de requêtes/réponses
- Description des paramètres
- Codes de réponse HTTP

**Annotations** :
- `@OA\Get`, `@OA\Post`, etc. pour les méthodes
- `@OA\Parameter` pour les paramètres
- `@OA\Response` pour les réponses
- `@OA\Schema` pour les modèles

### 9.4 Codes de Réponse HTTP

- `200 OK` : Succès
- `201 Created` : Ressource créée
- `400 Bad Request` : Requête invalide
- `401 Unauthorized` : Non authentifié
- `403 Forbidden` : Non autorisé (mauvais rôle)
- `404 Not Found` : Ressource non trouvée
- `422 Unprocessable Entity` : Erreur de validation
- `500 Internal Server Error` : Erreur serveur

### 9.5 Format des Réponses

**Succès** :
```json
{
  "data": { ... },
  "message": "Succès"
}
```

**Erreur** :
```json
{
  "message": "Message d'erreur",
  "errors": {
    "field": ["Erreur de validation"]
  }
}
```

### 10.6 Exemples Complets de Requêtes/Réponses

#### 10.6.1 Authentification API

**Requête** :
```http
POST /api/login HTTP/1.1
Content-Type: application/json

{
  "email": "producer@example.com",
  "password": "password123"
}
```

**Réponse Succès (200)** :
```json
{
  "token": "1|abcdef1234567890...",
  "user": {
    "id": 1,
    "name": "Producteur Test",
    "email": "producer@example.com",
    "roles": ["producer"]
  }
}
```

**Réponse Erreur (401)** :
```json
{
  "message": "Invalid credentials"
}
```

#### 10.6.2 Liste des Produits (GET)

**Requête** :
```http
GET /api/products HTTP/1.1
Authorization: Bearer 1|abcdef1234567890...
```

**Réponse Succès (200)** :
```json
{
  "data": [
    {
      "id": 1,
      "user_id": 1,
      "category_id": 2,
      "title": "Riz local",
      "description": "Riz de qualité supérieure",
      "price": "1500.00",
      "stock": 100,
      "pricing_unit": "kg",
      "is_active": true,
      "created_at": "2025-11-04T10:00:00.000000Z",
      "updated_at": "2025-11-04T10:00:00.000000Z",
      "category": {
        "id": 2,
        "name": "Céréales",
        "slug": "cereales"
      },
      "images": [
        {
          "id": 1,
          "path": "uploads/riz.jpg",
          "is_primary": true,
          "sort_order": 0,
          "url": "/storage/uploads/riz.jpg"
        }
      ]
    }
  ],
  "count": 1
}
```

#### 10.6.3 Création de Produit (POST)

**Requête** :
```http
POST /api/products HTTP/1.1
Authorization: Bearer 1|abcdef1234567890...
Content-Type: application/json

{
  "title": "Maïs bio",
  "description": "Maïs biologique certifié",
  "price": 2000,
  "stock": 50,
  "category_id": 2,
  "pricing_unit": "kg",
  "is_active": true
}
```

**Réponse Succès (201)** :
```json
{
  "data": {
    "id": 2,
    "user_id": 1,
    "category_id": 2,
    "title": "Maïs bio",
    "description": "Maïs biologique certifié",
    "price": "2000.00",
    "stock": 50,
    "pricing_unit": "kg",
    "is_active": true,
    "created_at": "2025-11-04T11:00:00.000000Z",
    "updated_at": "2025-11-04T11:00:00.000000Z"
  },
  "message": "Produit créé avec succès"
}
```

**Réponse Erreur Validation (422)** :
```json
{
  "message": "The given data was invalid.",
  "errors": {
    "title": ["The title field is required."],
    "price": ["The price must be a number."],
    "stock": ["The stock must be an integer."]
  }
}
```

#### 10.6.4 Mise à Jour de Produit (PUT)

**Requête** :
```http
PUT /api/products/2 HTTP/1.1
Authorization: Bearer 1|abcdef1234567890...
Content-Type: application/json

{
  "title": "Maïs bio premium",
  "price": 2200,
  "stock": 45
}
```

**Réponse Succès (200)** :
```json
{
  "data": {
    "id": 2,
    "title": "Maïs bio premium",
    "price": "2200.00",
    "stock": 45,
    "updated_at": "2025-11-04T12:00:00.000000Z"
  },
  "message": "Produit mis à jour"
}
```

#### 10.6.5 Suppression de Produit (DELETE)

**Requête** :
```http
DELETE /api/products/2 HTTP/1.1
Authorization: Bearer 1|abcdef1234567890...
```

**Réponse Succès (200)** :
```json
{
  "message": "Produit supprimé avec succès"
}
```

**Réponse Erreur Autorisation (403)** :
```json
{
  "message": "This action is unauthorized."
}
```

### 10.7 Codes HTTP et Gestion des Erreurs

#### 10.7.1 Codes de Statut HTTP Utilisés

**Succès** :
- `200 OK` : Requête réussie (GET, PUT, PATCH)
- `201 Created` : Ressource créée avec succès (POST)
- `204 No Content` : Suppression réussie (DELETE)

**Redirection** :
- `302 Found` : Redirection temporaire (web uniquement)

**Erreurs Client** :
- `400 Bad Request` : Requête mal formée
- `401 Unauthorized` : Non authentifié (token manquant/invalide)
- `403 Forbidden` : Non autorisé (mauvais rôle/permission)
- `404 Not Found` : Ressource non trouvée
- `422 Unprocessable Entity` : Erreur de validation
- `429 Too Many Requests` : Trop de requêtes (rate limiting)

**Erreurs Serveur** :
- `500 Internal Server Error` : Erreur serveur interne
- `503 Service Unavailable` : Service temporairement indisponible

#### 10.7.2 Gestion des Erreurs Standardisée

**Format d'Erreur Générique** :
```json
{
  "message": "Message d'erreur descriptif",
  "errors": {
    "field_name": ["Erreur de validation spécifique"]
  },
  "status_code": 422
}
```

**Exemples par Type d'Erreur** :

**Erreur de Validation** :
```json
{
  "message": "The given data was invalid.",
  "errors": {
    "email": ["The email field is required.", "The email must be a valid email address."],
    "password": ["The password must be at least 8 characters."]
  }
}
```

**Erreur d'Authentification** :
```json
{
  "message": "Unauthenticated."
}
```

**Erreur d'Autorisation** :
```json
{
  "message": "This action is unauthorized."
}
```

**Erreur Ressource Non Trouvée** :
```json
{
  "message": "No query results for model [App\\Models\\Product] 999"
}
```

**Erreur Serveur** :
```json
{
  "message": "Server Error",
  "error": "Detailed error message (seulement en développement)"
}
```

### 10.8 Rate Limiting et Sécurité API

#### 10.8.1 Rate Limiting

**Configuration** :
- Limite par défaut : 60 requêtes par minute par IP
- Limite authentifiée : 1000 requêtes par minute par utilisateur
- Headers de réponse :
  - `X-RateLimit-Limit` : Limite totale
  - `X-RateLimit-Remaining` : Requêtes restantes
  - `Retry-After` : Secondes avant nouvelle tentative (si dépassé)

**Réponse en Cas de Dépassement (429)** :
```json
{
  "message": "Too Many Attempts."
}
```

#### 10.8.2 CORS (Cross-Origin Resource Sharing)

**Configuration** :
- Origines autorisées : Configurées dans `config/cors.php`
- Headers autorisés : `Content-Type`, `Authorization`, `X-Requested-With`
- Méthodes autorisées : `GET`, `POST`, `PUT`, `DELETE`, `PATCH`, `OPTIONS`

---

## 10. TESTS ET QUALITE

### 10.1 Framework de Tests

**Pest PHP 4.1** : Framework de tests moderne et expressif

**Avantages** :
- Syntaxe claire et lisible
- Intégration Laravel native
- Tests rapides à écrire
- Messages d'erreur clairs

### 10.2 Types de Tests

#### 10.2.1 Tests Unitaires
- Tests des modèles (relations, méthodes)
- Tests des services (SmsService, etc.)
- Tests des helpers et utilitaires

#### 10.2.2 Tests Fonctionnels
- Tests des routes (accès, permissions)
- Tests des contrôleurs (logique métier)
- Tests des middlewares
- Tests des policies

#### 10.2.3 Tests d'Intégration
- Tests des flux complets (inscription vers création produit vers commande)
- Tests des notifications
- Tests des queues

### 10.3 Couverture de Tests

**Modules Testés** :
- Authentification (inscription, connexion, réinitialisation)
- Gestion des produits (CRUD, images)
- Gestion des équipements (CRUD, images)
- Panier et commandes
- Locations
- Notifications
- Administration

### 10.4 Exécution des Tests

```bash
# Tous les tests
php artisan test

# Tests spécifiques
php artisan test --filter=ProductTest

# Avec couverture (nécessite Xdebug)
php artisan test --coverage
```

### 10.5 Qualité du Code

#### 10.5.1 Laravel Pint
- Formatter de code automatique
- Respect des standards PSR-12
- Exécution : `./vendor/bin/pint`

#### 10.5.2 Standards de Code
- PSR-12 pour le style
- Conventions Laravel
- Nommage cohérent
- Commentaires pour code complexe

---

## 11. DEPLOIEMENT ET PRODUCTION

### 11.1 Environnement de Développement

#### 11.1.1 Local (Sans Docker)
```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm install && npm run dev
php artisan serve
```

#### 11.1.2 Docker (Laravel Sail)
```bash
./vendor/bin/sail up -d
./vendor/bin/sail artisan migrate --seed
./vendor/bin/sail npm install && ./vendor/bin/sail npm run dev
```

### 11.2 Environnement de Production

#### 11.2.1 Docker Compose
```bash
docker compose -f docker-compose.prod.yml up -d --build
```

#### 11.2.2 Configuration Requise
- PHP 8.2+
- Composer
- Node.js 18+
- Base de données (MySQL/PostgreSQL)
- Serveur web (Nginx/Apache)
- SSL/TLS pour HTTPS

#### 11.2.3 Variables d'Environnement
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://votre-domaine.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_DATABASE=agri_platform
DB_USERNAME=...
DB_PASSWORD=...

MAIL_MAILER=smtp
MAIL_HOST=...
MAIL_PORT=587
MAIL_USERNAME=...
MAIL_PASSWORD=...

TWILIO_ACCOUNT_SID=...
TWILIO_AUTH_TOKEN=...
TWILIO_FROM_NUMBER=...
```

#### 11.2.4 Optimisations Production
```bash
# Cache de configuration
php artisan config:cache

# Cache des routes
php artisan route:cache

# Cache des vues
php artisan view:cache

# Optimisation autoloader
composer install --optimize-autoloader --no-dev

# Build des assets
npm run build
```

### 11.3 Sécurité Production

- `APP_DEBUG=false`
- HTTPS obligatoire
- Mots de passe forts
- Rate limiting activé
- Logs surveillés
- Sauvegardes régulières
- Mises à jour de sécurité

### 11.4 Monitoring et Maintenance

- Logs Laravel (`storage/logs/laravel.log`)
- Monitoring des erreurs
- Surveillance des performances
- Sauvegardes automatiques
- Mises à jour régulières

### 11.5 Configuration Détaillée des Variables d'Environnement

#### 11.5.1 Configuration Application

```env
# Application
APP_NAME="Agri Platform"
APP_ENV=production
APP_KEY=base64:... (généré avec php artisan key:generate)
APP_DEBUG=false
APP_URL=https://agri-platform.com

# Locale
APP_LOCALE=fr
APP_FALLBACK_LOCALE=fr
APP_TIMEZONE=Africa/Dakar
```

#### 11.5.2 Configuration Base de Données

```env
# MySQL/PostgreSQL
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=agri_platform
DB_USERNAME=agri_user
DB_PASSWORD=secure_password

# SQLite (développement)
# DB_CONNECTION=sqlite
# DB_DATABASE=/absolute/path/to/database.sqlite
```

#### 11.5.3 Configuration Email

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=noreply@agri-platform.com
MAIL_PASSWORD=app_specific_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@agri-platform.com"
MAIL_FROM_NAME="${APP_NAME}"
```

#### 11.5.4 Configuration Twilio (SMS)

```env
TWILIO_ACCOUNT_SID=ACxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
TWILIO_AUTH_TOKEN=your_auth_token_here
TWILIO_FROM_NUMBER=+221XXXXXXXXX
```

#### 11.5.5 Configuration Session et Cache

```env
SESSION_DRIVER=database
SESSION_LIFETIME=120
CACHE_DRIVER=redis
QUEUE_CONNECTION=redis
```

#### 11.5.6 Configuration Fichiers

```env
FILESYSTEM_DISK=local
# Pour production avec S3
# FILESYSTEM_DISK=s3
# AWS_ACCESS_KEY_ID=...
# AWS_SECRET_ACCESS_KEY=...
# AWS_DEFAULT_REGION=...
# AWS_BUCKET=...
```

### 11.6 Logs et Debugging

#### 11.6.1 Structure des Logs

**Fichier Principal** : `storage/logs/laravel.log`

**Format des Entrées** :
```
[2025-11-04 10:00:00] local.ERROR: Message d'erreur {"user_id":1,"product_id":5}
```

**Niveaux de Log** :
- `DEBUG` : Informations détaillées (développement uniquement)
- `INFO` : Informations générales
- `NOTICE` : Notifications importantes
- `WARNING` : Avertissements
- `ERROR` : Erreurs
- `CRITICAL` : Erreurs critiques
- `ALERT` : Alertes nécessitant action immédiate
- `EMERGENCY` : Urgences système

#### 11.6.2 Utilisation des Logs

**Dans le Code** :
```php
use Illuminate\Support\Facades\Log;

// Log d'information
Log::info('Produit créé', ['product_id' => $product->id, 'user_id' => $user->id]);

// Log d'erreur
Log::error('Échec de paiement', [
    'order_id' => $order->id,
    'error' => $exception->getMessage()
]);

// Log avec contexte
Log::channel('daily')->warning('Stock faible', ['product_id' => $product->id]);
```

**Consultation des Logs** :
```bash
# Voir les dernières lignes
tail -f storage/logs/laravel.log

# Filtrer les erreurs
grep ERROR storage/logs/laravel.log

# Compter les erreurs
grep -c ERROR storage/logs/laravel.log
```

#### 11.6.3 Debugging en Développement

**Laravel Debugbar** (si installé) :
- Affichage des requêtes SQL
- Temps d'exécution
- Variables de session
- Requêtes AJAX

**Tinker (REPL)** :
```bash
php artisan tinker

# Exemples
$user = User::find(1);
$user->products;
$product = Product::where('title', 'like', '%riz%')->first();
```

**dd() et dump()** :
```php
// Affiche et arrête l'exécution
dd($variable);

// Affiche sans arrêter
dump($variable1, $variable2);
```

### 11.7 Sauvegardes et Restauration

#### 11.7.1 Sauvegarde de la Base de Données

**MySQL** :
```bash
mysqldump -u agri_user -p agri_platform > backup_$(date +%Y%m%d).sql
```

**PostgreSQL** :
```bash
pg_dump -U agri_user agri_platform > backup_$(date +%Y%m%d).sql
```

**SQLite** :
```bash
cp database/database.sqlite backups/backup_$(date +%Y%m%d).sqlite
```

#### 11.7.2 Sauvegarde des Fichiers

```bash
# Sauvegarder les uploads
tar -czf uploads_backup_$(date +%Y%m%d).tar.gz storage/app/public/uploads

# Sauvegarder les logs
tar -czf logs_backup_$(date +%Y%m%d).tar.gz storage/logs
```

#### 11.7.3 Restauration

**Base de Données** :
```bash
# MySQL
mysql -u agri_user -p agri_platform < backup_20251104.sql

# PostgreSQL
psql -U agri_user agri_platform < backup_20251104.sql

# SQLite
cp backups/backup_20251104.sqlite database/database.sqlite
```

**Fichiers** :
```bash
tar -xzf uploads_backup_20251104.tar.gz -C storage/app/public/
```

### 11.8 Troubleshooting

#### 11.8.1 Problèmes Courants

**Erreur 500 - Erreur Serveur** :
1. Vérifier les logs : `tail -f storage/logs/laravel.log`
2. Vérifier les permissions : `chmod -R 775 storage bootstrap/cache`
3. Vider les caches : `php artisan optimize:clear`
4. Vérifier `.env` : Variables correctement configurées

**Erreur 404 - Route Non Trouvée** :
1. Vérifier les routes : `php artisan route:list`
2. Vider le cache des routes : `php artisan route:clear`
3. Vérifier l'URL et les paramètres

**Erreur 419 - Token CSRF Expiré** :
1. Vérifier la session : `php artisan config:clear`
2. Vérifier le cookie de session
3. Régénérer la clé : `php artisan key:generate`

**Problèmes de Permissions** :
```bash
# Permissions correctes
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

**Problèmes de Base de Données** :
1. Vérifier la connexion : `php artisan migrate:status`
2. Réexécuter les migrations : `php artisan migrate:fresh --seed`
3. Vérifier les credentials dans `.env`

**Problèmes d'Assets (CSS/JS)** :
1. Recompiler : `npm run build`
2. Vérifier le symlink : `php artisan storage:link`
3. Vider le cache : `php artisan view:clear`

#### 11.8.2 Commandes de Diagnostic

```bash
# Vérifier la configuration
php artisan config:show

# Lister les routes
php artisan route:list

# Vérifier les migrations
php artisan migrate:status

# Tester la connexion DB
php artisan db:show

# Vérifier les queues
php artisan queue:work --once

# Vérifier les permissions
ls -la storage bootstrap/cache
```

---

## 12. CONCLUSION ET PERSPECTIVES

### 12.1 Réalisations

Agri Platform a été développé avec succès en intégrant toutes les fonctionnalités demandées :

**Fonctionnalités Implémentées** :
- Système d'authentification complet avec vérification email
- Gestion multi-rôles avec permissions granulaires
- CRUD complet pour produits et équipements
- Système de gestion d'images avancé (upload fichiers + URLs)
- Panier et système de commandes
- Système de location d'équipements
- Administration complète avec vérification CNI
- API REST documentée avec Swagger
- Système de notifications (email + base de données)
- Interface responsive et moderne

**Qualité Technique** :
- Architecture MVC propre et maintenable
- Tests automatisés
- Code suivant les standards PSR-12
- Documentation complète
- Sécurité renforcée

### 12.2 Points Forts

1. **Architecture Moderne** : Utilisation de frameworks et outils à jour (Laravel 12, Tailwind CSS 3, Vite 7)
2. **Sécurité** : Multiples couches de sécurité (CSRF, XSS, SQL injection, authentification forte)
3. **Flexibilité** : Support multi-rôles, API REST pour intégrations futures
4. **Expérience Utilisateur** : Interface intuitive, responsive, notifications en temps réel
5. **Maintenabilité** : Code organisé, tests, documentation

### 12.3 Défis Rencontrés

1. **Gestion des Images** : Implémentation d'un système mixte (fichiers + URLs) avec réorganisation
2. **Permissions Multi-Rôles** : Configuration Spatie Permission pour gérer les utilisateurs avec plusieurs rôles
3. **Workflow de Commandes** : Gestion des statuts et transitions d'état
4. **Notifications Asynchrones** : Mise en place des queues pour les notifications

### 12.4 Perspectives d'Évolution

#### 12.4.1 Court Terme
- Application mobile (React Native / Flutter) utilisant l'API REST
- Intégration de paiement en ligne réel (Stripe, PayPal, Orange Money, etc.)
- Système de messagerie entre utilisateurs
- Système de notation et avis
- Géolocalisation pour la recherche par proximité

#### 12.4.2 Moyen Terme
- Application de suivi de livraison
- Intégration avec des services de transport
- Tableau de bord analytique avancé
- Export de données (PDF, Excel)
- Multi-langues (Wolof, Pulaar, etc.)

#### 12.4.3 Long Terme
- Intelligence artificielle pour recommandations
- Prédiction de prix basée sur les tendances
- Intégration avec des capteurs IoT pour le suivi des cultures
- Marketplace B2B pour les grossistes
- Certification des producteurs bio/organiques

### 12.5 Impact Attendu

**Pour les Producteurs** :
- Meilleure visibilité de leurs produits
- Accès à un marché plus large
- Réduction des intermédiaires
- Traçabilité des ventes

**Pour les Propriétaires d'Equipements** :
- Monétisation de leurs équipements
- Gestion simplifiée des locations
- Calendrier de disponibilité

**Pour les Acheteurs** :
- Accès à une variété de produits locaux
- Prix compétitifs
- Traçabilité des produits
- Location d'équipements à moindre coût

**Pour le Secteur Agricole** :
- Digitalisation du secteur
- Amélioration de la chaîne de valeur
- Création d'emplois (livraison, support)
- Contribution à la sécurité alimentaire

### 12.6 Conclusion

Agri Platform représente une solution complète et moderne pour la digitalisation du secteur agricole sénégalais. L'application combine une architecture technique solide, une expérience utilisateur soignée et des fonctionnalités adaptées aux besoins réels des acteurs du secteur.

Le projet démontre la maîtrise des technologies web modernes, des bonnes pratiques de développement et de la capacité à créer une application complète de A à Z. Les choix techniques (Laravel, Tailwind, Sanctum, etc.) sont justifiés et contribuent à la qualité, la maintenabilité et la scalabilité de l'application.

Avec les perspectives d'évolution identifiées, Agri Platform a le potentiel de devenir une plateforme de référence pour l'agriculture numérique au Sénégal et potentiellement dans d'autres pays de la sous-région.

---

## ANNEXES

### A. Commandes Artisan Utiles

#### A.1 Gestion des Utilisateurs

```bash
# Créer un administrateur
php artisan admin:create --email=admin@example.com --password=password

# Créer un utilisateur avec rôle
php artisan tinker
>>> $user = User::create([...]);
>>> $user->assignRole('producer');
```

#### A.2 Base de Données

```bash
# Exécuter les migrations
php artisan migrate

# Rollback de la dernière migration
php artisan migrate:rollback

# Rollback de toutes les migrations
php artisan migrate:reset

# Réexécuter toutes les migrations (ATTENTION: supprime les données)
php artisan migrate:fresh

# Réexécuter avec seeders
php artisan migrate:fresh --seed

# Vérifier le statut des migrations
php artisan migrate:status

# Créer une nouvelle migration
php artisan make:migration create_table_name

# Créer un modèle avec migration
php artisan make:model ModelName -m
```

#### A.3 Seeders

```bash
# Exécuter tous les seeders
php artisan db:seed

# Exécuter un seeder spécifique
php artisan db:seed --class=RolesAndTestDataSeeder

# Exécuter avec factory
php artisan db:seed --class=RealisticTestDataSeeder
```

#### A.4 Cache

```bash
# Vider tous les caches
php artisan optimize:clear

# Vider le cache de configuration
php artisan config:clear

# Vider le cache des routes
php artisan route:clear

# Vider le cache des vues
php artisan view:clear

# Vider le cache de l'application
php artisan cache:clear

# Optimiser pour la production
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

#### A.5 API et Documentation

```bash
# Générer la documentation Swagger
php artisan l5-swagger:generate

# Lister les routes API
php artisan route:list --path=api
```

#### A.6 Tests

```bash
# Lancer tous les tests
php artisan test

# Lancer un test spécifique
php artisan test --filter=ProductTest

# Lancer avec couverture (nécessite Xdebug)
php artisan test --coverage

# Lancer en mode verbose
php artisan test -v
```

#### A.7 Queues et Jobs

```bash
# Traiter les jobs en attente
php artisan queue:work

# Traiter une fois
php artisan queue:work --once

# Traiter avec nombre de tentatives
php artisan queue:work --tries=3

# Vider la queue
php artisan queue:flush

# Relancer les jobs échoués
php artisan queue:retry all
```

#### A.8 Storage et Fichiers

```bash
# Créer le symlink pour storage public
php artisan storage:link

# Lister les fichiers
php artisan storage:list
```

#### A.9 Génération de Code

```bash
# Créer un contrôleur
php artisan make:controller ProductController

# Créer un contrôleur avec ressources
php artisan make:controller ProductController --resource

# Créer un modèle
php artisan make:model Product

# Créer un Form Request
php artisan make:request StoreProductRequest

# Créer un middleware
php artisan make:middleware CheckSuspended

# Créer une commande
php artisan make:command CreateAdminUser

# Créer une notification
php artisan make:notification OrderPaid

# Créer un event
php artisan make:event ProductCreated

# Créer un listener
php artisan make:listener SendProductNotification
```

#### A.10 Informations et Diagnostic

```bash
# Afficher la version Laravel
php artisan --version

# Afficher la configuration
php artisan config:show

# Lister toutes les routes
php artisan route:list

# Lister les routes d'un domaine
php artisan route:list --path=admin

# Afficher les informations de l'environnement
php artisan about

# Tester la connexion à la base de données
php artisan db:show
```

### B. Structure des Rôles

- **admin** : Accès complet
- **producer** : Gestion produits
- **equipment_owner** : Gestion équipements et locations
- **buyer** : Achat et location

### C. Statuts des Commandes

- **pending** : En attente
- **pending_payment** : En attente de paiement
- **pending_validation** : En attente de validation
- **paid** : Payée
- **cancelled** : Annulée
- **completed** : Terminée

### D. Statuts des Locations

- **pending** : En attente d'approbation
- **approved** : Approuvée
- **rejected** : Rejetée
- **completed** : Terminée

### E. Technologies et Versions

- PHP : 8.2+
- Laravel : 12.0
- Laravel Sanctum : 4.2
- Spatie Permission : 6.22
- Tailwind CSS : 3.1
- Alpine.js : 3.4
- Vite : 7.0
- Pest PHP : 4.1
- Twilio SDK : 8.8
- L5-Swagger : 9.0

### F. Diagrammes de Flux Principaux

#### F.1 Flux de Création de Produit

1. Utilisateur (Producteur) envoie GET /products/create
2. Serveur : Vérification auth + rôle
3. Serveur : Affichage formulaire (Blade)
4. Utilisateur : Remplit formulaire + Upload images
5. Utilisateur : POST /products (avec CSRF token)
6. Serveur : Middleware: auth, suspended, role:producer
7. Serveur : Validation (Form Request)
8. Serveur : Création Product en DB
9. Serveur : Upload images (si fichiers)
10. Serveur : Création Images en DB
11. Serveur : Redirection /products avec message flash
12. Utilisateur : Voir liste produits avec nouveau produit

#### F.2 Flux de Commande et Paiement

1. Acheteur : Ajoute produits au panier (POST /cart/add)
2. Serveur : Stockage en session
3. Acheteur : POST /checkout
4. Serveur : Création Order + OrderItems
5. Serveur : Redirection /orders/{id}/payment
6. Acheteur : Sélectionne mode paiement
7. Acheteur : POST /orders/{id}/payment
8. Serveur : Validation paiement
9. Serveur : Mise à jour Order (status: paid)
10. Serveur : Réduction stock produits
11. Serveur : Notification OrderPaid (email + DB)
12. Serveur : Redirection /orders/{id}
13. Acheteur : Voir commande payée

#### F.3 Flux de Location d'Equipement

1. Acheteur : Sélectionne équipement disponible
2. Acheteur : POST /equipment/{id}/rent (dates)
3. Serveur : Vérification disponibilité
4. Serveur : Calcul total (daily_rate * jours)
5. Serveur : Création Rental (status: pending)
6. Serveur : Notification au propriétaire
7. Propriétaire : GET /rentals
8. Propriétaire : Voir demande (status: pending)
9. Propriétaire : PUT /rentals/{id} (status: approved)
10. Serveur : Mise à jour Rental
11. Serveur : Notification au locataire
12. Locataire : Voir location approuvée

#### F.4 Flux de Vérification CNI

1. Utilisateur : Upload CNI recto/verso (profil)
2. Serveur : Stockage fichiers
3. Serveur : Mise à jour User (cni_verified: false)
4. Admin : GET /admin/cni
5. Admin : Voir liste CNI en attente
6. Admin : GET /admin/cni/{user}
7. Admin : Consulte documents
8. Admin : POST /admin/cni/{user}/approve (ou reject)
9. Serveur : Mise à jour User (cni_verified: true/false)
10. Serveur : Notification CniVerificationStatus
11. Utilisateur : Reçoit email + notification DB
12. Utilisateur : Voir statut dans profil

### G. Structure Complète des Fichiers

```
agri-platform/
├── app/
│   ├── Console/
│   │   └── Commands/          # Commandes Artisan personnalisées
│   ├── Http/
│   │   ├── Controllers/       # Contrôleurs MVC
│   │   │   ├── Admin/        # Contrôleurs admin
│   │   │   └── Auth/         # Contrôleurs authentification
│   │   ├── Middleware/        # Middlewares personnalisés
│   │   └── Requests/         # Form Requests (validation)
│   ├── Models/                # Modèles Eloquent
│   ├── Notifications/         # Classes de notifications
│   ├── Policies/              # Policies d'autorisation
│   ├── Providers/             # Service Providers
│   └── Services/          # Services métier (SMS, etc.)
├── bootstrap/                 # Fichiers de démarrage
├── config/                    # Fichiers de configuration
├── database/
│   ├── factories/             # Factories pour tests
│   ├── migrations/            # Migrations de schéma
│   └── seeders/               # Seeders de données
├── public/                    # Point d'entrée public
│   ├── index.php              # Point d'entrée Laravel
│   └── storage/               # Symlink vers storage/app/public
├── resources/
│   ├── css/                   # Fichiers CSS source
│   ├── js/                    # Fichiers JavaScript source
│   └── views/                 # Vues Blade
│       ├── admin/             # Vues admin
│       ├── auth/              # Vues authentification
│       ├── components/        # Composants réutilisables
│       └── layouts/           # Layouts de base
├── routes/
│   ├── web.php                # Routes web
│   ├── api.php                # Routes API
│   └── auth.php               # Routes authentification
├── storage/
│   ├── app/                   # Fichiers applicatifs
│   │   ├── private/           # Fichiers privés
│   │   └── public/            # Fichiers publics (uploads)
│   ├── framework/             # Cache framework
│   └── logs/                  # Fichiers de logs
├── tests/                     # Tests automatisés
│   ├── Feature/              # Tests fonctionnels
│   └── Unit/                  # Tests unitaires
├── vendor/                    # Dépendances Composer
├── .env                       # Variables d'environnement
├── .env.example               # Exemple de .env
├── composer.json              # Dépendances PHP
├── package.json               # Dépendances Node.js
├── artisan                    # CLI Laravel
└── vite.config.js            # Configuration Vite
```

### H. Workflow de Développement

#### H.1 Workflow Git Standard

```bash
# 1. Créer une branche pour une fonctionnalité
git checkout -b feature/nouvelle-fonctionnalite

# 2. Développer et commiter
git add .
git commit -m "feat: ajout fonctionnalité X"

# 3. Pousser la branche
git push origin feature/nouvelle-fonctionnalite

# 4. Créer une Pull Request sur GitHub/GitLab

# 5. Après review, merger dans main
git checkout main
git merge feature/nouvelle-fonctionnalite
git push origin main
```

#### H.2 Convention de Nommage des Commits

- `feat:` : Nouvelle fonctionnalité
- `fix:` : Correction de bug
- `docs:` : Documentation
- `style:` : Formatage (pas de changement de code)
- `refactor:` : Refactoring
- `test:` : Ajout/modification de tests
- `chore:` : Tâches de maintenance

#### H.3 Workflow de Développement Local

```bash
# 1. Cloner le projet
git clone https://github.com/user/agri-platform.git
cd agri-platform

# 2. Installer les dépendances
composer install
npm install

# 3. Configurer l'environnement
cp .env.example .env
php artisan key:generate

# 4. Configurer la base de données dans .env
# Puis exécuter les migrations
php artisan migrate --seed

# 5. Créer le symlink storage
php artisan storage:link

# 6. Lancer le serveur de développement
php artisan serve
# Dans un autre terminal
npm run dev
```

### I. Métriques et Performance

#### I.1 Métriques à Surveiller

**Performance** :
- Temps de réponse moyen des pages (moins de 500ms)
- Temps de réponse API (moins de 200ms)
- Temps de chargement initial (moins de 2s)
- Nombre de requêtes SQL par page (moins de 10)

**Utilisation** :
- Nombre d'utilisateurs actifs
- Nombre de produits/équipements
- Nombre de commandes par jour
- Taux de conversion (visiteurs vers commandes)

**Technique** :
- Taille de la base de données
- Espace disque utilisé (uploads)
- Utilisation mémoire PHP
- Erreurs 500 par jour

#### I.2 Optimisations Recommandées

**Base de Données** :
- Index sur colonnes fréquemment recherchées
- Eager loading pour éviter N+1
- Pagination pour grandes listes
- Cache des requêtes fréquentes

**Assets** :
- Minification CSS/JS en production
- Compression Gzip
- CDN pour images statiques
- Lazy loading des images

**Application** :
- Cache de configuration/routes/vues
- Queue pour tâches lourdes (emails, SMS)
- Optimisation des requêtes Eloquent
- Limitation des requêtes (rate limiting)

---

**Document généré le** : 2025-11-04  
**Version** : 1.0  
**Auteur** : Équipe de Développement Agri Platform

