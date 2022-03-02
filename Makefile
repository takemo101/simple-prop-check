#### for php ####
.PHONY: start
start:
	docker-compose up -d php

.PHONY: shell
shell:
	docker-compose exec php bash

.PHONY: stop
stop:
	docker-compose stop php

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
	docker-compose run --rm php ./vendor/bin/phpunit

.PHONY: phpstan
phpstan:
	docker-compose run --rm phpstan analyse

#### for document ####
# draw.io command name
DRAWIO_COMMAND_NAME = draw.io
# draw.io application path
DRAWIO_APPLICATION_PATH = /Applications/draw.io.app/Contents/MacOS/draw.io
# pdf output path
DRAWIO_OUTPUT_PATH = ./document/pdf
# pdf input path
DRAWIO_INPUT_PATH = ./document

# please install draw.io application
# https://github.com/jgraph/drawio-desktop/releases
setup-di-mac:
	echo 'alias ${DRAWIO_COMMAND_NAME}=${DRAWIO_APPLICATION_PATH}' >> ~/.bash_profile
	source ~/.bash_profile

# output pdf
.PHONY: pdf
pdf:
	${DRAWIO_APPLICATION_PATH} -xrf pdf -a -o ${DRAWIO_OUTPUT_PATH} ${DRAWIO_INPUT_PATH}
