# Scrumify-Server

## Cara Install

- Git clone repository ini
- `composer install`
- `cp .env.example .env` jangan lupa disetting sesuai database mu .env-nya
- `php artisan key:generate`
- `php artisan migrate`
- `php artisan db:seed`
- `php artisan passport:install`
- `php artisan passport:client --personal`
- Untuk menjalankan program `php artisan serve`