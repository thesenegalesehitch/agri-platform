# 📊 Diagrammes PlantUML - AgriLink

Ce dossier contient tous les diagrammes PlantUML pour le projet AgriLink.

## 📁 Fichiers disponibles

### 1. Diagramme de Classe (`01-diagramme-classe.puml`)
- Représente toutes les entités du modèle de données
- Affiche les relations entre les classes (hasMany, belongsTo, morphMany, etc.)
- Inclut les principaux attributs et méthodes de chaque modèle
- Montre les statuts possibles pour Order et Rental

### 2. Diagramme de Cas d'Utilisation (`02-diagramme-cas-utilisation.puml`)
- Représente tous les cas d'utilisation par rôle
- Organisé par packages fonctionnels :
  - Authentification
  - Gestion Produits
  - Gestion Matériels
  - Gestion Images
  - Panier et Commandes
  - Location Matériel
  - Gestion Utilisateurs
  - Gestion Demandes
  - Dashboard
- Couleurs distinctes pour chaque rôle

### 3. Diagramme de Séquence - Inscription (`03-sequence-inscription.puml`)
- Flux complet du processus d'inscription
- Étapes : Validation → Création → Attribution rôle → Connexion
- Inclut les interactions avec la base de données
- Montre la gestion des erreurs de validation

### 4. Diagramme de Séquence - Connexion (`04-sequence-connexion.puml`)
- Flux complet du processus de connexion
- Inclut le rate limiting et la gestion des tentatives
- Vérification compte suspendu
- Régénération de session pour sécurité

## 🚀 Utilisation

### Prérequis
- Installer PlantUML : http://plantuml.com/starting
- Ou utiliser un outil en ligne : http://www.plantuml.com/plantuml/uml/

### Génération des diagrammes

#### Méthode 1 : En ligne de commande
```bash
# Installer PlantUML (Java requis)
# macOS
brew install plantuml

# Linux
sudo apt-get install plantuml

# Générer un diagramme
plantuml diagrams/01-diagramme-classe.puml

# Générer tous les diagrammes
plantuml diagrams/*.puml
```

#### Méthode 2 : Extension VS Code
1. Installer l'extension "PlantUML" dans VS Code
2. Ouvrir un fichier `.puml`
3. Utiliser `Alt+D` pour prévisualiser
4. Utiliser `Ctrl+Shift+P` > "PlantUML: Export Current Diagram"

#### Méthode 3 : Outil en ligne
1. Aller sur http://www.plantuml.com/plantuml/uml/
2. Copier le contenu d'un fichier `.puml`
3. Coller dans l'éditeur
4. Le diagramme s'affiche automatiquement
5. Exporter en PNG, SVG ou PDF

#### Méthode 4 : Docker
```bash
docker run -d -p 8080:8080 plantuml/plantuml-server:jetty
# Puis accéder à http://localhost:8080
```

## 🎨 Personnalisation

Les diagrammes utilisent les couleurs du thème AgriLink :
- **PRIMARY_COLOR** : #5c4033 (Marron)
- **SECONDARY_COLOR** : #4CAF50 (Vert)
- **TERTIARY_COLOR** : #d0c9c0 (Beige)

Pour modifier les couleurs, éditez les variables `!define` en haut de chaque fichier.

## 📝 Notes

- Les diagrammes sont synchronisés avec le code actuel du projet
- En cas de modification du modèle, mettre à jour les diagrammes correspondants
- Les relations polymorphiques (Image) sont représentées avec `morphTo`

## 🔄 Mise à jour

Pour mettre à jour les diagrammes après des changements dans le code :

1. **Diagramme de Classe** : Vérifier les modèles dans `app/Models/`
2. **Cas d'Utilisation** : Vérifier les routes dans `routes/web.php` et les contrôleurs
3. **Séquences** : Vérifier les contrôleurs dans `app/Http/Controllers/Auth/`

---

*Générés le 2025-11-02*

