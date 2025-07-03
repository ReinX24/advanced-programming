<?php

namespace App\Providers;

use App\Events\CheckAllJobsForExpiry;
use App\Events\JobExpiryCheckRequested;
use App\Listeners\UpdateAllJobStatuses;
use App\Listeners\UpdateJobStatusOnExpiry;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(JobExpiryCheckRequested::class, [UpdateJobStatusOnExpiry::class, 'handle']);
        Event::listen(CheckAllJobsForExpiry::class, [UpdateAllJobStatuses::class, 'handle']);
    }
}
