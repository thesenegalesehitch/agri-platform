# 📋 Comptes de Test - Agri-Platform

Ce document répertorie tous les comptes de test créés pour faciliter les tests de l'application.

## 👤 ADMINISTRATEUR

### Compte Principal (Production)
- **Email**: `nleopold931@gmail.com`
- **Mot de passe**: `Alexandr3`
- **Rôle**: Admin
- **Profil**: Complet avec CNI vérifiée

### Compte de Test
- **Email**: `admin@test.com`
- **Mot de passe**: `admin123`
- **Rôle**: Admin
- **Profil**: Complet avec CNI vérifiée

---

## 🛒 ACHETEURS

### Compte 1
- **Email**: `buyer@test.com`
- **Mot de passe**: `buyer123`
- **Rôle**: Buyer (Acheteur)
- **Profil**: Complet avec CNI vérifiée

### Compte 2
- **Email**: `acheteur@test.com`
- **Mot de passe**: `acheteur123`
- **Rôle**: Buyer (Acheteur)
- **Profil**: Complet avec CNI vérifiée

---

## 🌾 PRODUCTEURS

### Compte 1
- **Email**: `producer@test.com`
- **Mot de passe**: `producer123`
- **Rôle**: Producer (Producteur)
- **Ferme**: Ferme Bio Test
- **Type**: Agriculture biologique
- **Profil**: Complet avec CNI vérifiée

### Compte 2
- **Email**: `producteur@test.com`
- **Mot de passe**: `producteur123`
- **Rôle**: Producer (Producteur)
- **Ferme**: Ferme Test 2
- **Type**: Agriculture conventionnelle
- **Profil**: Complet avec CNI vérifiée

---

## 🚜 PROPRIÉTAIRES DE MATÉRIEL

### Compte 1
- **Email**: `owner@test.com`
- **Mot de passe**: `owner123`
- **Rôle**: Equipment Owner (Propriétaire de matériel)
- **Entreprise**: Agri-Equip Test
- **Flotte**: 10 équipements
- **Profil**: Complet avec CNI vérifiée

### Compte 2
- **Email**: `proprietaire@test.com`
- **Mot de passe**: `proprietaire123`
- **Rôle**: Equipment Owner (Propriétaire de matériel)
- **Entreprise**: Matériel Agricole Test
- **Flotte**: 8 équipements
- **Profil**: Complet avec CNI vérifiée

---

## 🎯 Utilisation

Pour créer ou réinitialiser tous ces comptes de test, exécutez :

```bash
php artisan db:seed --class=TestAccountsSeeder
```

Pour créer tous les seeders (rôles, comptes, catégories, produits et matériels) :

```bash
php artisan db:seed
```

---

## 📝 Notes

- Tous les comptes ont leur email vérifié (`email_verified_at`)
- Tous les comptes ont leur CNI vérifiée (`cni_verified = true`)
- Tous les comptes ont leur téléphone vérifié (`phone_verified = true`)
- Tous les comptes sont actifs (non suspendus)
- Les mots de passe sont simples pour faciliter les tests mais peuvent être changés

---

**⚠️ ATTENTION** : Ces comptes sont destinés uniquement au développement et aux tests. Ne pas utiliser ces identifiants en production !

