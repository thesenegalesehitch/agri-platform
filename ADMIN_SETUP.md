# Configuration Admin et SMS

## Compte Administrateur

Un compte administrateur a été créé avec les identifiants suivants :
- **Email**: `nleopold931@gmail.com`
- **Mot de passe**: `Alexandr3`

Pour créer/mettre à jour ce compte, exécutez :
```bash
php artisan db:seed --class=RolesAndTestDataSeeder
```

## Configuration SMS avec Twilio

### 1. Créer un compte Twilio
1. Allez sur https://www.twilio.com
2. Créez un compte gratuit (trial) ou payant
3. Obtenez vos identifiants depuis le dashboard :
   - Account SID
   - Auth Token
   - Numéro de téléphone Twilio (From Number)

### 2. Configurer les variables d'environnement

Ajoutez ces lignes dans votre fichier `.env` (ne pas modifier directement, juste ajouter) :

```env
TWILIO_ACCOUNT_SID=your_account_sid_here
TWILIO_AUTH_TOKEN=your_auth_token_here
TWILIO_FROM_NUMBER=+1234567890  # Format: +code_pays numéro
```

**Note**: En mode développement sans Twilio configuré, les SMS seront loggés dans les logs Laravel au lieu d'être envoyés.

### 3. Utilisation

Le service SMS est automatiquement utilisé lors de la vérification de téléphone dans le profil utilisateur. Le service `SmsService` :
- Formate automatiquement les numéros sénégalais (+221)
- Gère les erreurs gracieusement
- Log les messages en mode développement

## Fonctionnalités Admin

### Dashboard Admin
- Accès: `/admin` (après connexion avec le compte admin)
- Statistiques : Total utilisateurs, actifs, suspendus, CNI en attente
- Actions rapides : Gestion utilisateurs, vérification CNI, demandes de réactivation

### Gestion des Utilisateurs
- Liste tous les utilisateurs avec filtres
- Suspendre/Réactiver les comptes
- Modifier les rôles
- Voir les détails complets

### Vérification CNI
- Accès: `/admin/cni`
- Affiche tous les utilisateurs avec CNI uploadée
- Approuver ou rejeter les CNI avec notes
- Notifications automatiques envoyées aux utilisateurs

### Demandes de Réactivation
- Les utilisateurs suspendus peuvent demander la réactivation depuis leur profil
- Les admins voient toutes les demandes avec filtres
- Approuver/Rejeter avec réponse personnalisée

## Protection Comptes Suspendus

Un middleware `CheckSuspended` bloque automatiquement :
- L'accès aux routes authentifiées pour les comptes suspendus
- Les utilisateurs suspendus sont déconnectés automatiquement
- Un message d'erreur s'affiche à la connexion

## Notifications

Les notifications sont envoyées par email et stockées en base de données pour :
- **Vérification CNI** : Lorsqu'une CNI est approuvée ou rejetée
- **Demande de réactivation** : Lorsqu'une demande est approuvée ou rejetée

## Prochaines étapes

1. Configurer Twilio avec vos identifiants
2. Connectez-vous avec le compte admin
3. Explorez le dashboard admin
4. Testez la vérification CNI
5. Testez la suspension/réactivation de comptes

