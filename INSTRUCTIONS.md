# Instructions de Configuration

## 1. Créer le compte administrateur

Si le compte admin n'existe pas encore, exécutez :

```bash
php artisan admin:create
```

Par défaut, cela créera le compte avec :
- **Email**: `nleopold931@gmail.com`
- **Mot de passe**: `Alexandr3`

Vous pouvez également spécifier d'autres identifiants :
```bash
php artisan admin:create --email=votre@email.com --password=VotreMotDePasse
```

## 2. Pré-remplir les produits et matériels

Pour créer des produits et matériels d'exemple, exécutez :

```bash
php artisan db:seed --class=ProductAndEquipmentSeeder
```

Ou pour tout seed (rôles, catégories, utilisateurs, produits, matériels) :
```bash
php artisan db:seed
```

## 3. Vérification Email

La vérification email est maintenant activée :
- Lors de l'inscription, un email de vérification est envoyé
- L'utilisateur doit cliquer sur le lien dans l'email pour activer son compte
- Les pages d'authentification sont maintenant entièrement en français

## 4. Configuration Email

Pour que les emails fonctionnent, configurez votre `.env` :

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=votre@gmail.com
MAIL_PASSWORD=votre_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@agri-platform.com"
MAIL_FROM_NAME="${APP_NAME}"
```

Pour Gmail, vous devrez créer un "App Password" dans votre compte Google.

## Résumé des fonctionnalités

✅ **Compte Admin** : Créé avec la commande `admin:create`
✅ **Vérification Email** : Activée pour tous les nouveaux utilisateurs
✅ **Pages Auth en Français** : Login, Register, Password Reset, Email Verification
✅ **Produits Pré-définis** : 9 produits variés (riz, mil, arachides, mangues, etc.)
✅ **Matériels Pré-définis** : 8 matériels (tracteurs, moissonneuses, irrigation, outils)

## Accès Admin

Une fois le compte créé :
1. Connectez-vous avec `nleopold931@gmail.com` / `Alexandr3`
2. Accédez à `/admin` pour le dashboard admin
3. Gérez les utilisateurs, vérifiez les CNI, gérez les suspensions

