git pull origin master
composer install --no-interaction --no-dev --prefer-dist
php artisan migrate --force