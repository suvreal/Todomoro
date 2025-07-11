.PHONY: install setup run build watch down

install:
	composer install
	npm install

setup:
	cp .env.example .env || true
	php artisan key:generate
	php artisan migrate --seed

build:
	npm run build

watch:
	npm run dev

watcher-check:
	@echo "Checking system watcher limits..."
	chmod +x scripts/setup-watcher-limit.sh
	@bash scripts/setup-watcher-limit.sh

run: install setup build
	php artisan serve --host=127.0.0.1 --port=8000

dev: install setup
	concurrently "npm run dev" "php artisan serve --host=127.0.0.1 --port=8000"

down:
	@echo "Stopping artisan serve..."
	@pkill -f "artisan serve" || true
	@echo "Stopping vite dev server..."
	@pkill -f "vite" || pkill -f "npm run dev" || pkill -f "node .*vite" || true
	@fuser -k 5173/tcp || true
