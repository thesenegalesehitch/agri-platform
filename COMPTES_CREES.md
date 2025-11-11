# 📋 Liste des Comptes Créés - AgriLink

Date de génération: 2025-11-01

## Total: 15 utilisateurs

### 👨‍💼 Administrateurs (1)

| Nom | Email | Rôles | Localisation |
|-----|-------|-------|--------------|
| Alexandre Ndour | alexandre.ndour@agrilink.com | admin | Rufisque, Dakar - Sénégal |

---

### 🌾 Producteurs (7)

| Nom | Email | Rôles | Localisation |
|-----|-------|-------|--------------|
| Ibrahima Diallo | ibrahima.diallo@agrilink.com | producer | Ziguinchor, Ziguinchor - Sénégal |
| Awa Diop | awa.diop@agrilink.com | producer | Kaolack, Kaolack - Sénégal |
| Cheikh Gueye | cheikh.gueye@agrilink.com | producer | Fatick, Fatick - Sénégal |
| Mamadou Ndiaye | mamadou.ndiaye@agrilink.com | producer | Saint-Louis, Saint-Louis - Sénégal |
| Mariama Fall | mariama.fall@agrilink.com | producer | Louga, Louga - Sénégal |
| Ousmane Ba | ousmane.ba@agrilink.com | producer | Mbacké, Diourbel - Sénégal |
| Alexandre Albert Ndour | pitik33614@provko.com | producer | - |

---

### 🚜 Propriétaires de Matériel (5)

| Nom | Email | Rôles | Localisation |
|-----|-------|-------|--------------|
| Djibril Sow | djibril.sow@agrilink.com | equipment_owner | Thiès, Thiès - Sénégal |
| Abdoulaye Diouf | abdoulaye.diouf@agrilink.com | equipment_owner | Dakar, Dakar - Sénégal |
| Amadou Faye | amadou.faye@agrilink.com | equipment_owner | Matam, Matam - Sénégal |
| Khadija Sarr | khadija.sarr@agrilink.com | equipment_owner | Tambacounda, Tambacounda - Sénégal |
| Khour | khour@gmail.com | equipment_owner | - |

---

### 🔄 Comptes Multi-Rôles (1)

| Nom | Email | Rôles | Localisation |
|-----|-------|-------|--------------|
| Alex | alexandrendour7@gmail.com | producer, equipment_owner | - |

---

## 📝 Notes

- **Comptes principaux avec localisation spécifiée :**
  - **Alexandre Ndour** (Admin) - Rufisque, Dakar
  - **Djibril Sow** (Équipement) - Thiès
  - **Ibrahima Diallo** (Producteur) - Ziguinchor, Casamance

- Les mots de passe par défaut pour les comptes de test sont généralement `password123` ou `Alexandr3` (pour les comptes admin).

---

## ✅ Vérification des Fonctionnalités CRUD

### Producteurs
- ✅ **Read** : `/equipment` - Rechercher des équipements disponibles
- ✅ **Create** : `/equipment/{id}/rent` - Demander une location
- ✅ **Read** : `/rentals` - Suivre ses demandes de location

### Propriétaires de Matériel
- ✅ **Create** : `/equipment/create` - Créer un équipement
- ✅ **Read** : `/equipment` - Liste des équipements (ses propres équipements)
- ✅ **Update** : `/equipment/{id}/edit` - Modifier un équipement
- ✅ **Delete** : `/equipment/{id}` - Supprimer un équipement (via formulaire DELETE)
- ✅ **Update** : `/rentals/{id}` - Gérer le statut des demandes de location

### Fonctionnalités Images
- ✅ Upload local jusqu'à 10 images
- ✅ Ajout par URL jusqu'à 10 images
- ✅ Sélection de l'image principale
- ✅ Réorganisation des images (drag & drop)
- ✅ Suppression d'images
- ✅ Support mixte (URL + fichiers)

---

*Ce fichier liste tous les comptes créés dans la base de données AgriLink.*
