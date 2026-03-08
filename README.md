# 🎬 Mes Films Préférés

Application web Laravel permettant à des amis de partager leurs films préférés et de donner leur avis.

![Laravel](https://img.shields.io/badge/Laravel-12.x-red) ![PHP](https://img.shields.io/badge/PHP-8.5-blue) ![SQLite](https://img.shields.io/badge/DB-SQLite%20%2F%20MySQL-green)

## Fonctionnalités

- ✅ Inscription et connexion utilisateur
- ✅ Recherche de films via l'API TMDB
- ✅ Ajout de films en favoris
- ✅ Ajout d'un avis (note 1-5 étoiles + commentaire) sur ses favoris
- ✅ Gestion des amis (ajouter / retirer)
- ✅ Partage individuel d'un favori à un ami
- ✅ Consultation des films partagés avec moi
- ✅ Profil utilisateur modifiable
- ✅ Page détail d'un film (synopsis, casting, note TMDB)

## Installation

### Prérequis
- PHP 8.2+
- Composer
- Node.js + npm
- Une clé API TMDB gratuite ([themoviedb.org](https://www.themoviedb.org/settings/api))

### Étapes

```bash
# 1. Cloner le repo
git clone https://github.com/Mateo-R13/mesFilmsPreferes.git
cd mesFilmsPreferes

# 2. Installer les dépendances PHP
composer install

# 3. Copier et configurer l'environnement
cp .env.example .env
php artisan key:generate

# 4. Configurer la base de données et la clé TMDB dans .env
# DB_CONNECTION=sqlite  (ou mysql)
# TMDB_API_KEY=ta_clé_ici

# 5. Créer la base et lancer les migrations
php artisan migrate

# 6. Installer les dépendances JS et compiler
npm install
npm run dev

# 7. Lancer le serveur
php artisan serve
```

Ouvrir **http://localhost:8000** 🎉

## Stack technique

| Couche | Technologie |
|---|---|
| Backend | Laravel 12, PHP 8.5 |
| Base de données | SQLite (dev) / MySQL (prod) |
| Frontend | Blade, Vite, CSS custom |
| API externe | TMDB (The Movie Database) |
| Auth | Laravel Auth (classe Auth) |

## Structure des modèles

```
User → hasMany Favori
Favori → hasOne Avis
Favori → hasMany Partage
User → hasMany Ami
Partage → belongsTo User (expéditeur)
Partage → belongsTo User (destinataire)
```

## Obtenir une clé API TMDB

1. Créer un compte sur [themoviedb.org](https://www.themoviedb.org/signup)
2. Aller dans **Paramètres → API**
3. Cliquer sur **"Créer"** → choisir **Developer** (gratuit)
4. Copier la clé dans `.env` : `TMDB_API_KEY=ta_clé`

## Auteur

Projet réalisé dans le cadre d'un cours Laravel — ESN TopDev
