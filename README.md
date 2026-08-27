# TomTroc

Projet réalisé dans le cadre de la formation **Développeur d'application PHP/Symfony** d'OpenClassrooms.

## Prérequis

* Docker et Docker Compose installés.
* Composer (ou accès au conteneur PHP pour exécuter Composer).

## Installation

1. Cloner le dépôt :

```bash
git clone <url-du-repository>
cd tomtroc
```

2. Démarrer les conteneurs Docker :

```bash
docker compose up --build
```

3. Installer les dépendances Composer dans le conteneur PHP :

```bash
docker exec -it tomtroc-php-1 bash

composer install
composer dump-autoload
```

## Lancer l'application

Une fois les conteneurs démarrés, l'application est accessible à l'adresse suivante :

**http://localhost:8085/index.php?action=home**