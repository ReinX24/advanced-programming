# IRIS (Interactive Recruitment Information System)

#### Installing laravel breeze

composer require laravel/breeze --dev

php artisan breeze:install blade

#### Creating Job Openings

php artisan make:model JobOpening -m

php artisan make:factory JobOpeningFactory

php artisan make:seeder JobOpening Seeder

php artisan migrate:fresh --seed

php artisan make:controller JobOpeningController --resource

#### Tailwind config file

npm install -D tailwindcss postcss autoprefixer

npx tailwindcss init
