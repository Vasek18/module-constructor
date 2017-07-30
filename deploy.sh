#!/bin/bash
export PATH=$HOME/.local/bin:$PATH
cd $(dirname $(readlink -f $0))

composer install --no-interaction --no-dev --prefer-dist
php artisan migrate --force
