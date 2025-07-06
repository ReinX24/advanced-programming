<?php

namespace App\Http\Controllers;

use App\Models\ApplicationFee;
use Illuminate\Http\Request;

class ApplicationFeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Eager load applicant and jobOpening relationships for efficient display
        $applicationFees = ApplicationFee::with(['applicant', 'jobOpening'])->paginate(10);
        return view('application_fees.index', compact('applicationFees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        dd('TODO: finish create page');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ApplicationFee $applicationFee)
    {
        dd('TODO: finish show page: ' . $applicationFee);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ApplicationFee $applicationFee)
    {
        dd('TODO: finish edit page: ' . $applicationFee);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ApplicationFee $applicationFee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ApplicationFee $applicationFee)
    {
        //
    }
}
