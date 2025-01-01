# SAÉ 3.01 - Développement d’une application

## 📄 Sujet

## 👥 Membres du groupe 
- Marcoux Corentin **(marc0237)** ou **(corentinmrcx)**
- Baudat Louis **(baud0157)**
- Lobreau Romain **(lobr0013)** ou **(RomsLob1)**

## 📝 Notes
- Identifiant : ``
- Mot de passe : ``
- Adresse IP : ``
- PassPhrase : ``
- Site : 

## 🛠️ Installation et configuration du projet
### 1. Installation 


### 3. Scripts Composer
- Script **Start** qui lance le serveur web de test *(« symfony serve »)* sans restriction de durée d'exécution :
    ```
    "start": [
            "Composer\\Config::disableProcessTimeout",
            "symfony serve"
    ],
   ```
- Script **test:phpcs** qui lance la commande de vérification du code par PHP CS Fixer :
    ```
    "test:phpcs": [
        "php vendor/bin/php-cs-fixer fix --dry-run"
    ],
  ```
- Script **fix:phpcs** qui lance la commande de correction du code par PHP CS Fixer :
    ```
    "fix:phpcs": [
        "php vendor/bin/php-cs-fixer fix"
    ],
  ```
- Script **test:twigcs** qui lance la commande de vérification du code par Twig CS Fixer :
    ```
    "test:twigcs": [
        "php vendor/bin/twig-cs-fixer lint"
    ],
    ```
- Script **fix:twigcs** qui lance la commande de correction du code par Twig CS Fixer :
    ```
    "fix:twigcs": [
        "php vendor/bin/twig-cs-fixer fix"
    ]
    ```
***
## Comptes et Authentification
| **Prénom - Nom** | **Email**                | **Mot de passe** | **Rôle**          |
|------------------|----------------------|--------------|---------------|
| Louis Baudat     | louis@example.com     | test         | ROLE_ADMIN    |
| Corentin Marcoux | corentin@example.com  | test         | ROLE_ADMIN    |
| Romain Lobreaux  | romain@example.com    | test         | ROLE_ADMIN    |
| Peter Parker     | user@example.com      | test         | ROLE_CUSTOMER |
| Tony Stark       | manager@example.com    | test         | ROLE_MANAGER  |
***

## Fonctionnalités du projet
### 1. Recherche de produits
- **Barre de recherche dynamique :**
  - Les utilisateurs peuvent rechercher des produits par **nom**, **marque** ou **catégorie**.
  - Les résultats de recherche sont affichés directement sur la page `/product`.
- **Affichage des résultats :**
  - Lorsque l'utilisateur effectue une recherche, un message indique les termes recherchés.
  - Si aucun produit ne correspond, un message est affiché.
### 2. Gestion des images de produits avec VichUploaderBundle
  - **Installation et configuration :**
     - Mise en place de **VichUploaderBundle** pour faciliter la gestion des fichiers uploadés.
      - Configuration d'un mapping product_images permettant de sauvegarder les images des produits dans le dossier `/public/images/products`.
- **Image par défaut :**
   - Si aucune image n'est uploadée pour un produit, une image par défaut (`default_image.webp`) est automatiquement affichée.
- **Affichage dynamique des images :**
   - Les templates utilisent `vich_uploader_asset` pour récupérer les images des produits.
   - Si aucune image n'est associée, l'image par défaut est utilisée via Twig.
  


