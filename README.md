# 🍓 Jam


Projet e-commerce de confitures avec panier, espace d'administration et filtres avancés.

Veuillez trouver sur le [wiki](https://github.com/IssaDia/application_jam_3wa-api/wiki) les détails des choix d'implémentation ainsi que les réponses à une partie de l'examen

# 📜 Sommaire

- [Objectif](#-objectif)
- [Construit avec](#-construit-avec)
- [Mon environnement de code et mes outils](#-mon-environnement-de-code-et-mes-outils)
- [Pourquoi ce choix](#-pourquoi-ce-choix)
- [Le plus gros challenge du projet](#-le-plus-gros-challenge-du-projet)
- [Feedback](#-feedback)

- [Comment démarrer l'application](#-comment-démarrer-application)
- [Node Package Manager](#-node-package-manager)
- [Installer les packages](#-installer-les-packages)
- [Lancer l'application](#-rlancer-application)
- [Lancer les Tests](#-lancer-les-tests)
- [A améliorer](#-a-ameliorer)

## Objectif principal

- Mettre en place une api permettant la consommation du service depuis divers dispositifs

## 🏗 Construit avec

- Symfony 6.2
- Webpack encore
- EasyAdmin
- Stripe
- Api platform
- Lexik JWT

## Mon environnement de code et mes outils

- VsCode
- MacOs
- NPM
- EsLint
- Prettier
- Postman

## Le plus gros challenge sur le projet

- Mettre en place le JWT token afin de sécuriser l'api et d'authentifier les utilisateurs

  
## Feedback

Bonne opportunité d'analyser un projet en cours et d'apporter une solution adapté à une problématique

## Pré-requis :

- Avoir PHP >=8.1 installé.
- Avoir installé composer
- Avoir installé le CLI symfony

Aide à l'installation à la fin de ce README.

Pour vérifier vos versions :

```bash
php -v
composer -v
```

Télécharger et installer la partie front end présente ici : https://github.com/IssaDia/application_jam_3wa-front

## Quick start

### 1. Démarrez par vous créer un compte Stripe sur https://dashboard.stripe.com/ <br>

Lorsqu'il vous sera demandé vos informations sur : https://dashboard.stripe.com/account/onboarding/business-structure
![README/img.png](README/img.png)
Il vous suffit de cliquer sur continuer, vous n'avez rien de plus à remplir pour rendre effectif votre compte.
<br><br>
Puis, <br>
Allez sur https://dashboard.stripe.com/test/dashboard Votre clé secrète se trouve en bas à droite sur votre dashboard. Ciquez sur l'oeil pour la découvrir.
![README/img_1.png](README/img_1.png)

### 2. Créer un fichier /.env.local :<br>

Mettre à jour ses identifiants de connexion MySql et sa secretkey de Stripe

```
STRIPE_API_KEY="sk_test_..."
DATABASE_URL="mysql://user:password@127.0.0.1:8889/shop?serverVersion=5.7.9"

```

### 3. Console

Enfin, installez les dépendances, créez votre base de données et remplissez la des fixtures grâce aux commandes suivantes :

```
composer install
npm install
npm run build
php bin/console doctrine:database:create
php bin/console make:migration
php bin/console doctrine:migration:migrate
php bin/console doctrine:fixtures:load
symfony server:start
```

Les fixtures permettent de créer les produits, les catégories et un utilisateur Admin.


Puis télécharger le repository et installer la partie front end présente ici : https://github.com/IssaDia/application_jam_3wa-front

## Ressources

### Installer Composer

1. Windows <br>
   https://getcomposer.org/Composer-Setup.exe

2. Mac ou Linux<br>

```
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === '906a84df04cea2aa72f40b5f787e49f22d4c2f19492ac310e8cba5b96ac8b64115ac402c8cd292b8a03482574915d1a8') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
mv composer.phar /usr/local/bin/composer
```

### Installation CLI SYMFONY

1. Windows<br>
   https://github.com/symfony-cli/symfony-cli/releases/download/v5.4.2/symfony-cli_windows_amd64.zip <br>
   Dézipper dans le dossier de votre choix et ajouter le path du dossier dans le Path des variable d'environnement système
   <br><br>
2. Mac ou Linux<br>

```
wget https://get.symfony.com/cli/installer -O - | bash
mv /Users/VOTRENOM/.symfony5/bin/symfony /usr/local/bin/symfony
```

## 🧪 Lancer les tests

Pour lancer les tests unitaires:

```
php bin/phpunit                       
```

## 📑 A améliorer

- Plus de tests unitaires
- Mise en place de Docker pour faciliter l'accés à l'application

