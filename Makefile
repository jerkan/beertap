install:
	docker-compose --env-file .env.local up -d --build
	docker-compose exec app bash -c "composer install"
	.docker/setup-file-permissions.sh
	docker-compose exec app bash -c "php bin/console doc:mig:mig -n"
	docker-compose exec app bash -c "php bin/console --env=test doc:mig:mig -n"

start:
	docker-compose --env-file .env.local up -d

test:
	docker-compose exec app php ./vendor/bin/simple-phpunit

cache-clear:
	docker-compose exec app php bin/console cache:clear

bash:
	docker-compose exec app bash

stop:
	docker-compose stop
