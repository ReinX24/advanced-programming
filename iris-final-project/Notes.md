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

#### Creating event for checking jobs' status

php artisan make:event JobExpiryCheckRequested

php artisan make:listener UpdateJobStatusOnExpiry

php artisan make:event CheckAllJobsForExpiry

php artisan make:listener UpdateAllJobStatuses

#### Creating Applicants

php artisan make:model Applicant -mfsc --resource

php artisan migrate

php artisan storage:link

#### Creating applications

php artisan make:migration create_job_opening_applicat

php artisan migrate

php artisan make:seeder ApplicantSeeder

#### Creating finance records / application fee

php artisan make:model ApplicationFee -mfsc --resource
