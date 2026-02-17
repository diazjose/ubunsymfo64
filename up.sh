#!/usr/bin/env bash
set -e

echo "🐳 Build + up de Docker..."
docker compose down -v
docker compose up -d --build

echo "⏳ Esperando a que MySQL esté listo..."
sleep 10

echo "📦 Instalando dependencias (Composer)..."
docker compose exec app composer install --no-interaction

#echo "🗄️ Creando base de datos..."
#docker compose exec app php bin/console doctrine:database:create --if-not-exists

#echo "📑 Ejecutando migraciones..."
#docker compose exec app php bin/console doctrine:migrations:migrate --no-interaction

echo "🧹 Limpiando cache..."
docker compose exec app php bin/console cache:clear

echo "✅ Listo: http://localhost:8080"
