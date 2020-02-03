up:
	docker-compose up -d

down:
	docker-compose down

restart:
	docker-compose restart

exec:
	docker-compose exec fpm bash

ps:
	docker-compose ps

rebuild:
	docker-compose up -d --build

n:
	docker-compose exec web nginx -s reload
