#!/usr/bin/env sh
set -eu

mkdir -p /tmp/nutricycle/views

exec php artisan serve --host=0.0.0.0 --port="${PORT:-3000}"
