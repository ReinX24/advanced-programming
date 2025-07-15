<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ApplicantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $applicants = Applicant::latest()->paginate(10);

        return view('applicants.index', ['applicants' => $applicants]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('applicants.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data based on your schema
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'required|integer|min:18|max:100', // Assuming age is between 18 and 100
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Max 2MB for images
            'curriculum_vitae' => 'nullable|mimes:pdf,doc,docx|max:10240', // Max 10MB for documents
            // 'working_experience' => 'nullable|string',
            // 'educational_attainment' => ['required', Rule::in(['Primary', 'Secondary', 'Vocational', 'Bachelor', 'Master', 'Doctoral'])],
            'medical' => ['required', Rule::in(['Pending', 'Fit To Work'])],
            'status' => ['required', Rule::in(['Line Up', 'On Process', 'For Interview', 'For Medical', 'Deployed'])],
        ]);

        // Handle file uploads
        // If a profile photo is provided, store it in the 'profile_photos' directory within 'storage/app/public'
        if ($request->hasFile('profile_photo')) {
            $validatedData['profile_photo'] = $request->file('profile_photo')->store('profile_photos', 'public');
        }

        // If a curriculum vitae is provided, store it in the 'curriculum_vitae' directory within 'storage/app/public'
        if ($request->hasFile('curriculum_vitae')) {
            $validatedData['curriculum_vitae'] = $request->file('curriculum_vitae')->store('curriculum_vitae', 'public');
        }

        // Create a new Applicant record in the database using the validated data
        Applicant::create($validatedData);

        // Redirect the user to the applicants index page with a success message
        return redirect()->route('applicants.index')
            ->with('success', 'Applicant created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Applicant $applicant)
    {
        return view('applicants.show', ['applicant' => $applicant]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Applicant $applicant)
    {
        return view('applicants.edit', ['applicant' => $applicant]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Applicant $applicant)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'required|integer|min:18|max:100',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'curriculum_vitae' => 'nullable|mimes:pdf,doc,docx|max:10240',
            // 'working_experience' => 'nullable|string',
            // 'educational_attainment' => ['required', Rule::in(['Primary', 'Secondary', 'Vocational', 'Bachelor', 'Master', 'Doctoral'])],
            'medical' => ['required', Rule::in(['Pending', 'Fit To Work'])],
            'status' => ['required', Rule::in(['Line Up', 'On Process', 'For Interview', 'For Medical', 'Deployed'])],
        ]);

        // Handle profile photo update
        if ($request->hasFile('profile_photo')) {
            // Delete old photo if it exists
            if ($applicant->profile_photo) {
                Storage::disk('public')->delete($applicant->profile_photo);
            }
            $validatedData['profile_photo'] = $request->file('profile_photo')->store('profile_photos', 'public');
        }

        // Handle curriculum vitae update
        if ($request->hasFile('curriculum_vitae')) {
            // Delete old CV if it exists
            if ($applicant->curriculum_vitae) {
                Storage::disk('public')->delete($applicant->curriculum_vitae);
            }
            $validatedData['curriculum_vitae'] = $request->file('curriculum_vitae')->store('curriculum_vitae', 'public');
        }

        $applicant->update($validatedData);

        return redirect()->route('applicants.show', $applicant)
            ->with('success', 'Applicant updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Applicant $applicant)
    {
        $applicant->delete();

        return redirect()->route('applicants.index')
            ->with('success', 'Applicant deleted successfully!');
    }

    public function createEducationalAttainment(int $applicantId)
    {
        return view("applicants.create-educational", [
            'applicant' => Applicant::find($applicantId)
        ]);
    }

    public function storeEducationalAttainment(Request $request, int $applicantId)
    {
        // Validate the incoming array of educational attainments
        $request->validate([
            'educational_attainments' => ['required', 'array'],
            'educational_attainments.*.school' => ['required', 'string', 'max:255'],
            'educational_attainments.*.educational_level' => ['required', 'string', Rule::in(['Primary', 'Secondary', 'Vocational', 'Bachelor', 'Master', 'Doctoral'])],
            'educational_attainments.*.start_year' => ['nullable', 'integer', 'min:1900', 'max:' . date('Y')],
            'educational_attainments.*.end_year' => ['nullable', 'integer', 'min:1900', 'max:' . (date('Y') + 5), 'after_or_equal:educational_attainments.*.start_year'],
        ]);

        // Delete existing educational attainments if you want to replace them,
        // or just add new ones if you want to append.
        // For this scenario, we'll assume you're adding new ones.
        // If you want to replace all, uncomment the line below:
        // $applicant->educationalAttainments()->delete();

        foreach ($request->input('educational_attainments') as $attainmentData) {
            // Ensure data is not empty (e.g., if a row was added but left blank)
            if (!empty(array_filter($attainmentData))) {
                $attainmentData["applicant_id"] = $applicantId;

                $applicant = Applicant::find($applicantId);

                $applicant->educationalAttainments()->create($attainmentData);
            }
        }

        return redirect()->route('applicants.show', $applicant)
            ->with('success', 'Educational attainment records added successfully!');
    }

    public function createWorkAttainment() {}

    public function storeWorkAttainment() {}
}
