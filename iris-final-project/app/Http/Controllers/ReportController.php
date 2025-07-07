<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\JobOpening;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function jobReports(Request $request)
    {
        $query = JobOpening::query();

        // Apply existing filters
        if ($request->filled('date_needed')) {
            $query->whereDate('date_needed', '>=', $request->input('date_needed'));
        }
        if ($request->filled('date_expiry')) {
            $query->whereDate('date_expiry', '<=', $request->input('date_expiry'));
        }
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Apply new Applicants filter
        if ($request->filled('applicant_id')) {
            $applicantId = $request->input('applicant_id');
            // If JobOpening has many applicants (e.g., through a pivot table 'job_opening_applicant'):
            $query->whereHas('applicants', function ($q) use ($applicantId) {
                $q->where('applicants.id', $applicantId);
            });
        }

        // Ensure applicants_count is loaded for the view
        $jobOpenings = $query->withCount('applicants')->paginate(10); // Or your preferred pagination

        // Fetch all applicants for the dropdown
        $applicants = Applicant::orderBy('name')->get(); // Assuming 'name' is the applicant's name field

        return view('reports.jobs', compact('jobOpenings', 'applicants'));
    }

    public function applicantReports()
    {
        // Logic to fetch and prepare applicant-related report data
        return view('reports.applicants'); // You'll need to create this view
    }

    public function downloadJobsCsv(Request $request)
    {
        $query = JobOpening::query();

        // Apply existing filters
        if ($request->filled('date_needed')) {
            $query->whereDate('date_needed', '>=', $request->input('date_needed'));
        }
        if ($request->filled('date_expiry')) {
            $query->whereDate('date_expiry', '<=', $request->input('date_expiry'));
        }
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Apply new Applicants filter to CSV download
        if ($request->filled('applicant_id')) {
            $applicantId = $request->input('applicant_id');
            $query->whereHas('applicants', function ($q) use ($applicantId) {
                $q->where('applicants.id', $applicantId);
            });
        }

        $jobOpenings = $query->withCount('applicants')->get();

        $filename = 'job_openings_report_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($jobOpenings) {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'ID',
                'Title',
                'Location',
                'Status',
                'Date Needed',
                'Date Expiry',
                'Applicants'
            ]);

            foreach ($jobOpenings as $job) {
                fputcsv($file, [
                    $job->id,
                    $job->title,
                    $job->location,
                    ucfirst($job->status),
                    $job->date_needed->format('M d, Y'),
                    $job->date_expiry ? $job->date_expiry->format('M d, Y') : 'N/A',
                    $job->applicants_count
                ]);
            }

            fclose($file);
        };

        return new StreamedResponse($callback, 200, $headers);
    }
}
