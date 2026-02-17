#!/usr/bin/env bash
echo "🔁 Rebuild completo..."
docker compose down -v
docker compose build --no-cache
docker compose up -d
echo "✅ Rebuild terminado"
