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
    echo "[INFO] .env existe déjà, conservation des valeurs existantes"
fi

# 2. SESSION_DRIVER=file uniquement (ne touche pas CACHE_STORE)
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

echo "[OK] SESSION_DRIVER=file et SESSION_LIFETIME=360 appliqués"
echo "[INFO] CACHE_STORE et DB_* non modifiés (conservation de ta config)"

# 3. Installer les dépendances
echo ""
echo "--- Installation des dépendances PHP ---"
composer install --no-interaction --prefer-dist

echo ""
echo "--- Installation des dépendances JS ---"
npm install

# 4. Générer la clé app si absente
if grep -q "^APP_KEY=$" .env || ! grep -q "^APP_KEY=" .env; then
    php artisan key:generate
    echo "[OK] Clé application générée"
fi

# 5. Migrations avec confirmation
echo ""
read -p "⚠️  Lancer php artisan migrate ? Cela peut modifier ta base de données. (o/N) : " confirm
if [[ "$confirm" =~ ^[oO]$ ]]; then
    php artisan migrate
    echo "[OK] Migrations exécutées"
else
    echo "[SKIP] Migrations ignorées"
fi

# 6. Vider les caches
echo ""
echo "--- Nettoyage des caches ---"
php artisan config:clear
php artisan cache:clear
php artisan view:clear
echo "[OK] Caches nettoyés"

# 7. Build assets
echo ""
echo "--- Compilation des assets ---"
npm run build

echo ""
echo "=== ✅ Setup terminé ! Lancer avec : php artisan serve ==="
echo ""
