#### Creating a database migration

php artisan make:migration create_students_table --table=students

#### Creating factory and seeder

php artisan make:factory StudentFactory

php artisan make:seeder StudentSeeder

php artisan db:seed --class=StudentSeeder

#### Rolling back last migration

php artisan migrate:rollback

#### Running migration and seeder

php artisan migrate:fresh --seed

#### Running a single seeder

php artisan db:seed --class=StudentSeeder