#!/bin/bash
# ===========================================
# Script de configuration rapide - Mes Films Préférés
# Usage : bash setup.sh
# ===========================================

echo ""
echo "=== 🎬 Mes Films Préférés - Setup ==="
echo ""

# 1. Copier .env si absent
if [ ! -f .env ]; then
    cp .env.example .env
    echo "[OK] .env créé depuis .env.example"
else
    echo "[INFO] .env existe déjà"
fi

# 2. Forcer SESSION_DRIVER=file et SESSION_LIFETIME=360 dans .env
if grep -q "^SESSION_DRIVER=" .env; then
    sed -i 's/^SESSION_DRIVER=.*/SESSION_DRIVER=file/' .env
else
    echo "SESSION_DRIVER=file" >> .env
fi

if grep -q "^SESSION_LIFETIME=" .env; then
    sed -i 's/^SESSION_LIFETIME=.*/SESSION_LIFETIME=360/' .env
else
    echo "SESSION_LIFETIME=360" >> .env
fi

if grep -q "^CACHE_STORE=" .env; then
    sed -i 's/^CACHE_STORE=.*/CACHE_STORE=file/' .env
else
    echo "CACHE_STORE=file" >> .env
fi

echo "[OK] SESSION_DRIVER=file, SESSION_LIFETIME=360, CACHE_STORE=file appliqués"

# 3. Installer les dépendances
echo ""
echo "--- Installation des dépendances PHP ---"
composer install --no-interaction --prefer-dist

echo ""
echo "--- Installation des dépendances JS ---"
npm install

# 4. Générer la clé app si absente
if grep -q "^APP_KEY=$" .env; then
    php artisan key:generate
    echo "[OK] Clé application générée"
fi

# 5. Migrations
echo ""
echo "--- Exécution des migrations ---"
php artisan migrate --force

# 6. Vider les caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# 7. Build assets
echo ""
echo "--- Compilation des assets ---"
npm run build

echo ""
echo "=== ✅ Setup terminé ! Lancer avec : php artisan serve ==="
echo ""
