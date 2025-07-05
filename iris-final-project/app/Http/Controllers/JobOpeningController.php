<?php

namespace App\Http\Controllers;

use App\Events\CheckAllJobsForExpiry;
use App\Events\CheckJobForExpiry;
use App\Models\Applicant;
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
        // Dispatch the event to check and update the status of this specific job.
        // This will update the database record for $job's status if needed.
        event(new CheckJobForExpiry($job));

        // Re-fetch the job from the database to get its potentially updated status
        // AND eager load its applicants, sorted by the timestamp they were attached
        // to this job (pivot table's created_at) in descending order (latest first).
        $job = JobOpening::with(['applicants' => function ($query) {
            $query->orderBy('job_opening_applicants.created_at', 'DESC');
        }])->find($job->id);

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

    public function addApplicant(JobOpening $job)
    {
        // Get IDs of applicants already added for this job
        $currentApplicantIds = $job->applicants->pluck('id')->toArray();

        // Get all the applicants currently not applied to this job
        $availableApplicants = Applicant::whereNotIn('id', $currentApplicantIds)->latest()->get();

        return view('job_openings.add_applicant', ["job" => $job, "availableApplicants" => $availableApplicants]);
    }

    public function attachApplicant(Request $request, JobOpening $job)
    {
        $request->validate([
            'applicant_id' => [
                'required',
                'exists:applicants,id',
                // Ensure the applicant is not already attached to this job
                Rule::unique('job_opening_applicants')->where(function ($query) use ($job) {
                    return $query->where('job_opening_id', $job->id);
                }),
            ],
        ], [
            'applicant_id.unique' => 'This applicant is already assigned to this job opening.',
        ]);

        try {
            // Attach the applicant to the job opening
            $job->applicants()->attach($request->applicant_id);

            return redirect()->route('jobs.show', $job->id)
                ->with('success', 'Applicant successfully added to this job opening!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to add applicant. ' . $e->getMessage());
        }
    }

    public function detachApplicant(JobOpening $job, Applicant $applicant)
    {
        try {
            // Detach the applicant from the job opening
            $job->applicants()->detach($applicant);

            // If successful, it redirects back to the job's show page
            // with a success flash message.
            return redirect()->route('jobs.show', $job)
                ->with('success', 'Applicant successfully removed from this job opening!');
        } catch (\Exception $e) {
            // If an error occurs during the detachment process,
            // it redirects back to the previous page (the job's show page in this context)
            // with an error flash message.
            return redirect()->back()
                ->with('error', 'Failed to remove applicant. ' . $e->getMessage());
        }
    }
}
