<?php

use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\ApplicationFeeController;
use App\Http\Controllers\JobOpeningController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Models\ApplicationFee;
use App\Models\JobOpening;
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

require __DIR__ . '/auth.php';
