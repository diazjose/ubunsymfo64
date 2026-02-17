up:
	docker compose up -d --build

down:
	docker compose down

bash:
	docker exec -it symfony_app bash

logs:
	docker logs -f symfony_app

db:
	docker exec -it symfony_db mysql -u symfony -p

migrate:
	docker exec -it symfony_app php bin/console doctrine:migrations:migrate
