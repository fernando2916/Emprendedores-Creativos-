<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PrivacyNotice;
use Illuminate\Http\Request;

class PrivacyNoticeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $avisopr = PrivacyNotice::orderBy('id', 'asc')->paginate(10);

        return view('admin.legales.aviso.index', compact('avisopr'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.legales.aviso.create');
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
    public function show(PrivacyNotice $privacyNotice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PrivacyNotice $privacyNotice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PrivacyNotice $privacyNotice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PrivacyNotice $privacyNotice)
    {
        //
    }
}
