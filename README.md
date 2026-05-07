# 🎬 Mes Films Préférés

Application web développée dans le cadre du **BTS SIO** permettant de rechercher des films via l'API TMDB, de gérer ses favoris, de donner des avis, d'ajouter des amis et de partager des films.

---

## 📋 Contexte

Ce projet répond à un cahier des charges BTS SIO : développer une application exploitant une **API REST externe** (TMDB - The Movie Database). L'objectif est de proposer une plateforme sociale autour du cinéma, où chaque utilisateur peut constituer sa liste de films préférés et interagir avec ses amis.

---

## 🛠️ Stack technique

| Couche | Technologie |
|---|---|
| Framework back-end | Laravel 11 (PHP 8.2+) |
| Base de données | SQLite (dev) / MySQL (prod) |
| Moteur de templates | Blade |
| Build front-end | Vite.js |
| CSS | Vanilla CSS (thème cinéma custom) |
| API externe | TMDB v3 (The Movie Database) |
| Authentification | Laravel Auth (sessions) |
| Sécurité | Rate limiting, headers HTTP, CSRF, XSS |
| Versioning | Git / GitHub |

---

## 🗂️ Architecture du projet

```
mesFilmsPreferes/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/              # LoginController, RegisterController
│   │   │   ├── FilmsController    # Recherche + détail TMDB + ajout favori
│   │   │   ├── FavorisController  # Liste, suppression favoris
│   │   │   ├── AvisController     # Créer, modifier, supprimer un avis
│   │   │   ├── AmisController     # Recherche, ajout, retrait d'amis (réciproque)
│   │   │   ├── PartagesController # Partager un film à un ami
│   │   │   ├── ProfilController   # Mon profil + profil public d'un ami
│   │   │   └── HomeController     # Page d'accueil avec stats
│   │   └── Middleware/
│   │       └── SecurityHeaders    # Headers HTTP de sécurité
│   ├── Models/
│   │   ├── User.php
│   │   ├── Favori.php
│   │   ├── Avis.php
│   │   ├── Ami.php
│   │   └── Partage.php
│   └── Services/
│       └── TmdbService.php        # Client HTTP pour l'API TMDB
├── database/migrations/           # Migrations Laravel
├── resources/
│   ├── views/                     # Vues Blade
│   └── css/app.css                # Styles globaux (thème cinéma)
└── routes/web.php                 # Toutes les routes de l'application
```

---

## 🗄️ Schéma de base de données

```
users           favoris              avis
──────          ───────              ────
id              id                   id
firstname       user_id (FK)         favori_id (FK)
lastname        tmdb_id              user_id (FK)
username        titre                note (1-5)
email           synopsis             commentaire
password        affiche              created_at
created_at      annee                updated_at
updated_at      note_tmdb
                created_at
                updated_at

amis            partages
────            ────────
id              id
user_id (FK)    user_id (FK)     ← celui qui partage
friend_id (FK)  ami_id (FK)      ← celui qui reçoit
created_at      favori_id (FK)
updated_at      message
                created_at
                updated_at
```

---

## 🚀 Installation

### Prérequis
- PHP 8.2+
- Composer
- Node.js 18+
- Une clé API TMDB (gratuite sur [themoviedb.org](https://www.themoviedb.org/settings/api))

### Étapes

```bash
# 1. Cloner le projet
git clone https://github.com/Mateo-R13/mesFilmsPreferes.git
cd mesFilmsPreferes

# 2. Installer les dépendances PHP
composer install

# 3. Installer les dépendances JS
npm install

# 4. Configurer l'environnement
cp .env.example .env
php artisan key:generate

# 5. Renseigner la clé TMDB dans .env
# TMDB_API_KEY=ta_cle_ici

# 6. Créer la base de données et jouer les migrations
php artisan migrate

# 7. Compiler les assets
npm run build
# ou en développement :
npm run dev

# 8. Lancer le serveur
php artisan serve
```

L'application est accessible sur **http://localhost:8000**.

---

## 📖 Guide d'utilisation

### 1. Créer un compte
- Clique sur **"Créer un compte"** depuis la page d'accueil
- Remplis prénom, nom, nom d'utilisateur, email et mot de passe (8 caractères minimum)
- Tu es automatiquement connecté après l'inscription

### 2. Rechercher un film
- Va dans **"Rechercher"** dans la barre de navigation
- Tape le titre d'un film dans la barre de recherche
- Les résultats proviennent en temps réel de l'API TMDB
- Clique sur **"Détails"** pour voir la fiche complète du film
- Clique sur **"+ Ajouter aux favoris"** pour sauvegarder le film

### 3. Gérer ses favoris
- Va dans **"Mes favoris"** pour voir ta liste
- Tu peux **trier** par date d'ajout, note TMDB ou titre A→Z
- Sur chaque carte :
  - **"+ Donner un avis"** → note de 1 à 5 étoiles + commentaire optionnel
  - **"📤 Partager"** → partager le film directement à un ami
  - **"Retirer"** → supprimer le film de tes favoris

### 4. Ajouter des amis
- Va dans **"Mes amis"**
- Utilise la barre de recherche pour trouver un utilisateur par username, email, prénom ou nom
- Clique sur **"+ Ajouter"** → l'amitié est **automatiquement réciproque** (les deux utilisateurs se voient dans leurs amis)
- Pour retirer un ami, clique sur **"Retirer"** — les deux liens sont supprimés

### 5. Voir le profil d'un ami
- Depuis **"Mes amis"**, clique sur **"Voir profil"**
- Tu accèdes au profil de ton ami avec ses statistiques et toute sa liste de favoris
- Tu peux **ajouter directement un de ses films** à tes propres favoris

### 6. Partager un film
- **Depuis "Mes favoris"** : clique sur **"📤 Partager"** sur la carte du film, choisis un ami et ajoute un message optionnel
- **Depuis "Mes partages"** : utilise le formulaire dédié avec les menus déroulants
- Dans **"Mes partages"** tu vois :
  - **Reçus** : les films que tes amis t'ont partagés, avec leur message
  - **Envoyés** : l'historique de tes partages

### 7. Modifier son profil
- Va dans **"Mon profil"** puis clique sur **"✏️ Modifier"**
- Tu peux modifier prénom, nom, username, email et mot de passe
- Les statistiques (favoris, avis, amis, partages) sont visibles sur la page profil

---

## 🔒 Sécurité

| Mesure | Description |
|---|---|
| CSRF | Token `@csrf` sur tous les formulaires (natif Laravel) |
| Rate limiting | Max 5 tentatives de connexion / minute par IP |
| XSS | `strip_tags()` sur les inputs, `e()` sur les sorties |
| Injection SQL | Requêtes via Eloquent ORM (requêtes préparées) |
| Contrôle d'accès | Vérification `user_id` sur chaque ressource sensible |
| Headers HTTP | X-Frame-Options, X-Content-Type-Options, HSTS, Referrer-Policy |
| Mots de passe | Hachage `bcrypt` via `Hash::make()` |
| Auth | Middleware `auth` sur toutes les routes protégées |

---

## 🌐 Routes disponibles

| Méthode | URL | Description | Auth |
|---|---|---|---|
| GET | `/` | Page d'accueil | Non |
| GET | `/register` | Formulaire d'inscription | Guest |
| POST | `/register` | Créer un compte | Guest |
| GET | `/login` | Formulaire de connexion | Guest |
| POST | `/login` | Connexion | Guest |
| POST | `/logout` | Déconnexion | Oui |
| GET | `/films/rechercher` | Rechercher un film | Oui |
| GET | `/films/{tmdbId}` | Fiche d'un film | Oui |
| POST | `/films/ajouter-favori` | Ajouter aux favoris | Oui |
| GET | `/favoris` | Mes favoris | Oui |
| POST | `/favoris/{favori}` | Supprimer un favori | Oui |
| POST | `/avis/{favori}` | Ajouter un avis | Oui |
| POST | `/avis/{avis}/update` | Modifier un avis | Oui |
| POST | `/avis/{avis}/delete` | Supprimer un avis | Oui |
| GET | `/amis` | Mes amis | Oui |
| POST | `/amis/{user}/ajouter` | Ajouter un ami | Oui |
| POST | `/amis/{user}/retirer` | Retirer un ami | Oui |
| GET | `/partages` | Mes partages | Oui |
| POST | `/partages/ajouter` | Partager un film | Oui |
| GET | `/profil` | Mon profil | Oui |
| GET | `/profil/edit` | Modifier mon profil | Oui |
| POST | `/profil/update` | Sauvegarder les modifications | Oui |
| GET | `/profil/{user}` | Profil public d'un ami | Oui |

---

## 👤 Auteur

**Mateo Roca** — BTS SIO  
[GitHub @Mateo-R13](https://github.com/Mateo-R13)

---

*Données films fournies par [TMDB](https://www.themoviedb.org). Ce produit utilise l'API TMDB mais n'est ni approuvé ni certifié par TMDB.*
