.PHONY: update
update:
	composer update

.PHONY: install
install:
	composer install --no-dev

.PHONY: install-dev
install-dev:
	composer install

.PHONY: phpcs
phpcs:
	./vendor/bin/phpcs --standard=./vendor/spryker/code-sniffer/Spryker/ruleset.xml ./src/FondOfImpala/ ./tests/FondOfImpala/

.PHONY: phpcbf
phpcbf:
	./vendor/bin/phpcbf --standard=./vendor/spryker/code-sniffer/Spryker/ruleset.xml ./src/FondOfImpala/ ./tests/FondOfImpala/

.PHONY: phpstan
phpstan:
	php -d memory_limit=-1 ./vendor/bin/phpstan analyse -l 4 ./src/FondOfImpala

.PHONY: codeception
codeception:
	./vendor/bin/codecept run --env standalone

.PHONY: ci
ci: phpcs codeception phpstan

.PHONY: clean
clean:
	rm -Rf composer.lock
	rm -Rf ./vendor
	find ./tests/_output/ -not -name .gitignore -delete
	rm -Rf src/Generated/*
	rm -Rf src/Orm/*
