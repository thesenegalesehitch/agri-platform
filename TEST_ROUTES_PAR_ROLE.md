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
- ✅ `GET /equipment` → Explorer les matériels disponibles
- ✅ `POST /equipment/{id}/rent` → Demander une location
- ✅ `GET /rentals` → Suivre ses demandes de location
- ✅ `GET /rentals/{id}` → Détails d'une demande

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
- ✅ `PATCH /rentals/{id}` → Mettre à jour une location

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

---

## 🔍 Vérifications Effectuées

### ✅ Contraintes de Routes
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

*Dernière mise à jour : 2025-11-11*

