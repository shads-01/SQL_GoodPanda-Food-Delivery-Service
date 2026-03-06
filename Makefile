# ─────────────────────────────────────────────────────────────────
# GoodPanda — Makefile shortcuts
# Usage: make <command>
# ─────────────────────────────────────────────────────────────────

.PHONY: help up down build restart logs shell migrate fresh seed \
        test composer npm artisan key-generate db-create

# Default: show help
help:
	@echo ""
	@echo "  GoodPanda Dev Commands"
	@echo "  ─────────────────────────────────────────"
	@echo "  make up          Start all containers"
	@echo "  make up-dev      Start containers + Vite (npm run dev)"
	@echo "  make down        Stop all containers"
	@echo "  make build       Rebuild Docker images"
	@echo "  make restart     Down + Up"
	@echo "  make logs        Tail all container logs"
	@echo "  make shell       Open shell inside app container"
	@echo "  make migrate     Run database migrations"
	@echo "  make fresh       Drop all tables and re-migrate"
	@echo "  make seed        Run database seeders"
	@echo "  make test        Run Pest test suite"
	@echo "  make key         Generate APP_KEY"
	@echo "  make db-create   Create the database in SQL Server"
	@echo ""

# ─────────────────────────────────────────
# Container management
# ─────────────────────────────────────────
up:
	docker compose up -d

up-dev:
	docker compose --profile dev up -d

down:
	docker compose down

build:
	docker compose build --no-cache

restart: down up

logs:
	docker compose logs -f

# ─────────────────────────────────────────
# App shell
# ─────────────────────────────────────────
shell:
	docker compose exec app bash

# ─────────────────────────────────────────
# Laravel commands (run inside app container)
# ─────────────────────────────────────────
key:
	docker compose exec app php artisan key:generate

migrate:
	docker compose exec app php artisan migrate

fresh:
	docker compose exec app php artisan migrate:fresh

seed:
	docker compose exec app php artisan migrate:fresh --seed

test:
	docker compose exec app php artisan test

artisan:
	docker compose exec app php artisan $(cmd)

composer:
	docker compose exec app composer $(cmd)

npm:
	docker compose exec node npm $(cmd)

# ─────────────────────────────────────────
# Create SQL Server database
# Run this once after first docker compose up
# ─────────────────────────────────────────
db-create:
	docker compose exec sqlserver /opt/mssql-tools18/bin/sqlcmd \
		-S localhost -U sas -P "GoodPanda@2025!" -No \
		-Q "IF NOT EXISTS (SELECT name FROM sys.databases WHERE name = 'goodpanda_db') CREATE DATABASE goodpanda_db;"
	@echo "Database 'goodpanda_db' is ready."