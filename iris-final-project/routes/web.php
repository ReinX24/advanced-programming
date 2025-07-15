<?php

use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\ApplicationFeeController;
use App\Http\Controllers\JobOpeningController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserManagementController;
use App\Http\Middleware\AdminMiddleware;
use App\Models\ApplicationFee;
use App\Models\JobOpening;
use App\Models\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// JobOpening routes
Route::resource('jobs', JobOpeningController::class)->middleware('auth');
Route::put('/jobs/{job}/toggleStatus', [JobOpeningController::class, 'toggleStatus'])->middleware('auth')->name('jobs.toggle');
Route::get('/jobs/{job}/addApplicant', [JobOpeningController::class, 'addApplicant'])->middleware('auth')->name('jobs.add_applicant');
Route::post('/jobs/{job}/attachApplicant', [JobOpeningController::class, 'attachApplicant'])->middleware('auth')->name('jobs.attach_applicant');
Route::delete('/jobs/{job}/detachApplicant/{applicant}', [JobOpeningController::class, 'detachApplicant'])->middleware('auth')->name('jobs.detach_applicant');

// TODO: implement admin gates to other routes
// TODO: implement conditionally showing elements on page
// Applicant routes
Route::resource('applicants', ApplicantController::class)->middleware('auth');

// Finance routes / Application fee
Route::resource('application_fees', ApplicationFeeController::class)->middleware('auth');

// Report Routes
Route::get('/reports/jobs', [ReportController::class, 'jobReports'])->name('reports.jobs')->middleware('auth');

Route::get('/reports/applicants', [ReportController::class, 'applicantReports'])->name('reports.applicants')->middleware('auth');

Route::get('/reports/jobs/download-csv', [ReportController::class, 'downloadJobsCsv'])
    ->name('reports.jobs.download-csv')->middleware('auth');

Route::get('/reports/applicants/download-csv', [ReportController::class, 'downloadApplicantsCsv'])
    ->name('reports.applicants.download-csv')->middleware('auth');

Route::get('/reports/login-events', [ReportController::class, 'loginReports'])
    ->name('reports.login-events')->middleware('auth');

Route::get('/reports/login-events/download-csv', [ReportController::class, 'downloadLoginReportsCsv'])
    ->name('reports.login-events.download-csv')->middleware('auth');

// Route for displaying the admin actions report page
Route::get('/reports/admin-actions', [ReportController::class, 'adminActionReports'])->name('reports.admin-actions')->middleware('auth');

// Route for downloading the admin actions report as CSV
Route::get('/reports/admin-actions/download-csv', [ReportController::class, 'downloadAdminActionReportsCsv'])->name('reports.admin-actions.download-csv')->middleware('auth');

// User management routes
Route::resource('user_management', UserManagementController::class)->middleware('auth');

require __DIR__ . '/auth.php';
