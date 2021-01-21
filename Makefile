SHELL := /bin/bash

help:
	@echo "Targets:"
	@echo ""
	@echo "doc           Generate documentation"
	@echo "pip-install   Installs dependencies"

.PHONY: doc
doc: venv pip-install
	source venv/bin/activate && mkdocs

.PHONY: pip-install
pip-install:
	source venv/bin/activate && pip install -q -r requirements.txt

venv:
	python3 -m venv venv
