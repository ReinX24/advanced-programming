<?php

namespace App\Http\Controllers;

use App\Events\CheckAllJobsForExpiry;
use App\Events\CheckJobForExpiry;
use App\Models\JobOpening;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Twilio\Rest\Bulkexports\V1\Export\JobList;

class JobOpeningController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobs = JobOpening::latest()->paginate(6);

        event(new CheckAllJobsForExpiry());

        return view('job_openings.index', [
            'jobs' => $jobs
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('job_openings.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date_needed' => 'required|date',
            'date_expiry' => 'nullable|date|after_or_equal:date_needed',
            'status' => ['required', Rule::in(['active', 'inactive'])],
            'location' => 'required|string|max:255',
        ]);

        $job = JobOpening::create($validatedData);

        return redirect()->route('jobs.show', $job)
            ->with('success', 'Job opening created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(JobOpening $job)
    {
        event(new CheckJobForExpiry($job));

        return view('job_openings.show', ['job' => $job]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobOpening $job)
    {
        return view('job_openings.edit', ['job' => $job]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JobOpening $job)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date_needed' => 'required|date',
            'date_expiry' => 'nullable|date|after_or_equal:date_needed',
            'location' => 'required|string|max:255',
        ]);

        $dateNeeded = Carbon::parse($validatedData['date_needed']);
        $dateExpiry = $validatedData['date_expiry'] ? Carbon::parse($validatedData['date_expiry']) : null;

        $determinedStatus = null;

        if ($dateExpiry) {
            if ($dateNeeded->greaterThan($dateExpiry)) {
                $determinedStatus = 'expired';
            } elseif ($dateNeeded->lessThan($dateExpiry) && Carbon::now()->lessThan($dateExpiry)) {
                $determinedStatus = 'active';
            } elseif ($dateExpiry->isPast()) {
                $determinedStatus = 'expired';
            }
        } else {
            // Set status as active if the dateExpiry is null
            $determinedStatus = 'active';
        }

        $validatedData['status'] = $determinedStatus;

        $job->update($validatedData);

        event(new CheckJobForExpiry($job));

        return redirect()->route('jobs.show', $job)
            ->with('success', 'Job opening updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobOpening $job)
    {
        $job->delete();

        return redirect()->route("jobs.index")->with('success', 'Job opening deleted successfully!');
    }

    public function toggleStatus(JobOpening $job)
    {
        $job->status = $job->status === "active" ? "inactive" : "active";

        $job->save();

        return redirect()->route('jobs.show', $job)
            ->with('success', 'Job opening updated successfully!');
    }

    public function markAsExpired(JobOpening $job)
    {
        $job->status = 'expired';

        $job->save();

        return redirect()->route('jobs.show', $job)
            ->with('success', 'Job opening updated successfully!');
    }
}
