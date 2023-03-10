# Date : 11/03/20
# Source author : Cyrille Grandval
# Edited by Arthur Djikpo
# Edited by Lory LÉTICÉE
# Date : 10/03/23

CONSOLE=bin/console
DC=docker compose
D=docker
HAS_DOCKER:=$(shell command -v $(DC) 2> /dev/null)

ifdef HAS_DOCKER
	EXECROOT=$(D) exec --privileged pdlc-php php
	EXEC=$(D) exec --privileged pdlc-php php
else
	EXECROOT=
	EXEC=
endif

.DEFAULT_GOAL := help

.PHONY: help ## Generate list of targets with descriptions
help:
		@grep '##' Makefile \
		| grep -v 'grep\|sed' \
		| sed 's/^\.PHONY: \(.*\) ##[\s|\S]*\(.*\)/\1:\2/' \
		| sed 's/\(^##\)//' \
		| sed 's/\(##\)/\t/' \
		| expand -t14

##
## Project setup & day to day shortcuts
##---------------------------------------------------------------------------

.PHONY: install ## Install the project (Install in first place)
install:
##	$(DC) pull || true
##	$(DC) build
	$(DC) up -d

.PHONY: composer ## Composer install
composer:
	$(EXEC) $(CONSOLE) doctrine:database:create --if-not-exists
	$(EXEC) $(CONSOLE) doctrine:schema:update --force --complete

.PHONY: stop ## stop the project
stop:
	$(DC) down

.PHONY: exec ## Run bash in the php container
exec:
	$(EXEC) /bin/bash

.PHONY: fixtures ## Install the fixtures
fixtures:
	$(EXEC) $(CONSOLE) doctrine:fixtures:load

.PHONY: all ## Install all & start the project

all: install composer