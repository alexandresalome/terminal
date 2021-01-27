SHELL := /bin/bash

help:
	@echo "Targets:"
	@echo ""
	@echo "doc           Generate documentation"
	@echo "pip-install   Installs dependencies"
	@echo "phpunit       Runs PHPUnit tests"

.PHONY: doc
doc: venv pip-install
	@source venv/bin/activate && mkdocs

.PHONY: pip-install
pip-install:
	@source venv/bin/activate && pip install -q -r requirements.txt

.PHONY: phpunit
phpunit: vendor
	@vendor/bin/phpunit

venv:
	@python3 -m venv venv

vendor:
	@composer install

generate-images:
	php bin/render-examples.php
