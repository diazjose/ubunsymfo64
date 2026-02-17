#!/usr/bin/env bash
set -e

echo "🚀 Deploy producción..."

docker compose -f docker-compose.prod.yml down
docker compose -f docker-compose.prod.yml up -d --build

echo "⏳ Esperando DB..."
sleep 10

docker compose -f docker-compose.prod.yml exec app composer install --no-dev --optimize-autoloader --no-interaction
docker compose -f docker-compose.prod.yml exec app php bin/console doctrine:migrations:migrate --no-interaction
docker compose -f docker-compose.prod.yml exec app php bin/console cache:clear --env=prod

echo "✅ Deploy PROD listo"
