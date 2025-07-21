# Projet CRUD Utilisateurs PHP

Ce projet est une application web de gestion d'utilisateurs (CRUD) développée en PHP avec une interface moderne utilisant Bootstrap et FontAwesome. Il permet à un administrateur de gérer les utilisateurs (création, lecture, modification, suppression) et propose une interface dédiée pour les utilisateurs simples.

## Fonctionnalités

- **Authentification sécurisée** (connexion, inscription, déconnexion)
- **Gestion des rôles** (admin, utilisateur)
- **CRUD utilisateurs** (ajout, édition, suppression, liste)
- **Interface responsive** avec Bootstrap 5 et FontAwesome
- **Modales de feedback** (succès, erreur)
- **Menu latéral dynamique** (offcanvas)
- **Recherche et filtrage** dans la liste des utilisateurs
- **Affichage/Masquage des colonnes** du tableau
- **Thème sombre/clair** et **changement de langue** (FR/EN, partiel)
- **Sécurité** : hachage des mots de passe, vérification de session, validation des entrées

## Structure du projet

```
.
├── index.php
├── actions/
│   ├── createUser.php
│   ├── deleteUser.php
│   ├── editUser.php
│   ├── loginUser.php
│   └── logout.php
├── assets/
├── bootstrap/
├── bootstrap-icons/
├── fontawesome/
├── forms/
│   ├── createUserPage.php
│   ├── editpage.php
│   └── sign_up.php
├── includes/
│   ├── db_connected_verify.php
│   ├── menu.php
│   ├── session_start_verify.php
│   ├── sign_in_db.php
│   └── user_functions.php
├── pages/
│   ├── admin/
│   │   ├── dashboard.php
│   │   └── listUsers.php
│   └── user/
│       └── interface_user.php
├── tools/
│   └── generer_hash.php
└── .gitignore
```

## Installation

1. **Cloner le dépôt**  
   ```sh
   git clone <url-du-repo>
   cd Projet-CRUD
   ```

2. **Placer le projet dans votre serveur web local**  
   Exemple : `/opt/lampp/htdocs/Projet-CRUD` pour XAMPP/LAMPP.

3. **Installer les dépendances front-end**  
   Les dossiers `bootstrap`, `fontawesome` et `bootstrap-icons` doivent contenir les fichiers CSS/JS nécessaires.  
   Si besoin, télécharge-les depuis :
   - [Bootstrap](https://getbootstrap.com/)
   - [FontAwesome](https://fontawesome.com/)
   - [Bootstrap Icons](https://icons.getbootstrap.com/)

4. **Configurer la base de données**  
   - Crée une base de données MySQL nommée `gestion_utiilisateurs` (attention à l'orthographe).
   - Exemple de table `utilisateurs` :
     ```sql
     CREATE TABLE utilisateurs (
         id INT AUTO_INCREMENT PRIMARY KEY,
         nom VARCHAR(100) NOT NULL,
         email VARCHAR(100) NOT NULL UNIQUE,
         mot_de_passe VARCHAR(255) NOT NULL,
         role ENUM('admin', 'user') DEFAULT 'user'
     );
     ```
   - Modifie les identifiants de connexion dans [`includes/sign_in_db.php`](includes/sign_in_db.php) si besoin.

5. **Lancer l'application**  
   Accède à [http://localhost/Projet-CRUD/index.php](http://localhost/Projet-CRUD/index.php) dans ton navigateur.

## Utilisation

- **Inscription** : Les nouveaux utilisateurs peuvent s'inscrire via le lien sur la page de connexion.
- **Connexion** : Les utilisateurs se connectent avec leur email et mot de passe.
- **Admin** : Accède à un tableau de bord, peut gérer tous les utilisateurs.
- **Utilisateur** : Accède à son espace personnel.

## Sécurité

- Les mots de passe sont hachés avec `password_hash`.
- Les sessions sont vérifiées sur chaque page protégée.
- Les entrées sont validées côté serveur et côté client.

## Personnalisation

- Pour ajouter des fonctionnalités, modifie ou ajoute des fichiers dans les dossiers `actions/`, `forms/`, `includes/`, ou `pages/`.
- Pour changer le style, modifie les fichiers dans `bootstrap/`, `fontawesome/`, ou ajoute tes propres fichiers CSS dans `assets/`.

## Auteurs

- Projet réalisé par [Aristide GBOHAÏDA](https://github.com/aristide-ghd) dans le cadre d'un exercice de gestion d'utilisateurs en PHP.

---

**Remarque** :  
Ce projet est un exemple pédagogique. Pour un usage en production, il est recommandé de renforcer la sécurité (CSRF, validation avancée, gestion des erreurs, etc).
