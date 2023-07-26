.PHONY: install
install:
	composer install

.PHONY: phpcs
phpcs:
	./vendor/bin/phpcs --standard=./vendor/spryker/code-sniffer/Spryker/ruleset.xml ./src/FondOfImpala/* ./tests/*

.PHONY: phpcbf
phpcbf:
	./vendor/bin/phpcbf --standard=./vendor/spryker/code-sniffer/Spryker/ruleset.xml ./src/FondOfImpala/* ./tests/*

.PHONY: phpstan
phpstan:
	./vendor/bin/phpstan --memory-limit=-1 analyse ./src/FondOfImpala ./tests

.PHONY: codeception
codeception:
	./vendor/bin/codecept run --env standalone

.PHONY: codeception-without-coverage
codeception-without-coverage:
	./vendor/bin/codecept run --env standalone

.PHONY: ci
ci: phpcs codeception phpstan
