<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use Illuminate\Http\Request;
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
            'working_experience' => 'nullable|string',
            'educational_attainment' => ['required', Rule::in(['Primary', 'Secondary', 'Vocational', 'Bachelor', 'Master', 'Doctoral'])],
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
        // TODO: finish edit
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Applicant $applicant)
    {
        // TODO: finish update
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Applicant $applicant)
    {
        // TODO: finish destroy
    }
}
