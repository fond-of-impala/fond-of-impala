BASE_DIRECTORY ?= $(shell dirname $(realpath $(firstword $(MAKEFILE_LIST))))

.PHONY: install
install:
	composer install

.PHONY: phpcs
phpcs:
	./vendor/bin/phpcs -d memory_limit=-1 --standard=./vendor/spryker/code-sniffer/Spryker/ruleset.xml --parallel=75 ./bundles/*

.PHONY: phpcs-with-cache
phpcs-with-cache:
	./vendor/bin/phpcs -d memory_limit=-1 --cache=phpcs.cache --standard=./vendor/spryker/code-sniffer/Spryker/ruleset.xml --parallel=75 ./bundles/*

.PHONY: phpcbf
phpcbf:
	./vendor/bin/phpcbf -d memory_limit=-1 --standard=./vendor/spryker/code-sniffer/Spryker/ruleset.xml ./bundles/*

.PHONY: phpstan
phpstan:
	./vendor/bin/phpstan --memory-limit=-1 analyse ./bundles/*/src/

.PHONY: codeception
codeception:
	./vendor/bin/codecept run --env monorepo --coverage --coverage-xml --coverage-html

.PHONY: codeception-without-coverage
codeception-without-coverage:
	./vendor/bin/codecept run --env monorepo

.PHONY: prepare-dandelion-config
prepare-dandelion-config:
	sed -i "s/<GITHUB_TOKEN>/$(GITHUB_TOKEN)/" $(BASE_DIRECTORY)/dandelion.json

.PHONY: init-split-repos
init-split-repos:
	docker run -i -v $(BASE_DIRECTORY):/home/dandelion/project -w /home/dandelion/project dandelionphp/dandelion:latest dandelion split-repository:init:all

.PHONY: split
split:
	docker run -i -v $(BASE_DIRECTORY):/home/dandelion/project -w /home/dandelion/project dandelionphp/dandelion:latest dandelion split:all $(BRANCH)

.PHONY: release
release:
	docker run -i -v $(BASE_DIRECTORY):/home/dandelion/project -w /home/dandelion/project dandelionphp/dandelion:latest dandelion release:all $(BRANCH)

.PHONY: ci
ci: phpcs codeception phpstan

.PHONY: print-composer-replace-content
print-composer-replace-content:
	./Makefile.d/composer.sh print_replace_content

.PHONY: add-all-to-packagist
add-all-to-packagist:
	./Makefile.d/packagist.sh add_all

.PHONY: ci-bundles
ci-bundles:
	./Makefile.d/bundle.sh test_all

.PHONY: ci-bundle
ci-bundle:
	@read -p "Enter Bundle Name: " BUNDLE; \
	./Makefile.d/bundle.sh test $$BUNDLE
