DC=docker-compose
APP=$(DC) exec -u 1000 php
DB=$(DC) exec db
DBT=$(DC) exec -T db

default:
	@echo 'Please provide correct command'

up:
	$(DC) up -d --build

down:
	$(DC) down

restart: down up

migrate:
	$(APP) php artisan migrate

install: up composer migrate

bash:
	$(APP) /bin/bash

voip-bash:
	$(DC) exec voip bash

asterisk:
	$(DC) exec voip asterisk -rvvvv

db:
	$(DB) /bin/bash

composer:
	$(APP) composer install
	$(APP) composer install --working-dir=./tools/php-cs-fixer

setup-test:
	$(DB) mysql -uroot -p12345678 -e "CREATE DATABASE IF NOT EXISTS test;"
	$(APP) php artisan migrate:fresh --env=testing

test:
	$(APP) php artisan optimize:clear --env=testing
	$(APP) php artisan test

ide-helper:
	$(APP) php artisan clear-compiled
	$(APP) php artisan ide-helper:generate
	$(APP) php artisan ide-helper:models -N
	$(APP) php artisan ide-helper:meta

cs-fix:
	$(APP) tools/php-cs-fixer/vendor/bin/php-cs-fixer fix --allow-risky=yes

