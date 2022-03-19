#### for php ####
.PHONY: start
start:
	docker-compose up -d php

.PHONY: shell
shell:
	docker-compose exec php81 bash

.PHONY: stop
stop:
	docker-compose stop php81

.PHONY: remove
remove:
	docker-compose rm php81

.PHONY: install
install:
	docker-compose run --rm composer install

.PHONY: update
update:
	docker-compose run --rm composer update

.PHONY: autoload
autoload:
	docker-compose run --rm composer dump-autoload

.PHONY: test
test:
	docker-compose run --rm php81 ./vendor/bin/phpunit

.PHONY: test80
test80:
	docker-compose run --rm php80 ./vendor/bin/phpunit

.PHONY: phpstan
phpstan:
	docker-compose run --rm phpstan analyse
