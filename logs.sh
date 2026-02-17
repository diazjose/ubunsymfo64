#!/usr/bin/env bash
set -e

echo "⚠️ Esto va a borrar la base de datos. Continuando..."

docker compose up -d

echo "⏳ Esperando MySQL..."
sleep 10

echo "💣 Borrando base..."
docker compose exec app php bin/console doctrine:database:drop --force --if-exists

echo "🗄️ Creando base..."
docker compose exec app php bin/console doctrine:database:create

echo "📑 Migrando..."
docker compose exec app php bin/console doctrine:migrations:migrate --no-interaction

echo "🧹 Cache clear..."
docker compose exec app php bin/console cache:clear

echo "✅ DB reseteada"
