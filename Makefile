up: docker-up

init: docker-clear docker-up api-env api-composer

docker-clear:
	docker-compose down --remove-orphans
	sudo rm -rf api/var/docker

docker-up:
	docker-compose up --build -d

docker-clear:
	docker-compose down --remove-orphans

api-env:
	docker-compose exec api-php-cli rm -f .env
	docker-compose exec api-php-cli ln -sr .env.example .env

api-composer:
	docker-compose exec api-php-cli composer install
	docker-compose exec api-php-cli composer update

api-tests:
	docker-compose exec api-php-cli php vendor/bin/codecept run -v
