#### Installing composer and npm packages

composer install

npm install

#### Running app with styles

composer run dev

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

#### Creating a controller

php artisan make:controller StudentController

php artisan make:controller ProfileController --resource

#### Creating a form request

php artisan make:request StoreStudentRequest

php artisan make:request UpdateStudentRequest

#### Creating and using a test

php artisan make:test ProfileControllerTest

php artisan test tests/Feature/ProfileControllerTest.php

#### Creating blade components

php artisan make:component nav --view

php artisan make:component title --view

php artisan make:component sidebar --view

#### Client/User controller

php artisan make:controller Client/UserController --resource

#### UserRequest

php artisan make:request UserRequest

#### Publish Pagination Links

php artisan vendor:publish

#### Adding Appointments

php artisan make:model Appointment

php artisan make:migration create_appointments_table

php artisan make:controller Client/AppointmentController --resource

#### Emailing student once appointment is made

php artisan make:mail AppointmentCreated

php artisan make:mail HelloMail

#### Publishing laravel mail components / templates

php artisan vendor:publish --tag=laravel-mail

#### Reference for sending email

https://www.youtube.com/watch?v=PeK_tD4T3Og

#### Creating jobs

php artisan make:job SendAppointmentEmailJob

#### Running jobs

php artisan queue:work

#### Profile Controller

php artisan make:controller Client/ProfileController --resource

php artisan make:request ProfileRequest

#### Adding profile photo

php artisan make:migration add_profile_photo_path_to_users_table --table=users

#### Installing ui components and auth logic for resetting password
composer require laravel/ui

php artisan ui bootstrap --auth
