<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TermsAndCondition;
use Illuminate\Http\Request;

class TermsAndConditionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $terms = TermsAndCondition::orderBy('id', 'asc')->paginate(10);

        return view('admin.legales.terminos.index', compact('terms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.legales.terminos.create');
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
    public function show(TermsAndCondition $termsAndCondition)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TermsAndCondition $termsAndCondition)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TermsAndCondition $termsAndCondition)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TermsAndCondition $termsAndCondition)
    {
        //
    }
}
