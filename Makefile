.PHONY: help

help:
	@echo ''
	@echo 'Usage:'
	@echo '  make [COMMAND]'
	@echo ''
	@echo 'Available commands:'
	@echo '  install  Install project'
	@echo '  update   Update project'
	@echo '  up       Start docker containers'
	@echo '  down     Stop docker containers'
	@echo '  migrate  Apply migrations'
	@echo ''

install:
	composer install
	npm install
	cp .env.example .env
	php artisan key:generate

update:
	composer install
	npm install

up:
	docker-compose up -d

down:
	docker-compose stop

migrate:
	docker-compose exec -T -u nobody backend php artisan migrate
