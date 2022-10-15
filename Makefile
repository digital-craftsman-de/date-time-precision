SHELL = /bin/bash

uid = $$(id -u)
gid = $$(id -g)
pwd = $$(pwd)

default: up

## update		Rebuild Docker images and start stack.
.PHONY: update
update: build up

## reset		Teardown stack, install and start.
.PHONY: reset
reset: .reset

.PHONY: .reset
.reset: .down .install .up

##
## Docker
## ------
##

## install	Install PHP dependencies.
.PHONY: .install
install: install-8.1

## install-8.1	Install with PHP 8.1.
.PHONY: install-8.1
install-8.1:
	docker-compose run --rm php-8.1 composer install

## install-8.2	Install with PHP 8.2.
.PHONY: install-8.2
install-8.2:
	docker-compose run --rm php-8.2 composer install

## build		Build the Docker images.
.PHONY: build
build:
	docker-compose build

## up		Start the Docker stack.
.PHONY: up
up: .up

.up:
	docker-compose up -d

## down		Stop the Docker stack.
.PHONY: down
down: .down

.down:
	docker-compose down

## php-cli	Enter a shell for PHP
.PHONY: .php-cli
php-cli: php-8.1-cli

## php-8.1-cli	Enter a shell for the PHP 8.1.
.PHONY: php-8.1-cli
php-8.1-cli:
	docker-compose run --rm php-8.1 sh

##
## Tests and code quality
## -----
##

## verify		Run the PHP tests.
.PHONY: verify
verify: php-code-validation php-tests php-mutation-testing

## php-tests		Run the PHP tests.
.PHONY: php-tests
php-tests: php-8.1-tests php-8.2-tests

## php-8.1-tests		Run tests on PHP 8.1.
.PHONY: php-8.1-tests
php-8.1-tests:
	docker-compose run --rm php-8.1 ./vendor/bin/phpunit

## php-8.2-tests		Run tests on PHP 8.2.
.PHONY: php-8.2-tests
php-8.2-tests:
	docker-compose run --rm php-8.2 ./vendor/bin/phpunit

## php-8.1-tests-ci		Run the tests for PHP 8.1 for CI.
.PHONY: php-8.1-tests-ci
php-8.1-tests-ci:
	docker-compose run --rm php-8.1 ./vendor/bin/phpunit --coverage-clover ./coverage.xml

## php-8.2-tests-ci		Run the tests for PHP 8.2 for CI.
.PHONY: php-8.2-tests-ci
php-8.2-tests-ci:
	docker-compose run --rm php-8.2 ./vendor/bin/phpunit

## php-8.1-tests-html-coverage		Run the PHP tests with coverage report as HTML.
.PHONY: php-8.1-tests-html-coverage
php-8.1-tests-html-coverage:
	docker-compose run --rm php-8.1 ./vendor/bin/phpunit --coverage-html ./coverage

## php-8.2-tests-html-coverage		Run the PHP tests with coverage report as HTML.
.PHONY: php-8.2-tests-html-coverage
php-8.2-tests-html-coverage:
	docker-compose run --rm php-8.2 ./vendor/bin/phpunit --coverage-html ./coverage

## php-code-validation		Run code fixers and linters for PHP.
.PHONY: php-code-validation
php-code-validation:
	docker-compose run --rm php-8.1 ./vendor/bin/php-cs-fixer fix
	docker-compose run --rm php-8.1 ./vendor/bin/psalm --show-info=false --no-diff

## php-mutation-testing		Run mutation testing
.PHONY: php-mutation-testing
php-mutation-testing:
	docker-compose run --rm php-8.1 ./vendor/bin/infection --show-mutations --threads=8

## php-mutation-testing-ci		Run mutation testing for CI.
.PHONY: php-mutation-testing-ci
php-mutation-testing-ci:
	docker-compose run --rm php-8.1 ./vendor/bin/infection --min-msi=100 --min-covered-msi=100 --threads=8
