# Symfony 6.4 + Docker (Dev)

## Requisitos
- Docker
- Docker Compose
- VS Code

## Crea archivo de atajos Makefile y luego:
## Levantar entorno
make up

## Entrar al contenedor
make bash

## Acceder a la app
http://localhost:8080

## phpMyAdmin
http://localhost:8081

## Debug con VS Code
- Instalar extensión PHP Debug
- Presionar F5 (Listen for Xdebug)
- Poner breakpoints en src/Controller

## Base de datos
Host: db
User: symfony
Pass: symfony
DB: symfony


## Scripts docker
- up.sh — levantar todo (dev)
- down.sh — bajar todo
- reset-db.sh — borrar DB y recrear
- logs.sh — ver logs en vivo
- rebuild.sh — rebuild limpio (cuando tocás Dockerfile)
- deploy.sh — modo producción 