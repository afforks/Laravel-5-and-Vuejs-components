setup laravel by,

1. composer install
2. chmod +x storage
3. chmod +x bootstrap/cache
4. npm install
5. in .env file at root setup database details.
6. php artisan migrate
7. php artisan db:seed

run project by,

php artisan serve

open localhost:8888 in your browser,

You can see routes in app/Http/routes.php