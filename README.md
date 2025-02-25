# SAÉ 3.01 - Développement d’une application
## 📄 Sujet
### Pharmatic - Plateforme de gestion de pharmacie en ligne

**Pharmatic** est une application web développée pour simplifier la gestion des commandes et des stocks pour les pharmacies, tout en offrant une expérience utilisateur fluide et intuitive.

**Fonctionnalités principales :**
- **Côté utilisateur :**
  - Recherche avancée de produits, catégories ou marques avec une barre de recherche intégrée.
  - Filtres dynamiques pour affiner les résultats.
  - Gestion de panier interactif et passage de commandes sécurisé.
- **Côté administrateur :**
  - Gestion des stocks en temps réel.
  - Ajout, modification et suppression des produits via une interface dédiée.
  - Visualisation des commandes passées par les clients.

**Technologies utilisées :**
- **Back-end :** Framework Symfony, PHP 8, MySQL pour la gestion de la base de données.
- **Front-end :** HTML5, CSS3, JavaScript, avec une charte graphique élaborée.
- **Environnement de déploiement :** Machine virtuelle configurée en serveur (Linux, Apache/Nginx).

**Objectif pédagogique :**

Ce projet a été réalisé dans un contexte académique pour mettre en pratique des compétences en développement full-stack, gestion de projet et travail en équipe.

***

## 👥 Membres du groupe 
- Marcoux Corentin **(marc0237)** ou **(corentinmrcx)**
- Baudat Louis **(baud0156)**
- Lobreau Romain **(lobr0013)** ou **(RomsLob1)**

***

## 📝 Notes
**Machine Virtuelle :**
- Identifiant : `pc-client-sae3-01`
- Mot de passe : `Azerty01@`
- Adresse IP : `10.31.33.115`
- Site : http://2a4v3-31uvm0371.ad-urca.univ-reims.fr/

**Hebergement sur serveur web :** 
- https://pharmatic.corentinmarcoux.fr/

***

## ⚙️ Installation et configuration du projet
### 1. Pré-requis
Avant de commencer, assurez-vous d’avoir les éléments suivants installés sur votre machine :
- PHP (version 8.2)
- Composer
- Un serveur local (par exemple : WAMP, XAMPP, ou Symfony CLI)
- Git

### 2. Etapes d'installation
1. **Cloner le dépot**
   - Clonez le dépot en local avec la commande suivante : `git clone https://iut-info.univ-reims.fr/gitlab/marc0237/sae3-01.git`
2. **Installer les dépendances PHP avec Composer**
   - Exécutez la commande suivante pour installer les dépendances : `composer install`
3. **Configurer le fichier .env**
   - Dupliquez le fichier `.env` en `.env.local`
   - Mettez à jour les variables d’environnement (base de données, etc.) en fonction de votre configuration : 
     ```
     DATABASE_URL="mysql://username:password@localhost:3306/dbname"
     ```
4. **Installer la base de données**
   - Exécutez les commandes suivantes pour créer et peupler la base de données :
     ```
     php bin/console doctrine:database:create
     php bin/console doctrine:migrations:migrate
     ```
5. **Lancer le serveur de développement**
   - Démarrez le serveur Symfony avec : `composer start`
   
### 3. Scripts Composer
- `composer start` : Lance le serveur web de test.
- `composer test:phpcs` : Lance la commande de vérification du code par PHP CS Fixer.
- `composer fix:phpcs` : Lance la commande de correction du code par PHP CS Fixer.
- `composer test:twigcs` : Lance la commande de vérification du code par Twig CS Fixer.
- `composer fix:twigcs` : Lance la commande de de correction du code par Twig CS Fixer.
- `composer test:codeception` : Nettoie le répertoire « _output » et le code généré par Codeception, initialise la base de données de test et lance les tests de Codeception.
- `composer test` : Teste la mise en forme du code et lance les tests avec Codeception.
- `composer db` : Détruit et recrée la base de données, migre sa structure et regénère les données factices.

***

## 💻 Déploiement du projet et Création de la VM
Les étapes suivantes décrivent le processus d'installation et de configuration du projet sur une machine virtuelle, utilisé comme serveur de production. Ces commandes couvrent la mise en place de l'environnement, l'installation des dépendances nécessaires et la configuration des services pour que le projet fonctionne correctement.
- `sudo apt update && sudo apt upgrade` : Mettre à jour et mettre à niveau les paquets de la machine.
- `sudo apt install apache2` : Installer le serveur web Apache.
- `sudo apt install php libapache2-mod-php` : Installer PHP et le module Apache pour PHP.
- `sudo apt install mysql-server` : Installer le serveur de base de données MySQL.
- `sudo apt install composer` : Installer Composer pour gérer les dépendances PHP.
- `git clone <URL_du_dépôt>` : Cloner le dépôt Git contenant le projet sur la machine virtuelle.
- `composer install` : Installer les dépendances PHP du projet.
- `php bin/console doctrine:migrations:migrate` : Exécuter les migrations pour configurer la base de données.
- `sudo nano /etc/apache2/sites-available/000-default.conf` : Configurer un hôte virtuel Apache pour pointer vers le répertoire du projet.
- `sudo systemctl restart apache2` : Redémarrer Apache pour appliquer les modifications.
- `sudo ufw allow 80` : Autoriser les connexions HTTP sur le pare-feu (port 80).
- `sudo systemctl enable apache2` : S'assurer qu'Apache démarre automatiquement au démarrage de la machine.
- `sudo chmod -R 755 /var/www/html` : Définit les permissions des fichiers pour permettre leur exécution tout en assurant leur sécurité.  
- `sudo chown -R www-data:www-data /var/www/html` : Attribue les droits utilisateur et groupe au serveur web (www-data) pour accéder aux fichiers du projet.
- `php bin/console cache:clear` : Vider le cache Symfony pour s’assurer que le déploiement utilise la version la plus récente.
- `sudo reboot` : Redémarrer la machine virtuelle pour appliquer les changements majeurs.

***

## 🙋‍♂️ Comptes et Authentification
### 1. **Création de compte**
- Les utilisateurs peuvent créer un compte en remplissant un formulaire d'inscription avec obligatoirement les informations suivantes :
    - **Nom**
    - **Prénom**
    - **Adresse e-mail**
    - **Mot de passe**
    - **Numéro de téléphone**

### 2. **Connexion**
- **Page de connexion :** Les utilisateurs peuvent accéder à leur compte en se connectant via un formulaire de connexion avec leur **adresse e-mail** et **mot de passe**.
- Une fois connecté, les utilisateurs ont accès à toutes les fonctionnalités spécifiques selon leur rôle.
- **Modification des informations personnelles :** Les utilisateurs peuvent modifier leurs informations personnelles depuis leur profil.

### 3. **Gestion des rôles et des permissions**
- **Rôle client :** Un utilisateur standard (ROLE_CUSTOMER) peut effectuer des recherches, gérer son panier et passer des commandes.
- **Rôle gestionnaire :** Les utilisateurs avec le rôle de gestionnaire (ROLE_MANAGER) peuvent gérer les commandes et les produits.
- **Rôle administrateur :** Les administrateurs (ROLE_ADMIN) peuvent gérer les utilisateurs et suivrent les stocks. 

### 4. **Comptes**
| **Prénom - Nom** | **Email**                | **Mot de passe** | **Rôle**          |
|-----------------|----------------------|--------------|---------------|
| Louis Baudat    | louis@example.com     | test         | ROLE_ADMIN    |
| Corentin Marcoux | corentin@example.com  | test         | ROLE_ADMIN    |
| Romain Lobreau  | romain@example.com    | test         | ROLE_ADMIN    |
| Peter Parker    | user@example.com      | test         | ROLE_CUSTOMER |
| Tony Stark      | manager@example.com    | test         | ROLE_MANAGER  |

***

## 🛠️ Fonctionnalités du projet
### 1. Recherche de produits et filtres
- **Barre de recherche dynamique :**
  - Les utilisateurs peuvent rechercher des produits par **nom**, **marque** ou **catégorie**.
  - Les résultats de recherche sont affichés directement sur la page `/product`.
- **Filtres**
  - Les utilisateurs peuvent appliquer des filtres pour affiner les résultats selon les **catégories**, les **marques**, ou le **prix**.
  - Ces filtres peuvent être utilisés indépendamment de la recherche. Il est possible de filtrer les produits sans avoir à saisir de termes dans la barre de recherche.
  - Les filtres s'appliquent immédiatement et permettent de mettre à jour la liste des produits affichés en fonction des critères choisis.
  - Un bouton de **réinitialisation** est disponible pour revenir aux résultats sans filtre.
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
#### 3. **Gestion du Panier**
- **Ajout et mise à jour des produits :**
    - Les utilisateurs peuvent ajouter des produits au panier.
- **Calcul du total du panier :**
    - La somme des prix des produits, multipliée par leur quantité respective, est calculée dynamiquement.
- **Suppression des produits :**
    - Chaque ligne du panier dispose d’un bouton pour supprimer une quantité de 1 pour le produit.
- **Validation du panier :**
    - Vérification que les quantités demandées sont disponibles en stock avant validation.
    - En cas de dépassement des stocks, un message d’avertissement s’affiche.

#### 4. **Gestion des Commandes**
- **Création d’une commande :**
    - Une commande est générée à partir des produits du panier lors de sa validation.
    - Chaque commande contient :
        - La liste des produits commandés.
        - Les quantités associées.
        - Le prix total calculé dynamiquement.
- **Gestion des données utilisateur :**
    - Les commandes sont associées à l’utilisateur connecté via une relation **ManyToOne**.
- **Affichage des commandes :**
    - Les utilisateurs peuvent consulter l’historique de leurs commandes, incluant :
        - Les produits commandés.
        - Les quantités et le prix total.
  

#### 5. **Gestion des Stocks**
- **Mise à jour des stocks :**
    - Lors de la validation d’une commande, les quantités des produits en stock sont automatiquement mises à jour.
- **Vérification des stocks :**
    - Le système empêche la validation d’un panier si les quantités demandées dépassent celles disponibles en stock.
    - Un message d’erreur s’affiche si un produit n’est plus disponible.
- **Suivi des ruptures de stock :**
    - Les produits avec un stock insuffisant sont signalés dans le panier et les commandes.
***
## 📋 Autres
Les fichiers suivants sont disponibles dans le répertoire `files` :

1. **Cahier des charges** du projet au format PDF.
2. **Charte Graphique** de notre application au format PNG.
3. **MCD** mis à jour pour Doctrine au format PDF. 
4. **Rapport de progression** de la conception du projet au format PDF.
5. **PowerPoint** de la soutenance du projet au format PPTX.
6. **Fichier d'accès à la VM** au format VV.
