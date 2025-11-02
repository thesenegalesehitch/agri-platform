# ✅ Tests des Routes par Rôle

## 🎯 Routes Corrigées pour Tous les Rôles

Toutes les routes avec des conflits potentiels (create/edit vs {param}) ont été corrigées avec :
1. **Routes explicites** au lieu de `Route::resource()` 
2. **Contraintes where()** pour exclure "create" et "edit" des valeurs de paramètres
3. **Ordre correct** : routes spécifiques (create, edit) AVANT routes avec paramètres

---

## 📋 Comptes de Test par Rôle

### 🌾 Producer (Producteur)
**Email** : `ibrahima.diallo@agrilink.com  
**Mot de passe** : `password123`

**Routes à tester** :
- ✅ `GET /products/create` → Créer un produit
- ✅ `GET /products/{id}/edit` → Modifier un produit
- ✅ `POST /products` → Sauvegarder un produit
- ✅ `PUT /products/{id}` → Mettre à jour un produit
- ✅ `DELETE /products/{id}` → Supprimer un produit

---

### 🚜 Equipment Owner (Propriétaire de Matériel)
**Email** : `djibril.sow@agrilink.com  
**Mot de passe** : `password123`

**Routes à tester** :
- ✅ `GET /equipment/create` → Créer un équipement
- ✅ `GET /equipment/{id}/edit` → Modifier un équipement
- ✅ `POST /equipment` → Sauvegarder un équipement
- ✅ `PUT /equipment/{id}` → Mettre à jour un équipement
- ✅ `DELETE /equipment/{id}` → Supprimer un équipement
- ✅ `GET /rentals` → Liste des locations
- ✅ `GET /rentals/{id}` → Détails d'une location
- ✅ `PUT /rentals/{id}` → Mettre à jour une location

---

### 🛒 Buyer (Acheteur)
**Email** : `fatoumata.kamate@agrilink.com  
**Mot de passe** : `password123`

**Routes à tester** :
- ✅ `GET /cart` → Voir le panier
- ✅ `POST /cart/add/{product}` → Ajouter au panier
- ✅ `POST /cart/remove/{product}` → Retirer du panier
- ✅ `POST /checkout` → Finaliser la commande
- ✅ `GET /orders` → Liste des commandes
- ✅ `GET /orders/{id}` → Détails d'une commande
- ✅ `GET /orders/{id}/payment` → Page de paiement
- ✅ `POST /orders/{id}/payment` → Traiter le paiement
- ✅ `POST /orders/{id}/cancel` → Demander annulation
- ✅ `POST /equipment/{id}/rent` → Demander location

---

### 👨‍💼 Admin (Administrateur)
**Email** : `alexandre.ndour@agrilink.com  
**Mot de passe** : `password123`

**Routes à tester** :
- ✅ `GET /admin` → Dashboard admin
- ✅ `GET /admin/users` → Liste des utilisateurs
- ✅ `GET /admin/users/create` → Créer un utilisateur
- ✅ `GET /admin/users/{id}` → Voir un utilisateur
- ✅ `GET /admin/users/{id}/edit` → Modifier un utilisateur
- ✅ `POST /admin/users` → Sauvegarder un utilisateur
- ✅ `PUT /admin/users/{id}` → Mettre à jour un utilisateur
- ✅ `DELETE /admin/users/{id}` → Supprimer un utilisateur
- ✅ `PATCH /admin/users/{id}/suspend` → Suspendre un utilisateur
- ✅ `PATCH /admin/users/{id}/reactivate` → Réactiver un utilisateur
- ✅ `GET /admin/cni` → Liste des vérifications CNI
- ✅ `GET /admin/cni/{id}` → Détails d'une vérification CNI
- ✅ `POST /admin/cni/{id}/approve` → Approuver CNI
- ✅ `POST /admin/cni/{id}/reject` → Rejeter CNI
- ✅ `GET /admin/orders/cancellations` → Demandes d'annulation
- ✅ `GET /admin/orders/cancellations/{id}` → Détails d'une annulation
- ✅ `POST /admin/orders/cancellations/{id}/approve` → Approuver annulation
- ✅ `POST /admin/orders/cancellations/{id}/reject` → Rejeter annulation

---

## 🔍 Vérifications Effectuées

### ✅ Contraintes de Routes
- `products/{product}` → Exclut "create" et "edit"
- `equipment/{equipment}` → Exclut "create" et "edit"
- `admin/users/{user}` → Pas besoin car create est défini avant

### ✅ Ordre des Routes
1. Routes spécifiques (create, edit) définies en premier
2. Routes avec paramètres ({id}, {user}) définies après
3. Routes publiques avant routes protégées

### ✅ Middleware
- Toutes les routes sont protégées par les bons middlewares :
  - `auth` → Authentification requise
  - `suspended` → Compte non suspendu
  - `role:producer` → Rôle producteur
  - `role:equipment_owner` → Rôle propriétaire matériel
  - `role:buyer` → Rôle acheteur
  - `role:admin` → Rôle administrateur

---

## 🚨 Si une Route Retourne 404

1. **Vérifiez que vous êtes connecté** :
   - Allez sur `/dashboard` → Doit fonctionner

2. **Vérifiez votre rôle** :
   ```bash
   php artisan tinker
   ```
   ```php
   $user = \App\Models\User::where('email', 'VOTRE_EMAIL')->first();
   echo "Roles: " . $user->roles->pluck('name')->join(', ') . PHP_EOL;
   ```

3. **Videz les caches** :
   ```bash
   php artisan optimize:clear
   ```

4. **Réessayez** la route

---

*Dernière mise à jour : 2025-11-01*

