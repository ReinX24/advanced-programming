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
        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->input('title') . '%');
        }
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
        $jobOpenings = $query->paginate(10); // Or your preferred pagination

        // Fetch all applicants for the dropdown
        $applicants = Applicant::orderBy('name')->get(); // Assuming 'name' is the applicant's name field

        return view('reports.jobs', compact('jobOpenings', 'applicants'));
    }

    public function applicantReports(Request $request)
    {
        $query = Applicant::query();

        // Apply filters based on request
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }
        if ($request->filled('min_age')) {
            $query->where('age', '>=', $request->input('min_age'));
        }
        if ($request->filled('max_age')) {
            $query->where('age', '<=', $request->input('max_age'));
        }
        if ($request->filled('educational_attainment')) {
            $query->where('educational_attainment', $request->input('educational_attainment'));
        }
        if ($request->filled('medical')) {
            $query->where('medical', $request->input('medical'));
        }
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Paginate the results
        $applicants = $query->paginate(10); // Adjust pagination limit as needed

        // Pass the paginated data and request query to the view
        return view('reports.applicants', compact('applicants'));
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

    public function downloadApplicantsCsv(Request $request)
    {
        $query = Applicant::query();

        // Re-apply filters for the CSV download
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }
        if ($request->filled('min_age')) {
            $query->where('age', '>=', $request->input('min_age'));
        }
        if ($request->filled('max_age')) {
            $query->where('age', '<=', $request->input('max_age'));
        }
        if ($request->filled('educational_attainment')) {
            $query->where('educational_attainment', $request->input('educational_attainment'));
        }
        if ($request->filled('medical')) {
            $query->where('medical', $request->input('medical'));
        }
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $applicants = $query->get(); // Get all filtered applicants for download

        $filename = 'applicants_report_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($applicants) {
            $file = fopen('php://output', 'w');

            // Add CSV headers
            fputcsv($file, [
                'ID',
                'Name',
                'Age',
                'Educational Attainment',
                'Medical',
                'Status',
                'Working Experience' // Include this if you want it in CSV
            ]);

            // Add data rows
            foreach ($applicants as $applicant) {
                fputcsv($file, [
                    $applicant->id,
                    $applicant->name,
                    $applicant->age,
                    $applicant->educational_attainment,
                    $applicant->medical,
                    $applicant->status,
                    $applicant->working_experience
                ]);
            }

            fclose($file);
        };

        return new StreamedResponse($callback, 200, $headers);
    }
}
