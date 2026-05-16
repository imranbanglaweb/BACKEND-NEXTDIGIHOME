<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactInfo;
use Illuminate\Http\Request;

class ContactInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contactInfos = ContactInfo::orderBy('sort_order')->paginate(15);

        return view('admin.contact-info.index', compact('contactInfos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.contact-info.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'value' => 'required|string',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        ContactInfo::create($request->all());

        return redirect()->route('admin.contact-info.index')->with('success', 'Contact info created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ContactInfo $contactInfo)
    {
        return view('admin.contact-info.show', compact('contactInfo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ContactInfo $contactInfo)
    {
        return view('admin.contact-info.edit', compact('contactInfo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ContactInfo $contactInfo)
    {
        $request->validate([
            'type' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'value' => 'required|string',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $contactInfo->update($request->all());

        return redirect()->route('admin.contact-info.index')->with('success', 'Contact info updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContactInfo $contactInfo)
    {
        $contactInfo->delete();

        return redirect()->route('admin.contact-info.index')->with('success', 'Contact info deleted successfully.');
    }

    /**
     * Toggle active status
     */
    public function toggleStatus(ContactInfo $contactInfo)
    {
        $contactInfo->update(['is_active' => !$contactInfo->is_active]);

        return redirect()->back()->with('success', 'Status updated successfully.');
    }
}