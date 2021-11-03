up:
	docker-compose up -d

down:
	docker-compose down

restart: down up

assets-watch:
	npm run watch

assets-dev:
	npm run dev

app-serve:
	symfony serve
