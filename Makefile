# Important note: use tab symbols "	" for indentation instead of spaces.
default: up

# Initial application setup.
.PHONY: docker--init
docker--init: docker--build docker--up docker--composer-install

.PHONY: docker--composer-install
docker--composer-install:
	docker compose exec --env XDEBUG_MODE=off appserver composer install

.PHONY: generate-qrcodes
generate-qrcodes:
	docker compose exec appserver composer generate-codes

.PHONY: docker--up up
docker--up:
	docker compose up -d
up: docker--up

.PHONY: docker--build build
docker--build:
	DOCKER_BUILDKIT=1 docker compose build --build-arg UID=$(shell id -u) --build-arg GID=$(shell id -g)
build: docker--build

.PHONY: docker--rebuild rebuild
docker--rebuild: docker--build docker--up
rebuild: docker--rebuild

.PHONY: docker--start start
docker--start:
	docker compose up -d --no-recreate
start: docker--start

.PHONY: docker--stop stop
docker--stop:
	docker compose stop
stop: docker--stop

.PHONY: docker--restart restart
docker--restart: docker--stop docker--up
restart: docker--restart

.PHONY: docker--destroy destroy
docker--destroy:
	docker compose down
destroy: docker--destroy

.PHONY: docker--ssh ssh
docker--ssh:
	docker compose exec appserver bash
ssh: docker--ssh
